#!/usr/bin/env bash
echo "Running composer"
composer update --working-dir=/var/www/html

echo "Caching config..."
php artisan optimize:clear

echo "Running migrations..."
touch /var/www/html/database/database.sqlite
php artisan migrate --seed --force

echo "Running server..."
php artisan serve --host=0.0.0.0 --port=80
