################################################################################
# RDS Subnet Group
################################################################################

resource "aws_db_subnet_group" "main" {
  name       = "${local.name_prefix}-db-subnet"
  subnet_ids = aws_subnet.database[*].id

  tags = { Name = "${local.name_prefix}-db-subnet" }
}

################################################################################
# RDS Parameter Group (MySQL 8.0 compatibility)
################################################################################

resource "aws_db_parameter_group" "mysql80" {
  name   = "${local.name_prefix}-mysql80"
  family = "mysql8.0"

  parameter {
    name  = "sql_mode"
    value = "NO_ENGINE_SUBSTITUTION"
  }

  parameter {
    name  = "character_set_server"
    value = "utf8mb4"
  }

  parameter {
    name  = "collation_server"
    value = "utf8mb4_unicode_ci"
  }

  tags = { Name = "${local.name_prefix}-mysql80-params" }
}

################################################################################
# Read DB Password from AWS Secrets Manager
# Create this secret manually first:
#   aws secretsmanager create-secret --name showcase/prod/db-password \
#     --secret-string "YOUR_STRONG_PASSWORD" --region us-east-1
################################################################################

data "aws_secretsmanager_secret_version" "db_password" {
  secret_id = "${var.project_name}/${var.environment}/db-password"
}

################################################################################
# RDS MySQL Instance
################################################################################

resource "aws_db_instance" "main" {
  identifier = "${local.name_prefix}-mysql"

  engine         = "mysql"
  engine_version = "8.0"
  instance_class = "db.t4g.micro"

  allocated_storage     = 20
  max_allocated_storage = 100
  storage_type          = "gp3"
  storage_encrypted     = true

  db_name  = var.db_name
  username = var.db_username
  password = data.aws_secretsmanager_secret_version.db_password.secret_string

  db_subnet_group_name   = aws_db_subnet_group.main.name
  vpc_security_group_ids = [aws_security_group.rds.id]
  parameter_group_name   = aws_db_parameter_group.mysql80.name

  multi_az            = false
  publicly_accessible = false
  skip_final_snapshot = false
  final_snapshot_identifier = "${local.name_prefix}-final-snapshot"

  backup_retention_period = 7
  backup_window           = "03:00-04:00"
  maintenance_window      = "sun:04:00-sun:05:00"

  tags = { Name = "${local.name_prefix}-mysql" }
}
