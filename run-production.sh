#!/bin/bash

# Exit on any error
set -e

echo "Starting production deployment for SG Finanzas..."

# Ensure necessary directories exist
mkdir -p docker/php docker/nginx

# Check if .env file exists
if [ ! -f .env ]; then
    echo "Error: .env file not found. Please create one based on .env.example"
    exit 1
fi

# Install predis if not installed
echo "Installing/checking for Predis..."
composer require predis/predis --no-interaction --quiet || true

# Update Redis configuration
echo "Updating Redis configuration..."
chmod +x docker/update-redis-config.sh
./docker/update-redis-config.sh

# Set permissions
echo "Setting file permissions..."
chmod +x docker/php/entrypoint.sh

# Build and run containers
echo "Stopping existing containers (if any)..."
docker compose down || true

echo "Building containers (this may take a while)..."
docker compose build --no-cache

echo "Starting containers..."
docker compose up -d

# Wait for services to be ready
echo "Waiting for services to initialize..."
sleep 10

# Show running containers
echo "Running containers:"
docker compose ps

echo "Application should now be available at http://localhost:8000"
echo ""
echo "Press Ctrl+C to stop viewing logs"
echo "To stop the application: docker compose down"
echo ""

# Show logs
docker compose logs -f
