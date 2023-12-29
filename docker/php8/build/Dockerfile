FROM php:8.2-fpm

RUN apt-get update --fix-missing
RUN apt-get install -y software-properties-common

RUN apt-get install -y neovim vifm

COPY ./vimrc /etc/vim/vimrc

#composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN apt-get install -y libzip-dev libpng-dev git zip curl
RUN apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libxslt-dev libicu-dev libmcrypt-dev libpng-dev libwebp-dev libxml2-dev libpq-dev

RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp
RUN docker-php-ext-install zip gd mysqli pdo pdo_mysql sockets

#run
CMD ["php-fpm"]