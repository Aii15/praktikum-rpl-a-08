# Produk Backlog

Project yang sedang kami kerjakan memiliki nama SpotRent dengan tema "Platform Penyewaan Lokasi untuk Kebutuhan Syuting Komersial" ini adalah sebuah platform di mana tempat berkumpulnya para penyewa properti dan yang menyewakan. <br>

Platform ini secara garis umum memiliki gambaran yang sama seperti platform penyewaan properti seperti perumahan ataupun kost baik yang berbasis web maupun mobile, hanya saja di project ini kita berfokus pada properti di dunia kreatif atau hiburan sehingga memiliki keunikan tersendiri yang membedakannya dengan platform lainnya <br>

Sebelum masuk pada list produk backlog, akan kami jabarkan terlebih dahulu glosarium dari atribut yang terdapat pada list kami <br>
| Nama atribut | Keterangan |
| ------------ | ---------- |
| Fitur | Nama fitur yang akan dikembangkan |
| User Story | User story pada fitur tersebut |
| Acceptance Criteria | Acceptance Criteria pada fitur tersebut |
| Prioritas | Prioritas di sini dibuat berdasarkan aturan MoSCoW |

Berikut kami sertakan produk backlog dari project tim kami:

| Fitur | User Story | Acceptance Criteria | Prioritas |
| ----- | ---------- | ------------------- | --------- |
| Pencarian Lokasi | As a penyewa, I want mencari lokasi berdasarkan kategori, lokasi, dan harga, so that saya dapat menemukan lokasi yang sesuai dengan cepat | Given penyewa berada di halaman pencarian, When penyewa memasukkan filter (lokasi/kategori/harga), Then sistem menampilkan daftar lokasi yang sesuai filter | Must Have |
| Melihat Detail Lokasi | As a penyewa, I want melihat informasi detail suatu lokasi, so that saya dapat mengevaluasi apakah lokasi tersebut sesuai dengan kebutuhan saya | Given user memilih salah satu lokasi, When user membuka halaman detail, Then sistem menampilkan deskripsi, foto, harga, dan fasilitas lokasi | Must Have |
| Booking Lokasi | As a penyewa, I want memesan lokasi langsung dari platform, so that saya dapat mengamankan lokasi tersebut untuk produksi saya | Given user berada di halaman detail lokasi, When user memilih tanggal dan klik tombol booking, Then sistem menyimpan permintaan booking dan menunggu konfirmasi mitra | Must Have |
| Menambahkan Properti | As a penyewa properti, I want mendaftarkan properti saya di platform ini, so that saya dapat menawarkannya kepada calon penyewa | Given mitra berada di dashboard, When mitra mengisi form tambah lokasi dan submit, Then sistem menyimpan dan menampilkan lokasi tersebut di platform | Must Have |
| Sistem Pembayaran | As a penyewa, I want melakukan pembayaran melalui platform ini, so that saya dapat menyelesaikan pemesanan dengan mudah dan aman | Given booking telah disetujui, When user melakukan pembayaran, Then sistem mengonfirmasi pembayaran dan mengubah status menjadi paid | Must Have |
| Ketersediaan Jadwal | As a penyewa, I want melihat jadwal ketersediaan lokasi, so that saya dapat menghindari konflik pemesanan | Given user membuka halaman detail lokasi, When user melihat kalender ketersediaan, Then sistem menampilkan tanggal yang tersedia dan yang sudah dibooking | Should Have |
| Mengelola Booking | As a penyewa properti, I want menerima atau menolak permintaan pemesanan, so that saya dapat mengelola ketersediaan properti saya | Given mitra menerima permintaan booking, When mitra memilih accept atau reject, Then status booking diperbarui sesuai keputusan mitra | Should Have |
| Sistem Notifikasi | As a penyewa properti atau penyewa, I want menerima notifikasi untuk pembaruan pemesanan, so that saya tetap mendapat informasi tentang status pemesanan | Given terjadi perubahan status booking, When status diperbarui (accepted/rejected), Then sistem mengirim notifikasi ke user dan mitra | Could Have |
