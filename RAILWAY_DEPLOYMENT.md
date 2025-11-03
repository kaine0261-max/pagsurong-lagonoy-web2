# Railway Deployment Guide - Pagsurong Lagonoy System

## ✅ Why Railway is Perfect for Your Laravel App

- Built-in MySQL/PostgreSQL database
- Persistent file storage
- Automatic HTTPS
- Easy environment variable management
- Free $5/month credit
- Zero configuration needed

---

## Step-by-Step Deployment Instructions

### Step 1: Access Railway

1. Open your browser and go to: **https://railway.app**
2. Click **"Login"** or **"Start a New Project"**
3. Click **"Login with GitHub"**
4. Authorize Railway to access your GitHub account

### Step 2: Create New Project

1. Once logged in, click **"New Project"** button
2. Select **"Deploy from GitHub repo"**
3. You'll see a list of your repositories
4. Find and click: **`pagsurong-lagonoy-web2`**
5. Railway will start importing your project

### Step 3: Add MySQL Database

1. In your project dashboard, click **"New"** button (top right)
2. Select **"Database"**
3. Choose **"Add MySQL"**
4. Railway will automatically:
   - Create a MySQL database
   - Generate credentials
   - Link it to your Laravel app
   - Set environment variables automatically

### Step 4: Configure Environment Variables

1. Click on your **web service** (the one with your app name)
2. Go to **"Variables"** tab
3. Click **"Add Variable"** or **"+ New Variable"**

Add this required variable:

**Variable Name:** `APP_KEY`  
**Value:** `base64:geyDt76Q85rVV2mS1mMoTT0yWdFOyX0q7NU/kQxX9KQ=`

Railway auto-sets these from your database:
- `DB_CONNECTION=mysql`
- `DB_HOST` (auto-generated)
- `DB_PORT` (auto-generated)
- `DB_DATABASE` (auto-generated)
- `DB_USERNAME` (auto-generated)
- `DB_PASSWORD` (auto-generated)

### Step 5: Deploy

1. Railway automatically deploys when you add the database
2. Watch the **"Deployments"** tab for build progress
3. Build takes 2-5 minutes
4. You'll see logs showing:
   - Installing dependencies
   - Running migrations
   - Starting server

### Step 6: Get Your URL

1. Click on your web service
2. Go to **"Settings"** tab
3. Scroll to **"Networking"** section
4. Click **"Generate Domain"**
5. Railway will give you a URL like: `your-app.up.railway.app`
6. Click the URL to visit your deployed app!

### Step 7: Verify Deployment

1. Visit your Railway URL
2. You should see your Pagsurong Lagonoy homepage
3. Test registration and login
4. Check if database is working

---

## Troubleshooting

### Build Failed

**Check the logs:**
1. Click "Deployments" tab
2. Click on the failed deployment
3. Read the error message

**Common fixes:**
- Ensure `APP_KEY` is set
- Check if database is connected
- Verify `nixpacks.toml` exists

### Database Connection Error

**Solution:**
1. Go to Variables tab
2. Ensure database variables are present
3. Redeploy if needed

### 500 Internal Server Error

**Solution:**
1. Check deployment logs
2. Ensure migrations ran successfully
3. Verify `APP_KEY` is set correctly

### App Not Loading

**Solution:**
1. Check if domain is generated
2. Wait a few minutes for DNS propagation
3. Check deployment status

---

## Post-Deployment Tasks

### Run Migrations Manually (if needed)

If migrations didn't run automatically:

1. Click on your web service
2. Click **"Deployments"** tab
3. Click the **three dots** (...) on latest deployment
4. Select **"View Logs"**
5. Or use Railway CLI:
   ```bash
   railway run php artisan migrate --force
   ```

### Create Admin User

You may need to create an admin user:

1. Use Railway CLI or database console
2. Or create a seeder and run it

### Upload Files

File uploads will work automatically on Railway (unlike Vercel).

---

## Railway CLI (Optional)

For advanced management:

### Install Railway CLI

```bash
npm i -g @railway/cli
```

### Login

```bash
railway login
```

### Link Project

```bash
railway link
```

### Run Commands

```bash
railway run php artisan migrate
railway run php artisan db:seed
railway run php artisan cache:clear
```

### View Logs

```bash
railway logs
```

---

## Cost Estimate

**Free Tier:**
- $5 free credit per month
- Enough for development/testing
- No credit card required initially

**If You Exceed Free Tier:**
- ~$5-10/month for small apps
- Pay only for what you use
- Can set spending limits

---

## Advantages Over Vercel

✅ **Database Included** - MySQL works out of the box  
✅ **File Storage** - Uploads persist  
✅ **Background Jobs** - Queue workers supported  
✅ **Cron Jobs** - Scheduled tasks work  
✅ **WebSockets** - Real-time features supported  
✅ **Better Laravel Support** - Built for backend apps  

---

## Next Steps After Deployment

1. ✅ Test all features (registration, login, business setup)
2. ✅ Upload sample data
3. ✅ Configure custom domain (optional)
4. ✅ Set up backups
5. ✅ Monitor application logs

---

## Support

- Railway Docs: https://docs.railway.app
- Railway Discord: https://discord.gg/railway
- GitHub Issues: Your repository

---

**Your APP_KEY (save this):**
```
base64:geyDt76Q85rVV2mS1mMoTT0yWdFOyX0q7NU/kQxX9KQ=
```

Good luck with your deployment! 🚀
