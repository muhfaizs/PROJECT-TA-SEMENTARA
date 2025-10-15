# 🧪 Panduan Testing - SIP Ibu & Anak

## ✅ Testing Checklist Manual

### 1. Setup & Environment

**Pre-requisites**:
```bash
# Pastikan sudah run migration & seeder
php artisan migrate:fresh --seed

# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Start server
php artisan serve
```

**Expected**:
- ✅ Tidak ada error saat migration
- ✅ Data seeder berhasil masuk (5 posyandu, 5 user)
- ✅ Server berjalan di http://127.0.0.1:8000

---

### 2. Authentication Testing

#### Test Case 2.1: Login Success
**Steps**:
1. Buka http://127.0.0.1:8000
2. Redirect otomatis ke `/login`
3. Login dengan: `admin@sipanak.id` / `password`

**Expected**:
- ✅ Redirect ke dashboard
- ✅ Muncul flash message "Selamat datang, Admin Sistem"
- ✅ Navbar menampilkan menu lengkap

#### Test Case 2.2: Login Failed
**Steps**:
1. Login dengan: `wrong@email.com` / `wrong`

**Expected**:
- ✅ Tetap di halaman login
- ✅ Muncul error "Email atau password salah"

#### Test Case 2.3: Logout
**Steps**:
1. Klik menu "Keluar"

**Expected**:
- ✅ Redirect ke halaman login
- ✅ Muncul flash message "Anda telah keluar"
- ✅ Tidak bisa akses dashboard tanpa login

---

### 3. RBAC (Role-Based Access Control)

#### Test Case 3.1: Kader Access
**Steps**:
1. Login sebagai kader: `kader1@sipanak.id` / `password`
2. Coba akses menu Verifikasi

**Expected**:
- ✅ Dashboard hanya menampilkan data dari Posyandu Melati 1
- ✅ Menu "Verifikasi" TIDAK muncul di navbar
- ✅ Direct access ke `/verifikasi` → Error 403 Forbidden

#### Test Case 3.2: Bidan Access
**Steps**:
1. Login sebagai bidan: `bidan@sipanak.id` / `password`
2. Akses menu Verifikasi

**Expected**:
- ✅ Dashboard menampilkan data dari SEMUA posyandu
- ✅ Menu "Verifikasi" muncul di navbar
- ✅ Bisa akses halaman verifikasi

---

### 4. Registrasi Ibu

#### Test Case 4.1: Registrasi Ibu Hamil
**Steps**:
1. Login sebagai kader
2. Menu Ibu → Registrasi Ibu
3. Isi form:
   - NIK: 3201012301900001
   - Nama: Siti Aminah
   - Tgl Lahir: 23/01/1990
   - HP: 081234567890
   - Alamat: Jl. Merdeka No. 10
   - Posyandu: Posyandu Melati 1
   - **HPHT: (tanggal 3 bulan lalu dari hari ini)**
4. Submit

**Expected**:
- ✅ Redirect ke halaman detail ibu
- ✅ Flash message "Data ibu berhasil disimpan"
- ✅ TP (Taksiran Persalinan) otomatis terhitung (HPHT + 280 hari)
- ✅ Usia kehamilan tampil dalam minggu
- ✅ Jika usia < 18 atau > 35, skor risiko ≥ 3

#### Test Case 4.2: Registrasi Ibu Tidak Hamil
**Steps**:
1. Registrasi ibu tanpa mengisi HPHT
2. Submit

**Expected**:
- ✅ Berhasil tersimpan
- ✅ Status: "Tidak sedang hamil"
- ✅ TP dan usia kehamilan: NULL

#### Test Case 4.3: NIK Duplicate
**Steps**:
1. Coba registrasi dengan NIK yang sama

**Expected**:
- ✅ Muncul error "NIK sudah terdaftar"
- ✅ Data tidak tersimpan

#### Test Case 4.4: Validasi NIK
**Steps**:
1. Isi NIK kurang dari 16 digit (misal: 123)
2. Submit

**Expected**:
- ✅ Muncul error "NIK harus 16 digit"

---

### 5. Registrasi Anak

#### Test Case 5.1: Registrasi Anak Dari Halaman Ibu
**Steps**:
1. Buka detail ibu (dari test 4.1)
2. Klik tombol "Tambah Anak"
3. Form sudah pre-select ibu tersebut
4. Isi form:
   - Nama: Ahmad
   - Tgl Lahir: 15/06/2023
   - Jenis Kelamin: L
   - BB Lahir: 3.2
   - PB Lahir: 48.5
