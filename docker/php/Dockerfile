FROM php:8.4-fpm

WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    nodejs \
    npm \
    libzip-dev \
    libicu-dev \
    netcat-openbsd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure intl \
    && docker-php-ext-install \
        pdo \
        pdo_pgsql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        intl \
        zip

# Install Redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy configuration files
COPY ./docker/php/php.ini /usr/local/etc/php/conf.d/app.ini

# Copy composer files first for better layer caching
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev --no-scripts

# Copy package.json for better layer caching
COPY package.json package-lock.json* ./

# Install Node.js dependencies
RUN npm ci

# Copy the rest of the application code
COPY . .

# Build frontend assets
RUN npm run build

# Run post-install scripts and optimize Laravel
RUN php artisan vendor:publish --tag=livewire:assets --force && \
    php artisan vendor:publish --tag=filament-assets --force

RUN composer dump-autoload --optimize && \
    php artisan optimize && \
    php artisan filament:optimize && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Cambiar permisos
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Copy and configure the entrypoint script
COPY ./docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 9000

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
