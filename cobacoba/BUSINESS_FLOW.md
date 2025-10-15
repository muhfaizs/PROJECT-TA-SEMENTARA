# 📖 Dokumentasi Alur Bisnis - SIP Ibu & Anak

## 🔄 Alur End-to-End

### 1️⃣ Registrasi Ibu Hamil di Posyandu

**Actor**: Kader Posyandu

**Alur**:
1. Kader login ke sistem
2. Masuk ke menu "Ibu" → "Registrasi Ibu"
3. Mengisi form:
   - NIK (16 digit, wajib, unique)
   - Nama lengkap
   - Tanggal lahir
   - No HP
   - Alamat
   - Posyandu
   - **HPHT** (Hari Pertama Haid Terakhir) - jika sedang hamil
4. Sistem otomatis:
   - Menghitung **Taksiran Persalinan (TP)** = HPHT + 280 hari
   - Menghitung **Skor Risiko** berdasarkan usia ibu:
     - Usia < 18 tahun atau > 35 tahun = Risiko +3
5. Data tersimpan dengan status `verified_at = NULL` (belum diverifikasi)
6. Redirect ke halaman detail ibu

**Output**: Data ibu masuk ke database, menunggu verifikasi dari puskesmas.

---

### 2️⃣ Registrasi Anak

**Actor**: Kader Posyandu

**Alur**:
1. Dari halaman detail ibu, klik "Tambah Anak"
   - **ATAU** dari menu "Anak" → "Registrasi Anak"
2. Mengisi form:
   - Pilih Ibu (dropdown)
   - NIK anak (opsional)
   - Nama anak
   - Tanggal lahir
   - Jenis kelamin (L/P)
   - Berat badan lahir (kg)
   - Panjang badan lahir (cm)
3. Data tersimpan
4. Redirect ke halaman detail anak

**Output**: Data anak terdaftar dan siap untuk monitoring.

---

### 3️⃣ Input Pengukuran Tumbuh Kembang

**Actor**: Kader Posyandu

**Alur**:
1. Dari halaman detail anak, klik "Input Pengukuran"
   - **ATAU** dari list anak, klik tombol "Ukur"
2. Sistem menampilkan:
   - Info anak (nama, usia, data ibu)
   - Pengukuran terakhir (jika ada)
3. Mengisi form pengukuran:
   - Tanggal pengukuran
   - **Berat Badan (kg)** - wajib
   - **Tinggi Badan (cm)** - wajib
   - **Lingkar Lengan (cm)** - opsional
4. Sistem otomatis menghitung **Status Gizi**:
   - `normal` - pertumbuhan sesuai
   - `stunted` - tinggi badan kurang (TB/U rendah)
   - `wasted` - berat badan kurang (BB/U rendah)
   - `overweight` - berat badan berlebih
5. Data tersimpan dengan:
   - `created_by` = user yang login
   - `posyandu_id` = posyandu user
   - `verified_at = NULL` (belum diverifikasi)
6. Redirect ke halaman detail anak

**Output**: Data pengukuran masuk antrian verifikasi di puskesmas.

---

### 4️⃣ Input Imunisasi

**Actor**: Kader Posyandu

**Alur**:
1. Dari halaman detail anak, klik "Input Imunisasi"
2. Sistem menampilkan:
   - Info anak
   - Riwayat imunisasi yang sudah diterima
3. Mengisi form imunisasi:
   - Pilih jenis vaksin (dropdown):
     - HB0 (Hepatitis B-0)
     - BCG
     - DPT-HB-Hib 1, 2, 3
     - Polio 1, 2, 3, 4
     - IPV
     - Campak/MR
   - Dosis (opsional)
   - Tanggal pemberian
   - Keterangan
4. Data tersimpan dengan status `verified_at = NULL`
5. Redirect ke halaman detail anak

**Output**: Data imunisasi masuk antrian verifikasi.

---

