<nav class="laundry-navbar">
    <ul class="nav-list">
        <li class="nav-item">
            <a href="{{ route('pelanggan.beranda') }}" class="nav-link" wire:navigate>
                <img src="{{ asset('img/icon/Home Page.png') }}" alt="Beranda" class="nav-icon">
                <span class="nav-text">BERANDA</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="" class="nav-link open-order-popup">
                <img src="{{ asset('img/icon/Van.png') }}" alt="Antar Jemput" class="nav-icon">
                <span class="nav-text">ANTAR JEMPUT</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pelanggan.produk_layanan') }}" class="nav-link" wire:navigate>
                <img src="{{ asset('img/icon/Clothes in Laundry.png') }}" alt="Produk & Layanan" class="nav-icon">
                <span class="nav-text">PRODUK & LAYANAN</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pelanggan.pesanan_anda') }}" class="nav-link" wire:navigate>
                <img src="{{ asset('img/icon/Purchase Order.png') }}" alt="Lokasi" class="nav-icon">
                <span class="nav-text">PESANAN ANDA</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link" wire:navigate>
                <img src="{{ asset('img/icon/People.png') }}" alt="Tentang Kami" class="nav-icon">
                <span class="nav-text">TENTANG KAMI</span>
            </a>
        </li>
        <li class="nav-item nav-photo-profile">
            <a href="{{ route('login') }}" class="photo-profile-link open-popup-login" wire:navigate>
                <img src="{{ asset('img/icon/Profile.png') }}" alt="foto profil" class="photo-profile-icon">
            </a>
        </li>
    </ul>

<!-- Responsive navigasi -->
    <ul class="bottom-navbar">
        <li class="nav-item">
            <a href="" class="nav-link open-order-popup">
                <img src="{{ asset('img/icon/Van.png') }}" alt="Antar Jemput" class="nav-icon">
                <span class="nav-text">ANTAR JEMPUT</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pelanggan.produk_layanan') }}" class="nav-link" wire:navigate>
                <img src="{{ asset('img/icon/Clothes in Laundry.png') }}" alt="Produk & Layanan" class="nav-icon">
                <span class="nav-text">PRODUK & LAYANAN</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pelanggan.beranda') }}" class="nav-link" wire:navigate>
                <img src="{{ asset('img/icon/Home Page.png') }}" alt="Beranda" class="nav-icon">
                <span class="nav-text">BERANDA</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pelanggan.pesanan_anda') }}" class="nav-link" wire:navigate>
                <img src="{{ asset('img/icon/Purchase Order.png') }}" alt="Lokasi" class="nav-icon">
                <span class="nav-text">PESANAN ANDA</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link" wire:navigate>
                <img src="{{ asset('img/icon/People.png') }}" alt="Tentang Kami" class="nav-icon">
                <span class="nav-text">TENTANG KAMI</span>
            </a>
        </li>
    </ul>

    <div class="mobile-profile">
    <a href="{{ route('login') }}" class="photo-profile-link open-popup-login" wire:navigate>
        <img src="{{ asset('img/icon/Profile.png') }}" alt="foto profil" class="mobile-profile-icon">
    </a>
    </div>
</nav>
