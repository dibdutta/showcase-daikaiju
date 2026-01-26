FROM php:8.3-apache

# Install mysqli extension
RUN docker-php-ext-install mysqli

# Enable mysqli
RUN docker-php-ext-enable mysqli
