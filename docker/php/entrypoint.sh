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

# Fix Git directory permissions if it exists
if [ -d "/var/www/html/.git" ]; then
    echo "Corrigiendo permisos de Git..."
    # Add git directory as safe directory
    git config --global --add safe.directory /var/www/html
    # Make directory accessible but protect important files
    find /var/www/html/.git -type d -exec chmod 755 {} \;
    find /var/www/html/.git -type f -exec chmod 644 {} \;
fi

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
