---
description: how to run the maintenance dashboard
---

To run the project, follow these steps:

1. **Open two terminal windows** or tabs.

2. In the first terminal, start the Laravel local development server:
// turbo
```powershell
cd "c:\Users\Dell\Maintenance Dashboard\maintenance-dashboard"
php artisan serve
```

3. In the second terminal, start the Vite development server for assets (Tailwind, Lucide, Chart.js):
// turbo
```powershell
cd "c:\Users\Dell\Maintenance Dashboard\maintenance-dashboard"
npm run dev
```

The application will be accessible at [http://127.0.0.1:8000](http://127.0.0.1:8000).
