# 🔐 Environment Variables for Production

Copy these to your Railway/Render environment variables:

```env
# Application
APP_NAME="Pagsurong Lagonoy"
APP_ENV=production
APP_KEY=base64:GENERATE_THIS_WITH_php_artisan_key:generate
APP_DEBUG=false
APP_URL=https://your-app.railway.app

# Logging
LOG_CHANNEL=stack
LOG_LEVEL=error

# Database (Railway will provide these)
DB_CONNECTION=mysql
DB_HOST=containers-us-west-xxx.railway.app
DB_PORT=3306
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=YOUR_RAILWAY_DB_PASSWORD

# Cache & Session
BROADCAST_DRIVER=log
CACHE_DRIVER=database
FILESYSTEM_DISK=public
QUEUE_CONNECTION=database
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_SECURE_COOKIE=true

# Mail (Optional - configure if needed)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@pagsuronglagonoy.com"
MAIL_FROM_NAME="${APP_NAME}"

# Optional: Cloudinary for file storage
CLOUDINARY_URL=cloudinary://API_KEY:API_SECRET@CLOUD_NAME
CLOUDINARY_CLOUD_NAME=your_cloud_name
CLOUDINARY_API_KEY=your_api_key
CLOUDINARY_API_SECRET=your_api_secret
```

## 📝 How to Generate APP_KEY

Run locally:
```bash
php artisan key:generate --show
```

Copy the output and paste it into Railway's APP_KEY variable.

## 🗄️ Database Credentials

Railway will automatically provide:
- DB_HOST
- DB_PORT  
- DB_DATABASE
- DB_USERNAME
- DB_PASSWORD

Copy these from Railway's MySQL service variables.

## ✅ Required Variables

Minimum required for deployment:
- APP_NAME
- APP_ENV
- APP_KEY ⚠️ MUST GENERATE
- APP_DEBUG
- APP_URL
- DB_CONNECTION
- DB_HOST
- DB_PORT
- DB_DATABASE
- DB_USERNAME
- DB_PASSWORD
