#!/bin/sh

echo "Waiting for Redis to be available..."
while ! nc -z redis 6379; do
  sleep 1
done
echo "Redis ready."

# Verify and fix directory permissions
echo "Fixing directory permissions..."

# Fix storage and cache permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Iniciar PHP-FPM
echo "Starting PHP-FPM..."
php-fpm
