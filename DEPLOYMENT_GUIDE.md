# Deployment Guide - Pagsurong Lagonoy System

This guide will help you deploy the Pagsurong Lagonoy Tourism & Business Management System to GitHub and production servers.

## Prerequisites

- Git installed on your system
- GitHub account
- Access to the repository: https://github.com/kaine0261-max/pagsurong-lagonoy-web2

## Upload to GitHub

### Step 1: Verify Git Status

Your repository is already configured and connected to GitHub. Check the current status:

```bash
git status
```

### Step 2: Push to GitHub

Push your committed changes to GitHub:

```bash
git push origin main
```

If this is your first push or you encounter authentication issues:

1. **Using HTTPS** (will prompt for credentials):
   ```bash
   git push origin main
   ```

2. **Using Personal Access Token** (recommended):
   - Go to GitHub Settings → Developer settings → Personal access tokens
   - Generate a new token with `repo` permissions
   - Use the token as your password when prompted

3. **Using SSH** (if configured):
   ```bash
   git remote set-url origin git@github.com:kaine0261-max/Pagsurong-Lagonoy-website.git
   git push origin main
   ```

### Step 3: Verify Upload

Visit your repository on GitHub:
https://github.com/kaine0261-max/pagsurong-lagonoy-web2

You should see all your files uploaded.

## Important Files Excluded from Git

The following files are intentionally excluded from version control (via `.gitignore`):

- `.env` - Environment configuration (contains sensitive data)
- `vendor/` - PHP dependencies (installed via Composer)
- `node_modules/` - Node dependencies (installed via NPM)
- `database/*.sqlite` - Database files
- `/public/build` - Compiled assets
- `/public/storage` - Uploaded files
- `/storage/*.key` - Encryption keys

## Production Deployment

### Option 1: Shared Hosting (cPanel/Plesk)

1. **Upload Files**
   - Use FTP/SFTP or cPanel File Manager
   - Upload all files to your hosting directory

2. **Install Dependencies**
   ```bash
   composer install --optimize-autoloader --no-dev
   npm install
   npm run build
   ```

3. **Configure Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Edit `.env` file**
   - Set `APP_ENV=production`
   - Set `APP_DEBUG=false`
   - Configure database credentials
   - Set proper `APP_URL`

5. **Set Permissions**
   ```bash
   chmod -R 755 storage bootstrap/cache
   ```

6. **Run Migrations**
   ```bash
   php artisan migrate --force
   ```

7. **Create Storage Link**
   ```bash
   php artisan storage:link
   ```

8. **Point Domain to `/public` directory**
   - Configure your web server to point to the `public` folder

### Option 2: VPS/Cloud Server (Ubuntu/Debian)

1. **Install Requirements**
   ```bash
   sudo apt update
   sudo apt install php8.1 php8.1-fpm php8.1-mysql php8.1-xml php8.1-mbstring php8.1-curl php8.1-zip composer nginx mysql-server
   ```

2. **Clone Repository**
   ```bash
   cd /var/www
   git clone https://github.com/kaine0261-max/pagsurong-lagonoy-web2.git
   cd pagsurong-lagonoy-web2
   ```

3. **Install Dependencies**
   ```bash
   composer install --optimize-autoloader --no-dev
   npm install
   npm run build
   ```

4. **Configure Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Set Permissions**
   ```bash
   sudo chown -R www-data:www-data /var/www/Pagsurong-Lagonoy-website
   sudo chmod -R 755 storage bootstrap/cache
   ```

6. **Configure Nginx**
   Create `/etc/nginx/sites-available/pagsuronglag`:
   ```nginx
   server {
       listen 80;
       server_name yourdomain.com;
       root /var/www/pagsurong-lagonoy-web2/public;

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

7. **Enable Site**
   ```bash
   sudo ln -s /etc/nginx/sites-available/pagsuronglag /etc/nginx/sites-enabled/
   sudo nginx -t
   sudo systemctl reload nginx
   ```

8. **Run Migrations**
   ```bash
   php artisan migrate --force
   php artisan storage:link
   ```

### Option 3: Platform as a Service (Heroku, Railway, etc.)

1. **Create `Procfile`** (already exists in your project)

2. **Configure Build Settings**
   - Build Command: `composer install && npm install && npm run build`
   - Start Command: See Procfile

3. **Set Environment Variables**
   - Copy all variables from `.env.example`
   - Set `APP_KEY` (generate using `php artisan key:generate --show`)

4. **Deploy**
   - Connect your GitHub repository
   - Enable automatic deployments from `main` branch

## Post-Deployment Checklist

- [ ] Verify `.env` configuration
- [ ] Test database connection
- [ ] Run migrations
- [ ] Create storage symlink
- [ ] Test file uploads
- [ ] Verify email configuration (if using)
- [ ] Test all user roles (customer, business owner, admin)
- [ ] Check SSL certificate
- [ ] Configure backups
- [ ] Set up monitoring

## Maintenance Commands

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Optimize for Production
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Database Backup
```bash
# For SQLite
cp database/database.sqlite database/backup-$(date +%Y%m%d).sqlite

# For MySQL
mysqldump -u username -p database_name > backup-$(date +%Y%m%d).sql
```

## Troubleshooting

### Permission Issues
```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

### 500 Internal Server Error
- Check Laravel logs: `storage/logs/laravel.log`
- Verify `.env` file exists and is configured
- Ensure `APP_KEY` is set
- Check file permissions

### Assets Not Loading
```bash
npm run build
php artisan storage:link
```

### Database Connection Failed
- Verify database credentials in `.env`
- Ensure database exists
- Check database server is running

## Security Recommendations

1. **Never commit `.env` file** - Already excluded in `.gitignore`
2. **Use strong `APP_KEY`** - Generated automatically
3. **Set `APP_DEBUG=false`** in production
4. **Use HTTPS** - Configure SSL certificate
5. **Regular updates** - Keep Laravel and dependencies updated
6. **Database backups** - Schedule regular backups
7. **Monitor logs** - Check `storage/logs` regularly

## Support

For issues or questions:
- Check the main README.md
- Review Laravel documentation: https://laravel.com/docs
- Open an issue on GitHub

---

Last Updated: November 2025
