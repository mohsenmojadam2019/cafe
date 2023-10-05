FROM php:8.2-fpm
########################################################################################################################
# Install system dependencies
########################################################################################################################
RUN apt-get update && apt-get install -y \
    gnupg \
    apt-transport-https \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libmcrypt-dev \
    zlib1g-dev \
    libicu-dev \
    libxml2-dev \
    libssl-dev \
     libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libgd-dev \
      jpegoptim optipng pngquant gifsicle \
        libonig-dev \
        libxml2-dev \
    g++ \
    curl \
    wget \
    git \
    zip \
    locales \
    curl \
    && echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && locale-gen \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

ENV PHP_OPCACHE_ENABLE=1
ENV PHP_OPCACHE_ENABLE_CLI=0
ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS=1
ENV PHP_OPCACHE_REVALIDATE_FREQ=1

#FROM engesoftwarebr/laravel-oracle

# Install swoole
#RUN apk add --no-cache libstdc++ supervisor nano unzip ${PHPIZE_DEPS} \
#    && pecl install openswoole \
#    && docker-php-ext-enable openswoole \
#    && apk del ${PHPIZE_DEPS}

#
RUN docker-php-ext-configure pcntl --enable-pcntl \
  && docker-php-ext-install \
    pcntl
#

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

########################################################################################################################
# Install Docker-PHP Extensions, php 8.x and it's dependencies
########################################################################################################################
RUN docker-php-ext-install pdo \
    pdo_mysql


RUN curl -sS https://getcomposer.org/installer | php -- \
--install-dir=/usr/bin --filename=composer

COPY . /var/www
WORKDIR /var/www


COPY ./docker/php/php.ini /usr/local/etc/php/php.ini
COPY ./docker/php/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY ./docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

RUN #composer install --ignore-platform-reqs

#RUN chown -R www-data:www-data .
Run chown -R www-data:www-data /var/www
RUN docker-php-ext-install soap && docker-php-ext-enable soap


RUN chmod -R 775 /var/www/storage
RUN chmod -R 775 /var/www/bootstrap
RUN chmod -R ugo+rw bootstrap/cache/
RUN docker compose exec php composer i
RUN #docker-php-ext-install gd
#RUN php artisan cache:clear
#RUN php artisan up
#RUN php artisan optimize:clear
#CMD php artisan websockets:serve

#EXPOSE 8000
#EXPOSE 6001

