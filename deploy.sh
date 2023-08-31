#!/usr/bin/env bash
echo "Running composer"
composer update --no-dev --working-dir=/var/www/html

echo "Caching config..."
php artisan config:cache

echo "Running migrations..."
php artisan migrate --seed --force

echo "Running server..."
php artisan serve --host=0.0.0.0 --port=80
