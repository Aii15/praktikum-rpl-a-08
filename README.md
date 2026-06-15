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

Screenshot MVP:
<img width="1897" height="967" alt="Image" src="https://github.com/user-attachments/assets/a751cc8f-f436-4e91-8e70-3c052998b901" />

<img width="1897" height="971" alt="Image" src="https://github.com/user-attachments/assets/de31eeb3-4882-4007-8ee6-f3094efdcbe1" />

<img width="1919" height="970" alt="Image" src="https://github.com/user-attachments/assets/5913494d-e48e-4a56-94b1-f37134217e28" />

<img width="1919" height="972" alt="Image" src="https://github.com/user-attachments/assets/2c737bba-ba97-4214-8496-e36365c45e5b" />

<img width="1919" height="971" alt="Image" src="https://github.com/user-attachments/assets/f9b07eaf-6d01-4b10-9214-4537aba4ab0c" />

<img width="1900" height="969" alt="Image" src="https://github.com/user-attachments/assets/b6906b2d-217f-44d2-8ab8-cb6b0c5a392a" />

<img width="1900" height="968" alt="Image" src="https://github.com/user-attachments/assets/eb922a42-851c-4d87-bb2f-7d42ec5dbcf4" />

<img width="1899" height="970" alt="Image" src="https://github.com/user-attachments/assets/9cc11598-371b-41ad-b89f-aecb125efefb" />

<img width="1900" height="972" alt="Image" src="https://github.com/user-attachments/assets/3d909ca6-24ae-4ac1-95b0-7192046b0685" />

<img width="1899" height="971" alt="Image" src="https://github.com/user-attachments/assets/f160da81-c360-4e96-9370-cc2043741051" />

<img width="1898" height="971" alt="Image" src="https://github.com/user-attachments/assets/10f84855-d511-4229-8c36-02c7573eb2eb" />

<img width="1919" height="971" alt="Image" src="https://github.com/user-attachments/assets/6a055743-a564-42e1-a3ee-eea99d8590c4" />
