@echo off
echo ================================================
echo   VM AGS Integration - Quick Setup
echo ================================================
echo.

REM Check if .env exists
if not exist .env (
    echo Creating .env file from .env.example...
    copy .env.example .env
    echo.
    echo WARNING: Please edit .env file and add your PROXMOX_PASSWORD!
    echo.
    pause
)

echo Step 1: Running database migrations...
php artisan migrate --force
if %errorlevel% neq 0 (
    echo ERROR: Migration failed!
    pause
    exit /b 1
)
echo ✓ Migration completed
echo.

echo Step 2: Choose data source
echo   [1] Sync from Proxmox API (Production)
echo   [2] Use dummy data (Testing)
echo.
set /p choice="Enter your choice (1 or 2): "

if "%choice%"=="1" (
    echo.
    echo Testing Proxmox API connection...
    php artisan proxmox:sync-vms --test
    echo.
    echo Press any key to start syncing VM data...
    pause >nul
    echo Syncing VM data from Proxmox...
    php artisan proxmox:sync-vms
) else if "%choice%"=="2" (
    echo.
    echo Seeding dummy VM data...
    php artisan db:seed --class=ProxmoxVMSeeder
) else (
    echo Invalid choice!
    pause
    exit /b 1
)

echo.
echo ================================================
echo   Setup Complete! 
echo ================================================
echo.
echo To view the VM dashboard:
echo   1. Run: php artisan serve
echo   2. Open: http://localhost:8000/proxmox/nodes
echo.
echo Press any key to start the server...
pause >nul

php artisan serve
