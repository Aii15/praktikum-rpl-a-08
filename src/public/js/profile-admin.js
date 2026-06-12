// =============================================
// ENTRY POINT & NAVIGASI SPA DASHBOARD ADMIN
// =============================================

document.addEventListener('DOMContentLoaded', function() {
    // Timeout untuk menghilangkan banner pesan kilat (flash alert)
    const flashContainer = document.getElementById('flash-message-container');
    if (flashContainer) {
        setTimeout(() => {
            flashContainer.style.opacity = '0';
            flashContainer.style.transform = 'translateY(-10px)';
            setTimeout(() => {
                flashContainer.style.display = 'none';
            }, 500);
        }, 4000);
    }

    // Inisialisasi SPA Router
    const menuLogAktivitas = document.getElementById('menu-log-aktivitas');
    const menuListProperti = document.getElementById('menu-list-properti');
    const menuManageComments = document.getElementById('menu-manage-comments');
    const menuManageUsers = document.getElementById('menu-manage-users');
    const menuStats = document.getElementById('menu-stats');
    const cardPengajuanProperti = document.getElementById('card-pengajuan-properti');
    const cardRiwayatPemesanan = document.getElementById('card-riwayat-pemesanan');
    const kembaliPengajuan = document.getElementById('kembali-pengajuan');
    const kembaliRiwayat = document.getElementById('kembali-riwayat');

    const routes = [
        { path: '/profile-admin', sectionId: 'section-log-aktivitas', title: 'Dashboard Admin - SpotRent', menuEl: menuLogAktivitas },
        { path: '/admin/pengajuan-properti', sectionId: 'section-pengajuan-properti', title: 'Pengajuan Properti - SpotRent', menuEl: menuLogAktivitas },
        { path: '/admin/riwayat-pemesanan', sectionId: 'section-riwayat-pemesanan', title: 'Riwayat Pemesanan - SpotRent', menuEl: menuLogAktivitas },
        { path: '/admin/list-properti', sectionId: 'section-list-properti', title: 'List Properti - SpotRent', menuEl: menuListProperti },
        { path: '/admin/manage-comments', sectionId: 'section-manage-comments', title: 'Kelola Komentar - SpotRent', menuEl: menuManageComments },
        { path: '/admin/manage-users', sectionId: 'section-manage-users', title: 'Manajemen Pengguna - SpotRent', menuEl: menuManageUsers },
        { path: '/admin/stats', sectionId: 'section-stats', title: 'Statistik - SpotRent', menuEl: menuStats }
    ];

    SPARouter.init(routes, routes[0]);

    // Pengikatan handler klik menu sidebar dan kartu navigasi
    const bindings = [
        { el: menuLogAktivitas, path: '/profile-admin' },
        { el: menuListProperti, path: '/admin/list-properti' },
        { el: menuManageComments, path: '/admin/manage-comments' },
        { el: menuManageUsers, path: '/admin/manage-users' },
        { el: menuStats, path: '/admin/stats' },
        { el: cardPengajuanProperti, path: '/admin/pengajuan-properti' },
        { el: cardRiwayatPemesanan, path: '/admin/riwayat-pemesanan' },
        { el: kembaliPengajuan, path: '/profile-admin' },
        { el: kembaliRiwayat, path: '/profile-admin' }
    ];

    bindings.forEach(binding => {
        if (binding.el) {
            binding.el.addEventListener('click', function(e) {
                e.preventDefault();
                navigateTo(binding.path);
            });
        }
    });

    // Event listener global untuk menutup dropdown kustom saat klik di luar area
    window.addEventListener('click', function() {
        ['rating-dropdown', 'time-dropdown', 'booking-status-dropdown', 'user-role-dropdown'].forEach(dropId => {
            const drop = document.getElementById(dropId);
            if (drop) drop.style.display = 'none';
        });
    });

    // Jalankan navigasi awal berdasarkan URL saat ini
    const currentPath = window.location.pathname;
    navigateTo(currentPath, false);
});
