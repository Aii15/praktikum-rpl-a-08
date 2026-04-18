# Software Requirements Specification (SRS)

## 1. Pendahuluan

### 1.1 Tujuan Dokumen
Dokumen Software Requirements Specification (SRS) ini disusun untuk mendeskripsikan secara detail mengenai kebutuhan perangkat lunak yang harus dipenuhi oleh platform "SpotRent". Dokumen ini berfungsi sebagai panduan teknis bagi tim pengembang serta menjadi kontrak formal antara tim pengembang dan pemangku kepentingan (stakeholders) mengenai fitur dan batasan sistem yang akan dibangun.

### 1.2 Ruang Lingkup
Sistem yang dikembangkan adalah platform digital bernama "SpotRent", sebuah platform penyewaan lokasi yang dikhususkan untuk kebutuhan syuting komersial.
* Fungsi utama: Mempermudah pencarian, pemilihan, dan pemesanan lokasi atau properti secara terpusat dan efisien untuk menghemat waktu pra-produksi.

* Target Pengguna:
    * User: Pihak kreatif seperti produser atau location manager yang membutuhkan lokasi.

    * Mitra: Pemilik properti yang ingin mempromosikan dan menyewakan tempatnya secara lebih luas ke industri kreatif.

    * Admin: Pengelola yang memverifikasi pengajuan properti dan manajemen seluruh aktivitas aplikasi.

### 1.3 Definisi dan Akronim
| Akronim   | Definisi                                                                                                                                                      |
| --------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| SRS       |  Software Requirements Specification adalah dokumen spesifikasi kebutuhan perangkat lunak yang menjadi acuan pengembangan.lunak                               |
| FR        | Functional Requirement adalah deskripsi layanan atau fitur yang harus disediakan oleh sistem (APA yang dilakukan sistem)                                      |
| NFR       | Non Functional Requirement adalah deskripsi mengenai batasan, kualitas, dan standar performa sistem (BAGAIMANA sistem bekerja)                                |
| AC | Acceptance Criteria adalah kriteria yang harus dipenuhi agar sebuah user story dianggap selesai dan diterima                                                         |
| US| User story adalah penjelasan singkat dan sederhana tentang suatu fitur yang ditulis dari sudut pandang orang yang menginginkan fitur tersebut                         |
| Mitra        | Pihak atau entitas yang mendaftarkan dan menyewakan properti/lokasi syuting di platform                                                                    |
| User        | Pihak yang mencari dan melakukan pemesanan (booking) lokasi di platform                                                                                     |  
| Admin      | Pihak yang mengelola platform                                                                                                                                |

## 2. Deskripsi Umum

### 2.1 Perspektif Produk
Platform penyewaan properti untuk kebutuhan syuting komersial yang dikembangkan ini merupakan sebuah sistem berbasis web dan mobile yang berfungsi sebagai penghubung antara pemilik properti (mitra) dan pihak penyewa (production house, brand, fotografer, atau kreator konten). Sistem ini dirancang untuk mempermudah proses pencarian, pemilihan, pemesanan, hingga pembayaran lokasi syuting secara efisien dan terpusat. <br>
Produk ini dapat dianggap sebagai bagian dari ekosistem digital marketplace, serupa dengan platform penyewaan properti pada umumnya, namun dengan fokus khusus pada kebutuhan industri kreatif dan produksi media. Platform ini berdiri secara independen, tetapi dapat terintegrasi dengan layanan pihak ketiga seperti sistem pembayaran online, dan layanan komunikasi. <br>
Dari sisi user (pihak penyewa), sistem menyediakan antarmuka yang intuitif untuk:
* Menjelajahi properti berdasarkan kategori
* Melihat detail properti
* Melakukan pemesanan dan pembayaran

Dari sisi pemilik properti, platform memungkinkan:
* Mengunggah dan mengelola daftar properti
* Menentukan harga properti

### 2.2 Fungsi Utama
Sistem di sini menyediakan berbagai fungsi utama yang mendukung interaksi antara penyewa dan pemilik properti, yaitu:
* Manajemen Akun Pengguna
     * Registrasi dan login sebagai penyewa atau pemilik properti
     * Pengelolaan profil pengguna
