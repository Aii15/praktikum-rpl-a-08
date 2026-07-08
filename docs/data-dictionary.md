# Data Dictionary

## 1. Users
| Kolom       | Tipe Data     | Constraint              | Keterangan                       |
| ----------- | ------------- | ----------------------- | -------------------------------- |
| id          | BIGINT        | PK, AUTO_INCREMENT      | ID user (penyewa, mitra, admin)  |
| name        | VARCHAR       | NOT NULL                | Nama user (penyewa, mitra, admin) |
| email       | VARCHAR       | UNIQUE, NOT NULL        | Email login                      |
| email_verified_at | DATETIME | NULL                   | Waktu verifikasi email           |
| password    | VARCHAR	      | NOT NULL                | Password hash                    |
| remember_token | VARCHAR    |  NULL                   | Token remember me                |
| role        | ENUM('admin','mitra','penyewa') | NOT NULL, DEFAULT 'penyewa' | Role utama user |
| no_hp       | VARCHAR(20)   | NULL                    | Nomor telepon                    |
| rekening_bank | VARCHAR     | NULL                    | Rekening bank user mitra         |
| KTP         | VARCHAR       | NULL                    | Nomor KTP user mitra             |
| alamat      | TEXT          | NULL                    | Alamat                           |
| created_at  | DATETIME      |	NOT NULL	              | Waktu dibuat                     |
| updated_at	| DATETIME      |	NOT NULL                |	Waktu diubah                     |

## 2. Roles
| Kolom       | Tipe Data     | Constraint              | Keterangan                       |
| ----------- | ------------- | ----------------------- | -------------------------------- |
| id	        | BIGINT	      | PK, AUTO_INCREMENT	    | ID role                          |
| name	      | VARCHAR	      | UNIQUE, NOT NULL	      | Nama role                        |
| created_at	| DATETIME	    | NOT NULL                |	Waktu dibuat                     |
| updated_at	| DATETIME      |	NOT NULL                |	Waktu diubah                     |

## 3. Role User
| Kolom       | Tipe Data     | Constraint              | Keterangan                       |
| ----------- | ------------- | ----------------------- | -------------------------------- |
| user_id	    | BIGINT	      | PK, FK, NOT NULL	      | Referensi users.id               |
| role_id     |	BIGINT	      | PK, FK, NOT NULL	      | Referensi roles.id               |

## 4. Mitra Profiles
| Kolom       | Tipe Data     | Constraint              | Keterangan                       |
| ----------- | ------------- | ----------------------- | -------------------------------- |
| id          |	BIGINT        |	PK, AUTO_INCREMENT	    | ID profil mitra                  |
| user_id     |	BIGINT        |	FK, UNIQUE, NOT NULL	  | Referensi users.id               |
| nama_mitra  |	VARCHAR(100)  |	NOT NULL                |	Nama mitra                       |
| KTP         |	VARCHAR(50)   |	NOT NULL	              | Nomor KTP mitra                  |
| rekening_bank	| VARCHAR	    | NULL                    |	Rekening bank mitra              |
| created_at  |	DATETIME      |	NOT NULL                |	Waktu dibuat                     |
| updated_at	| DATETIME      |	NOT NULL                |	Waktu diubah                     |

## 5. Kategori Properti
| Kolom       | Tipe Data     | Constraint              | Keterangan                       |
| ----------- | ------------- | ----------------------- | -------------------------------- |
| id_kategori |	BIGINT        |	PK, AUTO_INCREMENT      |	ID kategori                      |
| nama_kategori	| VARCHAR(50) |	NOT NULL                |	Nama kategori                    |

## 6. Lokasi
| Kolom       | Tipe Data     | Constraint              | Keterangan                       |
| ----------- | ------------- | ----------------------- | -------------------------------- |
| id_lokasi   |	BIGINT        |	PK, AUTO_INCREMENT      |	ID lokasi                        |
| nama_lokasi |	VARCHAR(100)  |	NOT NULL                |	Nama lokasi                      |
| alamat_detail |	TEXT        |	NOT NULL                |	Alamat detail                    |
| kota        |	VARCHAR(100)  |	NOT NULL                |	Kota                             |
| provinsi    |	VARCHAR(100)  |	NOT NULL                |	Provinsi                         |
| kode_pos    |	VARCHAR(10)   |	NULL                    |	Kode pos                         |
| created_at  |	DATETIME      |	NOT NULL                |	Waktu dibuat                     |
| updated_at  |	DATETIME      |	NOT NULL                |	Waktu diubah                     |

## 7. Properties
| Kolom       | Tipe Data     | Constraint              | Keterangan                       |
| ----------- | ------------- | ----------------------- | -------------------------------- |
| id_properti | BIGINT        | PK, AUTO INCREMENT      | ID properti                      |
| id_mitra    | BIGINT        | FK, NOT NULL            | Pemilik                          |
| id_kategori | BIGINT        | FK, NOT NULL            | Kategori                         |
| id_lokasi   | BIGINT        | FK, NOT NULL            | Lokasi                           |
| nama_properti | VARCHAR(150) | NOT NULL               | Nama                             |
| deskripsi   | TEXT          | NOT NULL                | Deskripsi                        |
| harga_per_hari | DECIMAL(12,2) | NOT NULL             | Harga                            |
| fasilitas   | TEXT          | NULL                    | Daftar fasilitas                 |
| status_pengajuan | ENUM('pending','approved','rejected') |	NOT NULL, DEFAULT 'pending' |	Status persetujuan |
| catatan     |	TEXT          |	NULL	                  | Catatan admin                    |
| created_at  | DATETIME      | NOT NULL                | Waktu dibuat                     |
| updated_at  | DATETIME      | NULL                    | Waktu update                     |

