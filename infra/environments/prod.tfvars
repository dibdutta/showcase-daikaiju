aws_region  = "us-east-1"
environment = "prod"

domain_name = "mygodzillashop.com"

# ECS task sizing
web_task_cpu      = 512  # 0.5 vCPU
web_task_memory   = 1024 # 1 GB
web_desired_count = 2

nat_instance_type = "t3.micro"

# USPS OAuth API credentials
usps_consumer_key    = "7qILcfTnmqqNGPsauLPZUG86Y04EZPjSk7UaZuLAD1X5zz6W"
usps_consumer_secret = "liwUXyKGX0XzG9hPaVWSwG8uSqE2cKouRJXw8Ahwq9z6uIYzGSjv3cgmc9Aowyn8"

# Set to true after adding ACM DNS validation records at your domain registrar
domain_validated = true
