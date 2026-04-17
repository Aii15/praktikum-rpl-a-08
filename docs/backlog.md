# Produk Backlog

Project yang sedang kami kerjakan memiliki nama SpotRent dengan tema "Platform Penyewaan Lokasi untuk Kebutuhan Syuting Komersial" ini adalah sebuah platform di mana tempat berkumpulnya para penyewa properti dan yang menyewakan. <br>

Platform ini secara garis umum memiliki gambaran yang sama seperti platform penyewaan properti seperti perumahan ataupun kost baik yang berbasis web maupun mobile, hanya saja di project ini kita berfokus pada properti di dunia kreatif atau hiburan sehingga memiliki keunikan tersendiri yang membedakannya dengan platform lainnya <br>

Sebelum masuk pada list produk backlog, akan kami jabarkan terlebih dahulu glosarium dari atribut yang terdapat pada list kami <br>
| Nama atribut | Keterangan |
| ------------ | ---------- |
| Fitur | Nama fitur yang akan dikembangkan |
| User Story | User story pada fitur tersebut |
| Kode US | Kode dari User Story |
| Acceptance Criteria | Acceptance Criteria pada fitur tersebut |
| Prioritas | Prioritas di sini dibuat berdasarkan aturan MoSCoW |

Berikut kami sertakan produk backlog dari project tim kami:

| Fitur | Kode US | User Story | Acceptance Criteria | Prioritas |
| ----- | ------- | ---------- | ------------------- | --------- |
| Pencarian Lokasi | US-01 | As a user, I want mencari lokasi berdasarkan kategori, lokasi, dan harga, so that saya dapat menemukan lokasi yang sesuai dengan cepat | Given user berada di halaman pencarian, When user memasukkan filter (lokasi/kategori/harga), Then sistem menampilkan daftar lokasi yang sesuai filter | Must Have |
| Melihat Detail Lokasi | US-02 | As a user, I want melihat informasi detail suatu lokasi, so that saya dapat mengevaluasi apakah lokasi tersebut sesuai dengan kebutuhan pemotretan saya | Given user memilih salah satu lokasi, When user membuka halaman detail, Then sistem menampilkan deskripsi, foto, harga, dan fasilitas lokasi | Must Have |
| Melihat Ketersediaan Jadwal | US-03 | As a user, I want melihat jadwal ketersediaan lokasi, so that saya dapat menghindari konflik pemesanan | Given user membuka halaman detail lokasi, When user melihat kalender ketersediaan, Then sistem menampilkan tanggal yang tersedia dan yang sudah dibooking | Should Have |
| Booking Lokasi | US-04 | As a user, I want memesan lokasi langsung dari platform, so that saya dapat mengamankan lokasi tersebut untuk produksi saya | Given user berada di halaman detail lokasi, When user memilih tanggal dan klik tombol booking, Then sistem menyimpan status booking | Must Have |
| Admin Mengelola Properti Mitra | US-05 | As a admin, I want menerima atau menolak permintaan pengajuan properti oleh mitra, so that saya dapat mengelola permintaan properti tersebut | Given admin menerima atau menolak pengajuan properti, When mitra mengajukan properti, Then properti diverifikasi masuk list atau tidak | Must Have |
| Manajemen Aplikasi | US-06 | As a admin, I want melihat riwayat seluruh aktivitas seperti transaksi dan pengajuan properti, so that saya dapat melihat seluruh aktivitas di aplikasi saya | Given admin melihat seluruh aktivitas, When user dan mitra melakukan aktivitas pada aplikasi, Then sistem menampilkan seluruh log aktivitas | Must Have |
| Pembayaran | US-07 | As a user, I want melakukan pembayaran melalui platform ini, so that saya dapat menyelesaikan pemesanan dengan mudah dan aman | Given setelah booking, When user melakukan pembayaran, Then sistem mengonfirmasi pembayaran dan mengubah status menjadi paid | Must Have |
| Notifikasi | US-08 | As a mitra atau user, I want menerima notifikasi untuk pembaruan pemesanan, so that saya tetap mendapat informasi tentang status pemesanan | Given terjadi perubahan status booking, When status diperbarui seperti dibatalkan atau kondisi lainnya, Then sistem mengirim notifikasi ke user dan mitra | Could Have |
| Menambahkan Properti | US-09 | As a mitra, I want mendaftarkan properti saya di platform ini, so that saya dapat menawarkannya kepada calon penyewa | Given mitra berada di dashboard, When mitra mengisi form tambah lokasi dan submit, Then sistem menyimpan dan menampilkan lokasi tersebut di platform | Must Have |
| Rating dan Review | US-10 | As a user, I want memberikan rating dan review properti, so that saya dapat membantu rekomendasi untuk user lain dan sebagai feedback untuk mitra | Given user memberikan rating, When masa booking dimulai, Then sistem memberikan izin pada user untuk review dan rating | Should Have |
