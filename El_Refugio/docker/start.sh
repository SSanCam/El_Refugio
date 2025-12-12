#!/bin/bash
set -e

echo "Iniciando El Refugio en entorno de producción"

# Comprobar existencia de APP_KEY
if [ -z "$APP_KEY" ]; then
    echo "APP_KEY no definida. Generando clave de aplicación"
    php artisan key:generate --force
fi

echo "Ejecutando migraciones de base de datos"
php artisan migrate --force

echo "Arrancando servidor Apache"
exec apache2-foreground
