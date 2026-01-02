# 🏢 IT Persero Batam - Maintenance Dashboard 🏢

A premium, modern, and high-density dashboard for monitoring Proxmox nodes, storage health, VM usage, and Nextcloud statistics. Built with **Laravel 11**, **Livewire 3**, **Tailwind CSS**, and **Chart.js**.

---

## 🚀 Quick Start / Installation Guide

If you just cloned this repository for the first time, follow these steps to get the project running locally:

### 1. Prerequisites
Ensure you have the following installed:
- **PHP 8.2 or higher**
- **Composer**
- **Node.js & NPM**
- **SQLite** (or your preferred database)

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

### 4. Database Setup
The dashboard relies on dummy data for all visualizations. Run the migration and seeders to populate your database:
```bash
# Create SQLite database (if using default)
touch database/database.sqlite

# Run migrations and seed the dummy data
php artisan migrate --seed
```

### 5. Running the Application
You need to run both the Laravel server and the Vite dev server for icons and charts to work:

**Terminal 1 (Laravel Server):**
```bash
php artisan serve
```

**Terminal 2 (Vite Server - Icons & CSS):**
```bash
npm run dev
```

Visit `http://localhost:8000` in your browser.

---

## 🎨 Design System
- **Theme**: Ultra Dark / Glassmorphism
- **Icons**: Lucide Icons
- **Charts**: Chart.js
- **Frontend Interaction**: Alpine.js & Livewire 3

## 📊 Features
- node status tracking (prox01)
- Storage health monitoring (LOCAL-LVM)
- Usage trend visualizations
- Nextcloud user & storage statistics
- System alerts with priority levels
- Quick management actions
