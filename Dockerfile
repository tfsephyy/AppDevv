FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    unzip curl git libzip-dev zip

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install

CMD php artisan serve --host=0.0.0.0 --port=$PORT