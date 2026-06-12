// =============================================
// VALIDASI FORM PROFIL MITRA & TOAST OVERLAY
// =============================================

let profileToastTimer = null;

function showProfileToast(msg) {
    const overlay = document.getElementById('profile-toast-overlay');
    const box = document.getElementById('profile-toast-box');
    const msgEl = document.getElementById('profile-toast-msg');
    if (!overlay || !box) return;

    msgEl.textContent = msg || 'Mohon lengkapi semua data profil terlebih dahulu.';
    overlay.style.display = 'block';

    // Trigger animation
    requestAnimationFrame(() => {
        box.style.opacity = '1';
        box.style.transform = 'translateX(-50%) translateY(0)';
    });

    // Auto-dismiss setelah 4 detik
    clearTimeout(profileToastTimer);
    profileToastTimer = setTimeout(() => closeProfileToast(), 4000);
}
window.showProfileToast = showProfileToast;

function closeProfileToast() {
    const overlay = document.getElementById('profile-toast-overlay');
    const box = document.getElementById('profile-toast-box');
    if (!overlay || !box) return;

    box.style.opacity = '0';
    box.style.transform = 'translateX(-50%) translateY(-20px)';
    setTimeout(() => { overlay.style.display = 'none'; }, 300);
}
window.closeProfileToast = closeProfileToast;

const profileMitraForm = document.getElementById('profile-mitra-form');
if (profileMitraForm) {
    profileMitraForm.addEventListener('submit', function (e) {
        const requiredInputs = profileMitraForm.querySelectorAll('input[required]');
        let valid = true;

        requiredInputs.forEach(input => {
            const card = input.closest('.field-card');
            if (!input.value.trim()) {
                valid = false;
                if (card) {
                    card.style.borderColor = '#ef4444';
                    card.style.boxShadow = '0 0 0 3px rgba(239,68,68,0.15)';
                }
            } else {
                if (card) {
                    card.style.borderColor = 'transparent';
                    card.style.boxShadow = '';
                }
            }

            // Clear highlight realtime saat user mulai mengetik
            input.addEventListener('input', function () {
                if (card && this.value.trim()) {
                    card.style.borderColor = 'transparent';
                    card.style.boxShadow = '';
                }
            }, { once: false });
        });

        if (!valid) {
            e.preventDefault();
            showProfileToast('Mohon lengkapi semua data profil terlebih dahulu.');
            // Scroll ke field pertama yang kosong
            const firstEmpty = profileMitraForm.querySelector('input[required]:placeholder-shown, input[required][value=""]');
            if (firstEmpty) {
                firstEmpty.closest('.field-card')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });
}
