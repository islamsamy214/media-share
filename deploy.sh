#!/usr/bin/env bash
echo "Caching config..."
php artisan config:cache

echo "Running migrations..."
php artisan migrate --force

echo "Running server..."
php artisan serve --host=0.0.0.0 --port=80