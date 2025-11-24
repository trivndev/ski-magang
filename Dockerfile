# -----------------------------
# Stage 1 - Build Frontend (Vite)
# -----------------------------
FROM node:20 AS frontend

WORKDIR /app

# Install build tools (untuk package native seperti esbuild, sharp, dll.)
RUN apt-get update && apt-get install -y python3 g++ make

# Copy package.json & package-lock.json dan install deps
COPY package*.json ./
RUN npm install

# Copy seluruh source code
COPY . .

# Set env vars Vite jika ada (Render akan inject via environment)
ARG VITE_API_URL
ENV VITE_API_URL=$VITE_API_URL

# Build frontend
RUN npm run build

# -----------------------------
# Stage 2 - Backend (Laravel + PHP)
# -----------------------------
FROM php:8.2-fpm AS backend

# Install system dependencies PHP
RUN apt-get update && apt-get install -y \
    git curl unzip libpq-dev libonig-dev libzip-dev zip \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy Laravel app files
COPY . .

# Copy hasil build frontend dari stage 1
COPY --from=frontend /app/dist ./public/dist

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Clear Laravel caches
RUN php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear

# Expose port untuk Render
EXPOSE 8080

# Start PHP-FPM
CMD ["php-fpm", "-F"]
