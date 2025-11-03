#!/bin/bash

# Create storage symlink for images
php artisan storage:link

# Start the Laravel server
php artisan serve --host=0.0.0.0 --port=$PORT
