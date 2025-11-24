# ------------------------------
# Stage 1 - Build Frontend (Vite)
# ------------------------------
FROM node:18 AS frontend
WORKDIR /app

# Copy package.json & install deps
COPY package*.json ./
RUN npm ci --no-audit --no-fund

# Copy source & build
COPY . .
RUN npm run build

# ------------------------------
# Stage 2 - Backend (Laravel + PHP + Composer)
# ------------------------------
FROM php:8.2-cli

WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl unzip libpq-dev libonig-dev libzip-dev zip \
    && docker-php-ext-install pdo pdo_mysql mbstring zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy Laravel app
COPY . .

# Copy built frontend from Stage 1
COPY --from=frontend /app/public/dist ./public/dist

# Prepare storage & bootstrap/cache
RUN mkdir -p storage/framework/{cache,views,sessions} bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && php artisan package:discover --ansi

# Laravel cache
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Set ownership for runtime
RUN chown -R www-data:www-data storage bootstrap/cache vendor

# Expose port Render
ENV PORT=10000
EXPOSE 10000

# Start Laravel Octane with FrankenPHP
CMD ["php", "artisan", "octane:start", "--server=frankenphp", "--host=0.0.0.0", "--port=10000", "--workers=4"]
