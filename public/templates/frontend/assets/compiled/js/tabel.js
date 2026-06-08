function switchTable(event, statusId) {
            // Hapus kelas 'active' dari semua tombol tab
            const tabButtons = document.querySelectorAll('.tab-btn-order');
            tabButtons.forEach(btn => btn.classList.remove('active'));

            // Hapus kelas 'active' dari semua panel tabel
            const tablePanels = document.querySelectorAll('.table-panel');
            tablePanels.forEach(panel => panel.classList.remove('active'));

            // Tambahkan kelas 'active' ke tombol yang sedang diklik
            event.currentTarget.classList.add('active');

            // Tampilkan panel tabel yang dipilih berdasarkan ID
            document.getElementById(statusId).classList.add('active');
        }