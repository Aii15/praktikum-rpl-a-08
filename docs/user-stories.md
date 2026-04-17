# **Identifikasi Role dan Penulisan User Story**

Terdapat tiga role pada project ini jika developer dihitung, yaitu:
- User sebagai pihak penyewa seperti bagian dari unsur dunia kreatif seperti produser, location manager, dll
- Mitra yang menyewakan properti untuk dijadikan tempat syuting
- Admin

| Fitur | Kode US | User Story | Acceptance Criteria |
| ----- | ------- | ---------- | ------------------- |
| Penyewaan Lokasi | US-01 |  As a penyewa, I want mencari lokasi berdasarkan kategori, lokasi, dan harga, so that saya dapat menemukan lokasi yang sesuai dengan cepat | Given penyewa berada di halaman pencarian, When penyewa memasukkan filter (lokasi/kategori/harga), Then sistem menampilkan daftar lokasi yang sesuai filter |
| Melihat Detail Lokasi | US-02 | As a penyewa, I want melihat informasi detail suatu lokasi, so that saya dapat mengevaluasi apakah lokasi tersebut sesuai dengan kebutuhan pemotretan saya | Given user memilih salah satu lokasi, When user membuka halaman detail, Then sistem menampilkan deskripsi, foto, harga, dan fasilitas lokasi |
| Melihat Ketersediaan | US-03 | As a penyewa, I want melihat jadwal ketersediaan lokasi, so that saya dapat menghindari konflik pemesanan | Given user membuka halaman detail lokasi, When user melihat kalender ketersediaan, Then sistem menampilkan tanggal yang tersedia dan yang sudah dibooking |
| Booking Lokasi | US-04 | As a penyewa, I want memesan lokasi langsung dari platform, so that saya dapat mengamankan lokasi tersebut untuk produksi saya | Given user berada di halaman detail lokasi, When user memilih tanggal dan klik tombol booking, Then sistem menyimpan permintaan booking dan menunggu konfirmasi mitra |
| Admin Mengelola Properti Mitra | US-05 | As a admin, I want menerima atau menolak permintaan pengajuan properti oleh mitra, so that saya dapat mengelola permintaan properti tersebut | Given admin menerima atau menolak pengajuan properti, When mitra mengajukan properti, Then properti diverifikasi masuk list atau tidak |
| Admin Manajemen User | US-06 | As a admin, I want melihat riwayat seluruh aktivitas seperti transaksi dan pengajuan properti, so that saya dapat melihat seluruh aktivitas di aplikasi saya | Given admin melihat seluruh aktivitas, When user dan mitra melakukan aktivitas pada aplikasi, Then sistem menyimpan log aktivitas |
| Pembayaran | US-07 | As a penyewa, I want melakukan pembayaran melalui platform ini, so that saya dapat menyelesaikan pemesanan dengan mudah dan aman | Given setelah booking, When user melakukan pembayaran, Then sistem mengonfirmasi pembayaran dan mengubah status menjadi paid |
| Notifikasi | US-08 | As a mitra atau penyewa, I want menerima notifikasi untuk pembaruan pemesanan, so that saya tetap mendapat informasi tentang status pemesanan | Given terjadi perubahan status booking, When status diperbarui (accepted/rejected), Then sistem mengirim notifikasi ke user dan mitra |
| Mitra Menambahkan Properti | US-09 | As a mitra, I want mendaftarkan properti saya di platform ini, so that saya dapat menawarkannya kepada calon penyewa | Given mitra berada di dashboard, When mitra mengisi form tambah lokasi dan submit, Then sistem menyimpan dan menampilkan lokasi tersebut di platform |
| Rating dan Review | US-10 | As a penyewa, I want memberikan rating dan review properti, so that saya dapat membantu rekomendasi untuk user lain dan sebagai feedback untuk mitra | Given penyewa memberikan rating, When masa booking dimulai, Then sistem memberikan izin pada penyewa untuk review dan rating |
