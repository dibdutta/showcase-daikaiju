################################################################################
# EventBridge Scheduler - Auction Cron (every 1 minute)
################################################################################

resource "aws_scheduler_schedule" "auction_cron" {
  name       = "${local.name_prefix}-auction-cron"
  group_name = "default"

  flexible_time_window {
    mode = "OFF"
  }

  schedule_expression = "rate(1 minute)"

  target {
    arn      = aws_ecs_cluster.main.arn
    role_arn = aws_iam_role.eventbridge_scheduler.arn

    ecs_parameters {
      task_definition_arn = aws_ecs_task_definition.cron.arn
      launch_type         = "FARGATE"
      task_count          = 1

      network_configuration {
        subnets          = aws_subnet.private[*].id
        security_groups  = [aws_security_group.ecs.id]
        assign_public_ip = false
      }
    }

    retry_policy {
      maximum_retry_attempts = 0
    }
  }
}

################################################################################
# EventBridge Scheduler - Invoice Expiry Cron (every 15 minutes)
################################################################################

resource "aws_scheduler_schedule" "invoice_cron" {
  name       = "${local.name_prefix}-invoice-cron"
  group_name = "default"

  flexible_time_window {
    mode = "OFF"
  }

  schedule_expression = "rate(15 minutes)"

  target {
    arn      = aws_ecs_cluster.main.arn
    role_arn = aws_iam_role.eventbridge_scheduler.arn

    ecs_parameters {
      task_definition_arn = aws_ecs_task_definition.cron.arn
      launch_type         = "FARGATE"
      task_count          = 1

      network_configuration {
        subnets          = aws_subnet.private[*].id
        security_groups  = [aws_security_group.ecs.id]
        assign_public_ip = false
      }

      # Override command for invoice expiry cron
    }

    retry_policy {
      maximum_retry_attempts = 0
    }
  }
}
