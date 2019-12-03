FROM php:7.4-fpm-alpine

LABEL maintainer = <gievoi.v@gmail.com>

ENV TZ=UTC

RUN set -xe \
    && apk add --no-cache --update libmemcached-libs zlib ca-certificates tzdata postgresql-dev \
    && cd /tmp/ \
    && apk add --no-cache --update --virtual .phpize-deps $PHPIZE_DEPS \
    && apk add --no-cache --update --virtual .memcached-deps zlib-dev libmemcached-dev cyrus-sasl-dev\
    && pecl install igbinary && \
    ( \
        pecl install --nobuild memcached && \
        cd "$(pecl config-get temp_dir)/memcached" && \
        phpize && \
        ./configure --enable-memcached-igbinary && \
        make -j$(nproc) && \
        make install && \
        cd /tmp/ \
    ) \
    && docker-php-ext-enable igbinary memcached \
    && docker-php-ext-install json bcmath sockets opcache pdo pdo_pgsql \
    && apk add --no-cache --update libpq \
    && rm -rf /tmp/* \
    && apk del .memcached-deps .phpize-deps postgresql-dev \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN mkdir -p /var/application/cache \
    && mkdir -p /var/application/metadata \
    && chown -R www-data:www-data /var/application \
    && chmod 775 -R /var/application

COPY ./app /application

RUN composer install -d /application \
    && composer test -d /application \
    && composer install -d /application --no-dev --optimize-autoloader --apcu-autoloader

WORKDIR /application

EXPOSE 9000 8080

CMD ["php-fpm", "-F", "-R"]
