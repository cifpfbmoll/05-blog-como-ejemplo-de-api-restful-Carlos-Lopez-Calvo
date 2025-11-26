FROM php:8.3-apache

# Instalar extensiones necesarias (SQLite, intl, zip, etc.)
RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    git \
    libzip-dev \
    sqlite3 \
    libsqlite3-dev \
    libicu-dev \
 && docker-php-ext-install pdo pdo_sqlite intl \
 && rm -rf /var/lib/apt/lists/*

# Habilitar mod_rewrite para que funcionen bien las rutas de CodeIgniter
RUN a2enmod rewrite

# Configurar Apache para usar el directorio public de CodeIgniter como DocumentRoot
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
 && sed -i 's|<Directory /var/www/html/>|<Directory /var/www/html/public/>|g' /etc/apache2/apache2.conf \
 && sed -i 's|AllowOverride None|AllowOverride All|g' /etc/apache2/apache2.conf

WORKDIR /var/www/html

# Copiar el binario de Composer desde la imagen oficial
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copiar el código del proyecto dentro de la imagen
COPY . .

# Marcar el repo como "seguro" para git (evita el warning de "dubious ownership")
RUN git config --global --add safe.directory /var/www/html

# Instalar dependencias PHP con Composer
RUN composer install --no-interaction --no-dev --optimize-autoloader \
 && chown -R www-data:www-data /var/www/html/writable

# Exponer el puerto HTTP
EXPOSE 80

# Apache ya viene configurado como CMD por la imagen base


