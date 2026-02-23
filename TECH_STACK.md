# Technology Stack - Maintenance Dashboard

Dokumen ini menjelaskan tumpuan teknologi (*tech stack*) yang digunakan dalam pengembangan Maintenance Dashboard untuk mempermudah tim pengembang dalam memahami arsitektur aplikasi.

## 1. Core Framework (Backend)
*   **Laravel 11 (PHP 8.2+):** Digunakan sebagai fondasi utama aplikasi. Mengelola routing, keamanan (autentikasi), manajemen database, dan logika bisnis.
*   **Eloquent ORM:** Sistem pemetaan database yang memudahkan pengelolaan data secara objektif (OOP) tanpa harus menulis query SQL secara manual.

## 2. Frontend & Interactivity
Aplikasi ini menggunakan kombinasi Blade, Alpine.js, dan Tailwind CSS untuk performa tinggi dan reaktivitas:
*   **Blade Templates:** Digunakan untuk struktur halaman dan komponen server-side.
*   **Alpine.js:** Framework JavaScript ringan untuk menangani logika di sisi klien:
    *   Navigasi sidebar (expand/collapse dengan persistensi LocalStorage).
    *   **Credential Management:** CRUD dinamis (pencarian, pagination, pemilihan entri) dilakukan sepenuhnya di sisi klien menggunakan Alpine logic.
    *   **Master Data:** Pengelolaan Lokasi Proxmox dan Threshold Alert.
*   **Lucide Icons:** Perpustakaan ikon modern yang bersih dan konsisten. Sub-menu Proxmox kini memiliki integrasi ikon berdasarkan tipe resource (Monitor, Box, Hard Drive, Network).

## 3. UI/UX & Styling
*   **Tailwind CSS v4:** Framework CSS utility-first untuk membangun antarmuka modern dan responsif.
*   **Glassmorphism & Brand Gradient:** Implementasi desain modern dengan efek kaca transparan dan gradien biru-violet (*brand-gradient*) untuk sidebar dan card components.
*   **Vite:** *Build tool* untuk kompilasi aset yang sangat cepat.

## 4. Visualisasi & Integrasi
*   **Chart.js:** Digunakan untuk grafik performa dan visualisasi data infrastruktur.
*   **Proxmox API Integration:** Integrasi data real-time untuk memantau node dan datacenter di 4 lokasi (AGS, Pusat, Punggur, Sekupang).
*   **Threshold Monitoring:** Sistem peringatan visual (warna progress bar berubah) jika resource CPU/MEM melewati batas yang dikonfigurasi di Master Data.

## 5. Data Management
*   **Single Source of Truth:** Data VM dan Node dikelola dalam satu objek sentral agar konsisten antara halaman Dashboard dan Detail Proxmox.
*   **SQLite/MySQL:** Mendukung SQLite untuk pengembangan cepat dan MySQL untuk skala produksi.

---

Pastikan untuk memeriksa konfigurasi desain di `resources/css/app.css` sebelum menambahkan gaya baru.
