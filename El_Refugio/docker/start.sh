#!/bin/bash
set -e

if ! grep -q "APP_KEY=" .env 2>/dev/null; then
    echo "APP_KEY=${APP_KEY}" >> .env
fi

echo "Ejecutando migraciones y seeders..."
php artisan migrate --force --seed

echo "Arrancando Apache..."
exec apache2-foreground
