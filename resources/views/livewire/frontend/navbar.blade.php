<nav class="laundry-navbar {{ auth('pelanggan')->check() ? 'user-logged-in' : '' }}">
    <ul class="nav-list">
        <li class="nav-item">
            <a href="{{ route('pelanggan.beranda') }}" class="nav-link" wire:navigate>
                <img src="{{ asset('img/icon/Home Page.png') }}" alt="Beranda" class="nav-icon">
                <span class="nav-text">BERANDA</span>
            </a>
        </li>
        <li class="nav-item">
            <a onclick="Livewire.dispatch('openOrderModal')" class="nav-link open-order-popup">
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
        
        @guest('pelanggan')
            <li class="nav-item nav-photo-profile nav-guest">
                <a href="{{ route('login') }}" class="photo-profile-link open-popup-login" wire:navigate>
                    <img src="{{ asset('img/icon/Profile.png') }}" alt="foto profil" class="photo-profile-icon">
                </a>
            </li>
        @endguest

        @auth('pelanggan')
            <li class="nav-item nav-photo-profile dropdown-wrapper" x-data="{ open: false }" @click.away="open = false">
                <button type="button" @click="open = !open" class="dropdown-trigger-btn">
                    <img src="{{ auth('pelanggan')->user()->foto_profil ? asset('storage/foto-pelanggan/' . auth('pelanggan')->user()->foto_profil) : asset('img/icon/Profile.png') }}" 
                         alt="foto profil" 
                         class="photo-profile-icon" 
                         style="object-fit: cover; border-radius: 50%;">
                </button>
        
                <div class="dropdown-menu" x-show="open" x-transition style="display: none;">
                    <a href="#" class="dropdown-item" wire:navigate>Profile</a>
                    <button type="button" wire:click="logout" class="dropdown-item logout-btn">
                        Logout
                    </button>
                </div>
            </li>
        @endauth
    </ul>

    <ul class="bottom-navbar">
        <li class="nav-item">
            <a href="javascript:void(0)" onclick="Livewire.dispatch('openOrderModal')" class="nav-link open-order-popup">
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
        @guest('pelanggan')
            <a href="{{ route('login') }}" class="photo-profile-link open-popup-login nav-guest" wire:navigate>
                <img src="{{ asset('img/icon/Profile.png') }}" alt="foto profil" class="mobile-profile-icon">
            </a>
        @endguest

        @auth('pelanggan')
            <div class="dropdown-wrapper" x-data="{ open: false }" @click.away="open = false">
                <button type="button" @click="open = !open" class="dropdown-trigger-btn">
                    <img src="{{ auth('pelanggan')->user()->foto_profil ? asset('storage/foto-pelanggan/' . auth('pelanggan')->user()->foto_profil) : asset('img/icon/Profile.png') }}" 
                         alt="foto profil" 
                         class="mobile-profile-icon" 
                         style="object-fit: cover; border-radius: 50%;">
                </button>
        
                <div class="dropdown-menu mobile-dropdown" x-show="open" x-transition style="display: none;">
                    <a href="#" class="dropdown-item" wire:navigate>Profile</a>
                    <button type="button" wire:click="logout" class="dropdown-item logout-btn">
                        Logout
                    </button>
                </div>
            </div>
        @endauth
    </div>
</nav>