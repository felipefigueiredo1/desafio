FROM php:8-fpm

# Copia arquivo de configuração do php.ini para o container
COPY php.ini /etc/php/php.ini

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Atualiza o sistema e instala lib do postgres
RUN apt-get update && apt-get install -y \
    git \
    libpq-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_pgsql

WORKDIR /var/www/html

# Deixa exposto porta 9000 que será um proxy reverso no Nginx
EXPOSE 9000

CMD ["php-fpm"]