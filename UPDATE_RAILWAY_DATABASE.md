# Update Railway Database - Social Media Columns

## ⚡ EASIEST METHOD - Custom Artisan Command

After deploying your latest code to Railway, run this ONE simple command:

```bash
php artisan db:add-social-media-columns
```

That's it! This custom command will:
- ✅ Check if columns already exist
- ✅ Add facebook_page, instagram_url, twitter_url columns
- ✅ Show you success/error messages
- ✅ Handle errors automatically

---

## Alternative: Standard Migration Command

If you prefer using the migration file:

```bash
php artisan migrate --path=database/migrations/2025_11_07_003620_add_social_media_to_business_profiles_table.php --force
```

## Alternative: Using Railway Dashboard

1. Go to your Railway project dashboard
2. Click on your **Laravel service** (not the database)
3. Click on **"Settings"** tab
4. Scroll to **"Deploy"** section
5. Under **"Custom Start Command"**, temporarily add:
   ```bash
   php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT
   ```
6. Click **"Deploy"** to redeploy
7. After deployment, change the start command back to:
   ```bash
   php artisan serve --host=0.0.0.0 --port=$PORT
   ```

## What This Migration Does

Adds three new columns to the `business_profiles` table:
- `facebook_page` (VARCHAR 255, nullable)
- `instagram_url` (VARCHAR 255, nullable)  
- `twitter_url` (VARCHAR 255, nullable)

These columns store social media links for business accounts.

## Verification

After running the migration, verify it worked by checking your Railway logs for:
```
Migration table created successfully.
Migrating: 2025_11_07_003620_add_social_media_to_business_profiles_table
Migrated:  2025_11_07_003620_add_social_media_to_business_profiles_table
```

## Manual SQL (If needed)

If the migration fails, you can run this SQL directly in Railway's database query console:

```sql
ALTER TABLE business_profiles 
ADD COLUMN IF NOT EXISTS facebook_page VARCHAR(255) NULL,
ADD COLUMN IF NOT EXISTS instagram_url VARCHAR(255) NULL,
ADD COLUMN IF NOT EXISTS twitter_url VARCHAR(255) NULL;
```
