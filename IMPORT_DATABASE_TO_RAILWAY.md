# Import MySQL Database to Railway

## ✅ Database Exported Successfully!

Your database has been exported to: `database_export.sql`

---

## Step-by-Step Import Process

### Method 1: Using Railway MySQL Client (Easiest)

1. **Get MySQL Connection Details from Railway:**
   - Go to Railway Dashboard
   - Click on your **MySQL** service (not the web service)
   - Go to **"Connect"** tab
   - You'll see connection details like:
     ```
     MYSQL_HOST=containers-us-west-xxx.railway.app
     MYSQL_PORT=6379
     MYSQL_USER=root
     MYSQL_PASSWORD=xxxxx
     MYSQL_DATABASE=railway
     ```

2. **Copy the MySQL URL:**
   - Look for **"MySQL Connection URL"** or **"DATABASE_URL"**
   - It looks like: `mysql://root:password@host:port/railway`

3. **Import Using Railway CLI:**
   
   **Install Railway CLI (if not installed):**
   ```bash
   npm install -g @railway/cli
   ```
   
   **Login to Railway:**
   ```bash
   railway login
   ```
   
   **Link Your Project:**
   ```bash
   railway link
   ```
   Select your project: `Pagsurong Lagonoy`
   
   **Import Database:**
   ```bash
   railway run mysql -h MYSQL_HOST -P MYSQL_PORT -u root -p MYSQL_DATABASE < database_export.sql
   ```
   When prompted, enter the MySQL password from Railway.

---

### Method 2: Using MySQL Workbench (GUI)

1. **Open MySQL Workbench**

2. **Create New Connection:**
   - Click **"+"** to add new connection
   - **Connection Name:** Railway - Pagsurong Lagonoy
   - **Hostname:** (from Railway MYSQL_HOST)
   - **Port:** (from Railway MYSQL_PORT)
   - **Username:** root
   - **Password:** (click "Store in Keychain" and enter Railway password)

3. **Test Connection** → Click "Test Connection"

4. **Connect** → Double-click the connection

5. **Import SQL File:**
   - Go to **Server** → **Data Import**
   - Select **"Import from Self-Contained File"**
   - Browse and select: `database_export.sql`
   - Click **"Start Import"**

---

### Method 3: Using Command Line (Direct)

**From your local machine:**

```bash
# Replace these with your Railway MySQL details
mysql -h RAILWAY_HOST -P RAILWAY_PORT -u root -p RAILWAY_DATABASE < database_export.sql
```

When prompted, enter your Railway MySQL password.

---

### Method 4: Using phpMyAdmin (if available)

1. **Access Railway MySQL via phpMyAdmin:**
   - Some Railway users set up phpMyAdmin
   - Or use a local phpMyAdmin pointing to Railway

2. **Import:**
   - Go to **Import** tab
   - Choose file: `database_export.sql`
   - Click **"Go"**

---

## After Import: Update Environment Variables

### 1. Add APP_KEY to Railway

In Railway Dashboard:
- Click your **web** service
- Go to **"Variables"** tab
- Add new variable:
  - **Name:** `APP_KEY`
  - **Value:** `base64:geyDt76Q85rVV2mS1mMoTT0yWdFOyX0q7NU/kQxX9KQ=`

### 2. Verify Database Connection

Railway should automatically set these when you added MySQL:
- `MYSQL_HOST`
- `MYSQL_PORT`
- `MYSQL_USER`
- `MYSQL_PASSWORD`
- `MYSQL_DATABASE`

But Laravel needs them as `DB_*`. Add these variables:
- `DB_CONNECTION` = `mysql`
- `DB_HOST` = `${MYSQL_HOST}`
- `DB_PORT` = `${MYSQL_PORT}`
- `DB_DATABASE` = `${MYSQL_DATABASE}`
- `DB_USERNAME` = `${MYSQL_USER}`
- `DB_PASSWORD` = `${MYSQL_PASSWORD}`

---

## Generate Domain and Test

1. **Generate Public Domain:**
   - Click your web service
   - Go to **"Settings"** tab
   - Scroll to **"Networking"**
   - Click **"Generate Domain"**

2. **Visit Your Site:**
   - Click the generated URL
   - Test login and registration
   - Verify data is showing correctly

---

## Troubleshooting

### Connection Refused
- Check if MySQL service is running in Railway
- Verify environment variables are set correctly

### Import Failed
- Check SQL file for errors
- Try importing in smaller chunks
- Check Railway MySQL logs

### App Shows Database Error
- Verify `DB_*` environment variables
- Check Railway logs for connection errors
- Ensure MySQL service is linked to web service

---

## Quick Commands Reference

```bash
# Export local database
mysqldump -u root pagsuronglag > database_export.sql

# Import to Railway (using Railway CLI)
railway login
railway link
railway run mysql -h HOST -P PORT -u root -p DATABASE < database_export.sql

# Or direct MySQL command
mysql -h RAILWAY_HOST -P RAILWAY_PORT -u root -p RAILWAY_DB < database_export.sql
```

---

## Your Database Export Location

```
c:\laragon\www\pagsuronglag\database_export.sql
```

File size: Check the file to ensure it exported correctly.

---

**Good luck with your import!** 🚀

If you encounter any issues, check the Railway logs or let me know!
