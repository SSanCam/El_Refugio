#!/bin/bash
set -e

echo "Generando APP_KEY si no existe..."
if [ ! -f /var/www/html/storage/app/.env.generated ]; then
    php artisan key:generate --force
    touch /var/www/html/storage/app/.env.generated
fi

echo "Ejecutando migraciones y seeders..."
php artisan migrate --force --seed

echo "Arrancando Apache..."
exec apache2-foreground
