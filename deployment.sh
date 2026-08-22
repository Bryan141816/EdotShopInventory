#!/bin/bash

LOG_FILE="/home/LogFiles/deployment.sh.log"

# Send stdout and stderr to both the console and the log file
exec > >(tee -a "$LOG_FILE") 2>&1

echo "=========================================="
echo "Deployment script started: $(date)"
echo "=========================================="

cd /home/site/wwwroot || exit 1

echo "==> Running Laravel migrations..."
php artisan migrate --force

echo "==> Clearing Laravel caches..."
php artisan optimize:clear

echo "==> Rebuilding Laravel caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "=========================================="
echo "==> Deployment completed: $(date)"
echo "=========================================="