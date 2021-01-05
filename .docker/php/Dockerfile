FROM php:7.4-fpm

RUN apt-get update

RUN apt-get install -y --no-install-recommends \
    libmemcached-dev \
    libz-dev \
    libpq-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libssl-dev \
    libmcrypt-dev

# install extensions
RUN docker-php-ext-install pdo_mysql && \
    apt-get -y install libxml2-dev && \
    docker-php-ext-install soap && \
	docker-php-ext-install bcmath && \
    apt-get install -y libzip-dev && \
    docker-php-ext-install zip

# XDebug
RUN pecl install xdebug \
	&& docker-php-ext-enable xdebug

# composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.0.7 && chmod +x /usr/local/bin/composer

WORKDIR /var/www

EXPOSE 8000

ENTRYPOINT ["php-fpm"]
