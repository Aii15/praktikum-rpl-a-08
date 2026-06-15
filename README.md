### ANGGOTA TIM

| Nama                     | NIM      |
| ------------------------ | -------- |
| YUSRAN RIZQI LAKSONO     | L0124125 |
| JAUHAR MUFID TAMIR       | L0124131 |
| MUHAMMAD AKBAR KURNIAWAN | L0124136 |
| MUHAMMAD AYMAN           | L0124137 |

Fitur yang sudah diimplementasikan:

| P-X | Fitur yang ditambahkan           | Status |
| --- | -------------------------------- | ------ | 
| P-6 | - Autentikasi login dan register | Done   |
| P-7 | - Search filter di landing page  | Done   |
|     | - Detail informasi properti      | Done   |
| P-8 | - Profil ketiga role             | Done   |
|     | - Pembayaran                     | Done   |
|     | - Rating dan review              | Done   |
|     | - Tambah Properti                | Done   |
|     | - Admin manajemen platform       | Done   |
|     | - Booking                        | Done   |
|     | - Melihat Ketersediaan Jadwal    | Done   |
|     | - Admin Mengelola Properti Mitra | Done   |
|     | - Notifikasi                     | Done   |
|     | - Semua fitur yang tersisa       | Done   |


Cara instalasi atau menjalankan programnya, lakukan dengan urut:
| Langkah | Command | Fungsi |
| ------- | ------- | ------ |
| Install Dependency PHP | composer install | Mengunduh dan menginstal seluruh package PHP yang dibutuhkan project berdasarkan file composer.json |
| Install Dependency Frontend | npm install | Mengunduh dan menginstal package frontend (Vite, Tailwind, Bootstrap, dll.) berdasarkan file package.json |
| Buat File Environment | Copy file .env.example dan rename menjadi .env | Wajib dilakukan jika file .env belum ada |
| Generate APP_KEY | php artisan key:generate | Membuat dan mengisi nilai APP_KEY pada file .env yang digunakan Laravel untuk enkripsi dan keamanan aplikasi |
| Jalankan Migrasi Database | php artisan migrate | Membuat tabel-tabel yang dibutuhkan aplikasi sesuai file migration yang ada pada project |
| Reset Database + Seeder | php artisan migrate:fresh –seed | Menghapus seluruh tabel, membuat ulang database, lalu mengisi data awal dari seeder |
| Membuat Storage Link | php artisan storage:link | Membuat akses file upload dari folder storage ke public |
| Jalankan Backend Laravel | php artisan serve | Menyalakan server backend Laravel sehingga aplikasi dapat diakses melalui browser |
