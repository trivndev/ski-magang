# ------------------------------
# Stage 1 - Build Frontend (Vite)
# ------------------------------
FROM node:18 AS frontend
WORKDIR /app

# Copy package files & install deps
COPY package*.json ./
RUN npm ci --no-audit --no-fund

# Copy all source & build
COPY . .
RUN npm run build

# ------------------------------
# Stage 2 - Backend (Laravel + PHP + Composer)
# ------------------------------
FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl unzip libpq-dev libonig-dev libzip-dev zip \
    && docker-php-ext-install pdo pdo_mysql mbstring zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy Laravel app
COPY . .

# Copy built frontend assets
COPY --from=frontend /app/public/dist ./public/dist

# Prepare storage & bootstrap/cache
RUN mkdir -p storage/framework/{cache,views,sessions} bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Install PHP dependencies & discover packages
RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && php artisan package:discover --ansi

# Laravel cache
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Set owner to www-data
RUN chown -R www-data:www-data storage bootstrap/cache vendor

# Expose port for FrankenPHP / Octane
EXPOSE 8080

# Start Laravel Octane with FrankenPHP
CMD ["php", "artisan", "octane:start", "--server=frankenphp", "--host=0.0.0.0", "--port=8080", "--workers=4"]
