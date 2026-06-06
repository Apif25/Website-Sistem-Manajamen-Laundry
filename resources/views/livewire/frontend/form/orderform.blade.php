<div class="modal-overlay" id="orderModal">
    <div class="order-popup">
        <button class="btn-close-order" id="close-order-popup">&times;</button>
        
        <div class="order-popup-header">
            <div class="header-title-container">
                <img src="{{ asset('img/icon/Truck.png') }}" alt="Truck" class="truck-icon">
                <span class="header-title-text">LAYANAN ANTAR JEMPUT</span>
            </div>
        </div>

        <div class="order-tabs">
            <button class="tab-btn active" data-tab="website">Website</button>
            <button class="tab-btn" data-tab="whatsapp">Whatsapp</button>
        </div>

        <div class="order-popup-body">
            <div class="tab-content active" id="tab-website">
                <form id="orderForm">
                    <div class="order-input-group">
                        <label for="jenis_pemesanan">Jenis Pemesanan</label>
                        <select id="jenis_pemesanan" name="jenis_pemesanan" required>
                            <option value="" disabled selected hidden>Pilih Jenis Pemesanan</option>
                            <option value="Satuan">Satuan</option>
                            <option value="Kiloan">Kiloan</option>
                        </select>
                    </div>

                    <div class="order-input-group">
                        <label for="layanan_pemesanan">Layanan Pemesanan</label>
                        <select id="layanan_pemesanan" name="layanan_pemesanan" required>
                            <option value="" disabled selected hidden>Pilih Layanan Pemesanan</option>
                            <option value="Cepat">Cepat</option>
                            <option value="Biasa">Biasa</option>
                        </select>
                    </div>

                    <div class="order-input-grid">
                        <div class="order-input-group">
                            <label for="jumlah_barang">Jumlah Barang</label>
                            <input type="number" id="jumlah_barang" name="jumlah_barang" placeholder="Jumlah Barang" required>
                        </div>
                        <div class="order-input-group">
                            <label for="tanggal_pemesanan">Tanggal Pemesanan</label>
                            <input type="date" id="tanggal_pemesanan" name="tanggal_pemesanan" required>
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
        </div>
    </div>
</div>