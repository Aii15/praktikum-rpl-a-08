// =============================================
// LOGIKA WIZARD & FORM KELOLA PROPERTI MITRA
// =============================================

function confirmDeleteProperty(propertyId) {
    showCustomConfirm(
        "Apakah Anda yakin ingin menghapus properti ini?",
        "danger",
    ).then((confirmed) => {
        if (confirmed) {
            document.getElementById(`delete-form-${propertyId}`).submit();
        }
    });
}
window.confirmDeleteProperty = confirmDeleteProperty;

function goToSubStep(subStep) {
    const stepUpload = document.getElementById("sub-step-upload");
    const stepCrop = document.getElementById("sub-step-crop");
    const profilePage = document.querySelector(".profile-page");
    if (!stepUpload || !stepCrop) return;

    const filesCount = window.selectedFiles ? window.selectedFiles.length : 0;

    if (subStep === "crop") {
        if (filesCount < 2) {
            showProfileToast(
                "Minimal 2 foto wajib diunggah untuk mengatur posisi.",
            );
            return;
        }
        window.activeSubStep = "crop";
        stepUpload.style.display = "none";
        stepCrop.style.display = "flex";

        if (typeof window.renderLiveLayoutPreview === "function") {
            window.renderLiveLayoutPreview();
        }

        // Sembunyikan sidebar dengan animasi
        if (profilePage) {
            profilePage.classList.add("sidebar-collapsed");
        }
        const btnBackCropTop = document.getElementById("btn-back-crop-top");
        if (btnBackCropTop) {
            btnBackCropTop.style.display = "inline-flex";
        }

        if (typeof window.showScrollArrow === "function") {
            window.showScrollArrow();
        }
    } else {
        window.activeSubStep = "upload";
        stepUpload.style.display = "flex";
        stepCrop.style.display = "none";

        // Pulihkan sidebar
        if (profilePage) {
            profilePage.classList.remove("sidebar-collapsed");
        }
        const btnBackCropTop = document.getElementById("btn-back-crop-top");
        if (btnBackCropTop) {
            btnBackCropTop.style.display = "none";
        }

        if (typeof window.hideScrollArrow === "function") {
            window.hideScrollArrow();
        }
    }

    const targetSec = document.getElementById("section-tambah-properti");
    if (targetSec) {
        targetSec.scrollIntoView({ behavior: "smooth" });
    }
}
window.goToSubStep = goToSubStep;

function goToStep(step) {
    const step1 = document.getElementById("step-1");
    const step2 = document.getElementById("step-2");

    if (step === 2) {
        // Validasi input wajib pada langkah 1
        const requiredInputs = step1.querySelectorAll("[required]");
        let valid = true;
        requiredInputs.forEach((input) => {
            const card = input.closest(".field-card");
            if (!input.value.trim()) {
                valid = false;
                if (card) {
                    card.style.borderColor = "#ef4444";
                    card.style.boxShadow = "0 0 0 3px rgba(239,68,68,0.15)";
                }
            } else {
                if (card) {
                    card.style.borderColor = "transparent";
                    card.style.boxShadow = "";
                }
            }

            // Clear highlight realtime saat user mulai mengetik
            input.addEventListener(
                "input",
                function () {
                    if (card && this.value.trim()) {
                        card.style.borderColor = "transparent";
                        card.style.boxShadow = "";
                    }
                },
                { once: false },
            );
        });

        if (!valid) {
            showProfileToast(
                "Mohon lengkapi semua data spesifikasi properti terlebih dahulu.",
            );
            // Scroll ke field pertama yang kosong
            const firstEmpty = step1.querySelector(
                '[required]:placeholder-shown, input[required][value=""]',
            );
            if (firstEmpty) {
                firstEmpty
                    .closest(".field-card")
                    ?.scrollIntoView({ behavior: "smooth", block: "center" });
            }
            return;
        }

        step1.style.display = "none";
        step2.style.display = "block";
        document.getElementById("form-title").textContent =
            "Tambah Foto Properti";

        // Secara default masuk ke sub-langkah unggah
        goToSubStep("upload");
    } else {
        step1.style.display = "block";
        step2.style.display = "none";
        document.getElementById("form-title").textContent = "Tambah Properti";

        // Pulihkan sidebar saat meninggalkan langkah 2
        const profilePage = document.querySelector(".profile-page");
        if (profilePage) {
            profilePage.classList.remove("sidebar-collapsed");
        }
        const btnBackCropTop = document.getElementById("btn-back-crop-top");
        if (btnBackCropTop) {
            btnBackCropTop.style.display = "none";
        }
    }
}
window.goToStep = goToStep;

