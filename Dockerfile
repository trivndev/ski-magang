# -----------------------------
# Stage 1 - Build Frontend (Vite)
# -----------------------------
FROM node:20 AS frontend

WORKDIR /app

# Install build tools & library native untuk dependency Vite
RUN apt-get update && apt-get install -y \
    python3 g++ make libzip-dev zlib1g-dev \
    && rm -rf /var/lib/apt/lists/*

# Copy package.json & package-lock.json
COPY package*.json ./
RUN npm install

# Copy seluruh source code
COPY . .

# Set env vars Vite (Render akan inject via ARG)
ARG VITE_API_URL
ENV VITE_API_URL=$VITE_API_URL

# Build frontend
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
