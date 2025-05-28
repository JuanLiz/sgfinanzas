#!/bin/bash

echo "Preparing environment for production..."

# Check if .env.production exists
if [ -f .env.production ]; then
    echo "Copying .env.production to .env for production environment..."
    cp .env.production .env
    echo "Production environment file copied successfully."
else
    echo "Warning: .env.production not found. Using current .env file."
    
    # Update critical variables for production in the current .env file
    sed -i 's/APP_ENV=.*/APP_ENV=production/' .env
    sed -i 's/APP_DEBUG=.*/APP_DEBUG=false/' .env
    sed -i 's/REDIS_HOST=127.0.0.1/REDIS_HOST=redis/' .env
    sed -i 's/LOG_LEVEL=.*/LOG_LEVEL=error/' .env
    
    echo "Critical variables updated in .env for production environment."
fi

# Configure permissions for scripts
chmod +x docker/php/entrypoint.sh

# Check if composer install needs to be executed
if [ ! -d "vendor" ] || [ ! -f "vendor/autoload.php" ]; then
    echo "Installing dependencies with Composer..."
    composer install --optimize-autoloader --no-dev
fi

# Build and run containers
echo "Building and running containers..."
docker-compose down  --remove-orphans
docker-compose build --no-cache
docker-compose up -d

# Show active services
echo "Active Docker services:"
docker-compose ps

echo ""
echo "=========== APPLICATION READY ==========="
echo "The application is running at: http://localhost"
echo "You can check the logs with: docker-compose logs -f"
echo "==========================================="
