#!/bin/bash

# Asegurarse de que los directorios necesarios existan
mkdir -p docker/php docker/nginx

# Instalar predis si no está instalado
composer require predis/predis --no-interaction

# Actualizar configuración de Redis
chmod +x docker/update-redis-config.sh
./docker/update-redis-config.sh

# Dar permisos al script de entrypoint
chmod +x docker/php/entrypoint.sh

# Construir y ejecutar los contenedores
echo "Construyendo y ejecutando los contenedores..."
docker-compose down
docker-compose build --no-cache
docker-compose up -d

# Mostrar los logs
echo "Mostrando logs de la aplicación..."
docker-compose logs -f
