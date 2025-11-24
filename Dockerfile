# -----------------------------
# Stage 1 - Build Frontend (Vite)
# -----------------------------
FROM node:20 AS frontend

WORKDIR /app

# Install build tools & library native untuk Vite
RUN apt-get update && apt-get install -y \
    git curl unzip php-cli libzip-dev zip python3 g++ make libpng-dev libjpeg-dev libfreetype6-dev \
    && rm -rf /var/lib/apt/lists/*

# Copy composer files & install PHP dependencies dulu
COPY composer.json composer.lock ./
RUN php -d memory_limit=-1 $(which composer) install --no-dev --optimize-autoloader

# Copy package.json & install Node dependencies
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
FROM php:8.4-fpm

# Install PHP extensions & PostgreSQL driver
RUN apt-get update && apt-get install -y \
    git curl unzip libpq-dev libonig-dev libzip-dev zip \
    libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip gd \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy Laravel app files
COPY . .

# Copy hasil build frontend
COPY --from=frontend /app/dist ./public/dist

# Install PHP dependencies (redundant, tapi aman)
RUN php -d memory_limit=-1 /usr/bin/composer install --no-dev --optimize-autoloader

# Clear Laravel caches
RUN php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear

# Expose port untuk Render
EXPOSE 8080

# Start PHP-FPM di foreground
CMD ["php-fpm", "-F"]
