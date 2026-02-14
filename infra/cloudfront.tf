################################################################################
# CloudFront Distribution (Static Assets + ALB)
################################################################################

resource "aws_cloudfront_distribution" "main" {
  enabled             = true
  is_ipv6_enabled     = true
  comment             = "MPE Static Assets and Site CDN"
  default_root_object = "index.php"
  price_class         = "PriceClass_100" # US, Canada, Europe only (cost saving)

  # Only attach custom domain when cert is validated
  aliases = var.domain_validated ? [var.domain_name, "www.${var.domain_name}"] : []

  # Origin 1: S3 for static assets
  origin {
    domain_name              = aws_s3_bucket.static_assets.bucket_regional_domain_name
    origin_id                = "s3-static"
    origin_access_control_id = aws_cloudfront_origin_access_control.s3.id
  }

  # Origin 2: ALB for dynamic content
  origin {
    domain_name = aws_lb.main.dns_name
    origin_id   = "alb-dynamic"

    custom_origin_config {
      http_port              = 80
      https_port             = 443
      origin_protocol_policy = var.domain_validated ? "https-only" : "http-only"
      origin_ssl_protocols   = ["TLSv1.2"]
    }
  }

  # CSS files -> S3
  ordered_cache_behavior {
    path_pattern     = "/css/*"
    allowed_methods  = ["GET", "HEAD"]
    cached_methods   = ["GET", "HEAD"]
    target_origin_id = "s3-static"

    forwarded_values {
      query_string = false
      cookies {
        forward = "none"
      }
    }

    compress               = true
    viewer_protocol_policy = "redirect-to-https"
    min_ttl                = 0
    default_ttl            = 2592000 # 30 days
    max_ttl                = 2592000
  }

  # JavaScript files -> S3
  ordered_cache_behavior {
    path_pattern     = "/javascript/*"
    allowed_methods  = ["GET", "HEAD"]
    cached_methods   = ["GET", "HEAD"]
    target_origin_id = "s3-static"

    forwarded_values {
      query_string = false
      cookies {
        forward = "none"
      }
    }

    compress               = true
    viewer_protocol_policy = "redirect-to-https"
    min_ttl                = 0
    default_ttl            = 2592000
    max_ttl                = 2592000
  }

  # Site images -> S3
  ordered_cache_behavior {
    path_pattern     = "/images/*"
    allowed_methods  = ["GET", "HEAD"]
    cached_methods   = ["GET", "HEAD"]
    target_origin_id = "s3-static"

    forwarded_values {
      query_string = false
      cookies {
        forward = "none"
      }
    }

    compress               = true
    viewer_protocol_policy = "redirect-to-https"
    min_ttl                = 0
    default_ttl            = 2592000
    max_ttl                = 2592000
  }

  # Default: dynamic content -> ALB
  default_cache_behavior {
    allowed_methods  = ["DELETE", "GET", "HEAD", "OPTIONS", "PATCH", "POST", "PUT"]
    cached_methods   = ["GET", "HEAD"]
    target_origin_id = "alb-dynamic"

    forwarded_values {
      query_string = true
      headers      = ["Host", "Origin", "Referer"]
      cookies {
        forward = "all"
      }
    }

    viewer_protocol_policy = "redirect-to-https"
    min_ttl                = 0
    default_ttl            = 0
    max_ttl                = 0
  }

  restrictions {
    geo_restriction {
      restriction_type = "none"
    }
  }

  # Use custom cert when validated, otherwise default CloudFront cert
  dynamic "viewer_certificate" {
    for_each = var.domain_validated ? [1] : []
    content {
      acm_certificate_arn      = aws_acm_certificate.main.arn
      ssl_support_method       = "sni-only"
      minimum_protocol_version = "TLSv1.2_2021"
    }
  }

  dynamic "viewer_certificate" {
    for_each = var.domain_validated ? [] : [1]
    content {
      cloudfront_default_certificate = true
    }
  }

  tags = { Name = "${local.name_prefix}-cdn" }
}
