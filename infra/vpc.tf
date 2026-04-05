################################################################################
# VPC
################################################################################

resource "aws_vpc" "main" {
  cidr_block           = var.vpc_cidr
  enable_dns_hostnames = true
  enable_dns_support   = true

  tags = { Name = "${local.name_prefix}-vpc" }
}

################################################################################
# Internet Gateway
################################################################################

resource "aws_internet_gateway" "main" {
  vpc_id = aws_vpc.main.id
  tags   = { Name = "${local.name_prefix}-igw" }
}

################################################################################
# Public Subnets
################################################################################

resource "aws_subnet" "public" {
  count                   = 2
  vpc_id                  = aws_vpc.main.id
  cidr_block              = cidrsubnet(var.vpc_cidr, 8, count.index + 1)
  availability_zone       = local.azs[count.index]
  map_public_ip_on_launch = true

  tags = { Name = "${local.name_prefix}-public-${local.azs[count.index]}" }
}

################################################################################
# Private Subnets (ECS)
################################################################################

resource "aws_subnet" "private" {
  count             = 2
  vpc_id            = aws_vpc.main.id
  cidr_block        = cidrsubnet(var.vpc_cidr, 8, count.index + 10)
  availability_zone = local.azs[count.index]

  tags = { Name = "${local.name_prefix}-private-${local.azs[count.index]}" }
}

################################################################################
# Database Subnets
################################################################################

resource "aws_subnet" "database" {
  count             = 2
  vpc_id            = aws_vpc.main.id
  cidr_block        = cidrsubnet(var.vpc_cidr, 8, count.index + 20)
  availability_zone = local.azs[count.index]

  tags = { Name = "${local.name_prefix}-db-${local.azs[count.index]}" }
}

################################################################################
# NAT Instance (cost-efficient alternative to NAT Gateway)
################################################################################

data "aws_ami" "al2023" {
  most_recent = true
  owners      = ["amazon"]

  filter {
    name   = "name"
    values = ["al2023-ami-minimal-*-x86_64"]
  }

  filter {
    name   = "virtualization-type"
    values = ["hvm"]
  }

  filter {
    name   = "architecture"
    values = ["x86_64"]
  }
}

resource "aws_instance" "nat" {
  ami                    = data.aws_ami.al2023.id
  instance_type          = var.nat_instance_type
  subnet_id              = aws_subnet.public[0].id
  vpc_security_group_ids = [aws_security_group.nat.id]
  iam_instance_profile   = "showcase-prod-nat-ssm-profile"
  source_dest_check      = false

  user_data = <<-EOF
    #!/bin/bash
    LOG=/var/log/nat-setup.log
    exec > >(tee -a $LOG) 2>&1
    echo "=== NAT setup started at $(date) ==="

    # === STEP 1: IP forwarding ===
    echo 1 > /proc/sys/net/ipv4/ip_forward
    sysctl -w net.ipv4.ip_forward=1
    echo "net.ipv4.ip_forward = 1" >> /etc/sysctl.conf
    echo "ip_forward=$(cat /proc/sys/net/ipv4/ip_forward)"

    # === STEP 2: Install iptables and nftables tools, then set up NAT ===
    # AL2023 minimal does not ship nft or iptables-nft — install them first
    yum install -y nftables iptables 2>&1
    echo "Installed nftables and iptables"

    PRIMARY_IF=$(ip route show default | awk '/default/ {print $5; exit}')
    echo "Primary interface: $PRIMARY_IF"

    # Use nft directly (AL2023 native)
    nft add table ip nat
    nft add chain ip nat postrouting '{ type nat hook postrouting priority srcnat ; }'
    nft add rule ip nat postrouting oifname "$PRIMARY_IF" masquerade
    echo "nft ruleset:"
    nft list ruleset

    # === STEP 3: Persist via nftables service ===
    nft list ruleset > /etc/nftables.conf
    sed -i '1s/^/flush ruleset\n/' /etc/nftables.conf
    systemctl enable nftables && echo "nftables service enabled"

    # === STEP 4: SSM agent (best effort) ===
    yum install -y amazon-ssm-agent 2>&1 || true
    systemctl enable amazon-ssm-agent 2>/dev/null || true
    systemctl start amazon-ssm-agent 2>/dev/null || true

    echo "=== NAT setup complete at $(date) ==="
  EOF

  tags = { Name = "${local.name_prefix}-nat-instance", ManagedBy = "terraform" }
}

resource "aws_security_group" "nat" {
  name_prefix = "${local.name_prefix}-nat-"
  vpc_id      = aws_vpc.main.id

  ingress {
    from_port   = 0
    to_port     = 0
    protocol    = "-1"
    cidr_blocks = [for s in aws_subnet.private : s.cidr_block]
  }

  egress {
    from_port   = 0
    to_port     = 0
    protocol    = "-1"
    cidr_blocks = ["0.0.0.0/0"]
  }

  tags = { Name = "${local.name_prefix}-nat-sg" }
}

################################################################################
# Route Tables
################################################################################

resource "aws_route_table" "public" {
  vpc_id = aws_vpc.main.id

  route {
    cidr_block = "0.0.0.0/0"
    gateway_id = aws_internet_gateway.main.id
  }

  tags = { Name = "${local.name_prefix}-public-rt" }
}

resource "aws_route_table_association" "public" {
  count          = 2
  subnet_id      = aws_subnet.public[count.index].id
  route_table_id = aws_route_table.public.id
}

resource "aws_route_table" "private" {
  vpc_id = aws_vpc.main.id

  route {
    cidr_block           = "0.0.0.0/0"
    network_interface_id = aws_instance.nat.primary_network_interface_id
  }

  tags = { Name = "${local.name_prefix}-private-rt" }
}

resource "aws_route_table_association" "private" {
  count          = 2
  subnet_id      = aws_subnet.private[count.index].id
  route_table_id = aws_route_table.private.id
}


resource "aws_route_table_association" "database" {
  count          = 2
  subnet_id      = aws_subnet.database[count.index].id
  route_table_id = aws_route_table.private.id
}
