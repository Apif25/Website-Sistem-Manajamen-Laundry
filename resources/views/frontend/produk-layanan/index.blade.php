<div class="split-container">
    <a href="{{ route('pelanggan.produk') }}" class="split-card card-product" wire:navigate>
        <img src="{{ asset('img/produk & layanan/produk bg.jpg') }}" alt="Produk">
        <div class="content">
            <h1>PRODUK</h1>
            <span class="btn-view">Lihat Semua <i class="arrow-icon"></i></span>
        </div>
    </a>
    
    <a href="{{ route('pelanggan.layanan') }}" class="split-card card-service" wire:navigate>
        <img src="{{ asset('img/produk & layanan/layanan bg.jpg') }}" alt="Layanan">
        <div class="content">
            <h1>LAYANAN</h1>
            <span class="btn-view">Lihat Semua <i class="arrow-icon"></i></span>
        </div>
    </a>
</div>
