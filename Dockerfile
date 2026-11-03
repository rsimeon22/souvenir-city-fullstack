FROM php:8.2-apache

# Install PHP/MySQL dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install mysqli pdo pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

# Configure Apache
# Explicitly enable only the prefork MPM
RUN rm -f /etc/apache2/mods-enabled/mpm_*.load \
    /etc/apache2/mods-enabled/mpm_*.conf \
    && a2enmod mpm_prefork rewrite \
    && apache2ctl -t \
    && apache2ctl -M 2>&1 | grep mpm
# Set working directory
WORKDIR /var/www/html

# Copy Composer from official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy project
COPY . /var/www/html/

# Install PHP dependencies from composer.lock
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction

# Apache permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]

CMD ["sh", "-c", "echo '=== ENABLED MPM FILES ==='; ls -la /etc/apache2/mods-enabled/mpm* 2>&1; echo '=== MPM LOADMODULE DIRECTIVES ==='; grep -RInE '^[[:space:]]*LoadModule[[:space:]]+mpm_' /etc/apache2/mods-enabled /etc/apache2/apache2.conf 2>&1; echo '=== APACHE CONFIG INCLUDES ==='; grep -n 'Include' /etc/apache2/apache2.conf; echo '=== HOLDING CONTAINER ==='; sleep 3600"]