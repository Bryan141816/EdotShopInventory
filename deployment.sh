#!/bin/bash

cd /home/site/wwwroot

echo "==> Running Laravel migrations..."
php artisan migrate --force

echo "==> Clearing Laravel caches..."
php artisan optimize:clear

echo "==> Rebuilding Laravel caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Deployment completed successfully."