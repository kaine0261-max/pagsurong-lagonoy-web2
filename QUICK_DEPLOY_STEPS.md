# ⚡ Quick Deployment Steps

## 🎯 Deploy to Railway.app in 15 Minutes

### **Step 1: Prepare Your Code (5 min)**

```bash
# 1. Make sure all changes are committed
git status

# 2. Add all files
git add .

# 3. Commit
git commit -m "Ready for deployment"

# 4. Push to GitHub
git push origin main
```

### **Step 2: Create Railway Account (2 min)**

1. Go to https://railway.app
2. Click "Start a New Project"
3. Sign up with GitHub
4. Authorize Railway

### **Step 3: Deploy from GitHub (3 min)**

1. Click "New Project"
2. Select "Deploy from GitHub repo"
3. Choose `pagsuronglag` repository
4. Railway auto-detects Laravel
5. Click "Deploy"

### **Step 4: Add MySQL Database (2 min)**

1. In project dashboard, click "+ New"
2. Select "Database"
3. Choose "MySQL"
4. Wait for provisioning (~1 min)

### **Step 5: Configure Environment (3 min)**

1. Click on your web service
2. Go to "Variables" tab
3. Click "Raw Editor"
4. Paste these (update values):

```env
APP_NAME=Pagsurong Lagonoy
APP_ENV=production
APP_KEY=base64:YOUR_KEY_HERE
APP_DEBUG=false
APP_URL=${{RAILWAY_PUBLIC_DOMAIN}}
DB_CONNECTION=mysql
DB_HOST=${{MYSQL_HOST}}
DB_PORT=${{MYSQL_PORT}}
DB_DATABASE=${{MYSQL_DATABASE}}
DB_USERNAME=${{MYSQL_USER}}
DB_PASSWORD=${{MYSQL_PASSWORD}}
SESSION_DRIVER=database
CACHE_DRIVER=database
```

**Generate APP_KEY locally:**
```bash
php artisan key:generate --show
```

4. Click "Save"
5. Railway will redeploy automatically

### **Step 6: Generate Domain (1 min)**

1. Go to "Settings" tab
2. Scroll to "Networking"
3. Click "Generate Domain"
4. Copy your URL: `your-app.railway.app`

### **Step 7: Access Your Site! 🎉**

Visit: `https://your-app.railway.app`

---

## 🗄️ Import Your Database

### **Option A: Using Railway CLI (Recommended)**

```bash
# 1. Install Railway CLI
npm i -g @railway/cli

# 2. Login
railway login

# 3. Link to your project
railway link

# 4. Export local database
mysqldump -u root pagsuronglag > database.sql

# 5. Import to Railway
railway run mysql -h ${{MYSQL_HOST}} -u ${{MYSQL_USER}} -p${{MYSQL_PASSWORD}} ${{MYSQL_DATABASE}} < database.sql

# 6. Or run migrations
railway run php artisan migrate:fresh --seed --force
```

### **Option B: Using MySQL Workbench**

1. Get Railway MySQL credentials from dashboard
2. Open MySQL Workbench
3. Create new connection with Railway credentials
4. Import your SQL file

---

## ✅ Verification Checklist

After deployment:
- [ ] Site loads at Railway URL
- [ ] Can register new user
- [ ] Can login
- [ ] Database queries work
- [ ] Images upload (if using storage)
- [ ] All pages accessible

---

## 🐛 Common Issues & Fixes

### **Issue: 500 Error**
```bash
# Check logs
railway logs

# Clear cache
railway run php artisan config:clear
railway run php artisan cache:clear
```

### **Issue: Database Connection Failed**
```bash
# Verify environment variables
railway variables

# Check MySQL is running
railway status
```

### **Issue: APP_KEY Missing**
```bash
# Generate locally
php artisan key:generate --show

# Add to Railway variables
# Then redeploy
```

### **Issue: Storage Not Working**
```bash
# Link storage
railway run php artisan storage:link

# Or use Cloudinary (recommended)
```

---

## 💰 Free Tier Limits

**Railway Free Tier:**
- $5 credit/month
- Enough for ~500 hours
- Perfect for testing/small apps

**When to Upgrade:**
- High traffic
- Need more resources
- 24/7 uptime required
- Cost: $5/month (Hobby plan)

---

## 🎯 Next Steps

After successful deployment:

1. **Set up custom domain** (optional)
2. **Configure email** (for notifications)
3. **Set up monitoring** (UptimeRobot)
4. **Create backup strategy**
5. **Test all features thoroughly**

---

## 📞 Need Help?

**Railway Support:**
- Discord: https://discord.gg/railway
- Docs: https://docs.railway.app

**Laravel Issues:**
- Discord: https://discord.gg/laravel
- Forum: https://laracasts.com/discuss

---

## 🎉 Success!

Your app should now be live at:
`https://your-app.railway.app`

**Congratulations on deploying! 🚀**
