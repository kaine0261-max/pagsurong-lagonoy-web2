# Vercel Deployment Guide - Pagsurong Lagonoy System

## ⚠️ Important Notice

**Vercel has limitations for Laravel applications:**
- Vercel is optimized for frontend frameworks (Next.js, React, Vue)
- PHP support is experimental via `vercel-php` runtime
- **Database limitations**: No persistent MySQL/PostgreSQL (must use external database)
- **File storage limitations**: No persistent file storage (uploads won't persist)
- **Session limitations**: Must use cookie or database sessions (not file-based)

## Recommended Alternative: Railway or Render

For a full Laravel application with database and file uploads, consider:
- **Railway.app** - Better Laravel support, includes database
- **Render.com** - Native PHP support with persistent storage
- **DigitalOcean App Platform** - Full Laravel support
- **Heroku** - Traditional PaaS with good Laravel support

## If You Still Want to Deploy to Vercel

### Prerequisites

1. Vercel account connected to GitHub ✅ (You have this)
2. External database (PlanetScale, Supabase, or Railway PostgreSQL)
3. External file storage (AWS S3, Cloudinary, or similar)

### Step 1: Prepare Your Application

The following files have been created:
- `vercel.json` - Vercel configuration
- `api/index.php` - Serverless entry point
- `.vercelignore` - Files to exclude from deployment

### Step 2: Update Environment Variables

You'll need to set these in Vercel Dashboard:

**Required Variables:**
```
APP_NAME=Pagsurong Lagonoy
APP_ENV=production
APP_KEY=base64:your-app-key-here
APP_DEBUG=false
APP_URL=https://your-app.vercel.app

LOG_CHANNEL=stderr
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=your-external-db-host
DB_PORT=3306
DB_DATABASE=your-database-name
DB_USERNAME=your-db-username
DB_PASSWORD=your-db-password

SESSION_DRIVER=cookie
SESSION_LIFETIME=120

CACHE_DRIVER=array
QUEUE_CONNECTION=sync

FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your-s3-key
AWS_SECRET_ACCESS_KEY=your-s3-secret
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-bucket-name
```

### Step 3: Deploy via Vercel Dashboard

1. **Go to Vercel Dashboard**
   - Visit: https://vercel.com/dashboard

2. **Import Project**
   - Click "Add New..." → "Project"
   - Select your GitHub repository: `pagsurong-lagonoy-web2`

3. **Configure Project**
   - Framework Preset: **Other**
   - Root Directory: `./` (leave as default)
   - Build Command: Leave empty or use:
     ```
     composer install --optimize-autoloader --no-dev && php artisan config:cache && php artisan route:cache
     ```
   - Output Directory: Leave empty

4. **Add Environment Variables**
   - Click "Environment Variables"
   - Add all variables from Step 2 above
   - **Important**: Generate APP_KEY locally first:
     ```bash
     php artisan key:generate --show
     ```
     Copy the output and use it as APP_KEY value

5. **Deploy**
   - Click "Deploy"
   - Wait for deployment to complete

### Step 4: Post-Deployment Setup

After successful deployment:

1. **Run Migrations** (if using external database)
   - You'll need to run migrations manually on your database
   - Connect to your database and import the schema

2. **Test the Application**
   - Visit your Vercel URL
   - Test basic functionality

### Known Limitations on Vercel

❌ **What Won't Work:**
- File uploads (unless using S3/external storage)
- Background jobs/queues (no persistent workers)
- Scheduled tasks (cron jobs)
- WebSockets/real-time features
- Large file processing

✅ **What Should Work:**
- Basic page rendering
- Authentication
- Database operations (with external DB)
- API endpoints
- Static asset serving

## Alternative: Deploy to Railway (Recommended)

Railway is much better suited for Laravel applications:

### Quick Railway Deployment

1. **Visit Railway**
   - Go to: https://railway.app

2. **New Project from GitHub**
   - Click "New Project"
   - Select "Deploy from GitHub repo"
   - Choose `pagsurong-lagonoy-web2`

3. **Add Database**
   - Click "New" → "Database" → "Add PostgreSQL" or "Add MySQL"

4. **Configure Environment Variables**
   Railway will auto-detect Laravel and set most variables.
   Add these manually:
   ```
   APP_KEY=base64:your-key-here
   APP_URL=https://your-app.railway.app
   ```

5. **Deploy**
   - Railway will automatically build and deploy
   - Database credentials are auto-injected

6. **Run Migrations**
   ```bash
   railway run php artisan migrate --force
   ```

### Railway Advantages
- ✅ Built-in database (MySQL/PostgreSQL)
- ✅ Persistent file storage
- ✅ Background workers support
- ✅ Automatic HTTPS
- ✅ Better Laravel support
- ✅ Free tier available

## Alternative: Deploy to Render

1. **Visit Render**
   - Go to: https://render.com

2. **New Web Service**
   - Click "New +" → "Web Service"
   - Connect your GitHub repository

3. **Configure**
   - Environment: **PHP**
   - Build Command:
     ```
     composer install --optimize-autoloader --no-dev && php artisan config:cache
     ```
   - Start Command:
     ```
     php artisan serve --host=0.0.0.0 --port=$PORT
     ```

4. **Add Database**
   - Create a new PostgreSQL database
   - Link it to your web service

5. **Deploy**
   - Render will build and deploy automatically

## Troubleshooting Vercel Deployment

### Build Fails
- Check Vercel build logs
- Ensure `composer.json` is valid
- Verify PHP version compatibility

### 500 Internal Server Error
- Check Vercel function logs
- Verify APP_KEY is set
- Check database connection

### Routes Not Working
- Verify `vercel.json` configuration
- Check that `api/index.php` exists
- Ensure `.htaccess` rules are compatible

### Database Connection Failed
- Verify external database credentials
- Check database host is accessible
- Ensure database exists

## Recommendation

**For your Pagsurong Lagonoy system, I strongly recommend using Railway or Render instead of Vercel** because:

1. Your app has file uploads (business documents, images)
2. You need a persistent database
3. You may need background jobs for order processing
4. Better Laravel ecosystem support

Would you like me to help you deploy to Railway or Render instead?

---

**Need Help?** 
- Railway Docs: https://docs.railway.app
- Render Docs: https://render.com/docs
- Vercel PHP: https://github.com/vercel-community/php
