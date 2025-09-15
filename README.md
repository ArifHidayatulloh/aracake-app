<p align="center">
  <img src="[URL_LOGO_ATAU_BANNER_ANDA_JIKA_ADA]" alt="Aracake App Banner" width="400"/>
</p>

<h1 align="center">Aracake App - E-Commerce Toko Kue</h1>

<p align="center">
  Aplikasi web e-commerce yang dibangun dengan Laravel untuk manajemen toko kue online.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.2%2B-blue?style=flat&logo=php" alt="PHP Version">
  <img src="https://img.shields.io/badge/Laravel-11.x-orange?style=flat&logo=laravel" alt="Laravel Version">
  <img src="https://img.shields.io/badge/License-MIT-green" alt="License">
</p>

---

## 📜 Tentang Proyek

Aracake App adalah aplikasi web e-commerce yang dirancang untuk toko kue "Aracake". Aplikasi ini memungkinkan pelanggan untuk melihat, memesan, dan melacak pembelian kue secara online. Di sisi lain, admin dapat dengan mudah mengelola produk, stok, pesanan yang masuk, dan melihat laporan penjualan. Proyek ini dibuat sebagai studi kasus implementasi framework Laravel dalam membangun aplikasi e-commerce yang fungsional.

## ✨ Fitur Utama

Berikut adalah beberapa fitur utama yang ada di dalam aplikasi ini:

* **Untuk Pelanggan (Customer):**
    * 🛒 Katalog produk dengan pencarian dan filter.
    * 📝 Proses pemesanan (checkout) yang mudah.
    * 🔐 Autentikasi dan manajemen profil pengguna.
    * 📜 Riwayat dan status pesanan.
* **Untuk Administrator (Admin):**
    * 🖥️ Dashboard dengan ringkasan penjualan dan statistik.
    * 🍰 Manajemen Produk (Tambah, Edit, Hapus Kue).
    * 📦 Manajemen Pesanan (Melihat pesanan baru, memproses, dan menyelesaikan pesanan).
    * 👥 Manajemen Pengguna.


## 🛠️ Teknologi yang Digunakan

* **Backend:** PHP, Laravel
* **Frontend:** Blade, Tailwind, JavaScript
* **Database:** MySQL
* **Server:** Apache
* **Tools:** Composer, NPM

## 🚀 Panduan Instalasi & Setup

Berikut adalah langkah-langkah untuk menjalankan proyek ini secara lokal:

**1. Prasyarat (Prerequisites)**
Pastikan Anda sudah menginstal:
* PHP (versi 8.2 atau lebih baru)
* Composer
* Node.js & NPM
* Database (MySQL)

**2. Clone Repository**
```bash
git clone [https://github.com/ArifHidayatulloh/aracake-app.git](https://github.com/ArifHidayatulloh/aracake-app.git)
cd aracake-app

# Instal dependency PHP
composer install

# Instal dependency JavaScript
npm install

# Salin file .env.example
cp .env.example .env

# Buat kunci aplikasi baru
php artisan key:generate

# Jalankan migrasi untuk membuat tabel
php artisan migrate

# (Opsional) Jalankan seeder untuk mengisi data awal (jika ada)
php artisan db:seed

npm run dev

php artisan serve```