################################################################################
# VPC Endpoints - Direct private connectivity to AWS services
################################################################################

# S3 Gateway endpoint - free, keeps S3 traffic (ECR image layers, static assets) off NAT
resource "aws_vpc_endpoint" "s3" {
  vpc_id            = aws_vpc.main.id
  service_name      = "com.amazonaws.${var.aws_region}.s3"
  vpc_endpoint_type = "Gateway"
  route_table_ids   = [aws_route_table.private.id]

  tags = { Name = "${local.name_prefix}-s3-endpoint" }
}
