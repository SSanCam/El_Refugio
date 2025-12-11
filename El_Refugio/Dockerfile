FROM php:8.2-apache

# -----------------------------
# Instalación de extensiones
# -----------------------------
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    pkg-config \
    curl

# Extensiones PHP
RUN docker-php-ext-install zip gd pdo_pgsql

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Copiar configuración de Apache
COPY ./docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Instalar Node (para Vite)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Directorio de trabajo
WORKDIR /var/www/html

# Copiar proyecto (sin .env)
COPY . .

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-ansi

# Instalar dependencias JS y construir Vite
RUN npm install && npm run build

# Optimizar Laravel
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Permisos
RUN chown -R www-data:www-data storage bootstrap/cache

# Copiar start script
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

# Exponer puerto HTTP
EXPOSE 80

# Arranque del contenedor
ENTRYPOINT ["/start.sh"]
CMD ["apache2-foreground"]
