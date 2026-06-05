# ⚽ Kinetic Futsal

> Platform pemesanan lapangan futsal berbasis web — dibangun dengan Laravel 11.

![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=flat-square&logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat-square&logo=mysql&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)

---

## 📋 Tentang Proyek

**Kinetic Futsal** adalah aplikasi web untuk pemesanan lapangan futsal secara online. Aplikasi ini memudahkan pelanggan untuk melihat ketersediaan lapangan, melakukan booking, dan mengelola jadwal bermain — sementara admin dapat mengelola lapangan, jadwal, dan data pemesanan dari satu dashboard terpusat.

> Proyek ini dikembangkan sebagai tugas akhir semester mata kuliah **Pengembangan Web**, Program Studi Sistem Informasi, Fakultas Ilmu Komputer, Universitas Sriwijaya.

---

## ✨ Fitur Utama

<table>
<tr>
<td width="50%" valign="top">

### 👤 Pelanggan

- Registrasi dan login akun
- Lihat daftar lapangan beserta foto dan informasi
- Cek ketersediaan slot waktu secara real-time
- Booking lapangan dengan pilihan tanggal dan jam
- Riwayat pemesanan dan status booking
- Konfirmasi pembayaran dengan upload bukti transfer

</td>
<td width="50%" valign="top">

### 🛡️ Admin

- Dashboard pengelolaan lapangan dan jadwal
- Manajemen data pemesanan (konfirmasi / tolak)
- Kelola pengguna terdaftar
- Laporan pemesanan dan pendapatan

</td>
</tr>
</table>

---

## 🛠️ Teknologi yang Digunakan

| Komponen | Teknologi |
|---|---|
| Backend Framework | Laravel 11 |
| Bahasa Pemrograman | PHP 8.2+ |
| Database | MySQL 8.0 |
| Frontend | Blade Template, Tailwind CSS |
| Authentication | Laravel Breeze |
| Server Lokal | Laragon |

---

## ⚙️ Instalasi & Menjalankan Lokal

Pastikan sudah menginstal: **PHP 8.2+**, **Composer**, **MySQL**, dan **Node.js**.

### 1. Clone repositori

```bash
git clone https://github.com/ZackyAlan/kinetic-futsal.git
cd kinetic-futsal
```

### 2. Install dependensi PHP

```bash
composer install
```

### 3. Install dependensi JavaScript

```bash
npm install
npm run build
```

### 4. Konfigurasi environment

```bash
cp .env.example .env
php artisan key:generate
```

Lalu edit file `.env` sesuai konfigurasi database lokal kamu:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kinetic_futsal
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Migrasi dan seed database

```bash
php artisan migrate --seed
```

### 6. Jalankan server

```bash
php artisan serve
```

Aplikasi berjalan di `http://localhost:8000`

---

## 🗂️ Struktur Direktori

```
kinetic-futsal/
├── app/
│   ├── Http/Controllers/   # Controller untuk setiap modul
│   ├── Models/             # Eloquent models
│   └── ...
├── database/
│   ├── migrations/         # Skema tabel database
│   └── seeders/            # Data awal (lapangan, admin, dll)
├── resources/
│   └── views/              # Blade templates
│       ├── admin/          # Halaman dashboard admin
│       ├── booking/        # Halaman proses booking
│       └── auth/           # Halaman login & register
├── routes/
│   └── web.php             # Definisi routing
└── public/                 # Assets publik
```

---

## 📸 Screenshot

<img width="1865" height="859" alt="Screenshot 2026-06-05 142609" src="https://github.com/user-attachments/assets/5ac48202-f11f-4ecd-ad27-ae27de41bb4a" />
<img width="609" height="780" alt="Screenshot 2026-06-05 142427" src="https://github.com/user-attachments/assets/18d18127-bf10-4d84-8d14-1ce31874ba96" />
<img width="1878" height="855" alt="Screenshot 2026-06-05 142523" src="https://github.com/user-attachments/assets/6c8168da-d656-4033-a26f-8aad7507291e" />
<img width="1864" height="863" alt="Screenshot 2026-06-05 142625" src="https://github.com/user-attachments/assets/d01a389d-3f1a-43c4-a9cd-1dde15665465" />
<img width="1888" height="859" alt="Screenshot 2026-06-05 142501" src="https://github.com/user-attachments/assets/fd596d90-1c4d-46cd-854c-c0c7187dc2dc" />
<img width="1875" height="863" alt="Screenshot 2026-06-05 142635" src="https://github.com/user-attachments/assets/c3a6eca9-ff83-488c-9764-b0f322e1882d" />

---

## 🗺️ Rencana Pengembangan

- [ ] Integrasi payment gateway (Midtrans / Xendit)
- [ ] Notifikasi WhatsApp otomatis setelah booking
- [ ] QR Code tiket untuk check-in di venue
- [ ] Fitur recurring booking (booking mingguan/bulanan)
- [ ] Laporan dan analitik pendapatan yang lebih lengkap
- [ ] Aplikasi mobile (React Native)

---

## 👨‍💻 Pengembang

**Muhammad Zacky Alan Fernando**  
Mahasiswa Sistem Informasi — Universitas Sriwijaya

- GitHub: [@MuhammadZackyAlanFernando](https://github.com/MuhammadZackyAlanFernando)

---

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).
