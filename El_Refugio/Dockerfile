FROM php:8.2-apache

# Extensiones del sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq5 \
    libpq-dev \
    pkg-config \
    curl

# Extensiones PHP
RUN docker-php-ext-install zip gd pdo_pgsql pgsql

# Apache
RUN a2enmod rewrite
COPY ./docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Node para Vite
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

WORKDIR /var/www/html

# Copiar proyecto
COPY . .

#Crea archivo .env 
RUN cp .env.example .env

# Dependencias PHP
RUN composer install --optimize-autoloader --no-interaction --no-ansi

# Build Vite
RUN npm install && npm run build

# Cache de Laravel
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Permisos
RUN chown -R www-data:www-data storage bootstrap/cache

# Start script
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 80

ENTRYPOINT ["/start.sh"]
CMD ["apache2-foreground"]
