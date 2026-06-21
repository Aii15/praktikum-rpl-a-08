# Laporan Pengujian Sistem (Test Cases) - SpotRent

Dokumen ini memuat daftar skenario pengujian (_test cases_) untuk platform **SpotRent** (Platform Penyewaan Lokasi untuk Kebutuhan Syuting Komersial). Skenario ini disusun berdasarkan kriteria penerimaan (_Acceptance Criteria_) dari _User Stories_ yang tercantum pada [backlog.md](file:///d:/SpotRent%20Repository/praktikum-rpl-a-08/docs/backlog.md) dan [user-stories.md](file:///d:/SpotRent%20Repository/praktikum-rpl-a-08/docs/user-stories.md).

Pengujian ini mencakup skenario **Happy Path** (alur normal) dan **Unhappy Path** (penanganan error & input tidak valid) pada fitur-fitur utama sistem. Seluruh pengujian telah dieksekusi secara manual dan dikonfirmasi berjalan dengan sukses tanpa adanya kendala (_bug_).

---

## Ringkasan Pengujian

| Fitur Inti                        | Jumlah Test Case | Happy Path | Unhappy Path |  Status Akhir  |
| :-------------------------------- | :--------------: | :---------: | :----------: | :------------: |
| 1. Registrasi dan Login           |        3        |      1      |      2      | **Pass** |
| 2. Pencarian (Filter)             |        2        |      1      |      1      | **Pass** |
| 3. Booking & Pembayaran           |        3        |      1      |      2      | **Pass** |
| 4. Mitra Menambahkan Properti     |        2        |      1      |      1      | **Pass** |
| 5. Admin Mengelola Properti Mitra |        2        |      1      |      1      | **Pass** |
| **Total**                   |   **12**   | **5** | **7** | **Pass** |

---

## Skenario Uji Berdasarkan Fitur

### 1. Fitur Registrasi dan Login

Fitur ini memungkinkan pengguna mendaftarkan akun baru atau masuk ke sistem dengan peran masing-masing (Penyewa, Mitra, atau Admin).

| TC-ID            | Judul                                                        | Precondition                               | Steps                                                                                                             | Expected Result                                                                                                                 | Actual Result                                                                                                     | Status         |
| :--------------- | :----------------------------------------------------------- | :----------------------------------------- | :---------------------------------------------------------------------------------------------------------------- | :------------------------------------------------------------------------------------------------------------------------------ | :---------------------------------------------------------------------------------------------------------------- | :------------- |
| **TC-001** | Login valid pengguna (Happy Path)                            | Halaman login terbuka (`/login`)         | 1. Isi email terdaftar.`<br>`2. Isi password yang valid.`<br>`3. Klik tombol "Login".                         | Berhasil login dan diarahkan ke dashboard sesuai*active role* yang dimiliki pengguna.                                         | Sistem berhasil melakukan autentikasi dan mengarahkan pengguna ke halaman profil/dashboard.                       | **Pass** |
| **TC-002** | Login gagal karena kata sandi salah (Unhappy Path)           | Halaman login terbuka (`/login`)         | 1. Isi email terdaftar.`<br>`2. Isi password yang salah.`<br>`3. Klik tombol "Login".                         | Tampil pesan validasi/error "Email atau nomor HP tidak valid, atau password salah." dan pengguna tetap berada di halaman login. | Muncul pesan error "Email atau nomor HP tidak valid, atau password salah." dan tetap di halaman login.            | **Pass** |
| **TC-003** | Registrasi gagal karena email sudah terdaftar (Unhappy Path) | Halaman registrasi terbuka (`/register`) | 1. Isi nama, email yang sudah terdaftar di sistem, nomor handphone, dan password.`<br>`2. Klik tombol "Daftar". | Sistem menolak pendaftaran dan memunculkan pesan error bahwa email sudah pernah digunakan.                                      | Pendaftaran ditolak dengan pesan validasi "Email sudah terdaftar. Silakan login menggunakan akun yang sudah ada." | **Pass** |

---

### 2. Fitur Pencarian (Filter)

Fitur ini memungkinkan pengguna (Penyewa) mencari properti untuk syuting dengan filter kategori, lokasi, dan rentang harga.

| TC-ID            | Judul                                                          | Precondition                    | Steps                                                                                                                                                          | Expected Result                                                                                                 | Actual Result                                                                                                    | Status         |
| :--------------- | :------------------------------------------------------------- | :------------------------------ | :------------------------------------------------------------------------------------------------------------------------------------------------------------- | :-------------------------------------------------------------------------------------------------------------- | :--------------------------------------------------------------------------------------------------------------- | :------------- |
| **TC-004** | Pencarian lokasi dengan filter valid (Happy Path)              | Halaman utama/pencarian terbuka | 1. Pilih filter kategori (misal: "Heritage").`<br>`2. Pilih filter lokasi (misal: "Semarang").`<br>`3. Pilih filter harga.`<br>`4. Klik tombol "Cari".   | Sistem memproses kueri dan menampilkan daftar lokasi syuting yang sesuai dengan kombinasi filter tersebut.      | Sistem menampilkan daftar properti berkategori "Heritage" di lokasi "Semarang" dalam rentang harga yang sesuai. | **Pass** |
| **TC-005** | Pencarian dengan filter tidak menghasilkan data (Unhappy Path) | Halaman utama/pencarian terbuka | 1. Masukkan filter dengan kombinasi kriteria yang tidak ada di database (misal: Lokasi "All" dengan tipe properti "Industrial").`<br>`2. Klik tombol "Cari". | Sistem menampilkan halaman pencarian kosong disertai pesan bahwa Tidak ada properti yang sesuai dengan filter.. | Sistem menampilkan halaman tanpa properti dengan pesan "Tidak ada lokasi yang cocok dengan filter pencarian."    | **Pass** |

---

### 3. Fitur Booking & Pembayaran  

Fitur ini memfasilitasi pengguna dalam melakukan reservasi jadwal pada properti yang diinginkan dan melakukan pelunasan sewa melalui _payment gateway_.

| TC-ID            | Judul                                                       | Precondition                                                                                          | Steps                                                                                                                                                | Expected Result                                                                                                    | Actual Result                                                                                                                                           | Status         |
| :--------------- | :---------------------------------------------------------- | :---------------------------------------------------------------------------------------------------- | :--------------------------------------------------------------------------------------------------------------------------------------------------- | :----------------------------------------------------------------------------------------------------------------- | :------------------------------------------------------------------------------------------------------------------------------------------------------ | :------------- |
| **TC-006** | Pemesanan dan pembayaran berhasil (Happy Path)              | User (Penyewa) sudah login dan berada di halaman detail properti                                      | 1. Pilih tanggal sewa yang tersedia pada kalender.`<br>`2. Klik tombol "Booking".`<br>`3. Isi formulir pembayaran dan konfirmasi transaksi sewa. | Booking tersimpan di sistem, status pembayaran berubah menjadi "Paid", dan booking masuk ke riwayat sewa.          | Pemesanan sukses diproses, data transaksi masuk ke Database, dan status pembayaran berubah menjadi "Terbayar".                                          | **Pass** |
| **TC-007** | Pemesanan gagal karena tanggal sudah dipesan (Unhappy Path) | User sudah login. Properti telah dibooking oleh user lain pada tanggal tertentu (misal: 25 Juni 2026) | 1. Buka kalender properti.`<br>`2. Pilih tanggal 25 Juni 2026 (yang berlabel tidak tersedia/merah).`<br>`3. Klik tombol "Pesan".                 | Tombol booking untuk tanggal tersebut dinonaktifkan atau sistem mengeluarkan pesan error validasi tanggal bentrok. | Sistem melarang pemilihan tanggal tersebut dan menampilkan pesan validasi bentrok jadwal.                                                               | **Pass** |
| **TC-008** | Pemesanan gagal tanpa memilih tanggal (Unhappy Path)        | User sudah login dan berada di halaman detail properti                                                | 1. Klik tombol "Pesan" langsung tanpa memilih tanggal sewa pada kalender.                                                                            | Sistem menolak pemesanan dan menampilkan pesan peringatan bahwa tanggal sewa wajib dipilih terlebih dahulu.        | Sistem memvalidasi input kosong pada sisi klien dan memunculkan pesan peringatan "Silakan pilih tanggal booking / sewa terlebih dahulu pada kalender.." | **Pass** |

---

### 4. Fitur Mitra Menambahkan Properti

Fitur ini memfasilitasi pengguna yang berperan sebagai Mitra untuk mendaftarkan aset properti baru agar dapat dipromosikan dan disewakan.

| TC-ID            | Judul                                                              | Precondition                                                                                  | Steps                                                                                                                                             | Expected Result                                                                                                       | Actual Result                                                                                                                       | Status         |
| :--------------- | :----------------------------------------------------------------- | :-------------------------------------------------------------------------------------------- | :------------------------------------------------------------------------------------------------------------------------------------------------ | :-------------------------------------------------------------------------------------------------------------------- | :---------------------------------------------------------------------------------------------------------------------------------- | :------------- |
| **TC-009** | Mitra berhasil menambahkan properti baru (Happy Path)              | Mitra sudah login, berada di dashboard mitra pada menu tambah properti (`/tambah-properti`) | 1. Isi nama properti, kategori, deskripsi, alamat, fasilitas, dan harga.`<br>`2. Unggah file gambar properti.`<br>`3. Klik "Ajukan Properti". | Properti baru tersimpan di database dengan status "Pending" (menunggu persetujuan admin) dan mitra diarahkan kembali. | Properti berhasil disimpan ke database, status diset sebagai "Pending", dan mitra diarahkan ke daftar properti saya.                | **Pass** |
| **TC-010** | Mitra gagal menambahkan properti karena data kosong (Unhappy Path) | Mitra sudah login, berada di dashboard mitra pada menu tambah properti (`/tambah-properti`) | 1. Kosongkan isian wajib seperti Nama Properti atau Harga Sewa.`<br>`2. Klik tombol "Lanjut".                                                   | Sistem menolak pengajuan, memunculkan pesan validasi error, dan tidak menyimpan data.                                 | Pengajuan diblokir oleh sistem dengan memunculkan pesan validasi "Mohon lengkapi semua data spesifikasi properti terlebih dahulu.". | **Pass** |

---

### 5. Fitur Admin Mengelola Properti Mitra 

Fitur ini digunakan oleh Admin untuk memverifikasi kelayakan properti yang diajukan oleh Mitra sebelum dipublikasikan di platform.

| TC-ID            | Judul                                                                                 | Precondition                                                                                      | Steps                                                                                                                                                                                 | Expected Result                                                                                                      | Actual Result                                                                                                       | Status         |
| :--------------- | :------------------------------------------------------------------------------------ | :------------------------------------------------------------------------------------------------ | :------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ | :------------------------------------------------------------------------------------------------------------------- | :------------------------------------------------------------------------------------------------------------------ | :------------- |
| **TC-011** | Admin menyetujui pengajuan properti mitra (Happy Path)                                | Admin sudah login, berada di menu pengajuan properti, terdapat data pengajuan berstatus "Pending" | 1. Klik detail pengajuan properti.`<br>`2. Klik tombol "Terima" (Approve).                                                                                                          | Status pengajuan properti berubah menjadi "Disetujui" dan properti langsung muncul di daftar katalog (landing page). | Status diperbarui menjadi "Approved", dan properti secara otomatis terindeks serta tampil pada landing page         | **Pass** |
| **TC-012** | Admin menolak pengajuan properti mitra dengan catatan (Unhappy Path/Alternative Path) | Admin sudah login, berada di menu pengajuan properti, terdapat data pengajuan berstatus "Pending" | 1. Klik detail pengajuan properti.`<br>`2. Klik tombol "Tolak" (Reject).`<br>`3. Isi kolom catatan untuk  alasan penolakan (misal: "Foto kurang jelas").`<br>`4. Klik "Kirim". | Status pengajuan berubah menjadi "Rejected" dan alasan penolakan terkirim ke dashboard status pengajuan milik Mitra. | Status berubah menjadi "Rejected", pesan penolakan disimpan di log sistem, dan tampil pada dashboard mitra terkait. | **Pass** |
