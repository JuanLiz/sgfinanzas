#!/bin/sh

# Esperar a que Redis esté disponible
echo "Esperando a que Redis esté disponible..."
while ! nc -z redis 6379; do
  sleep 1
done
echo "Redis está disponible"

# Verify and fix directory permissions
echo "Verificando permisos..."

# Fix storage and cache permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Limpiar cache en caso de cambios
php artisan optimize:clear

# Optimizar Laravel
echo "Optimizando Laravel..."
php artisan optimize

# Optimizar Filament
echo "Optimizando Filament..."
php artisan filament:optimize

# Iniciar PHP-FPM
echo "Iniciando PHP-FPM..."
php-fpm
