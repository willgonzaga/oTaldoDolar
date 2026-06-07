#!/bin/sh
set -e

if [ ! -d "vendor" ]; then
    composer install --no-interaction --optimize-autoloader --no-dev --no-scripts --no-security-blocking
    composer dump-autoload --optimize
fi

if grep -q "^APP_KEY=$" .env 2>/dev/null; then
    php -r "file_put_contents('.env', preg_replace('/^APP_KEY=$/m', 'APP_KEY=' . 'base64:' . base64_encode(random_bytes(32)), file_get_contents('.env')));"
fi

exec "$@"
