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

# # Publish Livewire and Filament assets
# if [ -f /var/www/html/artisan ]; then
#     echo "Publishing assets..."
#     php artisan vendor:publish --tag=livewire:assets --force
#     php artisan vendor:publish --tag=filament-assets --force
    
#     # Clear any existing caches
#     php artisan optimize:clear
    
#     # Generate app key if not set
#     php artisan key:generate --force
    
#     # Rebuild optimized files
#     php artisan optimize
#     php artisan view:cache
#     php artisan config:cache
# fi

# Start PHP-FPM
echo "Starting PHP-FPM..."
php-fpm
