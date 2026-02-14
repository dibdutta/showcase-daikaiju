FROM php:8.3-apache

# Install GD dependencies (for image processing)
RUN apt-get update && apt-get install -y libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Install mysqli extension
RUN docker-php-ext-install mysqli

# Enable mysqli
RUN docker-php-ext-enable mysqli

# Enable mod_rewrite for SEO-friendly URLs
RUN a2enmod rewrite

# Suppress Apache ServerName warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Allow .htaccess overrides in document root
RUN echo '<Directory /var/www/html>\n    AllowOverride All\n</Directory>' > /etc/apache2/conf-available/allowoverride.conf \
    && a2enconf allowoverride

# Configure PHP for production
RUN { \
    echo 'session.save_path = "/var/www/html/sessions"'; \
    echo 'upload_max_filesize = 20M'; \
    echo 'post_max_size = 25M'; \
    echo 'memory_limit = 256M'; \
    echo 'max_execution_time = 120'; \
    } > /usr/local/etc/php/conf.d/custom.ini

# Copy application source
COPY src/ /var/www/html/

# Ensure writable directories exist
RUN mkdir -p /var/www/html/sessions \
    /var/www/html/templates_c \
    /var/www/html/admin_templates_c \
    /var/www/html/poster_photo \
    /var/www/html/bulkupload \
    && chown -R www-data:www-data /var/www/html/sessions \
    /var/www/html/templates_c \
    /var/www/html/admin_templates_c \
    /var/www/html/poster_photo \
    /var/www/html/bulkupload

EXPOSE 80
