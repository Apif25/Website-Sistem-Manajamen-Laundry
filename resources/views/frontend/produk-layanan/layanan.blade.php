<div>
    <div class="top-container" style="margin-bottom: 50px;">
        <img src="{{ asset('img/produk & layanan/Layanan bg.jpg') }}" alt="Layanan" class="bg-hero-image">
        <div class="top-container-text" style="position: absolute; bottom: 20px; left: 20px; color: white;">
            <h1>LAYANAN KAMI</h1>
        </div>
    </div>

    <div class="tabs-container">
        <button 
            wire:click="setTab('kiloan')" 
            class="tab-btn-order {{ $activeTab === 'kiloan' ? 'active' : '' }}">
            Layanan Kiloan
        </button>
        <button 
            wire:click="setTab('satuan')" 
            class="tab-btn-order {{ $activeTab === 'satuan' ? 'active' : '' }}">
            Layanan Satuan
        </button>
    </div>

    <div class="table-content">
        
        @if($activeTab === 'kiloan')
            <div class="table-panel active" wire:key="tab-kiloan">
                <div class="table-responsive">
                    <table class="order-table">
                        <thead>
                            <tr>
                                <th>Jenis Layanan</th>
                                <th>Estimasi Selesai</th>
                                <th>Harga / Kg</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="customer-name">Reguler Kiloan</span></td>
                                <td>2 - 3 Hari</td>
                                <td><span class="order-id">Rp 7.000</span></td>
                            </tr>
                            <tr>
                                <td><span class="customer-name">Kilat Kiloan (Express)</span></td>
                                <td><span class="badge-status diproses" style="text-transform: none;">24 Jam</span></td>
                                <td><span class="order-id">Rp 12.000</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p style="font-size: 13px; color: #64748b; margin-top: 15px; font-style: italic;">
                    * Catatan: Berlaku minimal order 3 kg per nota.
                </p>
            </div>
        @endif

        @if($activeTab === 'satuan')
            <div class="table-panel active" wire:key="tab-satuan">
                <div class="table-responsive">
                    <table class="order-table">
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th>Harga Reguler (2-3 Hari)</th>
                                <th>Harga Kilat (24 Jam)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="category-divider-row">
                                <td colspan="3"><strong>PAKAIAN & FORMAL WEAR</strong></td>
                            </tr>
                            <tr>
                                <td><span class="customer-name">Kemeja / Blus</span></td>
                                <td>Rp 12.000 / pcs</td>
                                <td><span class="order-id">Rp 20.000 / pcs</span></td>
                            </tr>
                            <tr>
                                <td><span class="customer-name">Celana Panjang / Jeans</span></td>
                                <td>Rp 15.000 / pcs</td>
                                <td><span class="order-id">Rp 25.000 / pcs</span></td>
                            </tr>
                            <tr>
                                <td><span class="customer-name">Jas / Blazer</span></td>
                                <td>Rp 35.000 / pcs</td>
                                <td><span class="order-id">Rp 55.000 / pcs</span></td>
                            </tr>
                            <tr class="category-divider-row">
                                <td colspan="3"><strong>PERLENGKAPAN RUMAH TANGGA</strong></td>
                            </tr>
                            <tr>
                                <td><span class="customer-name">Bed Cover (King Size)</span></td>
                                <td>Rp 45.000 / pcs</td>
                                <td><span class="order-id">Rp 75.000 / pcs</span></td>
                            </tr>
                            <tr>
                                <td><span class="customer-name">Selimut Tebal</span></td>
                                <td>Rp 25.000 / pcs</td>
                                <td><span class="order-id">Rp 40.000 / pcs</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

    </div>
</div>