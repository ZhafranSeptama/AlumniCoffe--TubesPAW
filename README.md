# ☕ Alumni Coffee - Project Tubes PAW

Aplikasi Coffee Shop berbasis web yang dibangun menggunakan **Laravel 10** dan **Tailwind CSS**. Project ini dibuat untuk memenuhi Tugas Besar Mata Kuliah Pengembangan Aplikasi Web (PAW).

## 🚀 Fitur Utama

### 👤 Customer
- **Katalog Menu:** Melihat daftar kopi dengan tampilan grid galeri.
- **Keranjang Belanja:** Menambahkan item, mengubah jumlah, dan menghapus item.
- **Checkout & Pembayaran:** Simulasi pembayaran dengan pop-up QRIS.
- **Riwayat Pesanan:** Melihat status pesanan yang pernah dibuat.

### 👮 Admin
- **Dashboard Analitik:** Grafik pendapatan bulanan & statistik penjualan (Chart.js).
- **Manajemen Menu:** Tambah, Edit (termasuk upload foto), dan Hapus menu kopi.
- **Kelola Pesanan:** Filter & Sort pesanan masuk, serta mengubah status pesanan.

## 🛠️ Teknologi yang Digunakan
- **Backend:** Laravel Framework
- **Frontend:** Blade Templates, Tailwind CSS
- **Database:** MySQL
- **Charts:** Chart.js (CDN)
- **Icons:** FontAwesome

## 💻 Cara Install (Untuk Dosen/Asisten)

1. **Clone Repository**
   ```bash
   git clone [https://github.com/ZhafranSeptama/AlumniCoffe--TubesPAW.git](https://github.com/ZhafranSeptama/AlumniCoffe--TubesPAW.git)
2. **Masuk Folder**
    ```bash
   cd AlumniCoffe--TubesPAW
3. **Install Dependencies**
    ```bash
   composer install
4. **Generate Key & Migrate**
    ```bash
    php artisan key:generate
    php artisan migrate:fresh --seed
    php artisan storage:link
5. **Jalankan Server**
    ```bash
    php artisan serve


## Dibuat oleh Zhafran Septama DKK.
