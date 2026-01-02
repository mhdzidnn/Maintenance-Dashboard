# Role & Objective

You are an expert Full Stack Developer specializing in Laravel applications and modern dashboard interfaces. Your goal is to build a complete, production-ready **Maintenance Dashboard** system from scratch that closely replicates the provided design reference. The dashboard must be visually stunning, highly functional, data-driven, and fully responsive.

---

# IMPORTANT: Design Reference Image

**The user will provide a screenshot/image of the dashboard design.**

Please analyze the provided image carefully and replicate:
- Layout structure (sidebar, main content, cards arrangement)
- Color scheme (dark theme, accent colors, status indicators)
- Typography (font sizes, weights, hierarchy)
- Component styling (cards, buttons, badges, progress bars)
- Spacing and proportions
- Icons and visual elements

**If the image is not yet provided, ask the user to upload it before proceeding.**

---

# 1. Tech Stack Strategy

Build this application using a modern Laravel stack optimized for real-time data visualization and API integration:

- **Backend Framework:** Laravel 11.x (latest stable)
- **Frontend Framework:** Laravel Livewire 3.x (for reactive components)
- **Styling:** Tailwind CSS (mandatory for clean, modern UI matching the design)
- **Charts/Visualization:** Chart.js or ApexCharts (for data visualization components)
- **Icons:** Lucide Icons or Heroicons
- **Animation:** Alpine.js (lightweight, pairs well with Livewire)
- **Font:** Inter, Geist Sans, or SF Pro Display (for modern, clean typography)
- **API Integration:** RESTful API structure with placeholder endpoints ready for external API integration

---

# 2. Design Aesthetic ("The Vibe")

The dashboard should feel:

