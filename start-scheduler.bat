@echo off
echo [%TIME%] Starting Laravel scheduler...
php artisan run:scheduler

echo [%TIME%] Scheduler exited with code %ERRORLEVEL%
pause