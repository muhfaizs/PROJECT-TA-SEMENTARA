# 🏥 Sistem Informasi Posyandu Ibu & Anak (SIP Ibu & Anak)

Aplikasi monitoring kesehatan Ibu (hamil) & Anak berbasis Laravel dengan interface HTML/CSS (Blade).

## 📋 Fitur Utama

### Role & Akses
- **Kader Posyandu**: Registrasi ibu/anak, input penimbangan, imunisasi
- **Bidan/Perawat Puskesmas**: Verifikasi data, asesmen risiko, monitoring
- **Dokter/Koordinator**: Review kasus risiko tinggi, rujukan
- **Admin**: Manajemen user & master data

### Modul Aplikasi
1. **Manajemen Ibu**
   - Registrasi ibu (NIK, biodata, HPHT)
   - Tracking kehamilan & taksiran persalinan
   - Scoring risiko kehamilan
   
2. **Manajemen Anak**
   - Registrasi anak (biodata, data lahir)
   - Tracking perkembangan anak

3. **Tumbuh Kembang**
   - Input pengukuran (BB, TB, Lingkar Lengan)
   - Deteksi status gizi (stunted, wasted, normal, overweight)
   - Riwayat pengukuran

4. **Imunisasi**
   - Input jadwal imunisasi
   - Tracking kelengkapan imunisasi
   - Riwayat vaksinasi

5. **Verifikasi Data**
   - Antrian verifikasi untuk bidan/dokter
   - Approve/reject data dengan alasan
   - Audit trail

6. **Dashboard & Laporan**
   - Statistik per posyandu
   - Alert ibu risiko tinggi
   - Alert anak dengan status gizi non-normal
   - Tracking cakupan K1/K4, imunisasi

## 🚀 Setup & Instalasi

### Prasyarat
- PHP >= 8.2
- Composer
- MySQL/PostgreSQL
- Node.js & NPM (opsional, untuk asset compilation)

### Langkah Instalasi

1. **Clone/Copy project ke folder `cobacoba`**
   ```bash
   cd cobacoba
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Setup environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasi database di `.env`**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=sipanak
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Buat database**
   ```sql
   CREATE DATABASE sipanak;
   ```

6. **Jalankan migration & seeder**
   ```bash
   php artisan migrate --seed
   ```

7. **Jalankan aplikasi**
   ```bash
   php artisan serve
   ```

8. **Akses aplikasi**
   Buka browser: http://127.0.0.1:8000

## 👤 Akun Default

Setelah seeding, Anda dapat login dengan:

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@sipanak.id | password |
| Dokter | dokter@sipanak.id | password |
| Bidan | bidan@sipanak.id | password |
| Kader Posyandu 1 | kader1@sipanak.id | password |
| Kader Posyandu 2 | kader2@sipanak.id | password |

## 📊 Struktur Database

### Tables Utama
- `posyandus` - Master data posyandu
- `users` - User dengan role (kader, bidan, dokter, admin)
- `ibus` - Data ibu (hamil/tidak hamil)
- `anaks` - Data anak
- `tumbuh_records` - Riwayat pengukuran tumbuh kembang
- `imunisasi_records` - Riwayat imunisasi

### Relasi
```
posyandus
  ├── users (many)
  ├── ibus (many)
  ├── tumbuh_records (many)
  └── imunisasi_records (many)

ibus
  └── anaks (many)

anaks
  ├── tumbuh_records (many)
  └── imunisasi_records (many)
```

## 🔐 Keamanan

- CSRF Protection (otomatis Laravel)
- Role-Based Access Control (RBAC)
- NIK Masking (tampilkan 4 digit terakhir)
- Audit trail (created_by, verified_by, timestamps)
- Password hashing (bcrypt)

## 🎯 Alur Penggunaan

### Kader Posyandu
1. Login → Dashboard
2. Registrasi Ibu/Anak
3. Input Pengukuran & Imunisasi
4. Data masuk antrian verifikasi

### Bidan/Dokter Puskesmas
1. Login → Dashboard
2. Buka menu Verifikasi
3. Review data yang masuk
4. Approve atau Reject dengan alasan
5. Monitor dashboard untuk alert risiko tinggi

### Admin
1. Manajemen user
2. Manajemen posyandu
3. Akses semua data

## 📱 Teknologi

- **Backend**: Laravel 11.x
- **Frontend**: Blade Templates + CSS Vanilla (No framework)
- **Database**: MySQL/PostgreSQL
- **Authentication**: Laravel Built-in Auth
- **Authorization**: Custom Role Middleware

## 🔄 Development

### Menambah Posyandu Baru
```php
php artisan tinker
>>> \App\Models\Posyandu::create(['nama' => 'Posyandu Baru', 'desa' => 'Desa X', 'puskesmas' => 'Puskesmas Y']);
```

### Menambah User Baru
```php
\App\Models\User::create([
    'name' => 'Nama User',
    'email' => 'email@example.com',
    'password' => bcrypt('password'),
    'role' => 'kader', // kader|bidan|dokter|admin
    'posyandu_id' => 1, // nullable untuk non-kader
]);
```

### Clear Cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

## 📝 TODO / Pengembangan Lanjutan

- [ ] Implementasi z-score WHO untuk status gizi lebih akurat
- [ ] Export laporan ke PDF/Excel
- [ ] Notifikasi (email/SMS) untuk jadwal imunisasi
- [ ] Grafik pertumbuhan anak (growth chart)
- [ ] Modul rujukan dengan tracking status
- [ ] API untuk integrasi dengan sistem lain
- [ ] Mobile app (Flutter/React Native)

## 🐛 Troubleshooting

### Error: "Class not found"
```bash
composer dump-autoload
```

### Error: "Access denied for user"
Pastikan konfigurasi database di `.env` sudah benar

### Error: "419 Page Expired"
Clear cache dan pastikan CSRF token ada di form:
```bash
php artisan config:clear
```

## 📄 Lisensi

Open source untuk keperluan pendidikan dan kesehatan masyarakat.

## 👥 Kontributor

Dikembangkan untuk monitoring kesehatan Ibu & Anak di tingkat Posyandu dan Puskesmas.

---

**Catatan**: Aplikasi ini adalah MVP (Minimum Viable Product). Untuk implementasi produksi, perlu ditambahkan:
- Unit testing
- Integration testing
- Performance optimization
- Security hardening
- Backup & recovery system
- Monitoring & logging
