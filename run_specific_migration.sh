#!/bin/bash

# Run only the specific migration we need
php artisan migrate --path=database/migrations/2025_11_05_164900_fix_business_profiles_status_enum.php --force
