# ✅ PRE-DEPLOYMENT CHECKLIST
**Pagsurong Lagonoy Tourism Platform**  
**Date**: October 27, 2025

---

## 🚨 **CRITICAL - MUST COMPLETE BEFORE DEPLOYMENT**

### **1. Environment Configuration**
- [ ] Copy `.env.production.example` to `.env` on production server
- [ ] Update `APP_NAME` to "Pagsurong Lagonoy"
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false` ⚠️ **CRITICAL**
- [ ] Generate new `APP_KEY` with `php artisan key:generate`
- [ ] Set correct `APP_URL` (your domain with https://)
- [ ] Configure database credentials (DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD)
- [ ] Configure email settings (MAIL_HOST, MAIL_USERNAME, MAIL_PASSWORD)
- [ ] Set `SESSION_DRIVER=database`
- [ ] Set `QUEUE_CONNECTION=database`

### **2. Database Setup**
- [ ] Create production database
- [ ] Run migrations: `php artisan migrate --force`
- [ ] Verify all tables created successfully
- [ ] (Optional) Seed initial data: `php artisan db:seed --force`

### **3. File Permissions**
- [ ] Set storage permissions: `chmod -R 775 storage`
- [ ] Set cache permissions: `chmod -R 775 bootstrap/cache`
- [ ] Create storage link: `php artisan storage:link`

### **4. Application Optimization**
- [ ] Clear all caches: `php artisan cache:clear`
- [ ] Clear config: `php artisan config:clear`
- [ ] Clear routes: `php artisan route:clear`
- [ ] Clear views: `php artisan view:clear`
- [ ] Cache config: `php artisan config:cache`
- [ ] Cache routes: `php artisan route:cache`
- [ ] Cache views: `php artisan view:cache`
- [ ] Optimize: `php artisan optimize`

### **5. Frontend Assets**
- [ ] Install dependencies: `npm install`
- [ ] Build for production: `npm run build`
- [ ] Verify `public/build/` folder exists with assets

---

## 🔒 **SECURITY CHECKLIST**

### **Web Server Configuration**
- [ ] Point document root to `public/` folder (not root)
- [ ] Configure `.htaccess` or Nginx config
- [ ] Disable directory browsing
- [ ] Protect `.env` file from web access
- [ ] Set proper file permissions (755 for directories, 644 for files)

### **SSL/HTTPS**
- [ ] Install SSL certificate (Let's Encrypt recommended)
- [ ] Force HTTPS in web server config
- [ ] Update `APP_URL` to use https://
- [ ] Test SSL certificate validity

### **Application Security**
- [ ] Verify `APP_DEBUG=false` in production
- [ ] Verify no debug statements in code (dd, dump, console.log)
- [ ] Review file upload security
- [ ] Check CSRF protection is enabled
- [ ] Verify password hashing is working

---

## 🧪 **TESTING CHECKLIST**

### **Critical User Flows**
- [ ] **Registration**: Create new customer account
- [ ] **Login**: Login with customer credentials
- [ ] **Browse Products**: View products listing page
- [ ] **Product Details**: View individual product page
- [ ] **Add to Cart**: Add product to shopping cart
- [ ] **View Cart**: View cart page with items
- [ ] **Checkout**: Complete order process
- [ ] **View Orders**: Check orders page
- [ ] **Messages**: Test messaging system
- [ ] **Business Registration**: Register as business owner
- [ ] **Business Dashboard**: Access business dashboard
- [ ] **Admin Login**: Access admin panel
- [ ] **Image Upload**: Test image upload functionality

### **Mobile Testing**
- [ ] Test on iPhone/iOS Safari
- [ ] Test on Android/Chrome Mobile
- [ ] Test responsive navigation
- [ ] Test touch interactions
- [ ] Test image galleries on mobile
- [ ] Test forms on mobile

### **Browser Testing**
- [ ] Chrome (latest)
- [ ] Firefox (latest)
- [ ] Safari (latest)
- [ ] Edge (latest)

### **Error Handling**
- [ ] Test 404 page (visit non-existent URL)
- [ ] Test 500 page (if possible)
- [ ] Check error logs: `tail -f storage/logs/laravel.log`
- [ ] Verify errors are logged, not displayed to users

---

## 📊 **MONITORING SETUP**

### **Backup Configuration**
- [ ] Set up automated database backups (daily recommended)
- [ ] Set up file storage backups (weekly recommended)
- [ ] Test backup restoration process
- [ ] Document backup location and schedule

### **Uptime Monitoring**
- [ ] Sign up for uptime monitoring service (UptimeRobot, Pingdom)
- [ ] Add website URL to monitor
- [ ] Configure alert email/SMS
- [ ] Test alert system

### **Error Monitoring**
- [ ] Configure Laravel logging (check `config/logging.php`)
- [ ] Set up log rotation (keep 14 days)
- [ ] (Optional) Set up error notification emails
- [ ] (Optional) Integrate Sentry or similar service

---

## 📝 **DOCUMENTATION**

### **Admin Documentation**
- [ ] Document admin credentials (store securely)
- [ ] Document database credentials (store securely)
- [ ] Document email credentials (store securely)
- [ ] Document server access details (store securely)
- [ ] Create admin user guide
- [ ] Document backup procedures

### **User Documentation**
- [ ] Create customer user guide (optional)
- [ ] Create business owner guide (optional)
- [ ] Document common issues and solutions

---

## 🚀 **DEPLOYMENT DAY CHECKLIST**

### **Pre-Launch (1 hour before)**
- [ ] Announce maintenance window to users (if applicable)
- [ ] Backup current production database (if updating)
- [ ] Backup current production files (if updating)
- [ ] Review deployment plan with team

### **During Deployment**
- [ ] Upload files to production server
- [ ] Update .env file
- [ ] Run migrations
- [ ] Clear and cache everything
- [ ] Build frontend assets
- [ ] Test critical flows
- [ ] Check error logs

### **Post-Launch (First hour)**
- [ ] Monitor error logs continuously
- [ ] Test all critical features
- [ ] Check server resources (CPU, memory, disk)
- [ ] Verify backups are working
- [ ] Monitor user feedback
- [ ] Be ready to rollback if needed

### **Post-Launch (First 24 hours)**
- [ ] Check error logs every 2 hours
- [ ] Monitor server performance
- [ ] Respond to user feedback
- [ ] Fix any critical bugs immediately
- [ ] Document any issues encountered

---

## 🔧 **ROLLBACK PLAN**

### **If Deployment Fails**
1. [ ] Put site in maintenance mode: `php artisan down`
2. [ ] Restore database from backup
3. [ ] Restore files from backup
4. [ ] Clear all caches
5. [ ] Test restored version
6. [ ] Bring site back online: `php artisan up`
7. [ ] Investigate issues
8. [ ] Plan re-deployment

---

## 📞 **EMERGENCY CONTACTS**

### **Technical Support**
- **Developer**: [Your Name/Contact]
- **Server Admin**: [Server Admin Contact]
- **Database Admin**: [DBA Contact]

### **Service Providers**
- **Hosting Provider**: [Provider Name/Support]
- **Domain Registrar**: [Registrar Name/Support]
- **Email Service**: [Email Provider Support]

---

## ✅ **SIGN-OFF**

### **Deployment Team**

**Prepared by**: _________________ Date: _________

**Reviewed by**: _________________ Date: _________

**Approved by**: _________________ Date: _________

**Deployed by**: _________________ Date: _________

---

## 📊 **DEPLOYMENT STATUS**

- [ ] **Pre-Deployment**: All checklist items completed
- [ ] **Deployment**: Successfully deployed to production
- [ ] **Testing**: All critical tests passed
- [ ] **Monitoring**: Monitoring systems active
- [ ] **Documentation**: All documentation complete
- [ ] **Sign-Off**: Team sign-off obtained

---

## 🎉 **DEPLOYMENT COMPLETE!**

**Deployment Date**: _______________  
**Go-Live Time**: _______________  
**Status**: ⬜ Success ⬜ Partial ⬜ Failed  
**Notes**: _________________________________

---

**System Status**: ✅ READY FOR PRODUCTION

**Next Review Date**: _______________ (1 week after deployment)
