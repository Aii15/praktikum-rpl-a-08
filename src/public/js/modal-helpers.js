/**
 * Helper Modal Kustom SpotRent
 * Menyediakan modal alert dan konfirmasi kustom yang dapat diakses secara global.
 */

function showCustomAlert(message, alertType = 'success') {
    return new Promise((resolve) => {
        const overlay = document.createElement('div');
        overlay.className = 'custom-modal-overlay';
        
        overlay.innerHTML = `
            <div class="custom-modal-box">
                <div class="custom-modal-icon ${alertType}">
                    ${alertType === 'success' ? '✓' : '!'}
                </div>
                <h3>${alertType === 'success' ? 'Sukses' : 'Gagal'}</h3>
                <p>${message}</p>
                <div class="custom-modal-actions" style="justify-content: center;">
                    <button class="custom-modal-btn ok-btn">OK</button>
                </div>
            </div>
        `;
        
        document.body.appendChild(overlay);
        
        setTimeout(() => {
            overlay.classList.add('active');
        }, 10);
        
        const okBtn = overlay.querySelector('.ok-btn');
        
        function close() {
            overlay.classList.remove('active');
            setTimeout(() => {
                overlay.remove();
            }, 300);
        }
        
        okBtn.onclick = () => {
            close();
            resolve();
        };
        
        overlay.onclick = (e) => {
            if (e.target === overlay) {
                close();
                resolve();
            }
        };
    });
}
window.showCustomAlert = showCustomAlert;

function showCustomConfirm(message, actionType = 'confirm') {
    return new Promise((resolve) => {
        const overlay = document.createElement('div');
        overlay.className = 'custom-modal-overlay';
        
        let confirmBtnStyle = 'background: #f7c948; color: #111111;';
        if (actionType === 'danger') {
            confirmBtnStyle = 'background: #e11d48; color: #ffffff;';
        } else if (actionType === 'success') {
            confirmBtnStyle = 'background: #22c55e; color: #ffffff;';
        }
        
        let confirmBtnText = 'Ya, Lanjutkan';
        let cancelBtnText = 'Batal';
        
        let iconChar = '?';
        let iconClass = actionType;
        if (actionType === 'danger') {
            iconChar = '!';
        } else if (actionType === 'success') {
            iconChar = '✓';
            iconClass = 'success';
        } else if (actionType === 'confirm' || actionType === 'info') {
            iconClass = 'success';
        }
        
        overlay.innerHTML = `
            <div class="custom-modal-box">
                <div class="custom-modal-icon ${iconClass}">
                    ${iconChar}
                </div>
                <h3>Konfirmasi</h3>
                <p>${message}</p>
                <div class="custom-modal-actions" style="display: flex; gap: 12px; justify-content: center;">
                    <button class="custom-modal-btn cancel-btn" style="background: #f3f4f6; color: #374151; border: 1px solid #d1d5db;">${cancelBtnText}</button>
                    <button class="custom-modal-btn confirm-btn" style="${confirmBtnStyle}">${confirmBtnText}</button>
                </div>
            </div>
        `;
        
        document.body.appendChild(overlay);
        
        setTimeout(() => {
            overlay.classList.add('active');
        }, 10);
        
        const cancelBtn = overlay.querySelector('.cancel-btn');
        const confirmBtn = overlay.querySelector('.confirm-btn');
        
        function close() {
            overlay.classList.remove('active');
            setTimeout(() => {
                overlay.remove();
            }, 300);
        }
        
        cancelBtn.onclick = () => {
            close();
            resolve(false);
        };
        
        confirmBtn.onclick = () => {
            close();
            resolve(true);
        };
        
        overlay.onclick = (e) => {
            if (e.target === overlay) {
                close();
                resolve(false);
            }
        };
    });
}
window.showCustomConfirm = showCustomConfirm;
