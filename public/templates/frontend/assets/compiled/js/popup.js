document.addEventListener('DOMContentLoaded', () => {
    // Ambil elemen modal
    const orderModal = document.getElementById('orderModal');

    // Tutup overlay jika mengeklik di luar pop up order (menggunakan Livewire)
    window.addEventListener('click', (e) => {
        if (e.target === orderModal) {
            // Memanggil fungsi close() yang ada di komponen Livewire Anda
            Livewire.dispatch('closeOrderModal'); 
        }
    });
});