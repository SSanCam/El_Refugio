#!/bin/bash
set -e

echo "🔧 Ejecutando migraciones y seeders..."
php artisan migrate --force --seed || true

echo "🚀 Arrancando Apache..."
exec apache2-foreground
