<div>
    @if($isOpen)
        <div class="modal-overlay" id="orderModal" style="display: flex;">
            <div class="order-popup">
                <button type="button" wire:click="close" class="btn-close-order" id="close-order-popup">&times;</button>
                
                <div class="order-popup-header">
                    <div class="header-title-container">
                        <img src="{{ asset('img/icon/Truck.png') }}" alt="Truck" class="truck-icon">
                        <span class="header-title-text">LAYANAN ANTAR JEMPUT</span>
                    </div>
                </div>

                <div class="order-tabs">
                    <button type="button" wire:click="switchTab('website')" class="tab-btn {{ $activeTab === 'website' ? 'active' : '' }}">Website</button>
                    <button type="button" wire:click="switchTab('whatsapp')" class="tab-btn {{ $activeTab === 'whatsapp' ? 'active' : '' }}">Whatsapp</button>
                </div>

                <div class="order-popup-body">
                    @if($activeTab === 'website')
                        <div class="tab-content active" id="tab-website">
                            @if(auth()->guard('pelanggan')->check())
                                <form wire:submit.prevent="store">
                                    
                                    <div class="order-input-group">
                                        <label for="jenis_pemesanan">Jenis Pemesanan</label>
                                        <select id="jenis_pemesanan" wire:model="jenis_pemesanan">
                                            <option value="" hidden>Pilih Jenis Pemesanan</option>
                                            <option value="Satuan">Satuan</option>
                                            <option value="Kiloan">Kiloan</option>
                                        </select>
                                    </div>
                                    
                                    <div class="order-input-group">
                                        <label for="layanan_pemesanan">Layanan Pemesanan</label>
                                        <select id="layanan_pemesanan" wire:model="layanan_pemesanan">
                                            <option value="" hidden>Pilih Layanan Pemesanan</option>
                                            <option value="Kilat">Kilat</option>
                                            <option value="Biasa">Biasa</option>
                                        </select>
                                        @error('layanan_pemesanan') <span style="color: red; font-size: 12px;">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="order-input-grid">
                                        <div class="order-input-group">
                                            <label for="jumlah_barang">Jumlah Barang</label>
                                            <input type="number" id="jumlah_barang" wire:model="jumlah_brg" placeholder="Jumlah Barang">
                                            @error('jumlah_brg') <span style="color: red; font-size: 12px;">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="order-input-group">
                                            <label for="tanggal_pemesanan">Tanggal Pemesanan</label>
                                            <input type="date" id="tanggal_pemesanan" wire:model="tanggal_pemesanan">
                                            @error('tanggal_pemesanan') <span style="color: red; font-size: 12px;">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <!-- Pemilihan Alamat -->
                                    <div class="order-input-group">
                                        <label for="selectedAlamatId">Alamat Penjemputan / Pengiriman</label>
                                        @if(count($alamatList) > 0)
                                            <select id="selectedAlamatId" wire:model="selectedAlamatId">
                                                <option value="" hidden>Pilih Alamat</option>
                                                @foreach($alamatList as $alamat)
                                                    <option value="{{ $alamat->id_alamat }}">
                                                        {{ $alamat->formatted_alamat }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('selectedAlamatId') <span style="color: red; font-size: 12px;">{{ $message }}</span> @enderror
                                        @else
                                            <div style="padding: 12px; border: 1px solid #fca5a5; background-color: #fef2f2; border-radius: 8px; color: #b91c1c; font-size: 13px; line-height: 1.5; margin-bottom: 10px;">
                                                Anda belum memiliki alamat pengiriman. Silakan tambah alamat terlebih dahulu di <a href="{{ route('pelanggan.profile') }}" style="color: #3b82f6; font-weight: bold; text-decoration: underline;">Halaman Profil Anda</a>.
                                            </div>
                                        @endif
                                    </div>
                                    
                                    @error('jenis_pemesanan') <span style="color: red; font-size: 12px;">{{ $message }}</span> @enderror
                                    <div class="order-form-footer">
                                        <a href="#" class="btn-terms">
                                            <img src="{{ asset('img/icon/Purchase Order.png') }}" alt="Ketentuan">
                                            <span>Ketentuan Pemesanan</span>
                                        </a>
                                        @if(count($alamatList) > 0)
                                            <button type="submit" class="btn-submit-order">Kirim</button>
                                        @else
                                            <button type="button" class="btn-submit-order" style="background: #cbd5e1; cursor: not-allowed;" disabled>Kirim</button>
                                        @endif
                                    </div>
                                </form>
                            @else
                                <div style="padding: 30px 20px; text-align: center;">
                                    <p style="margin-bottom: 20px; color: #64748b; font-size: 14px;">Silakan login terlebih dahulu untuk melakukan pemesanan via website.</p>
                                    <a href="{{ route('login') }}" class="btn-submit-order" style="display: inline-block; text-decoration: none; width: auto; padding: 10px 30px; border-radius: 20px;">
                                        Login Sekarang
                                    </a>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="tab-content active" id="tab-whatsapp">
                            <div style="padding: 20px; text-align: center;">
                                <p style="margin-bottom: 15px;">Pesan lebih mudah langsung via WhatsApp Customer Service kami.</p>
                                <a href="https://wa.me/628xxxxxxxxxx" target="_blank" class="btn-submit-order" style="display: inline-block; text-decoration: none; background-color: #25D366;">
                                    Hubungi WhatsApp
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>