#!/bin/bash
set -e

# Iniciar MySQL
service mariadb start

# Crear base de datos si no existe
mysql -u root -e "CREATE DATABASE IF NOT EXISTS el_refugio CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Aplicar migraciones y seeders automáticamente
php artisan migrate --force --seed

# Iniciar Apache
apache2-foreground
