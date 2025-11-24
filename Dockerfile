FROM dunglas/frankenphp:latest

RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    npm \
    libicu-dev \
    libpq-dev \
    libzip-dev

WORKDIR /app

COPY . .

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN npm ci --no-audit --no-fund && npm run build

RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

ENV PORT=8080
EXPOSE 8080

CMD ["php", "artisan", "octane:start", "--server=frankenphp", "--host=0.0.0.0", "--port=8080"]
