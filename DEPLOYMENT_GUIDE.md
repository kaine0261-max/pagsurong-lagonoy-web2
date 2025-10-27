# 🚀 Deployment Guide - Step by Step
**System**: Pagsurong Lagonoy Tourism Platform  
**Date**: October 27, 2025

---

## ✅ **PRE-DEPLOYMENT CHECKLIST COMPLETED**

### **Code Quality Check**
- ✅ No `dd()` statements found
- ✅ No `dump()` statements found
- ✅ Code is clean and production-ready

---

## 📋 **DEPLOYMENT STEPS**

### **Step 1: Environment Configuration** ⚠️ CRITICAL

#### **1.1 Update .env File**

Open `.env` file and update these settings:

```env
# Application Settings
APP_NAME="Pagsurong Lagonoy"
APP_ENV=production
APP_DEBUG=false  # ⚠️ MUST BE FALSE IN PRODUCTION
APP_URL=https://your-domain.com  # Update with your actual domain

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1  # Or your production database host
DB_PORT=3306
DB_DATABASE=pagsuronglag  # Your production database name
DB_USERNAME=your_db_user  # Your production database user
DB_PASSWORD=your_secure_password  # Strong password

# Mail Configuration (for notifications)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com  # Or your mail server
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@pagsurong-lagonoy.com
MAIL_FROM_NAME="${APP_NAME}"

# Session & Cache
SESSION_DRIVER=database
CACHE_DRIVER=file
QUEUE_CONNECTION=database

# File Storage
FILESYSTEM_DISK=public
```

#### **1.2 Generate New Application Key**

⚠️ **IMPORTANT**: Generate a new key for production

```bash
php artisan key:generate
```

---

### **Step 2: Database Setup**

#### **2.1 Create Production Database**

```sql
CREATE DATABASE pagsuronglag CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

#### **2.2 Run Migrations**

```bash
php artisan migrate --force
```

#### **2.3 (Optional) Seed Initial Data**

```bash
php artisan db:seed --force
```

---

### **Step 3: Storage Setup**

#### **3.1 Create Storage Link**

```bash
php artisan storage:link
```

#### **3.2 Set Permissions**

```bash
# Windows (if deploying on Windows server)
icacls storage /grant Users:F /T
icacls bootstrap\cache /grant Users:F /T

# Linux (if deploying on Linux server)
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

---

### **Step 4: Optimize Application**

#### **4.1 Clear All Caches**

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

#### **4.2 Optimize for Production**

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

---

### **Step 5: Build Frontend Assets**

#### **5.1 Install Dependencies**

```bash
npm install
```

#### **5.2 Build for Production**

```bash
npm run build
```

This will create optimized CSS and JS files in `public/build/`

---

### **Step 6: Security Configuration**

#### **6.1 Update .htaccess (if using Apache)**

Ensure `.htaccess` in `public/` folder has:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>

# Disable directory browsing
Options -Indexes

# Prevent access to .env
<Files .env>
    Order allow,deny
    Deny from all
</Files>
```

#### **6.2 Configure Web Server**

**For Apache**: Point document root to `public/` folder

**For Nginx**: Use this configuration:

```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/pagsuronglag/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

---

### **Step 7: SSL/HTTPS Setup** (Recommended)

#### **7.1 Install SSL Certificate**

**Using Let's Encrypt (Free)**:

```bash
# Install Certbot
sudo apt-get install certbot python3-certbot-nginx

# Get certificate
sudo certbot --nginx -d your-domain.com -d www.your-domain.com
```

#### **7.2 Force HTTPS**

Add to `.env`:
```env
APP_URL=https://your-domain.com
```

---

### **Step 8: Testing**

#### **8.1 Test Critical Flows**

- [ ] **Registration**: Create new customer account
- [ ] **Login**: Login with customer account
- [ ] **Browse Products**: View products page
- [ ] **Add to Cart**: Add product to cart
- [ ] **Checkout**: Complete an order
- [ ] **Business Registration**: Register as business owner
- [ ] **Admin Login**: Access admin panel
- [ ] **Upload Images**: Test image uploads
- [ ] **Mobile View**: Test on mobile device

#### **8.2 Check Error Logs**

```bash
tail -f storage/logs/laravel.log
```

---

### **Step 9: Backup Setup** (Highly Recommended)

#### **9.1 Database Backup Script**

Create `backup-db.sh`:

```bash
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/backups/database"
mkdir -p $BACKUP_DIR

mysqldump -u your_db_user -p'your_password' pagsuronglag > $BACKUP_DIR/backup_$DATE.sql

# Keep only last 30 days
find $BACKUP_DIR -name "backup_*.sql" -mtime +30 -delete

echo "Database backup completed: backup_$DATE.sql"
```

#### **9.2 Schedule Daily Backups**

