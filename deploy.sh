#!/usr/bin/env bash
echo "Running composer"
composer update --no-dev --working-dir=/var/www/html

# if /var/www/html/database/database.sqlite does not exist then create it
echo "Checking if database exists..."
if [ ! -f /var/www/html/database/database.sqlite ]; then
    touch /var/www/html/database/database.sqlite
    php artisan migrate --seed --force
fi

echo "Caching config..."
php artisan config:cache

echo "Running migrations..."
php artisan migrate --force

echo "Running server..."
php artisan serve --host=0.0.0.0 --port=80
