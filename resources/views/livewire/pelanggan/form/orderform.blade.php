<div class="modal-overlay" id="orderModal">
    <div class="order-popup">
        <!-- Close Button -->
        <button class="btn-close-order" id="close-order-popup">&times;</button>
        
        <!-- Header -->
        <div class="order-popup-header">
            <div class="header-title-container">
                <!-- SVG Delivery Truck -->
                <svg class="truck-icon" viewBox="0 0 100 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Speed Lines -->
                    <line x1="12" y1="15" x2="32" y2="15" stroke="white" stroke-width="4" stroke-linecap="round" />
                    <line x1="5" y1="25" x2="25" y2="25" stroke="white" stroke-width="4" stroke-linecap="round" />
                    <line x1="15" y1="35" x2="30" y2="35" stroke="white" stroke-width="4" stroke-linecap="round" />
                    
                    <!-- Truck Body -->
                    <rect x="40" y="8" width="40" height="28" rx="3" fill="white" />
                    <path d="M80 15H92C94.5 15 96 17 96 20V36H80V15Z" fill="white" />
                    <path d="M84 19H90L88 26H84V19Z" fill="#2B82C9" class="window-cutout" />
                    
                    <!-- Wheels -->
                    <circle cx="52" cy="40" r="7" fill="white" />
                    <circle cx="52" cy="40" r="3" fill="#2B82C9" class="wheel-dot" />
                    
                    <circle cx="84" cy="40" r="7" fill="white" />
                    <circle cx="84" cy="40" r="3" fill="#2B82C9" class="wheel-dot" />
                </svg>
                <span class="header-title-text">LAYANAN ANTAR JEMPUT</span>
            </div>
        </div>

        <!-- Tabs -->
        <div class="order-tabs">
            <button class="tab-btn active" data-tab="website">Website</button>
            <button class="tab-btn" data-tab="whatsapp">Whatsapp</button>
        </div>

        <!-- Body Content -->
        <div class="order-popup-body">
            <!-- Tab Content: Website Form -->
            <div class="tab-content active" id="tab-website">
                <form id="orderForm">
                    <div class="order-input-group">
                        <label for="jenis_pemesanan">Jenis Pemesanan</label>
                        <select type="text" id="jenis_pemesanan" name="jenis_pemesanan" required>
                            <option value="" disabled selected hidden>Pilih Jenis Pemesanan</option>
                            <option value="Satuan">Satuan</option>
                            <option value="Kiloan">Kiloan</option>
                        </select>
                    </div>

                    <div class="order-input-group">
                        <label for="layanan_pemesanan">Layanan Pemesanan</label>
                        <select type="text" id="layanan_pemesanan" name="layanan_pemesanan" required>
                            <option value="" disabled selected hidden>Pilih Lyanan Pemesanan</option>
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
                            <input type="date" id="tanggal_pemesanan" name="tanggal_pemesanan" placeholder="Tanggal Pemesanan" required>
                        </div>
                    </div>

                    <div class="order-form-footer">
                        <a href="#" class="btn-ketentuan">
                            <svg class="doc-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="3" y="3" width="18" height="18" rx="4" fill="#2B82C9" />
                                <line x1="7" y1="8" x2="17" y2="8" stroke="white" stroke-width="2" stroke-linecap="round" />
                                <line x1="7" y1="12" x2="17" y2="12" stroke="white" stroke-width="2" stroke-linecap="round" />
                                <line x1="7" y1="16" x2="13" y2="16" stroke="white" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span>Ketentuan Pemesanan</span>
                        </a>
                        <button type="submit" class="btn-submit-order">Kirim</button>
                    </div>
                </form>
            </div>

            <!-- Tab Content: Whatsapp QR Code -->
            <div class="tab-content" id="tab-whatsapp">
                <div class="qr-container">
                    <div class="qr-card">
                        <!-- Custom SVG QR Code -->
                        <svg class="qr-code" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- Outer background -->
                            <rect width="100" height="100" fill="white"/>
                            
                            <!-- Position Patterns (Top-Left) -->
                            <rect x="8" y="8" width="28" height="28" fill="#111"/>
                            <rect x="12" y="12" width="20" height="20" fill="white"/>
                            <rect x="16" y="16" width="12" height="12" fill="#111"/>

                            <!-- Position Patterns (Top-Right) -->
                            <rect x="64" y="8" width="28" height="28" fill="#111"/>
                            <rect x="68" y="12" width="20" height="20" fill="white"/>
                            <rect x="72" y="16" width="12" height="12" fill="#111"/>

                            <!-- Position Patterns (Bottom-Left) -->
                            <rect x="8" y="64" width="28" height="28" fill="#111"/>
                            <rect x="12" y="68" width="20" height="20" fill="white"/>
                            <rect x="16" y="72" width="12" height="12" fill="#111"/>

                            <!-- Alignment Pattern -->
                            <rect x="68" y="68" width="12" height="12" fill="#111"/>
                            <rect x="71" y="71" width="6" height="6" fill="white"/>
                            <rect x="73" y="73" width="2" height="2" fill="#111"/>

                            <!-- Timing Patterns (Horizontal / Vertical dashed lines) -->
                            <rect x="38" y="12" width="4" height="4" fill="#111"/>
                            <rect x="46" y="12" width="4" height="4" fill="#111"/>
                            <rect x="54" y="12" width="4" height="4" fill="#111"/>
                            <rect x="12" y="38" width="4" height="4" fill="#111"/>
                            <rect x="12" y="46" width="4" height="4" fill="#111"/>
                            <rect x="12" y="54" width="4" height="4" fill="#111"/>

                            <!-- Random modules / bits -->
                            <rect x="38" y="20" width="4" height="4" fill="#111"/>
                            <rect x="42" y="24" width="4" height="4" fill="#111"/>
                            <rect x="50" y="20" width="4" height="8" fill="#111"/>
                            <rect x="58" y="24" width="4" height="4" fill="#111"/>
                            <rect x="46" y="32" width="8" height="4" fill="#111"/>

                            <rect x="38" y="42" width="4" height="8" fill="#111"/>
                            <rect x="46" y="46" width="8" height="4" fill="#111"/>
                            <rect x="58" y="42" width="4" height="4" fill="#111"/>
                            
                            <rect x="8" y="42" width="4" height="4" fill="#111"/>
                            <rect x="16" y="46" width="8" height="4" fill="#111"/>
                            <rect x="28" y="42" width="4" height="8" fill="#111"/>
                            <rect x="24" y="52" width="8" height="4" fill="#111"/>
                            <rect x="8" y="56" width="12" height="4" fill="#111"/>
                            
                            <rect x="42" y="56" width="8" height="4" fill="#111"/>
                            <rect x="54" y="52" width="4" height="8" fill="#111"/>

                            <rect x="68" y="38" width="8" height="4" fill="#111"/>
                            <rect x="80" y="42" width="4" height="8" fill="#111"/>
                            <rect x="88" y="38" width="4" height="4" fill="#111"/>
                            <rect x="84" y="48" width="8" height="4" fill="#111"/>

                            <rect x="42" y="68" width="4" height="4" fill="#111"/>
                            <rect x="46" y="76" width="8" height="4" fill="#111"/>
                            <rect x="54" y="68" width="4" height="8" fill="#111"/>
                            <rect x="42" y="84" width="12" height="4" fill="#111"/>

                            <rect x="68" y="84" width="4" height="4" fill="#111"/>
                            <rect x="76" y="80" width="8" height="4" fill="#111"/>
                            <rect x="84" y="84" width="4" height="4" fill="#111"/>
                            <rect x="88" y="72" width="4" height="8" fill="#111"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
