document.addEventListener('DOMContentLoaded', () => {

    // Elemen-elemen yang dipilih (Hanya Order Modal)
    const openOrderBtns = document.querySelectorAll('.open-order-popup');
    const orderModal = document.getElementById('orderModal');
    const closeOrderBtn = document.getElementById('close-order-popup');

    // Buka modal order
    openOrderBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            orderModal?.classList.add('show');
        });
    });

    // Tutup pop up order (Tombol Close)
    closeOrderBtn?.addEventListener('click', () => {
        orderModal.classList.remove('show');
    });

    // Tutup overlay jika mengeklik di luar pop up order
    window.addEventListener('click', (e) => {
        if (e.target === orderModal) {
            orderModal.classList.remove('show');
        }
    });
    
    // Ganti tabs di dalam Order Modal
    const tabBtns = document.querySelectorAll('.order-tabs .tab-btn');
    const tabContents = document.querySelectorAll('.order-popup-body .tab-content');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const targetTab = btn.getAttribute('data-tab');

            // Set tabs aktif
            tabBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            // Set content tabs aktif
            tabContents.forEach(content => {
                content.classList.remove('active');
                if (content.id === `tab-${targetTab}`) {
                    content.classList.add('active');
                }
            });
        });
    });
});