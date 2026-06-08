<div>
    <button wire:click="open" class="btn-open-order">
        Pesan Sekarang
    </button>

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
                            <form wire:submit.prevent="store">
                                
                                <div class="order-input-group">
                                    <label for="jenis_pemesanan">Jenis Pemesanan</label>
                                    <select id="jenis_pemesanan" wire:model="jenis_pemesanan">
                                        <option value="" hidden>Pilih Jenis Pemesanan</option>
                                        <option value="Satuan">Satuan</option>
                                        <option value="Kiloan">Kiloan</option>
                                    </select>
                                    @error('jenis_pemesanan') <span style="color: red; font-size: 12px;">{{ $message }}</span> @enderror
                                </div>

                                <div class="order-input-group">
                                    <label for="layanan_pemesanan">Layanan Pemesanan</label>
                                    <select id="layanan_pemesanan" wire:model="layanan_pemesanan">
                                        <option value="" hidden>Pilih Layanan Pemesanan</option>
                                        <option value="Cepat">Cepat</option>
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

                                <div class="order-form-footer">
                                    <a href="#" class="btn-ketentuan">
                                        <img src="{{ asset('img/icon/Purchase Order.png') }}" alt="Ketentuan">
                                        <span>Ketentuan Pemesanan</span>
                                    </a>
                                    <button type="submit" class="btn-submit-order">Kirim</button>
                                </div>
                            </form>
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