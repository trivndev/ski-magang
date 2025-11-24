FROM composer:2 AS composer
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist

FROM node:20-alpine AS assets
WORKDIR /app
COPY package*.json ./
RUN npm ci --no-audit --no-fund
COPY resources ./resources
COPY vite.config.js .
COPY tailwind.config.* ./
COPY postcss.config.* ./
COPY --from=composer /app/vendor /app/vendor
RUN npm run build

FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpq-dev \
    unzip \
    git \
    && docker-php-ext-install intl pdo_mysql pdo_pgsql bcmath \
    && docker-php-ext-enable pcntl

WORKDIR /app

COPY . /app
COPY --from=composer /app/vendor /app/vendor
COPY --from=assets /app/public/build /app/public/build

RUN php artisan storage:link || true
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

ENV PORT=8000
EXPOSE 8000

CMD ["php", "artisan", "octane:start", "--server=frankenphp", "--host=0.0.0.0", "--port=8000"]
