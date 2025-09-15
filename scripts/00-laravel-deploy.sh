#!/usr/bin/env bash
echo "Running composer..."
composer install --no-dev --working-dir=/var/www/html

echo "Generating application key..."
php artisan key:generate --force

echo "Running npm..."
npm install
npm run build

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force

echo "Publishing Livewire assets..."
php artisan livewire:publish --assets

echo "Optimizing application..."
php artisan optimize