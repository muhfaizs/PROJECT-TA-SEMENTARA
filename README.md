# COBA-COBA Repository

## 🏥 SIP Ibu & Anak - Sistem Informasi Posyandu

Aplikasi monitoring kesehatan Ibu (hamil) & Anak berbasis Laravel dengan front-end HTML/CSS (Blade).

### 📂 Struktur Project

```
COBA-COBA/
└── cobacoba/           # Aplikasi Laravel lengkap
    ├── app/
    ├── database/
    ├── resources/
    ├── routes/
    ├── SETUP_GUIDE.md        # 📖 Panduan instalasi
    ├── BUSINESS_FLOW.md      # 📊 Alur bisnis
    ├── TESTING_GUIDE.md      # 🧪 Panduan testing
    ├── COMMANDS.md           # ⚡ Quick commands
    └── PROJECT_SUMMARY.md    # ✨ Summary lengkap
```

### 🚀 Quick Start

```bash
cd cobacoba
composer install
cp .env.example .env
php artisan key:generate
# Setup database di .env
php artisan migrate:fresh --seed
php artisan serve
```

**Login**: http://127.0.0.1:8000
- Email: `admin@sipanak.id`
- Password: `password`

### 📚 Dokumentasi

Baca dokumentasi lengkap di folder `cobacoba/`:
1. **SETUP_GUIDE.md** - Cara instalasi & konfigurasi
2. **BUSINESS_FLOW.md** - Alur bisnis aplikasi
3. **TESTING_GUIDE.md** - Panduan testing manual
4. **COMMANDS.md** - Laravel commands reference
5. **PROJECT_SUMMARY.md** - Overview lengkap project

### ✨ Fitur Utama

- ✅ Multi-role (Kader, Bidan, Dokter, Admin)
- ✅ Registrasi Ibu & Anak
- ✅ Input Pengukuran Tumbuh Kembang
- ✅ Input Imunisasi
- ✅ Sistem Verifikasi Data
- ✅ Dashboard & Alert Risiko Tinggi
- ✅ Auto-calculate Status Gizi

### 🛠️ Tech Stack

- Laravel 11.x
- PHP 8.2+
- MySQL/PostgreSQL
- Blade Templates (HTML/CSS Vanilla)

---

**Developed for**: Posyandu & Puskesmas Health Monitoring System