- **Modern & Professional:** Dark theme (slate/zinc base) with high contrast elements
- **Data-Focused:** Clear visual hierarchy emphasizing critical metrics and alerts
- **Tech-Forward:** Subtle glassmorphism effects, smooth transitions, micro-interactions
- **Color Palette:**
  - **Background:** Dark slate (#1e293b, #0f172a)
  - **Primary Accent:** Electric Blue (#3b82f6) or Emerald (#10b981)
  - **Warning States:** Orange/Amber for warnings, Red for critical alerts, Green for healthy status
  - **Status Indicators:** Color-coded progress bars and badges

- **Layout Style:** Grid-based dashboard layout with card components, resembling the provided Proxmox maintenance interface

---

# 3. System Architecture & Features

## Core Functionality

The dashboard monitors and displays:
1. **Proxmox Node Health** (server status, uptime, health indicators)
2. **Storage Health** (LVM usage, RAID status, trend analysis)
3. **VM Usage Statistics** (top VMs by resource consumption)
4. **Nextcloud Integration** (user stats, quota warnings, recent logins)
5. **System Alerts** (critical warnings and notifications)
6. **Quick Actions** (maintenance operations like FS Trim, Cache Clear, Disk Scan)

---

# 4. Navigation & Routing

## CRITICAL REQUIREMENT: Fully Functional Navigation

The sidebar navigation MUST be fully functional from the start. Implement these routes:

### Web Routes (`routes/web.php`)
```php
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Proxmox Section
    Route::get('/proxmox', [ProxmoxController::class, 'index'])->name('proxmox.index');
    Route::get('/proxmox/nodes', [ProxmoxController::class, 'nodes'])->name('proxmox.nodes');
    Route::get('/proxmox/storage', [ProxmoxController::class, 'storage'])->name('proxmox.storage');
    Route::get('/proxmox/vms', [ProxmoxController::class, 'vms'])->name('proxmox.vms');
    Route::get('/proxmox/memory', [ProxmoxController::class, 'memory'])->name('proxmox.memory');
    
    // Nextcloud Section
    Route::get('/nextcloud', [NextcloudController::class, 'index'])->name('nextcloud.index');
    Route::get('/nextcloud/overview', [NextcloudController::class, 'overview'])->name('nextcloud.overview');
    Route::get('/nextcloud/users', [NextcloudController::class, 'users'])->name('nextcloud.users');
    Route::get('/nextcloud/storage', [NextcloudController::class, 'storage'])->name('nextcloud.storage');
    
    // System Section
    Route::get('/system', [SystemController::class, 'index'])->name('system.index');
    Route::get('/system/alerts', [SystemController::class, 'alerts'])->name('system.alerts');
    Route::get('/system/logs', [SystemController::class, 'logs'])->name('system.logs');
});
```

### Sidebar Menu Structure
Create a sidebar component with these menu items:
```
📊 Dashboard (/)
├── 🖥️ Proxmox
│   ├── Node
│   ├── Storage
│   ├── VMs
│   └── Memory
├── ☁️ Nextcloud
│   ├── Overview
│   ├── Users
│   └── Storage
└── ⚙️ System
    ├── Alerts
    └── Logs
```

### Navigation Interaction Requirements:
- **Active state styling:** Current page should be highlighted
- **Hover effects:** Smooth color transition on menu item hover
- **Expandable sections:** Proxmox, Nextcloud, System sections can expand/collapse
- **Icon indicators:** Show chevron (>) for expandable sections
- **Smooth transitions:** Use Alpine.js for smooth expand/collapse animations
- **Mobile responsive:** Sidebar collapses to hamburger menu on mobile

---

# 5. Data Visualization with Dummy Data

## CRITICAL REQUIREMENT: Show Real Visualizations Immediately

DO NOT wait for API integration. Use comprehensive dummy data from seeders to populate all charts and visualizations.

### Required Visualizations:

#### A. Storage Health Chart
- **Type:** Horizontal Progress Bar with gradient
- **Dummy Data:** 85% used (1.5 TB / 1.7 TB)
- **Visual:** Orange-to-red gradient fill
- **Labels:** Show percentage, absolute values, and trend (+4%/week)

#### B. VM Usage Chart
- **Type:** Vertical bar chart or list with usage bars
- **Dummy Data:**
```
  VM 110 (Backup): 450 GB
  VM 105 (DB Server): 300 GB
  VM 101 (Web Server): 120 GB
```
- **Visual:** Horizontal bars with blue gradient

#### C. Nextcloud Storage Gauge
- **Type:** Circular progress or horizontal bar
- **Dummy Data:** 2.3 TB / 5 TB (46%)
- **Visual:** Blue accent color

#### D. User Quota Warning
- **Type:** Progress bar with warning indicator
- **Dummy Data:** User "andi" at 94% (4.7 GB / 5 GB)
- **Visual:** Orange/red warning color

#### E. Recent Logins Timeline
- **Type:** Timeline list with timestamps
- **Dummy Data:**
```
  joko - 5 mins ago
  ana - 1 hour ago
  susi - 2 days ago
```
- **Visual:** Small circular avatars with activity bars

#### F. System Alerts Widget
- **Type:** Badge list with icons
- **Dummy Data:**
```
  ⚠️ LOCAL-LVM Usage High! 85% (1.5 TB / 1.7 TB)
  🔺 Nextcloud: User Quota Exceeded
```
- **Visual:** Warning (orange) and Critical (red) badges

---

# 6. Database Schema

Create migrations for the following tables:

## A. `nodes` Table
```php
Schema::create('nodes', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->enum('status', ['healthy', 'warning', 'critical'])->default('healthy');
    $table->integer('uptime_days');
    $table->decimal('uptime_percentage', 5, 2);
    $table->timestamps();
});
```

## B. `storage_health` Table
```php
Schema::create('storage_health', function (Blueprint $table) {
    $table->id();
    $table->foreignId('node_id')->constrained()->onDelete('cascade');
    $table->string('name');
    $table->decimal('usage_percentage', 5, 2);
    $table->decimal('local_percentage', 5, 2)->nullable();
    $table->string('raid_status')->default('HEALTHY');
    $table->string('trend')->nullable();
    $table->enum('alert_level', ['normal', 'warning', 'critical'])->default('normal');
    $table->timestamps();
});
```

## C. `virtual_machines` Table
```php
Schema::create('virtual_machines', function (Blueprint $table) {
    $table->id();
    $table->foreignId('node_id')->constrained()->onDelete('cascade');
    $table->string('vm_id');
    $table->string('name');
    $table->integer('usage_gb');
    $table->boolean('is_running')->default(true);
    $table->timestamps();
});
```

## D. `nextcloud_stats` Table
```php
Schema::create('nextcloud_stats', function (Blueprint $table) {
    $table->id();
    $table->enum('status', ['online', 'offline'])->default('online');
    $table->integer('total_users');
    $table->decimal('storage_used_tb', 8, 2);
    $table->decimal('storage_total_tb', 8, 2);
    $table->timestamps();
});
```

## E. `nextcloud_users` Table
```php
Schema::create('nextcloud_users', function (Blueprint $table) {
    $table->id();
    $table->string('username');
    $table->decimal('quota_used_gb', 8, 2);
    $table->decimal('quota_total_gb', 8, 2);
    $table->timestamp('last_login');
    $table->timestamps();
});
```

## F. `system_alerts` Table
```php
Schema::create('system_alerts', function (Blueprint $table) {
    $table->id();
    $table->enum('type', ['warning', 'critical']);
    $table->string('title');
    $table->text('message');
    $table->text('details')->nullable();
    $table->boolean('is_resolved')->default(false);
    $table->timestamps();
});
```

---

# 7. Database Seeders with Realistic Dummy Data

## CRITICAL REQUIREMENT: Comprehensive Dummy Data

Create seeders that populate ALL tables with realistic data:

### NodeSeeder.php
```php
Node::create([
    'name' => 'prox01',
    'status' => 'healthy',
    'uptime_days' => 47,
    'uptime_percentage' => 0.32
]);
```

### StorageHealthSeeder.php
```php
StorageHealth::create([
    'node_id' => 1,
    'name' => 'LOCAL-LVM',
    'usage_percentage' => 85,
    'local_percentage' => 33,
    'raid_status' => 'HEALTHY',
    'trend' => '+4% / week',
    'alert_level' => 'warning'
]);
```

### VirtualMachineSeeder.php
```php
VirtualMachine::insert([
    ['node_id' => 1, 'vm_id' => 'VM 110', 'name' => 'Backup', 'usage_gb' => 450, 'is_running' => true],
    ['node_id' => 1, 'vm_id' => 'VM 105', 'name' => 'DB Server', 'usage_gb' => 300, 'is_running' => true],
    ['node_id' => 1, 'vm_id' => 'VM 101', 'name' => 'Web Server', 'usage_gb' => 120, 'is_running' => true],
]);
```

### NextcloudStatSeeder.php
```php
NextcloudStat::create([
    'status' => 'online',
    'total_users' => 81,
    'storage_used_tb' => 2.3,
    'storage_total_tb' => 5.0
]);
```

### NextcloudUserSeeder.php
```php
NextcloudUser::insert([
    ['username' => 'joko', 'quota_used_gb' => 2.5, 'quota_total_gb' => 5.0, 'last_login' => now()->subMinutes(5)],
    ['username' => 'ana', 'quota_used_gb' => 3.2, 'quota_total_gb' => 5.0, 'last_login' => now()->subHour()],
    ['username' => 'susi', 'quota_used_gb' => 1.8, 'quota_total_gb' => 5.0, 'last_login' => now()->subDays(2)],
    ['username' => 'andi', 'quota_used_gb' => 4.7, 'quota_total_gb' => 5.0, 'last_login' => now()->subDays(1)],
]);
```

### SystemAlertSeeder.php
```php
SystemAlert::insert([
    [
        'type' => 'warning',
        'title' => 'LOCAL-LVM Usage High!',
        'message' => '85% (1.5 TB / 1.7 TB)',
        'details' => null,
        'is_resolved' => false
    ],
    [
        'type' => 'critical',
        'title' => 'Nextcloud: User Quota Exceeded',
        'message' => 'User andi has exceeded quota',
        'details' => null,
        'is_resolved' => false
    ]
]);
```

---

# 8. Code Structure
```
maintenance-dashboard/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/
│   │   │   │   ├── NodeController.php
│   │   │   │   ├── StorageController.php
│   │   │   │   ├── VMController.php
│   │   │   │   ├── NextcloudController.php
│   │   │   │   └── AlertController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── ProxmoxController.php
│   │   │   ├── NextcloudController.php
│   │   │   └── SystemController.php
│   │   └── Livewire/
│   │       ├── Sidebar.php
│   │       ├── NodeStatusCard.php
│   │       ├── StorageHealthCard.php
│   │       ├── VmUsageCard.php
│   │       ├── NextcloudOverview.php
│   │       ├── UserQuotaWarning.php
│   │       ├── RecentLogins.php
│   │       ├── SystemAlerts.php
│   │       └── QuickActions.php
│   ├── Models/
│   │   ├── Node.php
│   │   ├── StorageHealth.php
│   │   ├── VirtualMachine.php
│   │   ├── NextcloudStat.php
│   │   ├── NextcloudUser.php
│   │   └── SystemAlert.php
│   ├── Services/
│   │   ├── ExternalApiService.php
│   │   └── DashboardDataService.php
│   └── ...
├── database/
│   ├── migrations/
│   └── seeders/
│       ├── NodeSeeder.php
│       ├── StorageHealthSeeder.php
│       ├── VirtualMachineSeeder.php
│       ├── NextcloudStatSeeder.php
│       ├── NextcloudUserSeeder.php
│       └── SystemAlertSeeder.php
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   └── app.blade.php
│   │   ├── livewire/
│   │   │   ├── sidebar.blade.php
│   │   │   ├── node-status-card.blade.php
│   │   │   ├── storage-health-card.blade.php
│   │   │   ├── vm-usage-card.blade.php
│   │   │   ├── nextcloud-overview.blade.php
│   │   │   ├── user-quota-warning.blade.php
│   │   │   ├── recent-logins.blade.php
│   │   │   ├── system-alerts.blade.php
│   │   │   └── quick-actions.blade.php
│   │   ├── dashboard.blade.php
│   │   ├── proxmox/
│   │   │   ├── index.blade.php
│   │   │   ├── nodes.blade.php
│   │   │   ├── storage.blade.php
│   │   │   ├── vms.blade.php
│   │   │   └── memory.blade.php
│   │   ├── nextcloud/
│   │   │   ├── index.blade.php
│   │   │   ├── overview.blade.php
│   │   │   ├── users.blade.php
│   │   │   └── storage.blade.php
│   │   └── system/
│   │       ├── index.blade.php
│   │       ├── alerts.blade.php
│   │       └── logs.blade.php
│   ├── css/
│   │   └── app.css
│   └── js/
│       └── app.js
├── routes/
│   ├── web.php
│   └── api.php
├── config/
│   └── external_apis.php
└── ...
```

---

# 9. API Integration Instructions (Future Step)

When ready to integrate real APIs, follow these steps:

1. **Update `.env` file:**
```env
PROXMOX_API_URL=https://your-proxmox-server.com/api2/json
PROXMOX_API_TOKEN=your_token_here
NEXTCLOUD_API_URL=https://your-nextcloud.com/ocs/v2.php
NEXTCLOUD_API_TOKEN=your_token_here
```

2. **Create config file (`config/external_apis.php`):**
```php
<?php

return [
    'proxmox' => [
        'base_url' => env('PROXMOX_API_URL'),
        'token' => env('PROXMOX_API_TOKEN'),
    ],
    'nextcloud' => [
        'base_url' => env('NEXTCLOUD_API_URL'),
        'token' => env('NEXTCLOUD_API_TOKEN'),
    ],
];
```

3. **Create External API Service (`app/Services/ExternalApiService.php`):**
```php
<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ExternalApiService
{
    // TODO: Replace with real Proxmox API call
    public function getNodeHealth($nodeId)
    {
        return Cache::remember("node_health_{$nodeId}", 300, function() use ($nodeId) {
            // Uncomment when ready to use real API:
            // return Http::withToken(config('external_apis.proxmox.token'))
            //     ->get(config('external_apis.proxmox.base_url') . "/nodes/{$nodeId}/status")
            //     ->json();
            
            // For now, return null to use seeded data
            return null;
        });
    }
    
    // TODO: Replace with real Storage API call
    public function getStorageHealth()
    {
        return Cache::remember('storage_health', 300, function() {
            // Uncomment when ready to use real API:
            // return Http::withToken(config('external_apis.proxmox.token'))
            //     ->get(config('external_apis.proxmox.base_url') . "/storage")
            //     ->json();
            
            return null;
        });
    }
    
    // TODO: Replace with real VM API call
    public function getVirtualMachines()
    {
        return Cache::remember('virtual_machines', 300, function() {
            // Uncomment when ready to use real API:
            // return Http::withToken(config('external_apis.proxmox.token'))
            //     ->get(config('external_apis.proxmox.base_url') . "/vms")
            //     ->json();
            
            return null;
        });
    }
    
    // TODO: Replace with real Nextcloud API call
    public function getNextcloudStats()
    {
        return Cache::remember('nextcloud_stats', 300, function() {
            // Uncomment when ready to use real API:
            // return Http::withToken(config('external_apis.nextcloud.token'))
            //     ->get(config('external_apis.nextcloud.base_url') . '/serverinfo')
            //     ->json();
            
            return null;
        });
    }
    
    // TODO: Replace with real Nextcloud Users API call
    public function getNextcloudUsers()
    {
        return Cache::remember('nextcloud_users', 300, function() {
            // Uncomment when ready to use real API:
            // return Http::withToken(config('external_apis.nextcloud.token'))
            //     ->get(config('external_apis.nextcloud.base_url') . '/users')
            //     ->json();
            
            return null;
        });
    }
}
```

---

# 10. Implementation Priority

Execute in this exact order:

## Phase 1: Foundation (Day 1)
1. ✅ Initialize Laravel project
2. ✅ Install Livewire, Tailwind CSS, Chart.js
3. ✅ Create all database migrations
4. ✅ Create all Models with relationships
5. ✅ Create all Seeders with dummy data
6. ✅ Run migrations and seed database

## Phase 2: Layout & Navigation (Day 1)
1. ✅ Create app layout (`resources/views/layouts/app.blade.php`)
2. ✅ Build Sidebar Livewire component (fully functional)
3. ✅ Create all route definitions
4. ✅ Create all Controllers (Dashboard, Proxmox, Nextcloud, System)
5. ✅ Test navigation (expand/collapse, active states)

## Phase 3: Dashboard Cards (Day 2)
1. ✅ Node Status Card (with health badge)
2. ✅ Storage Health Card (with gradient progress bar)
3. ✅ VM Usage Card (top 3 VMs)
4. ✅ Nextcloud Overview Card
5. ✅ User Quota Warning Card
6. ✅ Recent Logins Card
7. ✅ System Alerts Card
8. ✅ Quick Actions Panel

## Phase 4: Polish & Testing (Day 3)
1. ✅ Responsive design testing
2. ✅ Add loading states
3. ✅ Add hover effects and transitions
4. ✅ Test all navigation links
5. ✅ Verify dummy data displays correctly
6. ✅ Add documentation comments

---

# 11. Design Reference Requirements

Based on the provided screenshot, ensure exact replication of:

### Colors
- **Background:** #0f172a (slate-950)
- **Cards:** #1e293b (slate-800) with #334155 borders (slate-700)
- **Text Primary:** #ffffff (white)
- **Text Secondary:** #94a3b8 (gray-400)
- **Success:** #10b981 (emerald-500)
- **Warning:** #f97316 (orange-500)
- **Critical:** #ef4444 (red-500)
- **Primary Accent:** #3b82f6 (blue-500)

### Typography
- **Headings:** Font weight 700 (bold), sizes 2xl-3xl
- **Body:** Font weight 400-500, size base-sm
- **Small text:** Font weight 400, size xs-sm, gray-400 color

### Component Styling
- **Cards:** Rounded-xl, border-slate-700, padding 1.5rem
- **Progress Bars:** Height 3rem (h-12), rounded-lg, gradient fills
- **Badges:** Rounded-full, small padding, border with opacity
- **Buttons:** Rounded-lg, hover state transitions
- **Icons:** Size 1.25-2rem (w-5-w-8)

### Layout
- **Sidebar:** Width 16rem (w-64), fixed height
- **Main Content:** Flex-1, padding 2rem
- **Grid:** 3 columns on large screens, responsive
- **Spacing:** Consistent gap-6 between cards

---

# 12. Quick Start Command

When starting with AI agent, use this exact prompt:
```
"Build a complete Laravel 11 Maintenance Dashboard with these requirements:

1. Analyze the attached design image and replicate exactly
2. Follow ALL specifications in the attached prompt.md file
3. Use Laravel 11 + Livewire 3 + Tailwind CSS
4. Navigation must be fully functional from start
5. All visualizations must show dummy data immediately (no API needed yet)
6. Create comprehensive seeders with realistic data

Start by:
- Creating the complete file structure
- Writing all migrations
- Creating all Models
- Building all Seeders
- Then build the UI components

Do NOT skip any steps. Build everything according to the prompt.md specifications."
```

---

# 13. Final Deliverables Checklist

Before considering complete, verify:

- [ ] ✅ Laravel 11 project initialized
- [ ] ✅ All dependencies installed (Livewire, Tailwind, Chart.js)
- [ ] ✅ 6 database tables created with migrations
- [ ] ✅ 6 Model classes with proper relationships
- [ ] ✅ 6 Seeder classes with comprehensive dummy data
- [ ] ✅ Database migrated and seeded successfully
- [ ] ✅ Sidebar component functional (expand/collapse works)
- [ ] ✅ All 13 routes defined and working
- [ ] ✅ 8 Livewire components created and functional
- [ ] ✅ All visualizations displaying with dummy data
- [ ] ✅ Storage health progress bar with gradient
- [ ] ✅ VM usage list displaying correctly
- [ ] ✅ Nextcloud stats showing properly
- [ ] ✅ User quota warnings visible
- [ ] ✅ Recent logins timeline working
- [ ] ✅ System alerts card functional
- [ ] ✅ Quick actions buttons operational
- [ ] ✅ Responsive design (mobile, tablet, desktop)
- [ ] ✅ Dark theme colors matching reference
- [ ] ✅ All hover effects implemented
- [ ] ✅ Active navigation states working
- [ ] ✅ Loading states on actions
- [ ] ✅ Comments explaining API integration points
- [ ] ✅ Documentation complete

---

# 14. CRITICAL: Exact Visual Implementation Requirements

## Reference Image
The user has provided a design reference image located at:
```
<img src="public/img/request tampilan.jpeg" alt="Request tampilan">
```

**IMPORTANT:** Analyze this image carefully and replicate the EXACT visual design on the dashboard page.

---

## Required Dashboard Components (Must Match Image Exactly)

### 1. STORAGE HEALTH Component
**Visual Requirements:**
- Large horizontal progress bar with **gradient orange-to-red fill**
- Display "85%" in **large bold white text** on the left
- Display "85% USED" in **large bold white text** on the right
- Background: Dark gradient from dark red to orange
- Below the bar, show:
  - Small gray dot + "local: 33%"
  - Yellow warning triangle icon + "CRITICAL SOON" (right aligned)
- Second row:
  - Small green dot + "RAID1: HEALTHY"
  - "TREND: +4% / week" (right aligned)
- Bottom: Small horizontal rainbow progress indicator (green → yellow → red gradient)

**Code Implementation:**
```blade
<div class="bg-slate-800 border border-slate-700 rounded-xl p-6">
    <h3 class="text-xl font-bold text-white mb-6">STORAGE HEALTH</h3>
    
    <div class="bg-slate-900/50 border border-slate-700 rounded-lg p-6">
        <div class="flex items-center mb-4">
            <svg class="w-6 h-6 text-gray-400 mr-3"><!-- Database icon --></svg>
            <span class="text-white font-semibold">LOCAL-LVM</span>
        </div>
        
        <!-- Main Progress Bar -->
        <div class="relative mb-4">
            <div class="flex justify-between items-center mb-2">
                <span class="text-5xl font-bold text-white">85%</span>
                <span class="text-3xl font-bold text-white">85% <span class="text-sm text-gray-400">USED</span></span>
            </div>
            
            <div class="relative h-16 bg-slate-900 rounded-lg overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-orange-600 via-orange-500 to-red-600" 
                     style="width: 85%">
                </div>
            </div>
        </div>
        
        <!-- Info Grid -->
        <div class="grid grid-cols-2 gap-4 mt-6">
            <div class="flex items-center text-sm">
                <div class="w-3 h-3 rounded-full bg-gray-500 mr-2"></div>
                <span class="text-gray-400">local: <span class="text-white">33%</span></span>
            </div>
            <div class="flex items-center justify-end text-sm">
                <svg class="w-4 h-4 text-orange-500 mr-2"><!-- Warning triangle --></svg>
                <span class="text-orange-500 font-medium">CRITICAL SOON</span>
            </div>
        </div>
        
        <div class="grid grid-cols-2 gap-4 mt-2">
            <div class="text-sm">
                <div class="w-3 h-3 rounded-full bg-green-500 inline-block mr-2"></div>
                <span class="text-gray-400">RAID1: <span class="text-white">HEALTHY</span></span>
            </div>
            <div class="text-sm text-right">
                <span class="text-gray-400">TREND: <span class="text-white">+4% / week</span></span>
            </div>
        </div>
        
        <!-- Rainbow Progress Indicator -->
        <div class="mt-4 h-2 bg-slate-900 rounded-full overflow-hidden">
            <div class="h-full bg-gradient-to-r from-green-500 via-yellow-500 to-red-500 w-full"></div>
        </div>
    </div>
</div>
```

---

### 2. NEXTCLOUD OVERVIEW Component
**Visual Requirements:**
- Blue cloud icon in header
- "Nextcloud Overview" title
- Two info boxes in top row:
  - Left: "Status" with green dot + "ONLINE"
  - Right: "81 Users" (large number)
- Bottom box:
  - "81 Users" label
  - "2.3 TB / 5 TB" (right aligned)
  - Horizontal blue progress bar
  - "46% Used" below bar

**Code Implementation:**
```blade
<div class="bg-slate-800 border border-slate-700 rounded-xl p-6">
    <div class="flex items-center space-x-3 mb-6">
        <svg class="w-8 h-8 text-blue-500"><!-- Cloud icon --></svg>
        <h3 class="text-xl font-bold text-white">Nextcloud <span class="text-gray-400">Overview</span></h3>
    </div>
    
    <div class="grid grid-cols-2 gap-6">
        <!-- Status Box -->
        <div class="bg-slate-900/50 rounded-lg p-4 border border-slate-700">
            <div class="flex items-center justify-between">
                <span class="text-gray-400 text-sm">Status</span>
                <span class="flex items-center">
                    <span class="w-2 h-2 rounded-full bg-green-500 mr-2 animate-pulse"></span>
                    <span class="text-green-500 font-semibold">ONLINE</span>
                </span>
            </div>
        </div>
        
        <!-- Users Box -->
        <div class="bg-slate-900/50 rounded-lg p-4 border border-slate-700">
            <div class="text-gray-400 text-sm mb-1">81 Users</div>
            <div class="text-3xl font-bold text-white">81</div>
        </div>
    </div>
    
    <!-- Storage Usage Box -->
    <div class="mt-6 bg-slate-900/50 rounded-lg p-4 border border-slate-700">
        <div class="flex justify-between items-center mb-3">
            <span class="text-white font-semibold">81 Users</span>
            <span class="text-white font-semibold">2.3 TB / 5 TB</span>
        </div>
        
        <div class="relative h-8 bg-slate-900 rounded-lg overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-blue-600" 
                 style="width: 46%">
            </div>
        </div>
        
        <div class="mt-2 text-sm text-gray-400 text-right">
            46% Used
        </div>
    </div>
</div>
```

---

### 3. TOP VM USAGE Component
**Visual Requirements:**
- Title: "TOP VM USAGE"
- Subtitle: "3 running / 4 total"
- Three VM entries, each with:
  - Blue dot indicator (left)
  - VM number and name (e.g., "VM 110 Backup")
  - Storage size in GB (right aligned, large bold)
  - Dark background card with hover effect

**Code Implementation:**
```blade
<div class="bg-slate-800 border border-slate-700 rounded-xl p-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-xl font-bold text-white">TOP VM USAGE</h3>
        <span class="text-sm text-gray-400">3 running / 4 total</span>
    </div>
    
    <div class="space-y-4">
        <!-- VM 110 -->
        <div class="flex items-center justify-between p-4 bg-slate-900/50 rounded-lg border border-slate-700 hover:border-blue-500/50 transition">
            <div class="flex items-center space-x-3">
                <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                <div>
                    <div class="text-white font-medium">VM 110</div>
                    <div class="text-sm text-gray-400">Backup</div>
                </div>
            </div>
            <div class="text-white font-bold text-2xl">450 GB</div>
        </div>
        
        <!-- VM 105 -->
        <div class="flex items-center justify-between p-4 bg-slate-900/50 rounded-lg border border-slate-700 hover:border-blue-500/50 transition">
            <div class="flex items-center space-x-3">
                <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                <div>
                    <div class="text-white font-medium">VM 105</div>
                    <div class="text-sm text-gray-400">DB Server</div>
                </div>
            </div>
            <div class="text-white font-bold text-2xl">300 GB</div>
        </div>
        
        <!-- VM 101 -->
        <div class="flex items-center justify-between p-4 bg-slate-900/50 rounded-lg border border-slate-700 hover:border-blue-500/50 transition">
            <div class="flex items-center space-x-3">
                <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                <div>
                    <div class="text-white font-medium">VM 101</div>
                    <div class="text-sm text-gray-400">Web Server</div>
                </div>
            </div>
            <div class="text-white font-bold text-2xl">120 GB</div>
        </div>
    </div>
</div>
```

---

### 4. SYSTEM ALERTS Component
**Visual Requirements:**
- Title: "SYSTEM ALERTS"
- Two alert types:
  1. **Warning Alert** (Orange):
     - Orange/yellow triangle icon
     - "LOCAL-LVM Usage High! 85%"
     - Subtitle: "(1.5 TB / 1.7 TB)"
  2. **Critical Alert** (Red):
     - Red triangle icon
     - "Nextcloud: User Quota Exceeded"
- Dark background with left colored border (orange/red)

**Code Implementation:**
```blade
<div class="bg-slate-800 border border-slate-700 rounded-xl p-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-xl font-bold text-white">SYSTEM ALERTS</h3>
        <span class="px-3 py-1 bg-red-900/30 text-red-500 text-xs font-semibold rounded-full border border-red-500/30">
            2 Active
        </span>
    </div>
    
    <div class="space-y-3">
        <!-- Warning Alert -->
        <div class="bg-slate-900/50 rounded-lg p-4 border-l-4 border-orange-500">
            <div class="flex items-start space-x-3">
                <svg class="w-5 h-5 text-orange-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div class="flex-1">
                    <div class="font-semibold text-orange-500">
                        LOCAL-LVM Usage High! 85%
                    </div>
                    <div class="text-sm text-gray-400 mt-1">(1.5 TB / 1.7 TB)</div>
                </div>
            </div>
        </div>
        
        <!-- Critical Alert -->
        <div class="bg-slate-900/50 rounded-lg p-4 border-l-4 border-red-500">
            <div class="flex items-start space-x-3">
                <svg class="w-5 h-5 text-red-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div class="flex-1">
                    <div class="font-semibold text-red-500">
                        Nextcloud: User Quota Exceeded
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
```

---

### 5. QUICK ACTIONS Component
**Visual Requirements:**
- Title: "QUICK ACTIONS"
- Four action buttons in 2x2 grid:
  1. **Run FS Trim** (wrench icon)
  2. **Clear Cache** (broom/trash icon)
  3. **Disk Scan** (document with checkmark icon)
  4. **View Snapshots** (camera icon)
- Each button:
  - Icon on top (gray, turns blue on hover)
  - Label below
  - Dark background with border
  - Hover effect (border turns blue)

**Code Implementation:**
```blade
<div class="bg-slate-800 border border-slate-700 rounded-xl p-6">
    <h3 class="text-xl font-bold text-white mb-6">QUICK ACTIONS</h3>
    
    <div class="grid grid-cols-2 gap-4">
        <!-- Run FS Trim -->
        <button class="flex flex-col items-center justify-center p-6 bg-slate-900/50 hover:bg-slate-900 border border-slate-700 hover:border-blue-500 rounded-lg transition group">
            <svg class="w-8 h-8 text-gray-400 group-hover:text-blue-500 mb-3 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
            <span class="text-white font-medium text-sm">Run FS Trim</span>
        </button>
        
        <!-- Clear Cache -->
        <button class="flex flex-col items-center justify-center p-6 bg-slate-900/50 hover:bg-slate-900 border border-slate-700 hover:border-blue-500 rounded-lg transition group">
            <svg class="w-8 h-8 text-gray-400 group-hover:text-blue-500 mb-3 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            <span class="text-white font-medium text-sm">Clear Cache</span>
        </button>
        
        <!-- Disk Scan -->
        <button class="flex flex-col items-center justify-center p-6 bg-slate-900/50 hover:bg-slate-900 border border-slate-700 hover:border-blue-500 rounded-lg transition group">
            <svg class="w-8 h-8 text-gray-400 group-hover:text-blue-500 mb-3 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
            <span class="text-white font-medium text-sm">Disk Scan</span>
        </button>
        
        <!-- View Snapshots -->
        <button class="flex flex-col items-center justify-center p-6 bg-slate-900/50 hover:bg-slate-900 border border-slate-700 hover:border-blue-500 rounded-lg transition group">
            <svg class="w-8 h-8 text-gray-400 group-hover:text-blue-500 mb-3 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span class="text-white font-medium text-sm">View Snapshots</span>
        </button>
    </div>
</div>
```

---

## Dashboard Layout Grid

**CRITICAL:** The dashboard page must display all components in this exact grid layout:
```
+----------------------------------+----------------------------------+----------------------------------+
|                                                                                                      |
|  PROXMOX NODE: prox01 (Full Width - 3 columns)                                                     |
|                                                                                                      |
+----------------------------------+----------------------------------+----------------------------------+
|                                  |                                  |                                  |
|  STORAGE HEALTH                  |  STORAGE HEALTH (continued)      |  NEXTCLOUD OVERVIEW             |
|  (2 columns)                     |                                  |  (1 column)                     |
|                                  |                                  |                                  |
+----------------------------------+----------------------------------+----------------------------------+
|                                  |                                  |                                  |
|  TOP VM USAGE                    |  USER QUOTA WARNING              |  RECENT LOGINS                  |
|  (1 column)                      |  (1 column)                      |  (1 column)                     |
|                                  |                                  |                                  |
+----------------------------------+----------------------------------+----------------------------------+
|                                  |                                                                     |
|  SYSTEM ALERTS                   |  QUICK ACTIONS                                                      |
|  (2 columns)                     |  (1 column)                                                         |
|                                  |                                                                     |
+----------------------------------+----------------------------------+----------------------------------+
```

**Tailwind Grid Classes:**
```blade
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Full Width - Node Status -->
    <div class="lg:col-span-3">
        @livewire('node-status-card')
    </div>
    
    <!-- Storage Health (2 cols) + Nextcloud (1 col) -->
    <div class="lg:col-span-2">
        @livewire('storage-health-card')
    </div>
    <div class="lg:col-span-1">
        @livewire('nextcloud-overview')
    </div>
    
    <!-- Top VM Usage (1 col) + User Quota (1 col) + Recent Logins (1 col) -->
    <div class="lg:col-span-1">
        @livewire('vm-usage-card')
    </div>
    <div class="lg:col-span-1">
        @livewire('user-quota-warning')
    </div>
    <div class="lg:col-span-1">
        @livewire('recent-logins')
    </div>
    
    <!-- System Alerts (2 cols) + Quick Actions (1 col) -->
    <div class="lg:col-span-2">
        @livewire('system-alerts')
    </div>
    <div class="lg:col-span-1">
        @livewire('quick-actions')
    </div>
</div>
```

---

## Color Specifications (Must Match Exactly)
```css
/* Main Background */
bg-slate-950: #020617

/* Card Backgrounds */
bg-slate-800: #1e293b
bg-slate-900: #0f172a
bg-slate-900/50: rgba(15, 23, 42, 0.5)

/* Borders */
border-slate-700: #334155
border-slate-800: #1e293b

/* Text Colors */
text-white: #ffffff
text-gray-400: #9ca3af
text-gray-500: #6b7280

/* Status Colors */
text-green-500: #10b981 (Healthy/Online)
text-orange-500: #f97316 (Warning)
text-red-500: #ef4444 (Critical)
text-blue-500: #3b82f6 (Primary Accent)

/* Progress Bar Gradients */
from-orange-600 via-orange-500 to-red-600
from-blue-500 to-blue-600
from-green-500 via-yellow-500 to-red-500
```

---

## Dummy Data Requirements

### All visualizations MUST use this exact dummy data:

**Storage Health:**
- Usage: 85%
- Local: 33%
- RAID1: HEALTHY
- Trend: +4% / week
- Alert: CRITICAL SOON

**Nextcloud:**
- Status: ONLINE
- Total Users: 81
- Storage: 2.3 TB / 5 TB (46%)

**Top VMs:**
1. VM 110 - Backup - 450 GB
2. VM 105 - DB Server - 300 GB
3. VM 101 - Web Server - 120 GB

**User Quota:**
- User: andi
- Usage: 94% (4.7 GB / 5 GB)

**Recent Logins:**
- joko - 5 mins ago
- ana - 1 hour ago
- susi - 2 days ago

**System Alerts:**
1. LOCAL-LVM Usage High! 85% (1.5 TB / 1.7 TB)
2. Nextcloud: User Quota Exceeded

---

## Implementation Checklist

Before submitting, verify:

- [ ] All 5 components match the reference image exactly
- [ ] Storage Health progress bar has orange-to-red gradient
- [ ] Nextcloud shows blue cloud icon and correct stats
- [ ] Top VM Usage displays 3 VMs with blue dots
- [ ] System Alerts shows 2 alerts (warning + critical)
- [ ] Quick Actions has 4 buttons in 2x2 grid
- [ ] Grid layout matches the specification (3 columns on desktop)
- [ ] All colors match the color specifications above
- [ ] All dummy data matches exactly as specified
- [ ] Hover effects work on all interactive elements
- [ ] Components are responsive (mobile, tablet, desktop)

---

**REMEMBER:** The dashboard MUST look exactly like the reference image. Pay attention to:
- Font sizes and weights
- Spacing and padding
- Border colors and thickness
- Icon sizes and colors
- Progress bar heights and gradients
- Card shadows and borders
- Text colors (white, gray-400, status colors)

---

**Ready to build! Copy this entire prompt.md and start vibe coding! 🚀**
```

---

## 🎯 Cara Pakai:

1. **Copy semua teks di atas**
2. **Buat file baru bernama `prompt.md`**
3. **Paste semua isinya**
4. **Save file**
5. **Siap digunakan untuk vibe coding!**

Ketika mulai dengan AI Agent, tinggal bilang:
```
"Build maintenance dashboard sesuai prompt.md ini [attach file] 
dengan design reference ini [attach gambar]"
<img src="public/img/request tampilan.jpeg" alt="Request Tampilan">

Alpine.js adalah
framework JavaScript minimalis dan ringan yang memungkinkan Anda menambahkan interaktivitas langsung ke dalam HTML dengan sintaks deklaratif, mirip Vue.js atau jQuery modern, untuk membuat elemen seperti dropdown, toggle, atau tab tanpa setup rumit, sangat cocok untuk proyek cepat dan dinamis. Framework ini mengizinkan Anda mendefinisikan logika dan state langsung di HTML menggunakan atribut khusus (direktif) seperti x-data, x-model, dan @click, menjadikannya alternatif yang efisien untuk manipulasi DOM yang kompleks. 
Fitur Utama

    Ringan: Ukurannya sangat kecil, hanya beberapa KB, sehingga tidak membebani aplikasi.
    Deklaratif & Reaktif: Anda menjelaskan apa yang diinginkan (interaksi), bukan bagaimana melakukannya, dan perubahan data akan otomatis diperbarui di DOM.
    Sintaks Mirip Vue/Angular: Mudah dipahami jika Anda sudah familiar dengan kerangka kerja lain, menggunakan direktif langsung di HTML.
    Tanpa Build Step: Cukup tambahkan tag skrip, lalu langsung tulis kode di HTML, mirip seperti menambahkan jQuery.
    Fokus pada Interaksi: Ideal untuk menambahkan fungsionalitas seperti menu, modal, accordion, atau fitur real-time kecil tanpa membuat aplikasi besar (Single Page Application). 