FROM php:8.3-fpm-alpine

RUN apk add --no-cache \
    linux-headers \
    oniguruma-dev \
    libxml2-dev \
    curl-dev \
    && docker-php-ext-install \
    pdo \
    mbstring \
    xml \
    curl \
    bcmath

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY composer.json ./
COPY docker/entrypoint.sh /usr/local/bin/docker-entrypoint

RUN chmod +x /usr/local/bin/docker-entrypoint

RUN COMPOSER_ALLOW_SUPERUSER=1 composer install \
    --no-interaction \
    --optimize-autoloader \
    --no-dev \
    --no-scripts \
    --no-security-blocking \
    && composer dump-autoload --optimize

COPY . .

RUN php -r "file_put_contents('.env', preg_replace('/^APP_KEY=$/m', 'APP_KEY=' . 'base64:' . base64_encode(random_bytes(32)), file_get_contents('.env')));" \
    && chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

EXPOSE 9000

ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]
