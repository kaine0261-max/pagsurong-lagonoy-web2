#!/bin/bash

# Run only pending database migrations (won't fail if tables exist)
php artisan migrate --force || echo "Migration warning (non-critical)"

# Create storage symlink for images
php artisan storage:link || echo "Storage link already exists"

# Start the Laravel server
php artisan serve --host=0.0.0.0 --port=$PORT
