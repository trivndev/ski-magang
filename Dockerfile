FROM node:20 AS frontend

WORKDIR /app

# Install PHP & Composer minimal untuk dependency
RUN apt-get update && apt-get install -y git curl unzip php-cli libzip-dev zip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

COPY package*.json ./
RUN npm install

COPY . .

ARG VITE_API_URL
ENV VITE_API_URL=$VITE_API_URL

RUN npm run build

# -----------------------------
# Stage 2 - Backend (Laravel + PHP)
# -----------------------------
FROM php:8.2-fpm

# Install PHP dependencies & PostgreSQL driver
RUN apt-get update && apt-get install -y \
    git curl unzip libpq-dev libonig-dev libzip-dev zip \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy Laravel app files
COPY . .

# Copy hasil build frontend
COPY --from=frontend /app/dist ./public/dist

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Clear Laravel caches
RUN php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear

# Expose port untuk Render
EXPOSE 8080

# Start PHP-FPM di foreground
CMD ["php-fpm", "-F"]
