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
        if (e.target === orderModal) {
            orderModal.classList.remove('show');
        }
    });

    // ==========================================
    // LAYANAN ANTAR JEMPUT POPUP JS             
    // ==========================================
    const orderModal = document.getElementById('orderModal');
    const closeOrderBtn = document.getElementById('close-order-popup');
    
    // Find "ANTAR JEMPUT" trigger buttons (handles class, id, and textual fallback)
    let openOrderBtns = Array.from(document.querySelectorAll('.open-order-popup, #open-order-popup'));
    if (openOrderBtns.length === 0) {
        document.querySelectorAll('a').forEach(link => {
            const text = link.textContent.trim().toUpperCase();
            if (text.includes('ANTAR JEMPUT')) {
                openOrderBtns.push(link);
            }
        });
    }

    // Bind open events
    openOrderBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            if (orderModal) {
                orderModal.classList.add('show');
            }
        });
    });

    // Bind close event
    if (closeOrderBtn && orderModal) {
        closeOrderBtn.addEventListener('click', () => {
            orderModal.classList.remove('show');
        });
    }

    // Tabs Switcher Logic
    const tabBtns = document.querySelectorAll('.order-tabs .tab-btn');
    const tabContents = document.querySelectorAll('.order-popup-body .tab-content');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const targetTab = btn.getAttribute('data-tab');

            // Toggle active class on tab buttons
            tabBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            // Toggle active class on contents
            tabContents.forEach(content => {
                content.classList.remove('active');
                if (content.id === `tab-${targetTab}`) {
                    content.classList.add('active');
                }
            });
        });
    });
});