### 5️⃣ Verifikasi Data di Puskesmas

**Actor**: Bidan/Dokter/Admin

**Alur**:
1. Login ke sistem
2. Dashboard menampilkan jumlah data pending verifikasi
3. Masuk ke menu "Verifikasi"
4. Sistem menampilkan antrian gabungan:
   - Data pengukuran (tumbuh_records)
   - Data imunisasi (imunisasi_records)
   - Yang belum diverifikasi (`verified_at IS NULL`)
5. Review setiap data:
   - Lihat detail: nama anak, nama ibu, posyandu
   - Lihat ringkasan: BB/TB untuk pengukuran, vaksin untuk imunisasi
   - Lihat siapa yang input (created_by)
6. **Pilihan Aksi**:
   
   **A. APPROVE**:
   - Klik tombol "✓ Approve"
   - Sistem set:
     - `verified_by` = user yang login
     - `verified_at` = timestamp sekarang
   - Data dianggap valid
   
   **B. REJECT**:
   - Klik tombol "✗ Reject"
   - Muncul modal untuk input alasan
   - Sistem set:
     - `verified_by` = user yang login
     - `verified_at` = timestamp sekarang
     - `reject_reason` = alasan penolakan
   - Data ditandai sebagai tidak valid

**Output**: Data terverifikasi dan masuk ke laporan/dashboard.

---

### 6️⃣ Monitoring Dashboard

**Actor**: Semua user (dengan filter sesuai role)

**Dashboard menampilkan**:

1. **Kartu Statistik**:
   - Total Ibu terdaftar
   - Total Anak terdaftar
   - Pengukuran bulan ini
   - Imunisasi bulan ini
   - (Khusus bidan/dokter) Pending verifikasi

2. **Alert Ibu Risiko Tinggi**:
   - List ibu hamil dengan skor risiko > 5
   - Menampilkan: nama, usia kehamilan, skor risiko, posyandu

3. **Alert Anak Status Gizi Non-Normal**:
   - List anak dengan status: stunted, wasted, overweight
   - Menampilkan: nama anak, nama ibu, tanggal ukur, status

4. **Quick Actions**:
   - Tombol cepat untuk registrasi ibu/anak
   - Link ke list data

**Filter Data**:
- **Kader**: Hanya lihat data dari posyandu sendiri
- **Bidan/Dokter/Admin**: Lihat semua data

---

## 📊 Flow Diagram

```
┌─────────────┐
│   KADER     │
│  POSYANDU   │
└──────┬──────┘
       │
       ├─→ Registrasi Ibu ────┐
       │                       │
       ├─→ Registrasi Anak ───┤
       │                       │
       ├─→ Input Pengukuran ──┤
       │                       │
       └─→ Input Imunisasi ───┤
                               │
                        [Database]
                         (Unverified)
                               │
                               ↓
                    ┌──────────────────┐
                    │ ANTRIAN VERIFIKASI│
                    └─────────┬─────────┘
                              │
                    ┌─────────┴─────────┐
                    │  BIDAN / DOKTER   │
                    └─────────┬─────────┘
                              │
                    ┌─────────┴─────────┐
                    │                   │
              [APPROVE]            [REJECT]
                    │                   │
                    └─────────┬─────────┘
                              │
                        [Database]
                        (Verified)
                              │
                              ↓
                    ┌──────────────────┐
                    │    DASHBOARD     │
                    │    & LAPORAN     │
                    └──────────────────┘
```

---

## 🎯 Use Cases Detail

### UC-01: Monitoring Ibu Hamil Risiko Tinggi

**Tujuan**: Mengidentifikasi dan memonitor ibu hamil dengan risiko tinggi

**Langkah**:
1. Kader input data ibu dengan HPHT
2. Sistem hitung skor risiko otomatis
3. Jika skor > 5, muncul di dashboard sebagai "Ibu Risiko Tinggi"
4. Bidan dapat:
   - Monitor perkembangan kehamilan
   - Buat rujukan ke rumah sakit (future feature)
   - Berikan konseling khusus

