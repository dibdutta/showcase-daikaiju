output "vpc_id" {
  description = "VPC ID"
  value       = aws_vpc.main.id
}

output "alb_dns_name" {
  description = "ALB DNS name"
  value       = aws_lb.main.dns_name
}

output "ecr_repository_url" {
  description = "ECR repository URL"
  value       = aws_ecr_repository.web.repository_url
}

output "rds_endpoint" {
  description = "RDS instance endpoint"
  value       = aws_db_instance.main.address
  sensitive   = true
}

output "efs_file_system_id" {
  description = "EFS file system ID"
  value       = aws_efs_file_system.main.id
}

output "cloudfront_distribution_id" {
  description = "CloudFront distribution ID"
  value       = aws_cloudfront_distribution.main.id
}

output "cloudfront_domain_name" {
  description = "CloudFront distribution domain name"
  value       = aws_cloudfront_distribution.main.domain_name
}

output "ecs_cluster_name" {
  description = "ECS cluster name"
  value       = aws_ecs_cluster.main.name
}

output "web_service_name" {
  description = "ECS web service name"
  value       = aws_ecs_service.web.name
}

output "github_actions_role_arn" {
  description = "IAM role ARN for GitHub Actions"
  value       = aws_iam_role.github_actions.arn
}

output "s3_static_bucket" {
  description = "S3 bucket for static assets"
  value       = aws_s3_bucket.static_assets.id
}

output "acm_certificate_validation_records" {
  description = "DNS records to add at your domain registrar for ACM cert validation"
  value = {
    for dvo in aws_acm_certificate.main.domain_validation_options : dvo.domain_name => {
      type  = dvo.resource_record_type
      name  = dvo.resource_record_name
      value = dvo.resource_record_value
    }
  }
}

output "efs_access_point_sessions" {
  description = "EFS access point ID for sessions"
  value       = aws_efs_access_point.sessions.id
}

output "efs_access_point_poster_photo" {
  description = "EFS access point ID for poster_photo"
  value       = aws_efs_access_point.poster_photo.id
}

output "efs_access_point_templates_c" {
  description = "EFS access point ID for templates_c"
  value       = aws_efs_access_point.templates_c.id
}

output "efs_access_point_admin_templates_c" {
  description = "EFS access point ID for admin_templates_c"
  value       = aws_efs_access_point.admin_templates_c.id
}

output "efs_access_point_bulkupload" {
  description = "EFS access point ID for bulkupload"
  value       = aws_efs_access_point.bulkupload.id
}

output "ecs_execution_role_arn" {
  description = "ECS execution role ARN"
  value       = aws_iam_role.ecs_execution.arn
}

output "ecs_task_role_arn" {
  description = "ECS task role ARN"
  value       = aws_iam_role.ecs_task.arn
}
