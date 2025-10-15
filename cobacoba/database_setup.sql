-- Quick Setup Database untuk SIP Ibu & Anak
-- Gunakan ini jika tidak ingin pakai Laravel migration

-- ============================================
-- 1. CREATE DATABASE
-- ============================================
CREATE DATABASE IF NOT EXISTS sipanak CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sipanak;

-- ============================================
-- 2. CREATE TABLES
-- ============================================

-- Table: posyandus
CREATE TABLE IF NOT EXISTS posyandus (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    desa VARCHAR(255) NULL,
    puskesmas VARCHAR(255) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_nama (nama)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: users
CREATE TABLE IF NOT EXISTS users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('kader', 'bidan', 'dokter', 'admin') NOT NULL DEFAULT 'kader',
    posyandu_id BIGINT UNSIGNED NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (posyandu_id) REFERENCES posyandus(id) ON DELETE SET NULL,
    INDEX idx_email (email),
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: ibus
CREATE TABLE IF NOT EXISTS ibus (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nik VARCHAR(16) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    tgl_lahir DATE NOT NULL,
    hp VARCHAR(20) NULL,
    alamat TEXT NULL,
    posyandu_id BIGINT UNSIGNED NOT NULL,
    hpht DATE NULL COMMENT 'Hari Pertama Haid Terakhir',
    tp DATE NULL COMMENT 'Taksiran Persalinan',
    risk_score SMALLINT UNSIGNED NULL,
    created_by BIGINT UNSIGNED NOT NULL,
    verified_at TIMESTAMP NULL,
    verified_by BIGINT UNSIGNED NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (posyandu_id) REFERENCES posyandus(id) ON DELETE RESTRICT,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE RESTRICT,
    FOREIGN KEY (verified_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_nik (nik),
    INDEX idx_nama (nama),
    INDEX idx_posyandu (posyandu_id),
    INDEX idx_verified (verified_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: anaks
CREATE TABLE IF NOT EXISTS anaks (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ibu_id BIGINT UNSIGNED NOT NULL,
    nik VARCHAR(16) NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    tgl_lahir DATE NOT NULL,
    jk ENUM('L', 'P') NOT NULL,
    bb_lahir DECIMAL(5,2) NULL COMMENT 'Berat badan lahir (kg)',
    tb_lahir DECIMAL(5,2) NULL COMMENT 'Tinggi badan lahir (cm)',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (ibu_id) REFERENCES ibus(id) ON DELETE CASCADE,
    INDEX idx_ibu (ibu_id),
    INDEX idx_nama (nama)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: tumbuh_records
CREATE TABLE IF NOT EXISTS tumbuh_records (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    anak_id BIGINT UNSIGNED NOT NULL,
    measured_at DATE NOT NULL,
    bb_kg DECIMAL(5,2) NOT NULL COMMENT 'Berat badan (kg)',
    tb_cm DECIMAL(5,2) NOT NULL COMMENT 'Tinggi badan (cm)',
    ll_cm DECIMAL(5,2) NULL COMMENT 'Lingkar lengan (cm)',
    status_gizi ENUM('stunted', 'wasted', 'normal', 'overweight') NULL,
    posyandu_id BIGINT UNSIGNED NOT NULL,
    created_by BIGINT UNSIGNED NOT NULL,
    verified_by BIGINT UNSIGNED NULL,
    verified_at TIMESTAMP NULL,
    reject_reason TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (anak_id) REFERENCES anaks(id) ON DELETE CASCADE,
    FOREIGN KEY (posyandu_id) REFERENCES posyandus(id) ON DELETE RESTRICT,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE RESTRICT,
    FOREIGN KEY (verified_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_anak (anak_id),
    INDEX idx_measured (measured_at),
    INDEX idx_verified (verified_at),
    INDEX idx_status (status_gizi)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: imunisasi_records
CREATE TABLE IF NOT EXISTS imunisasi_records (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    anak_id BIGINT UNSIGNED NOT NULL,
    vaksin_code VARCHAR(50) NOT NULL COMMENT 'Kode vaksin: BCG, DPT1, etc',
    dosis VARCHAR(20) NULL COMMENT 'Dosis ke-',
    given_at DATE NOT NULL,
    keterangan TEXT NULL,
    posyandu_id BIGINT UNSIGNED NOT NULL,
    created_by BIGINT UNSIGNED NOT NULL,
    verified_by BIGINT UNSIGNED NULL,
    verified_at TIMESTAMP NULL,
    reject_reason TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (anak_id) REFERENCES anaks(id) ON DELETE CASCADE,
    FOREIGN KEY (posyandu_id) REFERENCES posyandus(id) ON DELETE RESTRICT,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE RESTRICT,
    FOREIGN KEY (verified_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_anak (anak_id),
    INDEX idx_given (given_at),
    INDEX idx_verified (verified_at),
    INDEX idx_vaksin (vaksin_code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 3. INSERT SAMPLE DATA
-- ============================================

-- Insert Posyandus
INSERT INTO posyandus (nama, desa, puskesmas, created_at, updated_at) VALUES
('Posyandu Melati 1', 'Desa Sukamaju', 'Puskesmas Kecamatan A', NOW(), NOW()),
('Posyandu Melati 2', 'Desa Sukamaju', 'Puskesmas Kecamatan A', NOW(), NOW()),
('Posyandu Mawar', 'Desa Makmur', 'Puskesmas Kecamatan A', NOW(), NOW()),
('Posyandu Anggrek', 'Desa Sejahtera', 'Puskesmas Kecamatan B', NOW(), NOW()),
('Posyandu Dahlia', 'Desa Bahagia', 'Puskesmas Kecamatan B', NOW(), NOW());

-- Insert Users (password: 'password' hashed dengan bcrypt)
-- Note: Password hash di bawah adalah hasil dari bcrypt('password')
INSERT INTO users (name, email, email_verified_at, password, role, posyandu_id, created_at, updated_at) VALUES
('Admin Sistem', 'admin@sipanak.id', NOW(), '$2y$12$LQv3c1yycX6WBkb.Ckp2AeJ4UxqCyBANTRvfAMJ9WiNxFxdVQx5v2', 'admin', NULL, NOW(), NOW()),
('dr. Siti Nurhaliza', 'dokter@sipanak.id', NOW(), '$2y$12$LQv3c1yycX6WBkb.Ckp2AeJ4UxqCyBANTRvfAMJ9WiNxFxdVQx5v2', 'dokter', NULL, NOW(), NOW()),
('Bidan Ani', 'bidan@sipanak.id', NOW(), '$2y$12$LQv3c1yycX6WBkb.Ckp2AeJ4UxqCyBANTRvfAMJ9WiNxFxdVQx5v2', 'bidan', NULL, NOW(), NOW()),
('Kader Melati 1', 'kader1@sipanak.id', NOW(), '$2y$12$LQv3c1yycX6WBkb.Ckp2AeJ4UxqCyBANTRvfAMJ9WiNxFxdVQx5v2', 'kader', 1, NOW(), NOW()),
('Kader Mawar', 'kader2@sipanak.id', NOW(), '$2y$12$LQv3c1yycX6WBkb.Ckp2AeJ4UxqCyBANTRvfAMJ9WiNxFxdVQx5v2', 'kader', 3, NOW(), NOW());

-- ============================================
-- 4. VIEWS (Optional - untuk reporting)
-- ============================================

-- View: Statistik per Posyandu
CREATE OR REPLACE VIEW v_stats_posyandu AS
SELECT 
    p.id,
    p.nama AS posyandu_nama,
    p.desa,
    COUNT(DISTINCT i.id) AS total_ibu,
    COUNT(DISTINCT a.id) AS total_anak,
    COUNT(DISTINCT CASE WHEN i.hpht IS NOT NULL THEN i.id END) AS ibu_hamil,
    COUNT(DISTINCT CASE WHEN i.risk_score > 5 THEN i.id END) AS ibu_risiko_tinggi,
    COUNT(DISTINCT tr.id) AS total_pengukuran,
    COUNT(DISTINCT ir.id) AS total_imunisasi,
    COUNT(DISTINCT CASE WHEN tr.verified_at IS NULL THEN tr.id END) AS pending_verifikasi_tumbuh,
    COUNT(DISTINCT CASE WHEN ir.verified_at IS NULL THEN ir.id END) AS pending_verifikasi_imun
FROM posyandus p
LEFT JOIN ibus i ON p.id = i.posyandu_id
LEFT JOIN anaks a ON i.id = a.ibu_id
LEFT JOIN tumbuh_records tr ON p.id = tr.posyandu_id
LEFT JOIN imunisasi_records ir ON p.id = ir.posyandu_id
GROUP BY p.id, p.nama, p.desa;

-- View: Anak dengan Status Gizi Bermasalah
CREATE OR REPLACE VIEW v_anak_gizi_bermasalah AS
SELECT 
    a.id AS anak_id,
    a.nama AS anak_nama,
    a.tgl_lahir AS anak_tgl_lahir,
    TIMESTAMPDIFF(MONTH, a.tgl_lahir, CURDATE()) AS usia_bulan,
    i.nama AS ibu_nama,
    p.nama AS posyandu_nama,
    tr.measured_at,
    tr.bb_kg,
    tr.tb_cm,
    tr.ll_cm,
    tr.status_gizi,
    tr.verified_at
FROM anaks a
INNER JOIN ibus i ON a.ibu_id = i.id
INNER JOIN posyandus p ON i.posyandu_id = p.id
INNER JOIN tumbuh_records tr ON a.id = tr.anak_id
WHERE tr.status_gizi IN ('stunted', 'wasted', 'overweight')
  AND tr.verified_at IS NOT NULL
ORDER BY tr.measured_at DESC;

-- ============================================
-- 5. GRANTS (Optional - jika pakai user DB khusus)
-- ============================================

-- CREATE USER 'sipanak_user'@'localhost' IDENTIFIED BY 'SipAnakPass2025!';
-- GRANT ALL PRIVILEGES ON sipanak.* TO 'sipanak_user'@'localhost';
-- FLUSH PRIVILEGES;

-- ============================================
-- DONE! Database siap digunakan
-- ============================================

-- Untuk verifikasi:
SELECT 'Database sipanak berhasil dibuat!' AS status;
SELECT COUNT(*) AS jumlah_posyandu FROM posyandus;
SELECT COUNT(*) AS jumlah_users FROM users;
