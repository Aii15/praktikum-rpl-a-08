/**
 * Helper Router SPA SpotRent
 * Mengatur perutean sisi klien, perpindahan tab, dan integrasi riwayat browser.
 */

window.SPARouter = {
    routes: [],
    fallbackRoute: null,
    onRouteChanged: null,
    
    init(routes, fallbackRoute, onRouteChanged) {
        this.routes = routes;
        this.fallbackRoute = fallbackRoute;
        this.onRouteChanged = onRouteChanged;
        
        // Tangani aksi popstate tombol kembali/maju browser
        window.addEventListener('popstate', (e) => {
            const path = (e.state && e.state.path) ? e.state.path : window.location.pathname;
            this.navigateTo(path, false);
        });
    },
    
    navigateTo(path, pushState = true) {
        let matched = null;
        let params = null;
        
        // Cari rute yang cocok berdasarkan path atau pola regex
        for (let route of this.routes) {
            if (route.regex) {
                let match = path.match(route.regex);
                if (match) {
                    matched = route;
                    params = match.slice(1);
                    break;
                }
            } else if (route.path === path) {
                matched = route;
                break;
            }
        }
        
        // Rute cadangan jika tidak ada rute yang cocok
        if (!matched && this.fallbackRoute) {
            matched = this.fallbackRoute;
        }
        
        if (!matched) return;
        
        // Beralih status aktif untuk section tampilan dan item menu
        this.routes.forEach(route => {
            const sec = document.getElementById(route.sectionId);
            if (sec) {
                if (route === matched) {
                    sec.style.display = 'block';
                    sec.offsetHeight; // picu reflow browser
                    sec.classList.add('active');
                    if (route.menuEl) route.menuEl.classList.add('active');
                } else {
                    sec.classList.remove('active');
                    sec.style.display = 'none';
                    // Hanya hapus status aktif jika elemen tidak digunakan bersama oleh rute aktif
                    if (route.menuEl && route.menuEl !== matched.menuEl) {
                        route.menuEl.classList.remove('active');
                    }
                }
            }
        });
        
        if (matched.title) {
            document.title = matched.title;
        }
        
        if (pushState) {
            const historyPath = matched.regex ? path : matched.path;
            history.pushState({ path: historyPath }, '', historyPath);
        }
        
        if (this.onRouteChanged) {
            this.onRouteChanged(path, matched, params);
        }
    }
};

// Helper kompatibilitas navigateTo global
window.navigateTo = function(path, pushState = true) {
    if (window.SPARouter && typeof window.SPARouter.navigateTo === 'function') {
        window.SPARouter.navigateTo(path, pushState);
    }
};
