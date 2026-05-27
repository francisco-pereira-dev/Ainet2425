# 1. Usa o PHP com um servidor web Apache integrado
FROM php:8.3-apache

# 2. Instala os pacotes do sistema e Node.js (para o Frontend)
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    nodejs \
    npm

# 3. Instala as extensões de PHP necessárias para o Laravel
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# 4. Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Configura o Apache para apontar para a pasta /public do Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite

# 6. Define a pasta de trabalho
WORKDIR /var/www/html

# 7. Copia todos os ficheiros do teu projeto para dentro do servidor
COPY . .

# 8. Instala as dependências do PHP e do JavaScript
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_MEMORY_LIMIT=-1
RUN composer install --optimize-autoloader --no-dev --no-scripts --no-interaction --ignore-platform-reqs
RUN npm install
RUN npm run build

# 9. Dá as permissões corretas às pastas críticas do Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 10. Executa as migrações e arranca o servidor Apache
CMD php artisan migrate:fresh --seed --force && apache2-foreground