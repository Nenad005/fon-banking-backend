FROM composer:2 AS composer

FROM serversideup/php:8.4-fpm-nginx AS dependencies

WORKDIR /app

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY --chown=www-data:www-data composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-scripts \
    --no-autoloader \
    --prefer-dist

COPY --chown=www-data:www-data . .
RUN composer dump-autoload \
    --no-dev \
    --optimize \
    --no-interaction

FROM serversideup/php:8.4-fpm-nginx

ENV APP_ENV=production \
    APP_DEBUG=false \
    LOG_CHANNEL=stderr \
    PHP_OPCACHE_ENABLE=1

COPY --from=dependencies --chown=www-data:www-data /app /var/www/html

EXPOSE 8080

HEALTHCHECK --interval=30s --timeout=5s --start-period=10s --retries=3 \
    CMD curl --fail --silent http://127.0.0.1:8080/up > /dev/null || exit 1
