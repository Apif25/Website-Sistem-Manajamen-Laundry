document.addEventListener('DOMContentLoaded', () => {
    // ==========================================
    // 1. SELEKSI ELEMEN (LOGIN & ORDER)
    // ==========================================
    // Ambil semua tombol login & order (menggunakan CLASS karena elemennya dobel)
    const openLoginBtns = document.querySelectorAll('.open-popup-login');   
    const openOrderBtns = document.querySelectorAll('.open-order-popup');   

    // Ambil masing-masing container modal (menggunakan ID)
    const loginModal = document.getElementById('loginModal');       
    const orderModal = document.getElementById('orderModal'); 

    // Ambil tombol tutup (X) masing-masing modal
    const closeLoginBtn = document.getElementById('close-popup'); // Tombol X Login
    const closeOrderBtn = document.getElementById('close-order-popup'); // Tombol X Order (Pastikan ID ini ada di HTML Popup Order Anda)

    // ==========================================
    // 2. LOGIKA UNTUK POP-UP LOGIN
    // ==========================================
    // Buka Popup Login (Desktop & Mobile)
    if (openLoginBtns.length > 0 && loginModal) {
        openLoginBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                loginModal.classList.add('show');
            });
        });
    }

    // Tutup Popup Login lewat tombol X
    if (closeLoginBtn && loginModal) {
        closeLoginBtn.addEventListener('click', () => {
            loginModal.classList.remove('show');
        });
    }

    // ==========================================
    // 3. LOGIKA UNTUK POP-UP ORDER (ANTAR JEMPUT)
    // ==========================================
    // Buka Popup Order (Desktop & Mobile)
    if (openOrderBtns.length > 0 && orderModal) {
        openOrderBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault(); // Mencegah reload/pindah halaman
                orderModal.classList.add('show'); // Membuka pop-up order
            });
        });
    }

    // Tutup Popup Order lewat tombol X
    if (closeOrderBtn && orderModal) {
        closeOrderBtn.addEventListener('click', () => {
            orderModal.classList.remove('show');
        });
    }

    // ==========================================
    // 4. LOGIKA KLIK DI LUAR BOX (OVERLAY)
    // ==========================================
    window.addEventListener('click', (e) => {
        // Jika yang diklik adalah background hitam/overlay login
        if (loginModal && e.target === loginModal) {
            loginModal.classList.remove('show');
        }
        
        // Jika yang diklik adalah background hitam/overlay order
        if (orderModal && e.target === orderModal) {
            orderModal.classList.remove('show');
        }
    });
    
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

