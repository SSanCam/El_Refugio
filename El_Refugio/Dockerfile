FROM php:8.2-apache

# Dependencias del sistema
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
    curl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Extensiones PHP
RUN docker-php-ext-install zip gd pdo_pgsql pgsql

# Apache
RUN a2enmod rewrite

# 👉 Render usa la variable PORT
ENV PORT=10000

# Apache debe escuchar en $PORT
RUN sed -i 's/Listen 80/Listen ${PORT}/' /etc/apache2/ports.conf

COPY ./docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Node para Vite
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

WORKDIR /var/www/html

# Copiar proyecto
COPY . .

# Dependencias PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Build frontend
RUN npm install && npm run build

# Permisos Laravel
RUN mkdir -p bootstrap/cache \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views && \
    chown -R www-data:www-data storage bootstrap && \
    chmod -R 775 storage bootstrap/cache

# Script de arranque
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

# 👉 Exponer el puerto de Render
EXPOSE 10000

ENTRYPOINT ["/start.sh"]
CMD ["apache2-foreground"]
