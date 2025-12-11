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
    mariadb-server \
    && docker-php-ext-install pdo_mysql zip gd

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Copiar configuración de Apache
COPY ./docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Copiar proyecto
COPY . .

# Instalar dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader

# Generar key de Laravel
RUN php artisan key:generate --force

# Compilar assets
RUN npm install && npm run build

# Optimizar Laravel para producción
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

# Dar permisos
RUN chown -R www-data:www-data storage bootstrap/cache

# -----------------------------
# INICIAR MYSQL + APACHE
# -----------------------------
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 80

CMD ["/start.sh"]
