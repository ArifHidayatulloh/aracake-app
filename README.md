<p align="center">
  <img src="[URL_LOGO_ATAU_BANNER_ANDA_JIKA_ADA]" alt="Aracake App Banner" width="400"/>
</p>

<h1 align="center">Aracake App - E-Commerce Toko Kue</h1>

<p align="center">
  Aplikasi web e-commerce yang dibangun dengan Laravel untuk manajemen toko kue online.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.1%2B-blue?style=flat&logo=php" alt="PHP Version">
  <img src="https://img.shields.io/badge/Laravel-10.x-orange?style=flat&logo=laravel" alt="Laravel Version">
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

## 📸 Tampilan Aplikasi (Screenshot)

**SANGAT PENTING:** *Gantilah bagian di bawah ini dengan screenshot nyata dari aplikasi Anda. Ini akan membuat README Anda 100x lebih menarik!*

| Halaman Utama | Halaman Produk |
| :---: | :---: |
| ![Homepage]([URL_SCREENSHOT_HOMEPAGE]) | ![Product Page]([URL_SCREENSHOT_PRODUK]) |

| Dashboard Admin | Manajemen Pesanan |
| :---: | :---: |
| ![Admin Dashboard]([URL_SCREENSHOT_ADMIN]) | ![Order Management]([URL_SCREENSHOT_PESANAN]) |


## 🛠️ Teknologi yang Digunakan

* **Backend:** PHP, Laravel
* **Frontend:** Blade, Bootstrap 5, JavaScript
* **Database:** MySQL
* **Server:** Apache/Nginx
* **Tools:** Composer, NPM

## 🚀 Panduan Instalasi & Setup

Berikut adalah langkah-langkah untuk menjalankan proyek ini secara lokal:

**1. Prasyarat (Prerequisites)**
Pastikan Anda sudah menginstal:
* PHP (versi 8.1 atau lebih baru)
* Composer
* Node.js & NPM
* Database (misalnya MySQL)

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

php artisan serve