# **Identifikasi Role dan Penulisan User Story**

### 1. Penyewaan Lokasi <br>
   **User story:** <br>
   As a penyewa, I want mencari lokasi berdasarkan kategori, lokasi, dan harga, so that saya dapat menemukan lokasi yang sesuai dengan cepat. <br>
   
   **Acceptance Criteria:** <br>
   Given penyewa berada di halaman pencarian, When penyewa memasukkan filter (lokasi/kategori/harga), Then sistem menampilkan daftar lokasi yang sesuai filter.

### 2. Melihat Detail Lokasi <br>
   **User story:** <br>
   As a penyewa, I want melihat informasi detail suatu lokasi, so that saya dapat mengevaluasi apakah lokasi tersebut sesuai dengan kebutuhan pemotretan saya. <br>
   
   **Acceptance Criteria:** <br>
   Given user memilih salah satu lokasi, When user membuka halaman detail, Then sistem menampilkan deskripsi, foto, harga, dan fasilitas lokasi.

### 3. Melihat Ketersediaan <br>
   **User story:** <br>
   As a penyewa, I want melihat jadwal ketersediaan lokasi, so that saya dapat menghindari konflik pemesanan. <br>
   
   **Acceptance Criteria:** <br>
   Given user membuka halaman detail lokasi, When user melihat kalender ketersediaan, Then sistem menampilkan tanggal yang tersedia dan yang sudah dibooking.
   
### 4. Booking Lokasi <br>
   **User story:** <br>
   As a penyewa, I want memesan lokasi langsung dari platform, so that saya dapat mengamankan lokasi tersebut untuk produksi saya. <br>
   
   **Acceptance Criteria:** <br>
   Given user berada di halaman detail lokasi, When user memilih tanggal dan klik tombol booking, Then sistem menyimpan permintaan booking dan menunggu konfirmasi mitra.
   
### 5. Mitra Mengelola Booking <br>
   **User story:** <br>
   As a penyewa properti, I want menerima atau menolak permintaan pemesanan, so that saya dapat mengelola ketersediaan properti saya. <br>
   
   **Acceptance Criteria:** <br>
   Given mitra menerima permintaan booking, When mitra memilih accept atau reject, Then status booking diperbarui sesuai keputusan mitra.
   
### 6. Pembayaran <br>
   **User story:** <br>
   As a penyewa, I want melakukan pembayaran melalui platform ini, so that saya dapat menyelesaikan pemesanan dengan mudah dan aman. <br>
   
   **Acceptance Criteria:** <br>
   Given booking telah disetujui, When user melakukan pembayaran, Then sistem mengonfirmasi pembayaran dan mengubah status menjadi paid.
   
### 7. Notifikasi <br>
   **User story:** <br>
   As a penyewa properti atau penyewa, I want menerima notifikasi untuk pembaruan pemesanan, so that saya tetap mendapat informasi tentang status pemesanan. <br>
   
   **Acceptance Criteria:** <br>
   Given terjadi perubahan status booking, When status diperbarui (accepted/rejected), Then sistem mengirim notifikasi ke user dan mitra.

### 8. Mitra Menambahkan Properti <br>
   **User story:** <br>
   As a penyewa properti, I want mendaftarkan properti saya di platform ini, so that saya dapat menawarkannya kepada calon penyewa. <br>
   
   **Acceptance Criteria:** <br>
   Given mitra berada di dashboard, When mitra mengisi form tambah lokasi dan submit, Then sistem menyimpan dan menampilkan lokasi tersebut di platform.
