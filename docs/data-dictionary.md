# Data Dictionary
## 1. Penyewa
| Kolom       | Tipe Data     | Constraint              | Keterangan            |
| ----------- | ------------- | ----------------------  | --------------------- |
| id_penyewa  | BIGINT           | PK, AUTO_INCREMENT      | ID unik penyewa   |
| nama_lengkap    | VARCHAR(100)  | NOT NULL                | display name penyewa        |
| email       | VARCHAR(100)  | UNIQUE, NOT NUL         | Email login    |
| no_hp    | VARCHAR(20) | UNIQUE, NOT NULL              | Nomor HP  |
| password_hash  | VARCHAR(255)     | NOT NULL | Password (hashed)    |
| alamat | TEXT | NULL  | Alamat |
| created_at | DATETIME | NOT NULL  | Waktu dibuat |
| updated_at | DATETIME | NULL  | Waktu update |



## 2. Mitra
| Kolom       | Tipe Data     | Constraint              | Keterangan                       |
| ----------- | ------------- | ----------------------- | -------------------------------- |
| id_mitra          | BIGINT           | PK, AUTO INCREMENT    | ID mitra  |
| nama_mitra    | VARCHAR(100)  | NOT NULL                | Nama mitra     |
| email       | VARCHAR(100)  | UNIQUE, NOT NULL        | Email |
| no_hp    | VARCHAR(20) | UNIQUE, NOT NULL               | Nomor HP           |
|password_hash| VARCHAR(255)     | NOT NULL | Password            |
| alamat | TEXT | NULL | Alamat |
| created_at | DATETIME | NOT NULL | Waktu dibuat |
| updated_at | DATETIME | NULL | Waktu update |

## 3. Admin
| Kolom       | Tipe Data     | Constraint              | Keterangan                       |
| ----------- | ------------- | ----------------------- | -------------------------------- |
| id_admin | BIGINT | PK, AUTO INCREMENT | ID admin |
| nama_admin | VARCHAR(100) | NOT NULL | Nama admin |
| email | VARCHAR(100) | UNIQUE, NOT NULL | Email |
| password_hash | VARCHAR(255) | NOT NULL | Password |
| created_at | DATETIME | NOT NULL | Waktu dibuat |
| updated_at | DATETIME | NULL | Waktu update |

## 4. Kategori Properti
| Kolom       | Tipe Data     | Constraint              | Keterangan                       |
| ----------- | ------------- | ----------------------- | -------------------------------- |
| id_kategori | BIGINT | PK, AUTO INCREMENT | ID kategori |
| nama_kategori | VARCHAR(50) | UNIQUE, NOT NULL | Nama kategori |
| deskripsi | TEXT | NULL | Deskripsi |

## 5. Lokasi
| Kolom | Tipe Data | Constraint | Keterangan |
|------|----------|-----------|------------|
| id_lokasi | BIGINT | PK, AUTO INCREMENT | ID lokasi |
| nama_lokasi | VARCHAR(100) | NOT NULL | Nama lokasi |
| alamat_detail | TEXT | NOT NULL | Alamat |
| kota | VARCHAR(100) | NOT NULL | Kota |
| provinsi | VARCHAR(100) | NOT NULL | Provinsi |
| kode_pos | VARCHAR(10) | NULL | Kode pos |

## 6. Pengajuan Properti
| Kolom | Tipe Data | Constraint | Keterangan |
|------|----------|-----------|------------|
| id_pengajuan | BIGINT | PK, AUTO INCREMENT | ID pengajuan |
| id_mitra | BIGINT | FK, NOT NULL | Mitra |
| id_admin | BIGINT | FK, NULL | Admin verifikasi |
| id_kategori | BIGINT | FK, NOT NULL | Kategori |
| id_lokasi | BIGINT | FK, NOT NULL | Lokasi |
| nama_pengajuan | VARCHAR(150) | NOT NULL | Nama properti |
| deskripsi | TEXT | NOT NULL | Deskripsi |
| harga_per_hari | DECIMAL(12,2) | NOT NULL | Harga |
| status_pengajuan | VARCHAR(20) | NOT NULL | Status |
| catatan_admin | TEXT | NULL | Catatan |
| tanggal_pengajuan | DATETIME | NOT NULL | Waktu |
| tanggal_verifikasi | DATETIME | NULL | Waktu verifikasi |

## 7. Properti
| Kolom | Tipe Data | Constraint | Keterangan |
|------|----------|-----------|------------|
| id_properti | BIGINT | PK, AUTO INCREMENT | ID properti |
| id_mitra | BIGINT | FK, NOT NULL | Pemilik |
| id_pengajuan | BIGINT | FK, UNIQUE, NOT NULL | Dari pengajuan |
| id_kategori | BIGINT | FK, NOT NULL | Kategori |
| id_lokasi | BIGINT | FK, NOT NULL | Lokasi |
| nama_properti | VARCHAR(150) | NOT NULL | Nama |
| deskripsi | TEXT | NOT NULL | Deskripsi |
| harga_per_hari | DECIMAL(12,2) | NOT NULL | Harga |
| fasilitas | TEXT | NOT NULL | Daftar fasilitas |
| status_listing | VARCHAR(20) | NOT NULL | aktif/nonaktif |
| created_at | DATETIME | NOT NULL | Waktu dibuat |
| updated_at | DATETIME | NULL | Waktu update |

## 8. Foto Properti
| Kolom | Tipe Data | Constraint | Keterangan |
|------|----------|-----------|------------|
| id_foto | BIGINT | PK, AUTO INCREMENT | ID foto |
| id_properti | BIGINT | FK, NOT NULL | Properti |
| url_foto | VARCHAR(255) | NOT NULL | URL |
| urutan | INT | NOT NULL | Urutan |
| is_cover | BOOLEAN | NOT NULL | Cover |
| created_at | DATETIME | NOT NULL | Waktu |

## 9. Jadwal Ketersediaan
| Kolom | Tipe Data | Constraint | Keterangan |
|------|----------|-----------|------------|
| id_jadwal | BIGINT | PK, AUTO INCREMENT | ID |
| id_properti | BIGINT | FK, NOT NULL | Properti |
| tanggal | DATE | NOT NULL | Tanggal |
| status_ketersediaan | VARCHAR(20) | NOT NULL | Status |
| id_booking | BIGINT | FK, NULL | Booking |
| keterangan | TEXT | NULL | Catatan |

## 10. Booking
| Kolom | Tipe Data | Constraint | Keterangan |
|------|----------|-----------|------------|
| id_booking | BIGINT | PK, AUTO INCREMENT | ID |
| kode_booking | VARCHAR(30) | UNIQUE, NOT NULL | Kode |
| id_penyewa | BIGINT | FK, NOT NULL | Penyewa |
| id_properti | BIGINT | FK, NOT NULL | Properti |
| tanggal_mulai | DATE | NOT NULL | Mulai |
| tanggal_selesai | DATE | NOT NULL | Selesai |
| total_harga | DECIMAL(12,2) | NOT NULL | Total |
| status_booking | VARCHAR(20) | NOT NULL | Status |
| catatan | TEXT | NULL | Catatan |
| created_at | DATETIME | NOT NULL | Waktu |
| updated_at | DATETIME | NULL | Update |

