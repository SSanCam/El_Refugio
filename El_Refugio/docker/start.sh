#!/bin/bash
set -e

# Asegurar que .env existe
if [ ! -f /var/www/html/.env ]; then
    echo ".env not found — creating from example..."
    cp /var/www/html/.env.example /var/www/html/.env
fi

# Generar APP_KEY si falta
if ! grep -q "APP_KEY=base64" /var/www/html/.env ; then
    echo "Generating APP_KEY..."
    php artisan key:generate --force
fi

# Migraciones
echo "Ejecutando migraciones y seeders..."
php artisan migrate --force --seed || true

# Iniciar Apache
echo "Arrancando Apache..."
exec apache2-foreground
