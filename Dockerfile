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

# Allow .htaccess overrides in document root
RUN echo '<Directory /var/www/html>\n    AllowOverride All\n</Directory>' > /etc/apache2/conf-available/allowoverride.conf \
    && a2enconf allowoverride
