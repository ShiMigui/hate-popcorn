FROM php:8.5-fpm-alpine

RUN apk add --no-cache postgresql-dev libpng-dev libjpeg-turbo-dev freetype-dev \
  && docker-php-ext-configure gd --with-jpeg --with-freetype \
  && docker-php-ext-install pdo_pgsql gd

WORKDIR /var/www/html

COPY . .

RUN mkdir -p uploads/tmp public/imgs \
  && chown -R www-data:www-data uploads public/imgs
