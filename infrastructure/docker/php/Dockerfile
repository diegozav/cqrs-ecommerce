FROM php:8.2-fpm-alpine AS development

COPY composer.json /var/www/html/composer.json
COPY composer.lock /var/www/html/composer.lock

RUN apk --update add --no-cache --virtual dev-deps \
        autoconf \
        automake \
        make \
        gcc \
        g++ \
        git \
    && apk add --no-cache \
        icu-dev \
        libzip-dev \
        libpq-dev \
        oniguruma-dev

RUN apk add gnu-libiconv=1.17-r1 --update-cache --repository http://dl-cdn.alpinelinux.org/alpine/edge/community
ENV LD_PRELOAD /usr/lib/preloadable_libiconv.so

RUN pecl install apcu \
    && docker-php-ext-install -j$(nproc) \
        bcmath \
        opcache \
        intl \
        pdo_mysql \
        pdo \
        pdo_pgsql \
    && docker-php-ext-install zip \
    && docker-php-ext-enable apcu

COPY /infrastructure/docker/php/php-dev.ini /usr/local/etc/php/php.ini

#COPY /infrastructure/docker/php/conf.d/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
#ADD infrastructure/docker/php/extensions/xdebug.sh /root/install-xdebug.sh

#RUN apk add linux-headers \
#    && sh /root/install-xdebug.sh


# Install composer
RUN wget https://getcomposer.org/installer && \
    php installer --install-dir=/usr/local/bin/ --filename=composer && \
    rm installer


FROM development AS testing

USER root
WORKDIR /var/www/html/

ENV APP_ENV=test

RUN composer install --no-interaction --optimize-autoloader

COPY --chown=www-data:www-data . /var/www/html


FROM testing AS production

USER root
WORKDIR /var/www/html/

ENV APP_ENV=prod

COPY /infrastructure/php/conf.d/opcache.ini /usr/local/etc/php/conf.d/
COPY /etc/php/php.ini-production "$PHP_INI_DIR/php.ini"

RUN docker-php-ext-enable opcache \
    && composer update --no-dev --no-interaction --optimize-autoloader

ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS=0 \
    PHP_OPCACHE_MAX_ACCELERATED_FILES=8000 \
    PHP_OPCACHE_MEMORY_CONSUMPTION=128

RUN apk del dev-deps && \
    rm -vrf /var/cache/apk/* && \
    rm /usr/local/bin/composer

RUN chown -R www-data:www-data /var/www/html/*

