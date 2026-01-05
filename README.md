# SIAGA-PI - Sistem Informasi Izin & Administrasi Guru-Siswa SMK PI

Sistem terintegrasi untuk manajemen izin, perpindahan kelas, keterlambatan, dan buku tamu di SMK Prakarya Internasional berbasis Laravel 10.

## Fitur Utama

✅ **Sync Master Data** - Terintegrasi dengan data master Jurusan, Mapel, dan Kelas  
✅ **Form Izin Keluar** - Mendukung multiple siswa dan sinkronisasi mapel  
✅ **Form Perpindahan Kelas** - Pengelolaan perpindahan kelas dengan detail mapel  
✅ **Form Keterlambatan** - Pencatatan keterlambatan siswa terintegrasi  
✅ **Form Guestbook** - Registrasi tamu lengkap dengan fitur ambil foto  
✅ **Export PDF** - Generate surat resmi dalam format PDF dengan layout standar sekolah  
✅ **UI/UX Modern** - Antarmuka responsif dengan tema visual SMK PI  

## Persyaratan Sistem

- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL/MariaDB
- PHP Extensions:
  - pdo_mysql
  - mbstring
  - xml
  - gd
  - curl (opsional)

## Instalasi

### 1. Clone & Install Dependencies

```bash
cd /home/ryusaaa/Documents/Coding-Tugas/PENDATAAN-SEKOLAH

# Install PHP dependencies
composer install --ignore-platform-reqs

# Install JavaScript dependencies
npm install
```

### 2. Konfigurasi Environment

File `.env` sudah dibuat. Update konfigurasi database sesuai kebutuhan:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pendataan_sekolah
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Generate Application Key

```bash
php artisan key:generate
php artisan storage:link
```

### 4. Setup Database

Buat database baru:

```bash
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS pendataan_sekolah;"
```

Jalankan migrasi:

```bash
php artisan migrate
```

### 5. Build Assets

```bash
npm run build
# atau untuk development
npm run dev
```

### 6. Jalankan Aplikasi

```bash
php artisan serve
```

Akses aplikasi di: `http://localhost:8000`

## Struktur Project

```
├── app/
│   ├── Http/Controllers/
│   │   └── keluarKampusController.php  # Main controller
│   └── Models/                         # Siswa, Izin, Kelas, dll
├── resources/
│   ├── views/
│   │   ├── home.blade.php             # Homepage dengan form
│   │   └── pdf/                        # PDF templates
│   ├── css/                            # Styles
│   └── js/                             # JavaScript
├── public/
│   └── pdf/                            # Generated PDF files
└── routes/
    └── web.php                         # Route definitions
```

## Cara Penggunaan

### Form Izin Keluar

1. Pilih tab "Izin Keluar"
2. Pilih nama siswa (bisa multiple)
3. Isi alasan keluar
4. Isi mata pelajaran
5. Klik "Submit & Export PDF"
6. PDF akan terbuka di tab baru

### Form Perpindahan Kelas

1. Pilih tab "Pindah Kelas"
2. Pilih kelas tujuan
3. Isi jumlah siswa
4. Isi mata pelajaran
5. Klik "Submit & Export PDF"

### Form Surat Tamu

1. Pilih tab "Surat Tamu"
2. Isi data tamu (nama, identitas, telepon, dll)
3. Klik "Buka Kamera" untuk ambil foto
4. Klik "Ambil Foto"
5. Klik "Submit & Export PDF"

## Troubleshooting

### Error: PDO extension not found

Install PHP PDO extension:

```bash
# Alpine Linux
apk add php83-pdo php83-pdo_mysql

# Ubuntu/Debian
sudo apt-get install php8.1-mysql

# CentOS/RHEL
sudo yum install php-pdo php-mysqlnd
```

### Error: composer dependencies

Gunakan flag `--ignore-platform-reqs`:

```bash
composer install --ignore-platform-reqs
```

### PDF tidak ter-generate

Pastikan folder `public/pdf` writable:

```bash
chmod -R 775 public/pdf
```

## Konfigurasi Email (Opsional)

Untuk fitur email pada surat tamu, update `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME="your-email@gmail.com"
MAIL_PASSWORD="your-app-password"
MAIL_ENCRYPTION=tls
```

## Teknologi

- **Backend**: Laravel 10
- **Frontend**: HTML, CSS, JavaScript
- **UI**: Custom CSS dengan gradient & animations
- **PDF**: DomPDF (barryvdh/laravel-dompdf)
- **Database**: MySQL
- **Components**: Select2 untuk dropdown

## Lisensi

MIT License

---

Dibuat untuk SMK Prakarya Internasional 🎓