## 8. Foto Properti
| Kolom       | Tipe Data     | Constraint              | Keterangan                       |
| ----------- | ------------- | ----------------------- | -------------------------------- |
| id_foto     | BIGINT        | PK, AUTO INCREMENT      | ID foto                          |
| id_properti | BIGINT        | FK, NOT NULL            | Referensi properties.id_properti |
| url_foto    | VARCHAR(255)  | NOT NULL                | URL foto                         |
| urutan      | INT           | NOT NULL                | Urutan foto                      |
| is_cover    | BOOLEAN       | NOT NULL                | Foto cover                       |
| object_position	| VARCHAR(20) |	NULL, DEFAULT '50'    |	Posisi fokus gambar              |
| created_at  | DATETIME      | NOT NULL                | Waktu                            |
| updated_at  |	DATETIME      |	NOT NULL                |	Waktu diubah                     |

## 9. Bookings
| Kolom       | Tipe Data     | Constraint              | Keterangan                       |
| ----------- | ------------- | ----------------------- | -------------------------------- |
| id_booking  | BIGINT        | PK, AUTO INCREMENT      | ID                               |
| id_properti	| BIGINT        |	FK, NOT NULL            |	Referensi properti               |
| id_user	    | BIGINT        |	FK, NOT NULL            |	Referensi penyewa/user           |
| tanggal_mulai | DATE        | NOT NULL                | Mulai                            |
| tanggal_selesai | DATE      | NOT NULL                | Selesai                          |
| status_booking | VARCHAR(20) | NOT NULL               | Status                           |
| created_at  | DATETIME     | NOT NULL                 | Waktu                            |
| updated_at  | DATETIME     | NULL                     | Update                           |

## 10. Reviews
| Kolom       | Tipe Data     | Constraint              | Keterangan                       |
| ----------- | ------------- | ----------------------- | -------------------------------- |
| id_review   | BIGINT        | PK, AUTO INCREMENT      | ID                               |
| id_booking  | BIGINT        | FK, UNIQUE, NOT NULL    | Booking                          |
| rating      | TINYINT       | NOT NULL                | Nilai rating                     |
| komentar    | TEXT          | NULL                    | Ulasan                           |  
| tanggal_review | DATETIME   | NOT NULL                | Waktu review dibuat              |
| balasan_mitra |	TEXT        |	NULL                    |	Balasan dari mitra               |
| tanggal_balasan	| DATETIME  |	NULL                    |	Waktu balasan mitra              |
| created_at  | DATETIME      | NOT NULL                | Waktu dibuat                     |
| updated_at	| DATETIME      |	NOT NULL	              | Waktu diubah                     |

## 11. Wishlists
| Kolom       | Tipe Data     | Constraint              | Keterangan                       |
| ----------- | ------------- | ----------------------- | -------------------------------- |
| id_wishlist |	BIGINT        |	PK, AUTO_INCREMENT      |	ID wishlist                      |
| id_user     |	BIGINT        |	FK, NOT NULL            |	Referensi user                   |
| id_properti |	BIGINT        |	FK, NOT NULL            |	Referensi properti               |
| created_at	| DATETIME	    | NOT NULL	              | Waktu dibuat                     |
| updated_at  |	DATETIME      |	NOT NULL                |	Waktu diubah                     |

## Tabel Kardinalitas
| Entitas 1      | Relasi      | Entitas 2      | Kardinalitas      | Penjelasan      |
|--------------- | ----------- | -------------- | ----------------- | --------------- |
| users	         | memiliki    | roles          |	M:N               | Satu user bisa memiliki lebih dari satu role |
| users          |	memiliki   | mitra_profiles |	1:0..1            | Hanya user yang berperan sebagai mitra yang biasanya punya profil mitra tambahan |
| mitra	         | membuat     | properties     |	1:N               | Satu user mitra bisa membuat banyak properti |
| Kategori       | mengelompokkan | Properti    | 1 : N             | Satu kategori banyak properti |
| Lokasi         | memiliki    | Properti       | 1 : N             | Satu lokasi banyak properti |
| Properti       | memiliki    | Foto Properti  | 1 : N             | Banyak foto    |
| Penyewa        | membuat     | Booking        | 1 : N             | Banyak booking |
| Properti       | dipesan     | Booking        | 1 : N             | Banyak booking |
| Booking        | menghasilkan | Review        | 1:0..1            | Opsional       |
| users          | menyimpan   | wishlists      |	1:N               | Satu user bisa menyimpan banyak properti ke wishlist |
| properties     | tersimpan di |	wishlists     |	1:N               | Satu properti bisa muncul di wishlist milik banyak user |     
