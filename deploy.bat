@echo off
echo ========================================
echo Pagsurong Lagonoy - Deployment Script
echo ========================================
echo.

echo Step 1: Clearing caches...
call php artisan cache:clear
call php artisan config:clear
call php artisan route:clear
call php artisan view:clear
echo ✓ Caches cleared
echo.

echo Step 2: Optimizing application...
call php artisan config:cache
call php artisan route:cache
call php artisan view:cache
call php artisan optimize
echo ✓ Application optimized
echo.

echo Step 3: Creating storage link...
call php artisan storage:link
echo ✓ Storage link created
echo.

echo Step 4: Building frontend assets...
call npm run build
echo ✓ Frontend assets built
echo.

echo ========================================
echo ✅ DEPLOYMENT PREPARATION COMPLETE!
echo ========================================
echo.
echo IMPORTANT REMINDERS:
echo 1. Make sure .env is configured for production
echo 2. Set APP_DEBUG=false in .env
echo 3. Set APP_ENV=production in .env
echo 4. Configure database credentials in .env
echo 5. Run migrations: php artisan migrate --force
echo.
echo Next steps:
echo - Upload files to production server
echo - Configure web server (Apache/Nginx)
echo - Set up SSL certificate
echo - Test all critical features
echo.
pause
