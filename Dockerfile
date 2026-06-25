FROM composer:2.8 AS vendor

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --no-progress \
    --optimize-autoloader \
    --no-scripts

FROM node:22-bookworm-slim AS frontend

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY resources ./resources
COPY public ./public
COPY vite.config.js ./
RUN rm -f public/hot && npm run build

FROM php:8.3-fpm-bookworm AS app-runtime

WORKDIR /var/www/html

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        libicu-dev \
        libsqlite3-dev \
        unzip \
    && docker-php-ext-install -j"$(nproc)" \
        bcmath \
        intl \
        opcache \
        pcntl \
        pdo_sqlite \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2.8 /usr/bin/composer /usr/local/bin/composer
COPY . .
COPY --from=vendor /app/vendor ./vendor
COPY --from=frontend /app/public/build ./public/build

RUN rm -f public/hot \
    && mkdir -p /opt/app-template/storage/app/public \
    && mkdir -p /opt/app-template/storage/app/private \
    && mkdir -p /opt/app-template/storage/framework/cache/data \
    && mkdir -p /opt/app-template/storage/framework/sessions \
    && mkdir -p /opt/app-template/storage/framework/views \
    && mkdir -p /opt/app-template/storage/logs \
    && mkdir -p /opt/app-template/storage/database \
    && if [ -d storage/app/public ]; then cp -a storage/app/public/. /opt/app-template/storage/app/public/; fi \
    && chown -R www-data:www-data /var/www/html /opt/app-template/storage

COPY docker/php/conf.d/app.ini /usr/local/etc/php/conf.d/99-app.ini
COPY docker/php/conf.d/opcache.ini /usr/local/etc/php/conf.d/10-opcache.ini
COPY docker/php-fpm/zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf
COPY docker/entrypoint.sh /usr/local/bin/app-entrypoint

RUN chmod +x /usr/local/bin/app-entrypoint

ENTRYPOINT ["app-entrypoint"]
CMD ["php-fpm", "-F"]

FROM nginx:1.27-alpine AS nginx-runtime

WORKDIR /var/www

COPY public ./public
COPY --from=frontend /app/public/build ./public/build
COPY docker/nginx/default.http.conf.template /opt/nginx/templates/default.http.conf.template
COPY docker/nginx/default.https.conf.template /opt/nginx/templates/default.https.conf.template
COPY docker/nginx/10-select-template.envsh /docker-entrypoint.d/10-select-template.envsh

RUN rm -f public/hot \
    && mkdir -p /etc/nginx/templates \
    && rm -f /etc/nginx/conf.d/default.conf.default 2>/dev/null || true
