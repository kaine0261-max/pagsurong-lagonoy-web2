# 🚀 Free Hosting Deployment Guide
**Pagsurong Lagonoy Tourism Platform**  
**Date**: October 27, 2025

---

## 📋 **Table of Contents**
1. [Best Free Hosting Options](#best-free-hosting-options)
2. [Recommended: Railway.app](#recommended-railwayapp)
3. [Alternative: Render.com](#alternative-rendercom)
4. [Database Setup](#database-setup)
5. [Pre-Deployment Checklist](#pre-deployment-checklist)
6. [Step-by-Step Deployment](#step-by-step-deployment)
7. [Post-Deployment](#post-deployment)
8. [Troubleshooting](#troubleshooting)

---

## 🌟 **Best Free Hosting Options**

### **1. Railway.app** ⭐ RECOMMENDED
- **Free Tier**: $5 credit/month (enough for small apps)
- **Laravel Support**: ✅ Excellent
- **Database**: ✅ PostgreSQL/MySQL included
- **Storage**: ✅ Persistent storage
- **Custom Domain**: ✅ Free
- **SSL**: ✅ Automatic
- **Deployment**: Git-based (easiest)

### **2. Render.com**
- **Free Tier**: Yes (with limitations)
- **Laravel Support**: ✅ Good
- **Database**: ✅ PostgreSQL included
- **Storage**: ⚠️ Ephemeral (files deleted on restart)
- **Custom Domain**: ✅ Free
- **SSL**: ✅ Automatic

### **3. Fly.io**
- **Free Tier**: Limited resources
- **Laravel Support**: ✅ Good
- **Database**: ⚠️ Separate setup needed
- **Storage**: ⚠️ Complex setup

### **❌ Not Recommended**:
- **Heroku**: No longer has free tier
- **000webhost**: Poor Laravel support
- **InfinityFree**: No Laravel support

---

## 🚂 **RECOMMENDED: Railway.app**

### **Why Railway?**
- ✅ Easiest Laravel deployment
- ✅ Free database included
- ✅ Persistent file storage
- ✅ Automatic deployments from Git
- ✅ Environment variables management
- ✅ Logs and monitoring
- ✅ No credit card required initially

---

## 📝 **Pre-Deployment Checklist**

### **1. Prepare Your Code**

Create `.env.example` file:
```bash
APP_NAME="Pagsurong Lagonoy"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://your-app.railway.app

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME="${APP_NAME}"
```

### **2. Create `Procfile`** (for Railway/Render)

Create file: `Procfile` (no extension)
```
web: php artisan migrate --force && php artisan storage:link && php artisan config:cache && php artisan route:cache && php artisan view:cache && php -S 0.0.0.0:$PORT -t public
```

### **3. Create `nixpacks.toml`** (for Railway)

Create file: `nixpacks.toml`
```toml
[phases.setup]
nixPkgs = ['php82', 'php82Extensions.pdo', 'php82Extensions.pdo_mysql', 'php82Extensions.mbstring', 'php82Extensions.gd', 'php82Extensions.zip', 'php82Extensions.curl']

[phases.install]
cmds = ['composer install --no-dev --optimize-autoloader']

[phases.build]
cmds = ['php artisan config:clear', 'php artisan cache:clear']

[start]
cmd = 'php artisan serve --host=0.0.0.0 --port=$PORT'
```

### **4. Update `.gitignore`**

Make sure these are in `.gitignore`:
```
/node_modules
/public/hot
/public/storage
/storage/*.key
/vendor
.env
.env.backup
.phpunit.result.cache
Homestead.json
Homestead.yaml
npm-debug.log
yarn-error.log
```

### **5. Optimize for Production**

Update `config/app.php`:
```php
'debug' => env('APP_DEBUG', false),
```

Update `config/session.php`:
```php
'secure' => env('SESSION_SECURE_COOKIE', true),
'same_site' => 'lax',
```

---

## 🚀 **Step-by-Step: Railway Deployment**

### **Step 1: Prepare Git Repository**

```bash
# Initialize git (if not already)
git init

# Add all files
git add .

# Commit
git commit -m "Initial commit for deployment"

# Create GitHub repository and push
git remote add origin https://github.com/yourusername/pagsuronglag.git
git branch -M main
git push -u origin main
```

### **Step 2: Sign Up for Railway**

1. Go to https://railway.app
2. Click "Start a New Project"
3. Sign up with GitHub
4. Authorize Railway to access your repositories

### **Step 3: Create New Project**

1. Click "New Project"
2. Select "Deploy from GitHub repo"
3. Choose your `pagsuronglag` repository
4. Railway will detect it's a PHP/Laravel app

### **Step 4: Add MySQL Database**

1. In your project dashboard, click "New"
2. Select "Database"
3. Choose "MySQL"
4. Railway will create a MySQL instance
5. Note the connection details

### **Step 5: Configure Environment Variables**

1. Click on your web service
2. Go to "Variables" tab
3. Add these variables:

```
APP_NAME=Pagsurong Lagonoy
APP_ENV=production
APP_KEY=base64:YOUR_KEY_HERE
APP_DEBUG=false
APP_URL=https://your-app.railway.app

DB_CONNECTION=mysql
DB_HOST=containers-us-west-xxx.railway.app
DB_PORT=3306
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=YOUR_DB_PASSWORD

SESSION_DRIVER=database
CACHE_DRIVER=database
QUEUE_CONNECTION=database
```

**To generate APP_KEY**:
```bash
php artisan key:generate --show
```

### **Step 6: Deploy**

1. Railway will automatically deploy
2. Watch the build logs
3. Wait for deployment to complete (5-10 minutes)

### **Step 7: Run Migrations**

After deployment:
1. Go to your service
2. Click "Settings"
3. Scroll to "Deploy"
4. Add custom start command:
```bash
php artisan migrate --force && php artisan storage:link && php artisan serve --host=0.0.0.0 --port=$PORT
```

Or use Railway CLI:
```bash
# Install Railway CLI
npm i -g @railway/cli

# Login
railway login

# Link project
railway link

# Run migrations
railway run php artisan migrate --force

# Seed database (optional)
railway run php artisan db:seed --force
```

### **Step 8: Set Up Custom Domain (Optional)**

1. Go to "Settings"
2. Click "Generate Domain"
3. Railway provides: `your-app.railway.app`
4. Or add your own custom domain

---

## 🎨 **Alternative: Render.com Deployment**

### **Step 1: Create `render.yaml`**

Create file: `render.yaml`
```yaml
services:
  - type: web
    name: pagsuronglag
    env: php
    buildCommand: composer install --no-dev --optimize-autoloader && php artisan config:cache && php artisan route:cache && php artisan view:cache
    startCommand: php artisan migrate --force && php artisan storage:link && php -S 0.0.0.0:$PORT -t public
    envVars:
      - key: APP_KEY
        generateValue: true
      - key: APP_ENV
        value: production
      - key: APP_DEBUG
        value: false
      - key: DATABASE_URL
        fromDatabase:
          name: pagsuronglag-db
          property: connectionString

databases:
  - name: pagsuronglag-db
    databaseName: pagsuronglag
    user: pagsuronglag
```

### **Step 2: Deploy to Render**

1. Go to https://render.com
2. Sign up with GitHub
3. Click "New +"
4. Select "Blueprint"
5. Connect your repository
6. Render will use `render.yaml`
7. Click "Apply"

---

## 💾 **Database Setup**

### **Import Your Database**

**Option 1: Using Railway CLI**
```bash
# Export from local
mysqldump -u root pagsuronglag > database.sql

# Import to Railway
railway run mysql -h HOST -u root -p DATABASE < database.sql
```

**Option 2: Using MySQL Workbench**
1. Get Railway MySQL credentials
2. Connect using MySQL Workbench
3. Import your SQL file

**Option 3: Using phpMyAdmin**
1. Railway provides phpMyAdmin plugin
2. Add phpMyAdmin to your project
3. Import SQL file through web interface

### **Run Migrations Fresh**
```bash
railway run php artisan migrate:fresh --seed --force
```

---

## 📁 **File Storage Setup**

### **Issue**: Railway has persistent storage, but uploads need configuration

### **Solution 1: Use Railway Volumes**

In Railway dashboard:
1. Go to your service
2. Click "Settings"
3. Add "Volume"
4. Mount path: `/app/storage/app/public`

### **Solution 2: Use Cloud Storage (Recommended)**

**Use Cloudinary (Free tier: 25GB)**

1. Sign up at https://cloudinary.com
2. Get your credentials
3. Install package:
```bash
composer require cloudinary-labs/cloudinary-laravel
```

4. Add to `.env`:
```
CLOUDINARY_URL=cloudinary://API_KEY:API_SECRET@CLOUD_NAME
FILESYSTEM_DISK=cloudinary
```

5. Update `config/filesystems.php`:
```php
'cloudinary' => [
    'driver' => 'cloudinary',
    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
    'api_key' => env('CLOUDINARY_API_KEY'),
    'api_secret' => env('CLOUDINARY_API_SECRET'),
],
```

---

## ✅ **Post-Deployment Checklist**

### **1. Test Your Application**
- [ ] Homepage loads
- [ ] Registration works
- [ ] Login works
- [ ] Database queries work
- [ ] Images upload/display
- [ ] All routes accessible

### **2. Set Up Monitoring**

**Railway Built-in**:
- View logs in dashboard
- Monitor resource usage
- Set up alerts

**External (Optional)**:
- UptimeRobot (free uptime monitoring)
- Sentry (error tracking)

### **3. Configure Backups**

**Database Backups**:
```bash
# Create backup script
railway run mysqldump DATABASE > backup-$(date +%Y%m%d).sql
```

**Automated Backups**:
- Railway Pro: Automatic backups
- Free: Manual backups via cron job

### **4. Set Up CI/CD**

**Automatic Deployment**:
1. Railway auto-deploys on git push
2. Set up branch protection
3. Test before merging to main

---

## 🔧 **Troubleshooting**

### **Issue 1: APP_KEY Error**
```
Solution:
railway run php artisan key:generate --force
```

### **Issue 2: Database Connection Failed**
```
Check:
1. Database credentials in environment variables
2. Database is running
3. Firewall rules
```

### **Issue 3: Storage Link Not Working**
```
Solution:
railway run php artisan storage:link
```

### **Issue 4: 500 Internal Server Error**
```
Check:
1. Enable APP_DEBUG=true temporarily
2. Check logs: railway logs
3. Verify .env variables
4. Clear cache: railway run php artisan config:clear
```

### **Issue 5: Images Not Displaying**
```
Solution:
1. Check storage is linked
2. Verify file permissions
3. Use cloud storage (Cloudinary)
```

### **Issue 6: Slow Performance**
```
Solutions:
1. Enable caching
2. Optimize database queries
3. Use CDN for assets
4. Upgrade to paid tier
```

---

## 💰 **Cost Breakdown**

### **Railway Free Tier**
- **Credit**: $5/month
- **Usage**: ~$5/month for small app
- **Duration**: Can run 24/7 for a month
- **Upgrade**: $5/month for more resources

### **Render Free Tier**
- **Cost**: Free
- **Limitations**: 
  - Spins down after 15 min inactivity
  - 750 hours/month
  - Slower performance

### **Recommended for Production**
- **Railway Hobby**: $5/month
- **Cloudinary**: Free (25GB)
- **Total**: $5/month

---

## 🎯 **Quick Start Commands**

### **Deploy to Railway**
```bash
# 1. Install Railway CLI
npm i -g @railway/cli

# 2. Login
railway login

# 3. Initialize project
railway init

# 4. Add MySQL
railway add

# 5. Deploy
git push

# 6. Run migrations
railway run php artisan migrate --force

# 7. Open app
railway open
```

---

## 📚 **Additional Resources**

### **Documentation**
- Railway: https://docs.railway.app
- Render: https://render.com/docs
- Laravel Deployment: https://laravel.com/docs/deployment

### **Video Tutorials**
- Railway + Laravel: Search YouTube
- Database Migration: Laravel docs

### **Community**
- Railway Discord: https://discord.gg/railway
- Laravel Discord: https://discord.gg/laravel

---

## 🎉 **Success Checklist**

After deployment, you should have:
- [ ] Live website URL
- [ ] Database connected and migrated
- [ ] File uploads working
- [ ] All features functional
- [ ] SSL certificate (automatic)
- [ ] Monitoring set up
- [ ] Backup strategy in place

---

## 📞 **Need Help?**

If you encounter issues:
1. Check Railway/Render logs
2. Review this guide
3. Check Laravel logs
4. Ask in Railway Discord
5. Post on Stack Overflow

---

**Deployment Guide Created**: October 27, 2025  
**Platform**: Pagsurong Lagonoy Tourism  
**Status**: ✅ Ready for Deployment

**Good luck with your deployment! 🚀**
