#!/bin/bash
set -e

# Clear Smarty compiled template caches on every container start.
# These directories are mounted from EFS and persist across deployments,
# so stale compiled templates from previous code versions must be removed.
echo "Clearing Smarty compiled template caches..."
rm -rf /var/www/html/templates_c/* /var/www/html/admin_templates_c/* 2>/dev/null || true
echo "Done."

# Hand off to the default Apache entrypoint
exec docker-php-entrypoint apache2-foreground "$@"
