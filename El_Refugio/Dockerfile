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
    && docker-php-ext-install zip gd pdo_pgsql

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Copiar configuración de Apache (DocumentRoot → public)
COPY ./docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Copiar proyecto
COPY . .

# Instalar dependencias PHP para producción
RUN composer install --no-dev --optimize-autoloader

# Dar permisos necesarios a Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

# Exponer puerto HTTP
EXPOSE 80

# Arranque del servidor Apache
CMD ["apache2-foreground"]