5. Submit

**Expected**:
- ✅ Data anak tersimpan
- ✅ Usia otomatis terhitung dalam bulan
- ✅ Redirect ke halaman detail anak

#### Test Case 5.2: Registrasi Anak Langsung
**Steps**:
1. Menu Anak → Registrasi Anak
2. Pilih ibu dari dropdown
3. Submit

**Expected**:
- ✅ Berhasil tersimpan
- ✅ Muncul di list anak

---

### 6. Input Pengukuran Tumbuh Kembang

#### Test Case 6.1: Input Pengukuran Normal
**Steps**:
1. Dari halaman detail anak, klik "Input Pengukuran"
2. Isi form:
   - Tanggal: (hari ini)
   - BB: 12.5 kg
   - TB: 90.5 cm
   - LL: 15.2 cm
3. Submit

**Expected**:
- ✅ Data tersimpan
- ✅ Status gizi otomatis terhitung (misal: normal)
- ✅ `verified_at` = NULL (belum diverifikasi)
- ✅ Muncul di riwayat pengukuran dengan badge "⏳ Menunggu"

#### Test Case 6.2: Validasi Input
**Steps**:
1. Coba input BB = 0 (tidak valid)

**Expected**:
- ✅ Muncul error "Berat badan minimal 1 kg"

#### Test Case 6.3: Lihat Riwayat
**Steps**:
1. Input beberapa pengukuran dengan tanggal berbeda
2. Lihat di halaman detail anak

**Expected**:
- ✅ Riwayat tampil urut dari terbaru (max 10)
- ✅ Setiap row menampilkan: tanggal, BB, TB, LL, status gizi, verifikasi

---

### 7. Input Imunisasi

#### Test Case 7.1: Input Imunisasi
**Steps**:
1. Dari halaman detail anak, klik "Input Imunisasi"
2. Isi form:
   - Vaksin: BCG
   - Dosis: Ke-1
   - Tanggal: (hari ini)
   - Keterangan: Tidak ada efek samping
3. Submit

**Expected**:
- ✅ Data tersimpan
- ✅ `verified_at` = NULL
- ✅ Muncul di riwayat imunisasi

#### Test Case 7.2: Multiple Imunisasi
**Steps**:
1. Input beberapa vaksin berbeda untuk anak yang sama

**Expected**:
- ✅ Semua tersimpan
- ✅ Badge vaksin muncul di bagian atas form saat input baru

---

### 8. Verifikasi Data

#### Test Case 8.1: Lihat Antrian Verifikasi
**Steps**:
1. Logout dari kader
2. Login sebagai bidan: `bidan@sipanak.id` / `password`
3. Akses menu Verifikasi

**Expected**:
- ✅ Menampilkan gabungan data tumbuh & imunisasi yang belum diverifikasi
- ✅ Ada kolom: Jenis, Nama Anak, Nama Ibu, Tanggal, Detail, Posyandu, Dibuat Oleh
- ✅ Badge "Pengukuran" (biru) dan "Imunisasi" (biru)

#### Test Case 8.2: Approve Data
**Steps**:
1. Klik tombol "✓ Approve" pada salah satu data
2. Confirm

**Expected**:
- ✅ Flash message "Data berhasil diverifikasi"
- ✅ Data hilang dari antrian
- ✅ Di database: `verified_at` terisi, `verified_by` = user bidan

#### Test Case 8.3: Reject Data
**Steps**:
1. Klik tombol "✗ Reject"
2. Muncul modal
3. Isi alasan: "Data tidak sesuai, BB terlalu tinggi"
4. Submit

**Expected**:
- ✅ Flash message "Data ditolak dengan alasan: ..."
- ✅ Data hilang dari antrian
- ✅ Di database: `verified_at` terisi, `reject_reason` terisi

#### Test Case 8.4: Filter Verifikasi
**Steps**:
1. Filter by type = "Pengukuran"

**Expected**:
- ✅ Hanya tampil data pengukuran
- ✅ Data imunisasi hidden

---

### 9. Dashboard & Monitoring

#### Test Case 9.1: Dashboard Kader
**Steps**:
1. Login sebagai kader
2. Lihat dashboard

**Expected**:
- ✅ Kartu statistik menampilkan data dari posyandu sendiri
- ✅ Alert ibu risiko tinggi (jika ada)
- ✅ Alert anak status gizi non-normal (jika ada)
- ✅ Quick actions button

#### Test Case 9.2: Dashboard Bidan
**Steps**:
1. Login sebagai bidan
2. Lihat dashboard

