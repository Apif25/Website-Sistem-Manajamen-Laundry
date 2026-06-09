<div class="split-container">
    <a href="{{ route('pelanggan.produk') }}" class="split-card card-produk" wire:navigate>
        <img src="{{ asset('img/produk & layanan/produk bg.jpg') }}" alt="Produk">
        <div class="content">
            <h1>PRODUK</h1>
            <span class="btn-lihat">Lihat Semua <i class="arrow-icon"></i></span>
        </div>
    </a>
    
    <a href="{{ route('pelanggan.layanan') }}" class="split-card card-layanan" wire:navigate>
        <img src="{{ asset('img/produk & layanan/layanan bg.jpg') }}" alt="Layanan">
        <div class="content">
            <h1>LAYANAN</h1>
            <span class="btn-lihat">Lihat Semua <i class="arrow-icon"></i></span>
        </div>
    </a>
</div>
