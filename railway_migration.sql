-- Add social media columns to business_profiles table
-- Run this in your Railway MySQL database console

-- Check if columns don't exist before adding them
ALTER TABLE business_profiles 
ADD COLUMN IF NOT EXISTS facebook_page VARCHAR(255) NULL,
ADD COLUMN IF NOT EXISTS instagram_url VARCHAR(255) NULL,
ADD COLUMN IF NOT EXISTS twitter_url VARCHAR(255) NULL;

-- Verify the columns were added
DESCRIBE business_profiles;
