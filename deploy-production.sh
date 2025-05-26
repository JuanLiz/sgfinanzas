#!/bin/bash

echo "Preparando entorno para producción..."

# Verificar si existe .env.production
if [ -f .env.production ]; then
    echo "Copiando .env.production a .env para entorno de producción..."
    cp .env.production .env
    echo "Archivo de entorno para producción copiado correctamente."
else
    echo "Advertencia: No se encontró .env.production. Usando .env actual."
    
    # Actualizar variables críticas para producción en el .env actual
    sed -i 's/APP_ENV=.*/APP_ENV=production/' .env
    sed -i 's/APP_DEBUG=.*/APP_DEBUG=false/' .env
    sed -i 's/REDIS_HOST=127.0.0.1/REDIS_HOST=redis/' .env
    sed -i 's/LOG_LEVEL=.*/LOG_LEVEL=error/' .env
    
    echo "Variables críticas actualizadas en .env para entorno de producción."
fi

# Configurar permisos para los scripts
chmod +x docker/php/entrypoint.sh
chmod +x docker/update-redis-config.sh

# Verificar si se necesita ejecutar composer install
if [ ! -d "vendor" ] || [ ! -f "vendor/autoload.php" ]; then
    echo "Instalando dependencias con Composer..."
    composer install --optimize-autoloader --no-dev
fi

# Construir y ejecutar los contenedores
echo "Construyendo y ejecutando los contenedores..."
docker-compose down
docker-compose build --no-cache
docker-compose up -d

# Mostrar servicios activos
echo "Servicios Docker activos:"
docker-compose ps

echo ""
echo "=========== APLICACIÓN LISTA ==========="
echo "La aplicación está ejecutándose en: http://localhost"
echo "Puedes verificar los logs con: docker-compose logs -f"
echo "========================================="
