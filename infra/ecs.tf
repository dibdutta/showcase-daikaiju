################################################################################
# ECS Cluster
################################################################################

resource "aws_ecs_cluster" "main" {
  name = "${local.name_prefix}-cluster"

  setting {
    name  = "containerInsights"
    value = "disabled" # Enable later if needed ($$$)
  }

  tags = { Name = "${local.name_prefix}-cluster" }
}

################################################################################
# CloudWatch Log Groups
################################################################################

resource "aws_cloudwatch_log_group" "web" {
  name              = "/ecs/${local.name_prefix}-web"
  retention_in_days = 30
}

resource "aws_cloudwatch_log_group" "cron" {
  name              = "/ecs/${local.name_prefix}-cron"
  retention_in_days = 30
}

resource "aws_cloudwatch_log_group" "cloudbeaver" {
  name              = "/ecs/${local.name_prefix}-cloudbeaver"
  retention_in_days = 30
}

################################################################################
# SSM Parameters for Secrets
################################################################################

resource "aws_ssm_parameter" "db_server" {
  name  = "/${var.project_name}/${var.environment}/DB_SERVER"
  type  = "SecureString"
  value = aws_db_instance.main.address
}

resource "aws_ssm_parameter" "db_name" {
  name  = "/${var.project_name}/${var.environment}/DB_NAME"
  type  = "SecureString"
  value = var.db_name
}

resource "aws_ssm_parameter" "db_user" {
  name  = "/${var.project_name}/${var.environment}/DB_USER"
  type  = "SecureString"
  value = var.db_username
}

resource "aws_ssm_parameter" "db_password" {
  name  = "/${var.project_name}/${var.environment}/DB_PASSWORD"
  type  = "SecureString"
  value = data.aws_secretsmanager_secret_version.db_password.secret_string
}

################################################################################
# Web Task Definition
################################################################################

resource "aws_ecs_task_definition" "web" {
  family                   = "${local.name_prefix}-web"
  network_mode             = "awsvpc"
  requires_compatibilities = ["FARGATE"]
  cpu                      = var.web_task_cpu
  memory                   = var.web_task_memory
  execution_role_arn       = aws_iam_role.ecs_execution.arn
  task_role_arn            = aws_iam_role.ecs_task.arn

  container_definitions = jsonencode([
    {
      name      = "showcase-web"
      image     = "${aws_ecr_repository.web.repository_url}:latest"
      essential = true

      portMappings = [
        {
          containerPort = 80
          protocol      = "tcp"
        }
      ]

      environment = [
        { name = "APP_ENV", value = "production" },
        { name = "CDN_STATIC_URL", value = "https://${var.domain_name}" }
      ]

      secrets = [
        { name = "DB_SERVER", valueFrom = aws_ssm_parameter.db_server.arn },
        { name = "DB_NAME", valueFrom = aws_ssm_parameter.db_name.arn },
        { name = "DB_USER", valueFrom = aws_ssm_parameter.db_user.arn },
        { name = "DB_PASSWORD", valueFrom = aws_ssm_parameter.db_password.arn }
      ]

      mountPoints = [
        { sourceVolume = "sessions", containerPath = "/var/www/html/sessions" },
        { sourceVolume = "poster-photo", containerPath = "/var/www/html/poster_photo" },
        { sourceVolume = "templates-c", containerPath = "/var/www/html/templates_c" },
        { sourceVolume = "admin-templates-c", containerPath = "/var/www/html/admin_templates_c" },
        { sourceVolume = "bulkupload", containerPath = "/var/www/html/bulkupload" }
      ]

      logConfiguration = {
        logDriver = "awslogs"
        options = {
          "awslogs-group"         = aws_cloudwatch_log_group.web.name
          "awslogs-region"        = var.aws_region
          "awslogs-stream-prefix" = "web"
        }
      }
    }
  ])

  volume {
    name = "sessions"
    efs_volume_configuration {
      file_system_id     = aws_efs_file_system.main.id
      transit_encryption = "ENABLED"
      authorization_config {
        access_point_id = aws_efs_access_point.sessions.id
        iam             = "ENABLED"
      }
    }
  }

  volume {
    name = "poster-photo"
    efs_volume_configuration {
      file_system_id     = aws_efs_file_system.main.id
      transit_encryption = "ENABLED"
      authorization_config {
        access_point_id = aws_efs_access_point.poster_photo.id
        iam             = "ENABLED"
      }
    }
  }

  volume {
    name = "templates-c"
    efs_volume_configuration {
      file_system_id     = aws_efs_file_system.main.id
      transit_encryption = "ENABLED"
      authorization_config {
        access_point_id = aws_efs_access_point.templates_c.id
        iam             = "ENABLED"
      }
    }
  }

  volume {
    name = "admin-templates-c"
    efs_volume_configuration {
      file_system_id     = aws_efs_file_system.main.id
      transit_encryption = "ENABLED"
      authorization_config {
        access_point_id = aws_efs_access_point.admin_templates_c.id
        iam             = "ENABLED"
      }
    }
  }

  volume {
    name = "bulkupload"
    efs_volume_configuration {
      file_system_id     = aws_efs_file_system.main.id
      transit_encryption = "ENABLED"
      authorization_config {
        access_point_id = aws_efs_access_point.bulkupload.id
        iam             = "ENABLED"
      }
    }
  }
}

