FROM php:8.2-fpm-alpine3.17

ARG USER=app
ARG UID=1000
ARG GID=1000

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

ENV XDEBUG_MODE coverage

RUN apk add --no-cache --update git less curl linux-headers

RUN install-php-extensions mbstring bcmath exif gd pcntl intl mysqlnd pdo_mysql mysqli zip xdebug

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

RUN addgroup -S -g $GID app && adduser -u $UID -G app -D app

RUN chown -R app:app /var/www/

USER $USER

WORKDIR /var/www/
