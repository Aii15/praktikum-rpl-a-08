# Changelog

## [1.0.0] - 2026-07-06

### Added

- Fitur registrasi dan login untuk penyewa dan mitra
- Fitur pencarian lokasi properti dengan filter lokasi, kategori, dan harga
- Fitur melihat detail informasi lokasi properti secara lengkap
- Fitur booking lokasi properti langsung melalui platform
- Fitur ketersediaan jadwal/kalender booking
- Fitur pembayaran transaksi penyewaan
- Fitur edit profil bagi penyewa dan mitra
- Fitur bookmark atau wishlist untuk menyimpan properti favorit
- Fitur menambahkan dan mengelola properti untuk mitra
- Fitur persetujuan booking dan riwayat penyewaan untuk mitra
- Fitur dashboard admin (statistik platform, manajemen pengguna, dan penanganan feedback)
- Fitur notifikasi status pemesanan untuk mitra dan penyewa

### Fixed

- Perbaikan bug validasi form pada kolom Kategori Properti
- Perbaikan bug pop-up konfirmasi review dan pengiriman feedback oleh mitra
- Perbaikan bug validasi data pendaftaran mitra dan upgrade akun penyewa ke mitra
- Perbaikan bug role-based redirects dan routing middleware
- Perbaikan bug tampilan kontak mitra pada riwayat booking
- Perbaikan bug batasan booking untuk role mitra dan admin
- Perbaikan bug validasi format email saat registrasi
- Perbaikan bug validasi booking pada tanggal lampau
- Perbaikan bug validasi upload foto properti agar mematuhi batasan server PHP secara dinamis
- Perbaikan bug ketidaksesuaian posisi crop thumbnail gambar dengan cara menyamakan ukuran bingkai live preview dan halaman detail