################################################################################
# Web Service
################################################################################

resource "aws_ecs_service" "web" {
  name            = "${local.name_prefix}-web"
  cluster         = aws_ecs_cluster.main.id
  task_definition = aws_ecs_task_definition.web.arn
  desired_count   = var.web_desired_count
  launch_type     = "FARGATE"

  network_configuration {
    subnets          = aws_subnet.private[*].id
    security_groups  = [aws_security_group.ecs.id]
    assign_public_ip = false
  }

  load_balancer {
    target_group_arn = aws_lb_target_group.web.arn
    container_name   = "showcase-web"
    container_port   = 80
  }

  deployment_minimum_healthy_percent = 50
  deployment_maximum_percent         = 200

  depends_on = [aws_lb_listener.http, aws_lb_listener.https]
}

################################################################################
# Auto Scaling
################################################################################

resource "aws_appautoscaling_target" "web" {
  max_capacity       = 4
  min_capacity       = 2
  resource_id        = "service/${aws_ecs_cluster.main.name}/${aws_ecs_service.web.name}"
  scalable_dimension = "ecs:service:DesiredCount"
  service_namespace  = "ecs"
}

resource "aws_appautoscaling_policy" "web_cpu" {
  name               = "${local.name_prefix}-cpu-scaling"
  policy_type        = "TargetTrackingScaling"
  resource_id        = aws_appautoscaling_target.web.resource_id
  scalable_dimension = aws_appautoscaling_target.web.scalable_dimension
  service_namespace  = aws_appautoscaling_target.web.service_namespace

  target_tracking_scaling_policy_configuration {
    predefined_metric_specification {
      predefined_metric_type = "ECSServiceAverageCPUUtilization"
    }
    target_value       = 70.0
    scale_in_cooldown  = 300
    scale_out_cooldown = 60
  }
}

################################################################################
# Cron Task Definition
################################################################################

resource "aws_ecs_task_definition" "cron" {
  family                   = "${local.name_prefix}-cron"
  network_mode             = "awsvpc"
  requires_compatibilities = ["FARGATE"]
  cpu                      = 256
  memory                   = 512
  execution_role_arn       = aws_iam_role.ecs_execution.arn
  task_role_arn            = aws_iam_role.ecs_task.arn

  container_definitions = jsonencode([
    {
      name      = "showcase-cron"
      image     = "${aws_ecr_repository.web.repository_url}:latest"
      essential = true

      command = ["php", "/var/www/html/cron.php"]

      environment = [
        { name = "APP_ENV", value = "production" }
      ]

      secrets = [
        { name = "DB_SERVER", valueFrom = aws_ssm_parameter.db_server.arn },
        { name = "DB_NAME", valueFrom = aws_ssm_parameter.db_name.arn },
        { name = "DB_USER", valueFrom = aws_ssm_parameter.db_user.arn },
        { name = "DB_PASSWORD", valueFrom = aws_ssm_parameter.db_password.arn }
      ]

      logConfiguration = {
        logDriver = "awslogs"
        options = {
          "awslogs-group"         = aws_cloudwatch_log_group.cron.name
          "awslogs-region"        = var.aws_region
          "awslogs-stream-prefix" = "cron"
        }
      }
    }
  ])
}

################################################################################
# CloudBeaver Task Definition & Service
################################################################################

resource "aws_ecs_task_definition" "cloudbeaver" {
  family                   = "${local.name_prefix}-cloudbeaver"
  network_mode             = "awsvpc"
  requires_compatibilities = ["FARGATE"]
  cpu                      = 256
  memory                   = 512
  execution_role_arn       = aws_iam_role.ecs_execution.arn
  task_role_arn            = aws_iam_role.ecs_task.arn

  container_definitions = jsonencode([
    {
      name      = "cloudbeaver"
      image     = "dbeaver/cloudbeaver:latest"
      essential = true

      portMappings = [
        {
          containerPort = 8978
          protocol      = "tcp"
        }
      ]

      environment = [
        { name = "CB_SERVER_NAME", value = "MPE Database Manager" },
        { name = "CB_ADMIN_NAME", value = "admin" }
      ]

      logConfiguration = {
        logDriver = "awslogs"
        options = {
          "awslogs-group"         = aws_cloudwatch_log_group.cloudbeaver.name
          "awslogs-region"        = var.aws_region
          "awslogs-stream-prefix" = "cb"
        }
      }
    }
  ])
}

resource "aws_ecs_service" "cloudbeaver" {
  name            = "${local.name_prefix}-cloudbeaver"
  cluster         = aws_ecs_cluster.main.id
  task_definition = aws_ecs_task_definition.cloudbeaver.arn
  desired_count   = 1
  launch_type     = "FARGATE"

  network_configuration {
    subnets          = [aws_subnet.private[0].id]
    security_groups  = [aws_security_group.cloudbeaver.id]
    assign_public_ip = false
  }

  enable_execute_command = true # For SSM port forwarding
}
