// =============================================
// ENTRY POINT & NAVIGASI SPA DASHBOARD MITRA
// =============================================

document.addEventListener('DOMContentLoaded', function() {
    const menuTentangSaya = document.getElementById('menu-tentang-saya');
    const menuRiwayatPenyewaan = document.getElementById('menu-riwayat-penyewaan');
    const menuPropertiSaya = document.getElementById('menu-properti-saya');
    const menuTambahProperti = document.getElementById('menu-tambah-properti');
    const menuStatusPengajuan = document.getElementById('menu-status-pengajuan');

    const routes = [
        { path: '/profile-mitra', sectionId: 'section-tentang-saya', title: 'Profile Mitra - SpotRent', menuEl: menuTentangSaya },
        { path: '/riwayat-penyewaan', sectionId: 'section-riwayat-penyewaan', title: 'Riwayat Penyewaan - SpotRent', menuEl: menuRiwayatPenyewaan },
        { path: '/properti-saya', sectionId: 'section-properti-saya', title: 'Properti Saya - SpotRent', menuEl: menuPropertiSaya },
        { path: '/tambah-properti', sectionId: 'section-tambah-properti', title: 'Tambah Properti - SpotRent', menuEl: menuTambahProperti },
        { path: '/status-pengajuan', sectionId: 'section-status-pengajuan', title: 'Status Pengajuan - SpotRent', menuEl: menuStatusPengajuan },
        { path: '/detail-riwayat-penyewaan', regex: /^\/detail-riwayat-penyewaan\/(\d+)$/, sectionId: 'section-detail-penyewaan', title: 'Detail Penyewaan - SpotRent', menuEl: menuRiwayatPenyewaan }
    ];

    SPARouter.init(routes, routes[0], (path, matched, params) => {
        if (matched.path === '/detail-riwayat-penyewaan' || matched.regex) {
            const id = params ? params[0] : path.match(/^\/detail-riwayat-penyewaan\/(\d+)$/)[1];
            if (typeof window.showRentalDetail === 'function') {
                window.showRentalDetail(null, id, false);
            }
        }
        
        // Restore sidebar whenever page changes in router
        const profilePage = document.querySelector('.profile-page');
        if (profilePage) {
            profilePage.classList.remove('sidebar-collapsed');
        }
        const btnBackCropTop = document.getElementById('btn-back-crop-top');
        if (btnBackCropTop) {
            btnBackCropTop.style.display = 'none';
        }
    });

    // Ikat event klik pada menu
    const menuItems = [
        { el: menuTentangSaya, path: '/profile-mitra' },
        { el: menuRiwayatPenyewaan, path: '/riwayat-penyewaan' },
        { el: menuPropertiSaya, path: '/properti-saya' },
        { el: menuTambahProperti, path: '/tambah-properti' },
        { el: menuStatusPengajuan, path: '/status-pengajuan' }
    ];

    menuItems.forEach(item => {
        if (item.el) {
            item.el.addEventListener('click', function(e) {
                e.preventDefault();
                navigateTo(item.path);
            });
        }
    });

    // Pemeriksaan pemuatan awal halaman
    const currentPath = window.location.pathname;
    if (window.activeBookingId) {
        navigateTo(`/detail-riwayat-penyewaan/${window.activeBookingId}`, false);
    } else {
        navigateTo(currentPath, false);
    }

    // Picu pemeriksaan saat memuat jika nilai lama ada (untuk dropdown fasilitas)
    if (typeof window.updateFasilitasSelection === 'function') {
        window.updateFasilitasSelection();
    }

    // Pra-seleksi kategori lama
    const oldKategoriVal = document.getElementById('kategori-value')?.value;
    if (oldKategoriVal && typeof window.selectKategori === 'function') {
        const matchedRow = document.querySelector(`.category-item-row[data-id="${oldKategoriVal}"]`);
        if (matchedRow) {
            const name = matchedRow.getAttribute('data-name');
            const iconUrl = matchedRow.getAttribute('data-icon');
            window.selectKategori(oldKategoriVal, name, iconUrl);
        }
    }

    // Terapkan filter riwayat sewa dan pengurutan saat dimuat
    if (typeof window.applyAllFilters === 'function') {
        window.applyAllFilters();
    }
});
