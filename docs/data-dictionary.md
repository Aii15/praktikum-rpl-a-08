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