// Beralih tampilan daftar kategori
function toggleKategoriDropdown(e) {
    e.stopPropagation();
    const dropdown = document.getElementById("kategori-dropdown");
    dropdown.style.display =
        dropdown.style.display === "block" ? "none" : "block";
}
window.toggleKategoriDropdown = toggleKategoriDropdown;

// Pilih kategori
function selectKategori(id, name, iconUrl, e) {
    if (e) e.stopPropagation();
    const valueInput = document.getElementById("kategori-value");
    if (valueInput) {
        valueInput.value = id;
        valueInput.dispatchEvent(new Event("input"));

        const card = valueInput.closest(".field-card");
        if (card) {
            card.style.borderColor = "transparent";
            card.style.boxShadow = "";
        }
    }

    const displayContainer = document.getElementById("kategori-display");
    if (displayContainer) {
        displayContainer.innerHTML = "";

        const badge = document.createElement("div");
        badge.className = "selected-badge";

        const icon = document.createElement("img");
        icon.src = iconUrl;

        const label = document.createElement("span");
        label.textContent = name;

        badge.appendChild(icon);
        badge.appendChild(label);
        displayContainer.appendChild(badge);
    }

    const dropdown = document.getElementById("kategori-dropdown");
    if (dropdown) dropdown.style.display = "none";
}
window.selectKategori = selectKategori;

// Beralih tampilan daftar fasilitas
function toggleFasilitasDropdown(e) {
    e.stopPropagation();
    const dropdown = document.getElementById("fasilitas-dropdown");
    dropdown.style.display =
        dropdown.style.display === "block" ? "none" : "block";
}
window.toggleFasilitasDropdown = toggleFasilitasDropdown;

// Perbarui tampilan teks fasilitas dan input tersembunyi
function updateFasilitasSelection() {
    const checkboxes = document.querySelectorAll(".facility-checkbox");
    const selectedNames = [];
    const displayContainer = document.getElementById("fasilitas-display");
    if (!displayContainer) return;
    displayContainer.innerHTML = "";

    checkboxes.forEach((cb) => {
        if (cb.checked) {
            selectedNames.push(cb.value);

            const badge = document.createElement("div");
            badge.className = "selected-badge";

            const icon = document.createElement("img");
            icon.src = cb.dataset.icon;

            const label = document.createElement("span");
            label.textContent = cb.value;

            badge.appendChild(icon);
            badge.appendChild(label);
            displayContainer.appendChild(badge);
        }
    });

    const valueInput = document.getElementById("fasilitas-value");
    if (valueInput) valueInput.value = selectedNames.join(", ");

    if (selectedNames.length === 0) {
        displayContainer.innerHTML =
            '<span style="font-size: 15px; font-weight: 500; color: #777;">Pilih Fasilitas</span>';
    }
}
window.updateFasilitasSelection = updateFasilitasSelection;

// Tutup dropdown jika mengklik di luar area
document.addEventListener("click", function (e) {
    const container = document.getElementById("fasilitas-dropdown-container");
    const dropdown = document.getElementById("fasilitas-dropdown");
    if (container && !container.contains(e.target)) {
        if (dropdown) dropdown.style.display = "none";
    }

    const catContainer = document.getElementById("kategori-dropdown-container");
    const catDropdown = document.getElementById("kategori-dropdown");
    if (catContainer && !catContainer.contains(e.target)) {
        if (catDropdown) catDropdown.style.display = "none";
    }

    const statusContainer = document.getElementById(
        "status-dropdown-container",
    );
    const statusDropdown = document.getElementById("status-dropdown");
    if (statusContainer && !statusContainer.contains(e.target)) {
        if (statusDropdown) statusDropdown.style.display = "none";
    }

    const sortContainer = document.getElementById("sort-dropdown-container");
    const sortDropdown = document.getElementById("sort-dropdown");
    if (sortContainer && !sortContainer.contains(e.target)) {
        if (sortDropdown) sortDropdown.style.display = "none";
    }
});

// Logika pemformatan harga (pemformatan Rupiah Indonesia)
const displayInput = document.getElementById("harga_display");
const hiddenInput = document.getElementById("harga_per_hari");

function formatRupiah(value) {
    let number = value.replace(/[^0-9]/g, "");
    if (number === "") return "";
    return "Rp " + new Intl.NumberFormat("id-ID").format(number);
}

if (displayInput) {
    displayInput.addEventListener("input", function (e) {
        let rawVal = this.value.replace(/[^0-9]/g, "");
        this.value = formatRupiah(this.value);
        if (hiddenInput) hiddenInput.value = rawVal;
    });

    if (hiddenInput && hiddenInput.value) {
        displayInput.value = formatRupiah(hiddenInput.value);
    }
}
