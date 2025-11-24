# Base image FrankenPHP
FROM dunglas/frankenphp:latest

WORKDIR /app

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip npm libicu-dev libzip-dev libonig-dev libpq-dev \
    && docker-php-ext-install intl zip pdo_mysql bcmath pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# Copy composer binary
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy application code
COPY . .

# Prepare folders & permissions
RUN mkdir -p storage/framework/cache storage/framework/views storage/framework/sessions bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Build frontend assets if package.json exists
RUN if [ -f package.json ]; then npm ci --no-audit --no-fund && npm run build; fi

# Cache Laravel config, routes, views
RUN php artisan config:cache \
 && php artisan route:cache \
 && php artisan view:cache

# Expose default Railway port
EXPOSE 8000

# Start Laravel built-in server (simpler dari Octane)
CMD ["sh", "-c", "php artisan serve --host=0.0]()
