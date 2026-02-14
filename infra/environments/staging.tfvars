aws_region  = "us-east-1"
environment = "staging"

domain_name = "staging.movieposterexchange.com"

# Smaller sizing for staging
web_task_cpu      = 256  # 0.25 vCPU
web_task_memory   = 512  # 0.5 GB
web_desired_count = 1

nat_instance_type = "t2.micro"
