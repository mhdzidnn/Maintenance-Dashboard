# Technology Stack - Maintenance Dashboard

Dokumen ini menjelaskan tumpuan teknologi (*tech stack*) yang digunakan dalam pengembangan Maintenance Dashboard untuk mempermudah tim pengembang dalam memahami arsitektur aplikasi.

## 1. Core Framework (Backend)
*   **Laravel 10 (PHP 8.1+):** Digunakan sebagai fondasi utama aplikasi. Mengelola routing, keamanan (autentikasi), manajemen database, dan logika bisnis.
*   **Eloquent ORM:** Sistem pemetaan database yang memudahkan pengelolaan data secara objektif (OOP) tanpa harus menulis query SQL secara manual.

## 2. Dynamic Frontend (TALL Stack)
Aplikasi ini menggunakan filosofi **TALL Stack**, yang mengutamakan produktivitas dan performa tinggi tanpa kompleksitas framework JavaScript yang berat (SPA):
*   **Livewire 3:** Mengatur komponen UI yang reaktif dan interaktif (seperti *real-time status updates*) langsung dari sisi PHP.
*   **Alpine.js:** Framework JavaScript ringan untuk menangani logika di sisi klien (seperti buka/tutup menu sidebar, animasi sederhana, dan dropdown).

## 3. UI/UX & Styling
*   **Tailwind CSS v4:** Versi terbaru dari framework CSS utility-first. Digunakan untuk membangun antarmuka yang sangat kustom dan cepat.
*   **Glassmorphism Design:** Implementasi desain modern dengan efek kaca transparan, blur, dan gradien gelap yang dikonfigurasi melalui `@utility` khusus.
*   **Lucide Icons:** Perpustakaan ikon modern yang bersih dan konsisten untuk seluruh antarmuka.
*   **Vite:** *Build tool* generasi terbaru untuk kompilasi aset (CSS/JS) yang sangat cepat.

## 4. Visualisasi & Integrasi
*   **Chart.js:** Perpustakaan grafik untuk memvisualisasikan data penggunaan *resource* (CPU, RAM, Storage).
*   **Proxmox API Integration:** *Service Layer* khusus (`app/Services/ProxmoxApiService.php`) yang berkomunikasi langsung dengan REST API Proxmox untuk menarik data infrastruktur secara *real-time*.

## 5. Data & Otomatisasi
*   **Artisan Commands:** Perintah kustom (seperti `SyncProxmoxVMs`) untuk mengotomatisasi tugas di latar belakang via CLI.
*   **SQLite (Default):** Database default yang efisien untuk pengembangan dan produksi skala kecil/menengah tanpa memerlukan server database terpisah. Kompatibel penuh dengan MySQL/PostgreSQL jika ingin di-*upgrade*.

---

periksa konfigurasi `Tailwind v4` di `resources/css/app.css` sebelum menambahkan gaya baru untuk menjaga konsistensi desain.
