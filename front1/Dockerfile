ARG PHP_VERSION=""
FROM php:${PHP_VERSION:+${PHP_VERSION}-}apache

RUN a2enmod rewrite headers

COPY ./ /var/www/html/
