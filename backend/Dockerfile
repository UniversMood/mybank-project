FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl libzip-dev zip unzip \
    && docker-php-ext-install pdo_mysql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy everything and let composer install normally
COPY . .

# Install dependencies (will use existing composer.lock)
RUN composer install --no-scripts

# Set permissions
RUN chown -R www-data:www-data /var/www/html || true

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]