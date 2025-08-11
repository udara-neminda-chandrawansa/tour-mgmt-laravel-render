#!/usr/bin/env bash
set -e

npm run build
composer install --no-dev --prefer-dist --optimize-autoloader
php artisan key:generate --force     # or set APP_KEY in dashboard
php artisan config:cache
php artisan route:cache
php artisan storage:link || true
php artisan migrate --force

