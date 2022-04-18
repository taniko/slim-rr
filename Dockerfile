FROM composer:2.3.5 as build
WORKDIR /usr/src/app
COPY . ./

RUN docker-php-ext-install sockets

RUN composer install --no-dev

FROM php:8.1.4-alpine3.15

WORKDIR /usr/src/app
COPY --from=build /usr/src/app ./

RUN docker-php-ext-install sockets
RUN ./vendor/bin/rr get

CMD ["./rr", "serve"]