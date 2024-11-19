FROM php:8.3-fpm

# Definir variáveis de argumento
ARG user=yourusername
ARG uid=1000

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Limpar cache do apt
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensões PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sockets

# Obter Composer mais recente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Criar usuário do sistema
RUN useradd -G www-data,root -u $uid -d /home/$user $user && \
    mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Instalar extensão Redis
RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

# Definir o diretório de trabalho
WORKDIR /var/www

# Copiar arquivos composer.json e composer.lock
COPY composer.json composer.lock /var/www/

# Instalar dependências do Composer
RUN composer install --no-scripts --no-autoloader

# Copiar restante do projeto
COPY . /var/www

# Rodar autoloader do Composer
RUN composer dump-autoload --optimize

# Copiar configurações PHP customizadas
COPY docker/php/custom.ini /usr/local/etc/php/conf.d/custom.ini

# Trocar para o usuário criado
USER $user
