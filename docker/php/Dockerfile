FROM php:8.4-fpm

WORKDIR /var/www/html

# Instalar dependencias
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
    npm

# Limpiar cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensiones PHP
RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd

# Instalar redis
RUN pecl install redis && docker-php-ext-enable redis

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar archivos de configuración
COPY ./docker/php/php.ini /usr/local/etc/php/conf.d/app.ini

# Copiar código de la aplicación
COPY . .

# Instalar dependencias PHP
RUN composer install --optimize-autoloader --no-dev

# Instalar dependencias de Node.js y construir activos
RUN npm install && npm run build

# Optimizar Laravel y Filament
RUN php artisan optimize && \
    php artisan filament:optimize && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Cambiar permisos
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Instalar netcat para el script de entrypoint
RUN apt-get update && apt-get install -y netcat-openbsd && rm -rf /var/lib/apt/lists/*

# Copiar y configurar el script de entrypoint
COPY ./docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 9000

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
