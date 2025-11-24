FROM node:20-alpine AS assets
WORKDIR /app
COPY package*.json ./
RUN npm ci --no-audit --no-fund
COPY resources ./resources
COPY vite.config.js ./vite.config.js
RUN npm run build

FROM dunglas/frankenphp:1.2-php8.3 AS base

ARG APP_ENV=production
ENV APP_ENV=${APP_ENV}
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr
ENV PORT=8000

WORKDIR /app

RUN install-php-extensions \
    exif \
    pcntl \
    pdo_mysql \
    pgsql \
    pdo_pgsql \
    bcmath \
    intl \
    opcache

COPY --chown=www-data:www-data . /app
COPY --from=assets /app/public/build /app/public/build

RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader \
 && mkdir -p /app/storage/logs \
 && mkdir -p /app/storage/framework/cache \
 && mkdir -p /app/storage/framework/sessions \
 && mkdir -p /app/storage/framework/views \
 && php artisan storage:link \
 && php artisan config:cache \
 && php artisan route:cache \
 && php artisan view:cache \
 && chown -R www-data:www-data /app/storage /app/bootstrap/cache

EXPOSE 8000

USER www-data

CMD ["php", "artisan", "octane:start", "--server=frankenphp", "--host=0.0.0.0", "--port=${PORT}"]
