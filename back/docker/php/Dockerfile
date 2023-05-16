FROM php:8-fpm

# Copia arquivo de configuração do php.ini para o container
COPY php.ini /etc/php/php.ini

# Atualiza o sistema e instala lib do postgres
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql

# Deixa exposto porta 9000 que será um proxy reverso no Nginx
EXPOSE 9000

CMD ["php-fpm"]