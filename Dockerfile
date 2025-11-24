# === Base Image: FrankenPHP (Laravel Octane) ===
FROM dunglas/frankenphp:latest AS base

# Install dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip npm libicu-dev libpq-dev libzip-dev \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /app

# Copy composer from official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Install Node dependencies & build frontend
RUN npm ci --no-audit --no-fund && npm run build

# Cache Laravel config, routes, views
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# Expose the port Railway expects (default Laravel Octane)
EXPOSE 8000

# Start Octane via FrankenPHP
CMD ["php", "artisan", "octane:start", "--server=frankenphp", "--host=0.0.0.0", "--port=8000"]
