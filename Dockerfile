# Base image PHP + Apache
FROM php:8.2-apache

WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip npm libicu-dev libzip-dev libonig-dev libpq-dev \
    && docker-php-ext-install intl zip pdo_mysql bcmath pdo_pgsql \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Set Apache DocumentRoot ke public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Copy composer binary
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

# Prepare folders & permissions
RUN mkdir -p storage/framework/{cache,views,sessions} bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Build frontend assets if package.json exists
RUN if [ -f package.json ]; then npm ci --no-audit --no-fund && npm run build; fi

# Generate APP_KEY (jika belum ada)
RUN php artisan key:generate --ansi || true

# Laravel cache
RUN php artisan config:cache \
 && php artisan route:cache \
 && php artisan view:cache

# Expose Apache port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
