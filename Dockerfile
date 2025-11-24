# Base PHP + Apache
FROM php:8.2-apache

WORKDIR /var/www/html

# System deps
RUN apt-get update && apt-get install -y git curl zip unzip npm libicu-dev libzip-dev libonig-dev libpq-dev \
    && docker-php-ext-install intl zip pdo_mysql bcmath pdo_pgsql \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Apache port 8080 & DocumentRoot
RUN sed -i 's/80/8080/' /etc/apache2/ports.conf \
    && sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy project
COPY . .

# Permissions
RUN mkdir -p storage/framework/{cache,views,sessions} bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# PHP deps
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Optional: build assets
RUN if [ -f package.json ]; then npm ci --no-audit --no-fund && npm run build; fi

# Laravel setup
RUN php artisan key:generate --ansi || true \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

EXPOSE 80

CMD ["apache2-foreground"]