```bash
# Add to crontab
crontab -e

# Add this line (runs at 2 AM daily)
0 2 * * * /path/to/backup-db.sh
```

#### **9.3 File Backup**

```bash
# Backup storage folder
tar -czf storage_backup_$(date +%Y%m%d).tar.gz storage/app/public
```

---

### **Step 10: Monitoring Setup** (Recommended)

#### **10.1 Error Monitoring**

Monitor `storage/logs/laravel.log` for errors:

```bash
# Check for errors
grep "ERROR" storage/logs/laravel.log

# Watch in real-time
tail -f storage/logs/laravel.log | grep "ERROR"
```

#### **10.2 Uptime Monitoring**

Use free services:
- **UptimeRobot**: https://uptimerobot.com (Free)
- **Pingdom**: https://pingdom.com (Free tier)

#### **10.3 Performance Monitoring**

Check page load times:
```bash
curl -o /dev/null -s -w "Time: %{time_total}s\n" https://your-domain.com
```

---

## 🔧 **POST-DEPLOYMENT TASKS**

### **Day 1: Launch Day**

- [ ] Monitor error logs every hour
- [ ] Check server resources (CPU, memory)
- [ ] Test all critical features
- [ ] Monitor user feedback
- [ ] Check database connections

### **Week 1: First Week**

- [ ] Daily error log review
- [ ] Monitor performance metrics
- [ ] Check backup success
- [ ] Review user feedback
- [ ] Fix any critical bugs

### **Month 1: First Month**

- [ ] Weekly performance review
- [ ] Update dependencies if needed
- [ ] Review security logs
- [ ] Optimize slow queries
- [ ] Plan feature improvements

---

## 🚨 **TROUBLESHOOTING**

### **Issue: 500 Internal Server Error**

**Solution**:
```bash
# Check error logs
tail -50 storage/logs/laravel.log

# Clear caches
php artisan cache:clear
php artisan config:clear

# Check permissions
chmod -R 775 storage bootstrap/cache
```

### **Issue: Images Not Loading**

**Solution**:
```bash
# Recreate storage link
php artisan storage:link

# Check permissions
chmod -R 775 storage/app/public
```

### **Issue: CSS/JS Not Loading**

**Solution**:
```bash
# Rebuild assets
npm run build

# Clear browser cache
# Check APP_URL in .env matches your domain
```

### **Issue: Database Connection Error**

**Solution**:
```bash
# Check .env database credentials
# Test database connection
php artisan tinker
>>> DB::connection()->getPdo();

# Clear config cache
php artisan config:clear
```

---

## 📞 **MAINTENANCE COMMANDS**

### **Regular Maintenance**

```bash
# Clear logs older than 30 days
find storage/logs -name "*.log" -mtime +30 -delete

# Optimize database
php artisan optimize:clear
php artisan optimize

# Update dependencies (monthly)
composer update
npm update
```

### **Emergency Commands**

```bash
# Put site in maintenance mode
php artisan down --message="Scheduled maintenance" --retry=60

# Bring site back online
php artisan up

# Clear everything and restart
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize
```

---

## ✅ **DEPLOYMENT CHECKLIST**

Print this and check off as you complete:

### **Pre-Deployment**
- [ ] Update .env file with production settings
- [ ] Set APP_DEBUG=false
- [ ] Set APP_ENV=production
- [ ] Configure database credentials
- [ ] Generate new APP_KEY
- [ ] Configure email settings

### **Deployment**
- [ ] Upload files to server
- [ ] Run migrations
- [ ] Create storage link
- [ ] Set file permissions
- [ ] Clear all caches
- [ ] Optimize application
- [ ] Build frontend assets

### **Security**
- [ ] Configure web server
- [ ] Install SSL certificate
- [ ] Force HTTPS
- [ ] Test file upload security
- [ ] Review .env security

### **Testing**
- [ ] Test registration/login
- [ ] Test product browsing
- [ ] Test cart/checkout
- [ ] Test image uploads
- [ ] Test on mobile devices
- [ ] Check error logs

### **Monitoring**
- [ ] Set up database backups
- [ ] Set up file backups
- [ ] Configure uptime monitoring
- [ ] Set up error alerts
- [ ] Document admin credentials

---

## 🎉 **CONGRATULATIONS!**

Your Pagsurong Lagonoy Tourism Platform is now deployed!

### **Next Steps:**
1. Monitor the system closely for the first week
2. Gather user feedback
3. Fix any issues that arise
4. Plan future enhancements

### **Support Resources:**
- Laravel Documentation: https://laravel.com/docs
- Tailwind CSS: https://tailwindcss.com/docs
- Stack Overflow: https://stackoverflow.com

---

**Deployed by**: [Your Name]  
**Date**: October 27, 2025  
**Version**: 1.0  
**Status**: ✅ PRODUCTION READY
