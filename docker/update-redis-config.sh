#!/bin/bash

# Obtener la ubicación de Redis desde el entorno de Docker
REDIS_ENV_FILE=".env"

echo "Actualizando la configuración de Redis en $REDIS_ENV_FILE"

# Actualizar Redis Host
sed -i 's/REDIS_HOST=127.0.0.1/REDIS_HOST=redis/g' $REDIS_ENV_FILE

echo "Configuración actualizada exitosamente"