* Pencarian dan Eksplorasi Properti
     * Pencarian properti bedasarkan filter
     * Tampilan daftar properti beserta preview
* Detail Properti
     * Menampilkan informasi lengkap properti
* Pemesanan dan Pembayaran
     * Pemilihan tanggal dan durasi sewa
     * Integrasi dengan sistem pembayaran
     * Riwayat transaksi dan status pembayaran
* Manajemen Properti (Untuk mitra)
     * Menambahkan, mengedit, dan menghapus listing properti
     * Mengatur harga dan detail fasilitas
     * Melihat booking
* Notifikasi
     * Notifikasi terkait booking dan pembayaran
* Ulasan dan Rating
     * Penyewa dapat memberikan ulasan dan rating setelah masa booking dimulai
     * Menampilkan rating untuk meningkatkan kepercayaan pengguna

### 2.3 Karakteristik Pengguna
* User adalah individu atau tim seperti production house, kreator konten, fotografer, atau brand yang menggunakan platform untuk mencari dan menyewa properti sebagai lokasi syuting. Mereka umumnya memiliki kemampuan teknologi menengah dan mengutamakan kemudahan dalam pencarian, akses informasi, serta proses booking dan pembayaran yang cepat.
* Mitra adalah pihak yang menyediakan properti untuk disewakan, seperti pemilik rumah, pengelola studio, atau pemilik lokasi komersial. Mereka memiliki kemampuan teknologi yang bervariasi dan membutuhkan sistem yang sederhana untuk mengelola properti, harga, serta ketersediaan.
* Admin adalah pihak yang bertanggung jawab atas pengelolaan dan pengawasan sistem secara keseluruhan, termasuk mengelola data pengguna dan mitra, memverifikasi listing properti, serta mengawasi transaksi.

### 2.4 Batasan Sistem
* Keakuratan data properti bergantung pada input dari mitra
* Hak akses pengguna dibatasi berdasarkan peran
* Hanya berfokus pada penyewaan properti, tidak mencakup operasional produksi seperti izin dari pemerintah setempat, kru, dll
* Jumlah upload media (foto properti) dibatasi untuk menjaga performa sistem
* Tidak semua wilayah atau lokasi properti mungkin terjangkau oleh layanan platform
  
## 3. Kebutuhan Fungsional 

Tabel FR (Functional Requirement)
| ID | Deskripsi | Prioritas | Referensi US |
| -- | --------- | --------- | ------------ |
| FR-01 | Sistem menyediakan fitur pencarian lokasi berdasarkan kategori, lokasi, dan rentang harga serta menampilkan hasil sesuai filter yang dipilih user | High | US-01 |
| FR-02 | Sistem menampilkan informasi detail lokasi yang meliputi deskripsi, foto, harga, fasilitas, serta jadwal ketersediaan dalam bentuk kalender | High | US-02, US-03|
| FR-03 | Sistem menampilkan tanggal yang tersedia dan yang sudah dibooking serta memungkinkan user memilih tanggal untuk melakukan booking lokasi | High | US-03, US-04 |
| FR-04 | Sistem menyimpan data pemesanan (booking) ke dalam database dan mengelola status pemesanan. | High | US-04 |
| FR-05 | Sistem memungkinkan admin menerima atau menolak pengajuan properti serta mengelola properti yang ditampilkan di platform | High | US-05 |
| FR-06 | Sistem menampilkan dan mencatat seluruh aktivitas seperti transaksi, booking, dan pengajuan properti kepada admin dalam bentuk log | Medium | US-06 |
| FR-07 | Sistem menyediakan fitur pembayaran, mengonfirmasi pembayaran, serta mengubah status pemesanan menjadi “paid” | High | US-07 |
| FR-08 | Sistem mengirim notifikasi kepada user dan mitra saat terjadi perubahan status pemesanan atau booking | Medium | US-08 |
| FR-09 | Sistem memungkinkan mitra menambahkan properti melalui form input dan menyimpan data properti setelah diverifikasi oleh admin | High | US-09 |
| FR-10 | Sistem memungkinkan user memberikan rating dan review terhadap properti setelah masa booking dimulai | Medium | US-10 |
