# syntax=docker/dockerfile:1.4
ARG PHP_VERSION=8.4
ARG NODE_VERSION=22

#---------------------------------
# Base Image
#---------------------------------
FROM ghcr.io/yieldstudio/php:${PHP_VERSION}-frankenphp AS base

ENV HEALTHCHECK_PATH="/up"

#---------------------------------
# Composer Build
#---------------------------------
FROM base AS composer

WORKDIR /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY --chown=www-data:www-data composer.json composer.lock* ./

RUN --mount=type=cache,target=/tmp/.composer-cache \
    composer config cache-dir /tmp/.composer-cache

RUN --mount=type=cache,target=/tmp/.composer-cache \
    composer install --no-dev --no-interaction --no-scripts --prefer-dist --no-autoloader

COPY --chown=www-data:www-data . .

RUN --mount=type=cache,target=/tmp/.composer-cache \
    composer dump-autoload --classmap-authoritative --no-dev --optimize

#---------------------------------
# Assets Build
#---------------------------------
FROM node:${NODE_VERSION}-slim AS frontend

WORKDIR /app

COPY package*.json ./

RUN --mount=type=cache,target=/root/.npm \
    npm ci --prefer-offline --no-audit

COPY public/ ./public
COPY resources/ ./resources
COPY --from=composer /var/www/html/vendor ./vendor

RUN npm run build

#---------------------------------
# Production Image
#---------------------------------
FROM base

ENV \
    AUTORUN_ENABLED=true \
    SSL_MODE=off \
    PHP_OPCACHE_ENABLE=1 \
    PHP_MEMORY_LIMIT=512M \
    OCTANE_SERVER=frankenphp \
    HEALTHCHECK_PATH="/up"

USER www-data

COPY --from=composer --chown=www-data:www-data /var/www/html/vendor ./vendor

COPY --from=frontend --chown=www-data:www-data /app/public/build ./public/build

COPY --chown=www-data:www-data . /var/www/html

RUN php artisan octane:install --server=frankenphp -n