**Expected**:
- ✅ Statistik menampilkan data dari SEMUA posyandu
- ✅ Ada kartu "Menunggu Verifikasi" dengan jumlah
- ✅ Alert menampilkan semua data risiko tinggi

#### Test Case 9.3: Alert Ibu Risiko Tinggi
**Steps**:
1. Registrasi ibu dengan usia < 18 atau > 35 tahun + HPHT
2. Lihat dashboard

**Expected**:
- ✅ Ibu tersebut muncul di tabel "Ibu Hamil Risiko Tinggi"
- ✅ Badge merah untuk skor risiko
- ✅ Link ke detail ibu

#### Test Case 9.4: Alert Anak Status Gizi
**Steps**:
1. Input pengukuran dengan status gizi stunted/wasted
2. Verifikasi data tersebut (login sebagai bidan)
3. Lihat dashboard

**Expected**:
- ✅ Anak tersebut muncul di tabel "Anak dengan Status Gizi Non-Normal"
- ✅ Badge warna sesuai (merah untuk stunted/wasted)

---

### 10. Search & Filter

#### Test Case 10.1: Search Ibu
**Steps**:
1. Menu Ibu
2. Ketik nama di search box
3. Klik Cari

**Expected**:
- ✅ Hasil filter sesuai keyword
- ✅ Pagination tetap berfungsi

#### Test Case 10.2: Filter Posyandu
**Steps**:
1. Menu Ibu
2. Pilih posyandu dari dropdown
3. Klik Cari

**Expected**:
- ✅ Hanya tampil data dari posyandu terpilih

#### Test Case 10.3: Filter Bulan Pengukuran
**Steps**:
1. Menu Tumbuh
2. Pilih bulan (misal: Oktober 2025)
3. Klik Filter

**Expected**:
- ✅ Hanya tampil data pengukuran di bulan tersebut

---

## 🐛 Bug Testing

### Potential Issues to Check:

1. **CSRF Token**
   - ✅ Semua form memiliki `@csrf`
   - ✅ Tidak ada error 419 saat submit

2. **N+1 Query**
   - ✅ Gunakan `with()` di query
   - ✅ Check Laravel Debugbar (optional)

3. **Pagination**
   - ✅ Link pagination berfungsi
   - ✅ Query string preserved saat pagination

4. **Empty State**
   - ✅ Tampilan jika data kosong
   - ✅ Tidak ada error jika tabel kosong

5. **Date Format**
   - ✅ Tanggal tampil dengan format d/m/Y
   - ✅ Input date berfungsi di semua browser

---

## 📊 Performance Testing

### Load Test (Manual):
1. Input 100+ data ibu
2. Input 500+ data anak
3. Input 1000+ data pengukuran

**Check**:
- ✅ Dashboard load < 2 detik
- ✅ List page dengan pagination lancar
- ✅ Search tetap responsive

---

## 🔒 Security Testing

### Test Case S1: Direct URL Access
**Steps**:
1. Logout
2. Coba akses `/dashboard` langsung

**Expected**:
- ✅ Redirect ke login

### Test Case S2: CSRF Attack
**Steps**:
1. Buat form POST eksternal tanpa `@csrf`
2. Submit

**Expected**:
- ✅ Error 419 CSRF token mismatch

### Test Case S3: SQL Injection
**Steps**:
1. Di search box, input: `'; DROP TABLE users; --`

**Expected**:
- ✅ Query aman (menggunakan parameter binding)
- ✅ Tidak ada data terhapus

### Test Case S4: XSS
**Steps**:
1. Input nama: `<script>alert('XSS')</script>`

**Expected**:
- ✅ Blade otomatis escape HTML
- ✅ Script tidak execute

---

## ✅ Final Checklist

Sebelum deploy, pastikan:

- [ ] Semua test case di atas PASSED
- [ ] Tidak ada error di console browser
- [ ] Tidak ada error di log Laravel
- [ ] Database schema sesuai dokumentasi
- [ ] Seeder berjalan tanpa error
- [ ] README & dokumentasi up-to-date
- [ ] `.env.example` sudah dikonfigurasi
- [ ] Sensitive data tidak ter-commit ke git

---

## 📝 Testing Log Template

```
Date: _______________
Tester: _______________
Environment: _______________

Test Case | Status | Notes
----------|--------|-------
TC 2.1    | ✅ PASS | -
TC 2.2    | ✅ PASS | -
TC 3.1    | ❌ FAIL | Menu verifikasi masih muncul untuk kader
...
```

---

**Happy Testing! 🚀**
