<div class="p-4">
    <h3 class="mb-3 font-semibold text-lg">Peta Interaktif Lokasi</h3>
    
    <div id="map" wire:ignore></div>

    <script>
        document.addEventListener('livewire:navigated', () => {
            // 1. Inisialisasi Peta (Set pusat peta ke koordinat Indonesia secara umum)
            const map = L.map('map').setView([-2.5489, 118.0149], 5);

            // 2. Tambahkan Lapisan Peta (OpenStreetMap Tile)
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // 3. Ambil data locations dari properti Livewire ke JavaScript
            const locations = @json($locations);

            // 4. Perulangan untuk membuat marker di peta
            locations.forEach(location => {
                L.marker([location.lat, location.lng])
                    .addTo(map)
                    .bindPopup(`<b>${location.name}</b><br>Koordinat: ${location.lat}, ${location.lng}`);
            });
        });
    </script>
</div>