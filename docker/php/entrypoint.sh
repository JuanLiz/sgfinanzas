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

# Iniciar PHP-FPM
echo "Iniciando PHP-FPM..."
php-fpm
