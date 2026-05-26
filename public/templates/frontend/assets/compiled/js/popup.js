// File: navigasi.js

document.addEventListener('DOMContentLoaded', () => {
    const openLoginBtn = document.getElementById('open-popup');   // Ikon foto profil di file navigasi
    const loginModal = document.getElementById('loginModal');       // Container overlay popup
    const closeLoginBtn = document.getElementById('close-popup'); // Tombol X pada popup

    // 1. Klik Ikon Profil -> Buka Popup
    if (openLoginBtn && loginModal) {
        openLoginBtn.addEventListener('click', (e) => {
            e.preventDefault(); // Mencegah pindah halaman default href="#"
            loginModal.classList.add('show');
        });
    }

    // 2. Klik Tombol X -> Tutup Popup
    if (closeLoginBtn && loginModal) {
        closeLoginBtn.addEventListener('click', () => {
            loginModal.classList.remove('show');
        });
    }

    // 3. Klik di luar kotak popup (pada area overlay hitam) -> Tutup Popup
    window.addEventListener('click', (e) => {
        if (e.target === loginModal) {
            loginModal.classList.remove('show');
        }
    });
});