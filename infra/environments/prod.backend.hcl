bucket         = "showcase-terraform-state-prod"
key            = "prod/terraform.tfstate"
region         = "us-east-1"
dynamodb_table = "showcase-terraform-locks-prod"
encrypt        = true
# Note: bucket and dynamodb_table are overridden at runtime by bootstrap.yml
# to include the AWS account ID for global uniqueness
