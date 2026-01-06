# 🏢 IT Persero Batam - Maintenance Dashboard 🏢

A premium, modern, and high-density dashboard for monitoring Proxmox nodes, storage health, VM usage, and Nextcloud statistics. Built with **Laravel 10**, **Livewire 3**, **Tailwind CSS**, and **Chart.js**.

---

## 🚀 Quick Start / Installation Guide

If you just cloned this repository for the first time, follow these steps to get the project running locally:

### 1. Prerequisites
Ensure you have the following installed:
- **PHP 8.1 or higher**
- **Composer**
- **Node.js & NPM**
- **MySQL** (WAMP/XAMPP or standalone)

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Frontend dependencies
npm install
```

### 3. Environment Configuration
```bash
# Copy the example environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

Edit your `.env` file and configure your MySQL database:
```env
APP_URL=http://localhost/Maintenance-Dashboard/public

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=maintenance_dashboard
DB_USERNAME=root
DB_PASSWORD=
```

> [!IMPORTANT]
> Make sure to set `APP_URL` to match your WAMP setup path for proper asset loading.

### 4. Database Setup
The dashboard relies on dummy data for all visualizations. Run the migration and seeders to populate your database:
```bash
# Create the database first in MySQL
# Then run migrations and seed the dummy data
php artisan migrate --seed
```

### 5. Running the Application

**For WAMP Users (Recommended):**
1. Make sure WAMP is running
2. Run Vite dev server for icons and CSS:
   ```bash
   npm run dev
   ```
3. Visit `http://localhost/Maintenance-Dashboard/public/` in your browser

**Alternative - Using Laravel's Built-in Server:**
```bash
# Terminal 1: Laravel Server
php artisan serve

# Terminal 2: Vite Server
npm run dev
```
Then visit `http://localhost:8000` in your browser.

---

## 🎨 Design System
- **Theme**: Ultra Dark / Glassmorphism
- **Icons**: Lucide Icons
- **Charts**: Chart.js
- **Frontend Interaction**: Alpine.js & Livewire 3

## 📊 Features
- **Node Monitoring**: Real-time Proxmox node status tracking
- **Storage Health**: Monitor storage usage and health metrics (LOCAL-LVM)
- **Virtual Machines**: Track VM status, CPU, memory, and disk usage
- **Nextcloud Integration**: User statistics and storage analytics
- **System Alerts**: Priority-based alert system with status tracking
- **Usage Visualizations**: Interactive charts for trend analysis
- **Quick Actions**: Fast access to common management tasks
