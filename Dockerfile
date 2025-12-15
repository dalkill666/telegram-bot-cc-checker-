FROM php:8.0-cli
WORKDIR /app
COPY . /app

# Install system dependencies
RUN apt-get update && apt-get install -y git unzip libzip-dev zip curl \
    && docker-php-ext-install pdo pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install --no-dev --optimize-autoloader || true

EXPOSE 8080
CMD ["php", "-S", "0.0.0.0:8080", "index.php"]
