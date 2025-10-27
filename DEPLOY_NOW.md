# 🚀 Deploy Pagsurong Lagonoy Tourism System - READY TO GO!

## ✅ Pre-Deployment Checklist (COMPLETED)

- ✅ Git repository configured
- ✅ GitHub repository: `zhaoson983-eng/pagsuronglag-tourism`
- ✅ Procfile created
- ✅ Nixpacks.toml configured
- ✅ APP_KEY generated: `base64:hZBSkOaJb3xzH4c70dat8DWMM2gVR4wFEMdixYQsdu4=`

---

## 🎯 STEP-BY-STEP DEPLOYMENT GUIDE

### **Step 1: Commit and Push Your Code (5 minutes)**

Run these commands in your terminal:

```bash
# Add all files
git add .

# Commit changes
git commit -m "Ready for production deployment"

# Push to GitHub
git push origin main
```

---

### **Step 2: Create Railway Account (2 minutes)**

1. Go to **https://railway.app**
2. Click **"Start a New Project"**
3. Sign up with **GitHub** (use the same GitHub account)
4. **Authorize Railway** to access your repositories

---

### **Step 3: Deploy from GitHub (3 minutes)**

1. In Railway dashboard, click **"+ New Project"**
2. Select **"Deploy from GitHub repo"**
3. Choose **`pagsuronglag-tourism`** repository
4. Railway will auto-detect it's a Laravel app
5. Click **"Deploy"**

---

### **Step 4: Add MySQL Database (2 minutes)**

1. In your project dashboard, click **"+ New"**
2. Select **"Database"**
3. Choose **"MySQL"**
4. Wait for provisioning (~1 minute)

---

### **Step 5: Configure Environment Variables (5 minutes)**

1. Click on your **web service** (not the database)
2. Go to **"Variables"** tab
3. Click **"Raw Editor"**
4. **Copy and paste this entire block:**

```env
APP_NAME=Pagsurong Lagonoy
APP_ENV=production
APP_KEY=base64:hZBSkOaJb3xzH4c70dat8DWMM2gVR4wFEMdixYQsdu4=
APP_DEBUG=false
APP_URL=https://${{RAILWAY_PUBLIC_DOMAIN}}

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=${{MYSQL_HOST}}
DB_PORT=${{MYSQL_PORT}}
DB_DATABASE=${{MYSQL_DATABASE}}
DB_USERNAME=${{MYSQL_USER}}
DB_PASSWORD=${{MYSQL_PASSWORD}}

BROADCAST_DRIVER=log
CACHE_DRIVER=database
FILESYSTEM_DISK=public
QUEUE_CONNECTION=database
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_SECURE_COOKIE=true

MAIL_MAILER=log
MAIL_FROM_ADDRESS="noreply@pagsuronglagonoy.com"
MAIL_FROM_NAME="${APP_NAME}"
```

5. Click **"Save"**
6. Railway will automatically redeploy

---

### **Step 6: Generate Public Domain (1 minute)**

1. Go to **"Settings"** tab in your web service
2. Scroll to **"Networking"** section
3. Click **"Generate Domain"**
4. Copy your URL: `https://your-app.railway.app`

---

### **Step 7: Wait for Deployment (2-3 minutes)**

1. Go to **"Deployments"** tab
2. Watch the build logs
3. Wait for status to show **"Success"**
4. Look for message: `INFO  Server running on [http://0.0.0.0:PORT]`

---

### **Step 8: Access Your Live Site! 🎉**

Visit: `https://your-app.railway.app`

**First-time setup:**
- Database migrations will run automatically
- Storage link will be created
- Site will be ready to use!

---

## 🗄️ Database Migration Options

### **Option A: Fresh Start (Recommended for Testing)**

Railway will automatically run migrations on first deployment. Your database will be empty and ready for new data.

### **Option B: Import Existing Data**

If you want to import your local database:

```bash
# 1. Export local database
mysqldump -u root -p pagsuronglag > pagsuronglag_export.sql

# 2. Install Railway CLI
npm i -g @railway/cli

# 3. Login to Railway
railway login

# 4. Link to your project
railway link

# 5. Import database
railway run mysql -h $MYSQL_HOST -u $MYSQL_USER -p$MYSQL_PASSWORD $MYSQL_DATABASE < pagsuronglag_export.sql
```

---

## ✅ Post-Deployment Verification

After deployment, test these features:

- [ ] **Homepage loads** - Visit your Railway URL
- [ ] **Registration works** - Create a test account
- [ ] **Login works** - Sign in with test account
- [ ] **Database queries work** - Browse products/hotels
- [ ] **Images display** - Check if logos and images load
- [ ] **All pages accessible** - Test navigation

---

## 🐛 Troubleshooting

### **Issue: 500 Internal Server Error**

**Check logs:**
```bash
railway logs
```

**Clear cache:**
```bash
railway run php artisan config:clear
railway run php artisan cache:clear
railway run php artisan view:clear
```

### **Issue: Database Connection Failed**

**Verify variables:**
```bash
railway variables
```

Make sure all `${{MYSQL_*}}` variables are properly set.

### **Issue: Images Not Displaying**

**Run storage link:**
```bash
railway run php artisan storage:link
```

### **Issue: Page Not Found (404)**

**Clear route cache:**
```bash
railway run php artisan route:clear
railway run php artisan config:clear
```

---

## 💰 Railway Free Tier

**What you get:**
- **$5 credit/month** (free)
- **~500 hours** of runtime
- **Perfect for testing** and small apps
- **No credit card required** to start

**Usage tips:**
- Railway only charges when app is running
- Free tier is enough for development/testing
- Upgrade to Hobby plan ($5/month) for production

---

## 🎯 Next Steps After Deployment

1. **Test all features thoroughly**
2. **Create admin account** via registration
3. **Upload sample data** (hotels, products, attractions)
4. **Share URL with team** for testing
5. **Monitor logs** for any errors

---

## 📞 Support Resources

**Railway:**
- Discord: https://discord.gg/railway
- Docs: https://docs.railway.app

**Laravel:**
- Discord: https://discord.gg/laravel
- Forum: https://laracasts.com/discuss

---

## 🎉 You're Ready to Deploy!

Your app is **100% ready** for deployment. Just follow the steps above and you'll have your tourism system live in **~15 minutes**!

**Good luck! 🚀**
