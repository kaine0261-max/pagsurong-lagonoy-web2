#!/bin/bash

# Run database migrations
php artisan migrate --force

# Create storage symlink for images
php artisan storage:link

# Start the Laravel server
php artisan serve --host=0.0.0.0 --port=$PORT