**Kriteria Risiko** (dapat dikembangkan):
- Usia < 18 atau > 35 tahun: +3 poin
- Riwayat komplikasi: +5 poin (future)
- Jarak kelahiran < 2 tahun: +3 poin (future)

---

### UC-02: Deteksi Dini Stunting

**Tujuan**: Mendeteksi anak dengan risiko stunting sedini mungkin

**Langkah**:
1. Kader rutin input pengukuran (idealnya setiap bulan)
2. Sistem bandingkan dengan standar WHO (simplified untuk MVP)
3. Jika TB < 85% standar → status = `stunted`
4. Alert muncul di dashboard
5. Bidan/dokter:
   - Review data historis
   - Beri rekomendasi nutrisi
   - Jadwalkan follow-up
   - (Future) Rujukan ke ahli gizi

**Indikator**:
- Status `stunted` = tinggi badan kurang untuk usia
- Perlu intervensi nutrisi segera

---

### UC-03: Tracking Kelengkapan Imunisasi

**Tujuan**: Memastikan semua anak mendapat imunisasi lengkap

**Langkah**:
1. Kader input setiap imunisasi yang diberikan
2. Sistem tracking imunisasi yang sudah diterima
3. (Future) Sistem hitung jadwal imunisasi berikutnya
4. (Future) Alert jika jadwal lewat (overdue)
5. Laporan cakupan imunisasi per posyandu

**Jadwal Standar** (referensi):
- HB0: 0-7 hari
- BCG, Polio 1: 1 bulan
- DPT-HB-Hib 1, Polio 2: 2 bulan
- DPT-HB-Hib 2, Polio 3: 3 bulan
- DPT-HB-Hib 3, Polio 4, IPV: 4 bulan
- Campak/MR: 9 bulan

---

## 🔒 Keamanan & Privacy

### Data Privacy
- NIK di-mask (tampil: ************1234)
- Hanya user authorized yang bisa akses data
- Audit trail lengkap (siapa input, kapan, siapa verifikasi)

### Access Control
- **Kader**: CRUD data posyandu sendiri
- **Bidan/Dokter**: Read all + Verifikasi
- **Admin**: Full access

### Data Integrity
- Validasi input ketat di level Form Request
- Foreign key constraints di database
- Cascade delete untuk data terkait

---

## 📈 Metrik & KPI

### Indikator Kinerja Posyandu:
1. **Cakupan K1** = (Ibu hamil dengan kunjungan pertama / Total ibu hamil) × 100%
2. **Cakupan K4** = (Ibu hamil dengan min 4 kunjungan / Total ibu hamil) × 100%
3. **Cakupan Imunisasi Dasar Lengkap** = (Anak dengan IDL / Total anak) × 100%
4. **Prevalensi Stunting** = (Anak stunted / Total anak) × 100%

### Target (sesuai standar nasional):
- K1: ≥ 95%
- K4: ≥ 85%
- IDL: ≥ 90%
- Stunting: < 20%

---

## 🚀 Roadmap Pengembangan

### Phase 1 (MVP) ✅
- [x] CRUD Ibu, Anak, Tumbuh, Imunisasi
- [x] Dashboard & Statistik
- [x] Verifikasi data
- [x] RBAC

### Phase 2 (Enhancement)
- [ ] Z-score WHO untuk status gizi akurat
- [ ] Export PDF/Excel
- [ ] Growth chart visualization
- [ ] Modul rujukan dengan tracking

### Phase 3 (Advanced)
- [ ] Notifikasi SMS/Email
- [ ] Mobile app
- [ ] API untuk integrasi
- [ ] Predictive analytics dengan ML

---

**Catatan**: Dokumentasi ini akan terus di-update seiring pengembangan sistem.
