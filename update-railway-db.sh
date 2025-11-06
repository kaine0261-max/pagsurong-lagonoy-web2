#!/bin/bash
# Script to update Railway database with social media columns
# Run this command in your Railway project terminal

echo "Updating Railway database with social media columns..."

php artisan migrate --path=database/migrations/2025_11_07_003620_add_social_media_to_business_profiles_table.php --force

echo "Migration completed!"
echo "Social media columns (facebook_page, instagram_url, twitter_url) have been added to business_profiles table."
