#!/bin/bash
set -e

echo "Iniciando El Refugio en entorno de producción"

# Comprobar existencia de APP_KEY
if [ -z "$APP_KEY" ]; then
    echo "APP_KEY no definida. Generando clave de aplicación"
    php artisan key:generate --force
fi

echo "Limpiando caches de Laravel"
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

echo "Ejecutando migraciones de base de datos"
php artisan migrate --force

echo "Generando caches optimizados"
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Arrancando servidor Apache"
exec apache2-foreground
