################################################################################
# EFS File System
################################################################################

resource "aws_efs_file_system" "main" {
  creation_token = "${local.name_prefix}-efs"
  encrypted      = true

  lifecycle_policy {
    transition_to_ia = "AFTER_30_DAYS"
  }

  tags = { Name = "${local.name_prefix}-efs" }
}

resource "aws_efs_mount_target" "main" {
  count           = 2
  file_system_id  = aws_efs_file_system.main.id
  subnet_id       = aws_subnet.private[count.index].id
  security_groups = [aws_security_group.efs.id]
}

################################################################################
# EFS Access Points
################################################################################

resource "aws_efs_access_point" "sessions" {
  file_system_id = aws_efs_file_system.main.id

  posix_user {
    gid = 33 # www-data
    uid = 33
  }

  root_directory {
    path = "/sessions"
    creation_info {
      owner_gid   = 33
      owner_uid   = 33
      permissions = "0755"
    }
  }

  tags = { Name = "${local.name_prefix}-sessions" }
}

resource "aws_efs_access_point" "poster_photo" {
  file_system_id = aws_efs_file_system.main.id

  posix_user {
    gid = 33
    uid = 33
  }

  root_directory {
    path = "/poster_photo"
    creation_info {
      owner_gid   = 33
      owner_uid   = 33
      permissions = "0755"
    }
  }

  tags = { Name = "${local.name_prefix}-poster-photo" }
}

resource "aws_efs_access_point" "templates_c" {
  file_system_id = aws_efs_file_system.main.id

  posix_user {
    gid = 33
    uid = 33
  }

  root_directory {
    path = "/templates_c"
    creation_info {
      owner_gid   = 33
      owner_uid   = 33
      permissions = "0755"
    }
  }

  tags = { Name = "${local.name_prefix}-templates-c" }
}

resource "aws_efs_access_point" "admin_templates_c" {
  file_system_id = aws_efs_file_system.main.id

  posix_user {
    gid = 33
    uid = 33
  }

  root_directory {
    path = "/admin_templates_c"
    creation_info {
      owner_gid   = 33
      owner_uid   = 33
      permissions = "0755"
    }
  }

  tags = { Name = "${local.name_prefix}-admin-templates-c" }
}

resource "aws_efs_access_point" "bulkupload" {
  file_system_id = aws_efs_file_system.main.id

  posix_user {
    gid = 33
    uid = 33
  }

  root_directory {
    path = "/bulkupload"
    creation_info {
      owner_gid   = 33
      owner_uid   = 33
      permissions = "0755"
    }
  }

  tags = { Name = "${local.name_prefix}-bulkupload" }
}
