# SPOTRENT

Deskripsi Proyek
-
Project kami memiliki nama SpotRent yaitu platform pemesanan properti untuk kebutuhan syuting komersial maupun non komersial seperti music video, film pendek, film, dan lain-lain dengan menghadirkan berbagai macam tipe properti seperti hunian, komersial, lanskap, dan masih ada beberapa tipe properti lainnya yang tersedia di berbagai daerah di Indonesia.

Platform ini secara garis umum memiliki gambaran yang sama seperti platform penyewaan properti seperti perumahan ataupun kost, hanya saja di project ini kita berfokus pada properti di dunia kreatif atau hiburan sehingga memiliki keunikan tersendiri yang membedakannya dengan platform lainnya.

Daftar Anggota Tim Developer
-

| Nama                         | NIM      |  Akun GitHub                                 |
| :--------------------------- | :------- | :------------------------------------- |
| **YUSRAN RIZQI LAKSONO**     | L0124125 | [@YYYusrn](https://github.com/YYYusrn) |
| **JAUHAR MUFID TAMIR**       | L0124131 | [@jauhar7](https://github.com/jauhar7) |
| **MUHAMMAD AKBAR KURNIAWAN** | L0124136 | [@Frezga](https://github.com/Frezga)   |
| **MUHAMMAD AYMAN**           | L0124137 | [@Aii15](https://github.com/Aii15)     |

Fitur Platform SpotRent
-
Platform kami memiliki beragam macam fitur, di antaranya:
- Login dan sign up untuk akun yang sudah terdaftar dan belum terdaftar
- search filter untuk mem-filter berdasarkan lokasi, tipe properti, dan harga
- Detail informasi properti yang menampilkan seluruh detail informasi suatu properti
- Booking dan pembayaran
- Edit profil baik sebagai user ataupun mitra
- Edit booking
- Mitra bisa menambahkan properti

Screenshot Fitur atau MVP
-
- Screenshot fitur atau MVP:

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

Prasyarat
-
Terdapat beberapa prasyarat yang dibutuhkan sebelum menjalankan project ini, di antaranya adalah:
- PHP versi 8.3 atau lebih baru
- Composer versi terbaru (Composer 2.x)
- Node.js versi 20 atau lebih baru
- npm versi 10 atau lebih baru
- Database SQLite (default project), atau bisa ganti ke MySQL lewat konfigurasi .env
- Git (untuk clone repository)


Cara Instalasi
-
Cara instalasi untuk program ini di antaranya:
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

Lakukan semuanya di terminal IDE anda dan lakukan dengan urut

Cara Menjalankan
-
Cara menjalankan program ini:
- Opsi 1
  1. Dari folder src jalankan: composer run dev
  2. Akses aplikasi di browser: http://127.0.0.1:8000
- Opsi 2
  1. Terminal 1: php artisan serve
  2. erminal 2: npm run dev
  3. Akses aplikasi: http://127.0.0.1:8000
 
Struktur Folder Proyek
-
praktikum-rpl-a-08/
- README.md
- docs/
  - backlog.md
  - data-dictionary.md
  - problem-statement.md
  - srs.md
  - team-contract.md
  - test-cases.md
  - user-stories.md
  - UML/
- src/
  - app/
  - bootstrap/
  - config/
  - database/
  - public/
  - resources/
  - routes/
  - storage/
  - tests/
  - composer.json
  - package.json
  - phpunit.xml
- tests/
  - PemesananTest.php
  - PeranUserTest.php
  - PropertiTest.php
  - ValidasiUserTest.php

Lisensi yang digunakan
-
Project ini menggunakan lisensi MIT.

Daftar Anggota Tim
-

| Nama                         | NIM      |  Akun GitHub                                 |
| :--------------------------- | :------- | :------------------------------------- |
| **YUSRAN RIZQI LAKSONO**     | L0124125 | [@YYYusrn](https://github.com/YYYusrn) |
| **JAUHAR MUFID TAMIR**       | L0124131 | [@jauhar7](https://github.com/jauhar7) |
| **MUHAMMAD AKBAR KURNIAWAN** | L0124136 | [@Frezga](https://github.com/Frezga)   |
| **MUHAMMAD AYMAN**           | L0124137 | [@Aii15](https://github.com/Aii15)     |
