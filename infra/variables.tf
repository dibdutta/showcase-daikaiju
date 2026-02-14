variable "aws_region" {
  description = "AWS region"
  type        = string
  default     = "us-east-1"
}

variable "project_name" {
  description = "Project name used for resource naming"
  type        = string
  default     = "showcase"
}

variable "environment" {
  description = "Environment name"
  type        = string
  default     = "prod"
}

variable "vpc_cidr" {
  description = "VPC CIDR block"
  type        = string
  default     = "10.0.0.0/16"
}

variable "db_name" {
  description = "Database name"
  type        = string
  default     = "showcase"
}

variable "db_username" {
  description = "Database master username"
  type        = string
  default     = "showcaseadmin"
  sensitive   = true
}

variable "domain_name" {
  description = "Domain name for the application"
  type        = string
  default     = "movieposterexchange.com"
}

variable "web_task_cpu" {
  description = "CPU units for web task (1 vCPU = 1024)"
  type        = number
  default     = 512
}

variable "web_task_memory" {
  description = "Memory in MB for web task"
  type        = number
  default     = 1024
}

variable "web_desired_count" {
  description = "Desired number of web tasks"
  type        = number
  default     = 2
}

variable "nat_instance_type" {
  description = "Instance type for NAT instance"
  type        = string
  default     = "t2.micro"
}
