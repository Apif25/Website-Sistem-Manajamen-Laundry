<div>
    <div class="top-container">
        <img src="{{ asset('img/pesanan/section1.png') }}" alt="Produk" class="bg-hero-image">
        <div class="top-container-text">
            <h1>Pesanan Anda</h1>
        </div>
    </div>

    <div class="main-container">
        <div class="tabs-container">
            <button type="button" 
                    wire:click="switchTab('Diproses')" 
                    class="tab-btn-order {{ $statusAktif == 'Diproses' ? 'active' : '' }}">
                Diproses
            </button>
            <button type="button" 
                    wire:click="switchTab('Selesai')" 
                    class="tab-btn-order {{ $statusAktif == 'Selesai' ? 'active' : '' }}">
                Selesai
            </button>
            <button type="button" 
                    wire:click="switchTab('Dibatalkan')" 
                    class="tab-btn-order {{ $statusAktif == 'Dibatalkan' ? 'active' : '' }}">
                Dibatalkan
            </button>
        </div>

        <div class="table-content">
            <div class="table-responsive" wire:loading.class="opacity-50" style="transition: opacity 0.2s ease;">
                <table class="order-table">
                    <thead>
                        <tr>
                            <th>Kode Pesanan</th>
                            <th>Tanggal</th>
                            <th>Jenis & Layanan</th>
                            <th>Jumlah Barang</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pesanan as $item)
                            <tr class="order-row" onclick="Livewire.navigate('{{ route('pelanggan.pesanan_anda.detail', $item->id_pemesanan) }}')" style="cursor: pointer;">
                                <td class="order-id">{{ $item->kode_pemesanan }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_pemesanan)->translatedFormat('d M Y') }}</td>
                                <td>
                                    <strong>{{ $item->jenis_pemesanan }}</strong><br>
                                    <span style="font-size: 12px; color: #6c757d;">{{ $item->layanan_pemesanan }}</span>
                                </td>
                                <td>{{ $item->jumlah_brg }} Pcs</td>
                                <td>
                                    <span class="badge-status {{ strtolower($item->status_pemesanan) }}">
                                        {{ $item->status_pemesanan }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 20px; color: #6c757d;">
                                    Tidak ada data pesanan yang {{ $statusAktif }}.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>