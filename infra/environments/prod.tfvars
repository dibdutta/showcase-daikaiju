aws_region  = "us-east-1"
environment = "prod"

domain_name = "movieposterexchange.com"

# ECS task sizing
web_task_cpu      = 512  # 0.5 vCPU
web_task_memory   = 1024 # 1 GB
web_desired_count = 2

nat_instance_type = "t2.micro"
