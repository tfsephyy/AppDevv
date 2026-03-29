FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    unzip curl git libzip-dev zip libpng-dev libonig-dev libxml2-dev

RUN docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

# ONLY install dependencies here
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Fix permissions
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 10000

# Run Laravel setup when container starts (NOT build time)
CMD cp .env.example .env \
    && php artisan key:generate \
    && php artisan config:clear \
    && php artisan cache:clear \
    && php artisan serve --host=0.0.0.0 --port=$PORT