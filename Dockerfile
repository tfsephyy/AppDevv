FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    unzip curl git libzip-dev zip libpng-dev libonig-dev libxml2-dev

# Install PHP extensions required by Laravel
RUN docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy project files
COPY . .

# Install dependencies and setup Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader \
    && cp .env.example .env \
    && php artisan key:generate \
    && php artisan config:clear \
    && php artisan cache:clear \
    && php artisan route:clear \
    && php artisan view:clear \
    && chmod -R 775 storage bootstrap/cache

# OPTIONAL: enable debug (remove later in production)
RUN sed -i 's/APP_DEBUG=false/APP_DEBUG=true/' .env

# Expose port (Render uses dynamic port)
EXPOSE 10000

# Start Laravel server
CMD php artisan serve --host=0.0.0.0 --port=$PORT