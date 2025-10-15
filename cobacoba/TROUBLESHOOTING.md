# 🔧 Troubleshooting - Common Issues

## Issue 1: "could not find driver (Connection: sqlite)"

### Gejala
```
Illuminate\Database\QueryException
could not find driver (Connection: sqlite, SQL: select * from "sessions"...)
```

### Penyebab
File `.env` masih menggunakan SQLite sebagai database connection, padahal kita butuh MySQL.

### Solusi

**Step 1**: Edit file `.env`
```env
# Ubah dari:
DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel

# Menjadi:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sipanak
DB_USERNAME=root
DB_PASSWORD=
```

**Step 2**: Buat database di MySQL
```bash
mysql -u root -e "CREATE DATABASE IF NOT EXISTS sipanak CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

**Step 3**: Clear cache & jalankan migration
```bash
cd cobacoba
php artisan config:clear
php artisan migrate:fresh --seed
```

**Step 4**: Start server
```bash
php artisan serve
```

---

## Issue 2: "Base table or view not found"

### Gejala
```
SQLSTATE[42S02]: Base table or view not found: 1146 Table 'sipanak.cache' doesn't exist
```

### Penyebab
Migration belum dijalankan, table belum dibuat.

### Solusi
```bash
php artisan migrate:fresh --seed
```

---

## Issue 3: "Access denied for user 'root'@'localhost'"

### Gejala
```
SQLSTATE[HY000] [1045] Access denied for user 'root'@'localhost'
```

### Penyebab
Password MySQL salah di `.env`

### Solusi
Edit `.env` dan sesuaikan dengan password MySQL Anda:
```env
DB_USERNAME=root
DB_PASSWORD=your_mysql_password
```

Jika tidak ada password, kosongkan saja:
```env
DB_PASSWORD=
```

---

## Issue 4: "419 Page Expired" saat Submit Form

### Gejala
Error 419 muncul saat submit form

### Penyebab
CSRF token issue atau session issue

### Solusi
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

Refresh browser (Ctrl + Shift + R untuk hard refresh)

---

## Issue 5: Server Port Already in Use

### Gejala
```
Failed to listen on 127.0.0.1:8000 (reason: Address already in use)
```

### Penyebab
Port 8000 sudah digunakan oleh proses lain

### Solusi A - Gunakan port lain:
```bash
php artisan serve --port=8001
```

### Solusi B - Kill process yang pakai port 8000:
```bash
# Windows PowerShell
Get-Process -Id (Get-NetTCPConnection -LocalPort 8000).OwningProcess | Stop-Process

# Atau lihat dulu process-nya:
netstat -ano | findstr :8000
taskkill /PID [PID_NUMBER] /F
```

---

## Issue 6: "Class not found" Error

### Gejala
```
Class 'App\Models\Posyandu' not found
```

### Penyebab
Autoload composer belum di-refresh

### Solusi
```bash
composer dump-autoload
```

---

## Issue 7: Migration Already Exists

### Gejala
```
Migration file already exists
```

### Penyebab
Mencoba membuat migration dengan nama yang sama

### Solusi
- Gunakan nama yang berbeda, atau
- Hapus migration lama jika tidak diperlukan

---

## Issue 8: "No application encryption key"

### Gejala
```
RuntimeException: No application encryption key has been specified.
```

### Penyebab
APP_KEY di `.env` belum di-generate

### Solusi
```bash
php artisan key:generate
```

---

## Issue 9: Permission Denied (Linux/Mac)

### Gejala
```
Permission denied: storage/logs/laravel.log
```

### Solusi
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
sudo chown -R $USER:www-data storage
sudo chown -R $USER:www-data bootstrap/cache
```

---

## Issue 10: Route Not Found (404)

### Gejala
Mengakses route tapi mendapat 404

### Diagnosis
```bash
php artisan route:list
```

### Solusi
- Pastikan route sudah didefinisikan di `routes/web.php`
- Clear route cache: `php artisan route:clear`
- Restart server

---

## Quick Fix All Issues (Nuclear Option)

Jika banyak masalah sekaligus, jalankan ini:

```bash
# 1. Clear semua cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# 2. Refresh autoload
composer dump-autoload

# 3. Reset database
php artisan migrate:fresh --seed

# 4. Restart server
php artisan serve
```

---

## Debugging Tools

### Laravel Tinker
```bash
php artisan tinker

# Test database connection
>>> DB::connection()->getPdo();

# Check if table exists
>>> DB::select('SHOW TABLES');

# Get all users
>>> \App\Models\User::all();
```

### Check Laravel Version
```bash
php artisan --version
```

### Check PHP Version
```bash
php -v
```

### Check Extensions
```bash
php -m | findstr -i "pdo mysql"
```

---

## Checklist Setup Awal

Gunakan checklist ini untuk memastikan setup correct:

- [ ] `.env` file exists (copy dari `.env.example`)
- [ ] `APP_KEY` sudah di-generate
- [ ] Database connection di `.env` correct (mysql, bukan sqlite)
- [ ] Database `sipanak` sudah dibuat di MySQL
- [ ] Username & password MySQL di `.env` correct
- [ ] Composer dependencies installed (`composer install`)
- [ ] Migration sudah dijalankan (`php artisan migrate`)
- [ ] Seeder sudah dijalankan (`php artisan db:seed`)
- [ ] Server berjalan (`php artisan serve`)
- [ ] Bisa akses http://127.0.0.1:8000
- [ ] Bisa login dengan akun default

---

## Contact & Support

Jika masih ada masalah:
1. Check `storage/logs/laravel.log` untuk detail error
2. Gunakan `php artisan tinker` untuk debugging
3. Jalankan `php artisan about` untuk system info

**Tips**: Selalu jalankan `php artisan config:clear` setelah mengubah `.env`!
