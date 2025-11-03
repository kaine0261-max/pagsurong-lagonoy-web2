#!/bin/bash

# Vercel Build Script for Laravel

echo "Installing Composer dependencies..."
composer install --optimize-autoloader --no-dev --no-interaction

echo "Creating required directories..."
mkdir -p storage/framework/{sessions,views,cache}
mkdir -p storage/logs
mkdir -p bootstrap/cache

echo "Setting permissions..."
chmod -R 755 storage bootstrap/cache

echo "Build completed successfully!"
