<div>
    <link rel="stylesheet" href="{{ asset('templates/frontend/assets/compiled/css/tracker.css') }}">

    <div class="top-container">
        <img src="{{ asset('img/pesanan/section1.png') }}" alt="Detail Pesanan" class="bg-hero-image">
        <div class="top-container-text">
            <h1>Detail Pesanan #ORD-{{ $pemesanan->id_pemesanan }}</h1>
        </div>
    </div>

    <div class="main-container">
        
        @php
            $steps = ['Menunggu', 'Penjemputan', 'Pencucian', 'Penyetrikaan', 'Pengantaran', 'Selesai'];
            $stepLabels = [
                'Menunggu' => 'Pemesanan Diterima',
                'Penjemputan' => 'Penjemputan Cucian',
                'Pencucian' => 'Proses Pencucian',
                'Penyetrikaan' => 'Proses Penyetrikaan',
                'Pengantaran' => 'Pengantaran Cucian',
                'Selesai' => 'Selesai'
            ];
            
            $activeStepIndex = 0;
            $isCancelled = $pemesanan->status_pemesanan === 'Dibatalkan';
            $isProcessed = $pemesanan->pesanan !== null;
            
            if ($isProcessed && $pemesanan->pesanan->proses) {
                $currentStepName = $pemesanan->pesanan->proses->proses;
                $foundIndex = array_search($currentStepName, $steps);
                if ($foundIndex !== false) {
                    $activeStepIndex = $foundIndex;
                }
            }
        @endphp

        <div class="detail-container">
            <h3 class="detail-section-title">
                <img src="{{ asset('img/icon/Purchase Order.png') }}" alt="Status" style="width: 20px; height: 20px;">
                Status Lacak Cucian
            </h3>

            @if($isCancelled)
                <div style="padding: 15px; border: 1px solid #fca5a5; background-color: #fef2f2; border-radius: 8px; color: #b91c1c; font-weight: 600; text-align: center;">
                    ❌ PEMESANAN INI TELAH DIBATALKAN
                </div>
            @else
                <div class="tracker-steps">
                    @foreach($steps as $index => $step)
                        @php
                            $class = '';
                            $isMainOrderSelesai = $pemesanan->status_pemesanan === 'Selesai';

                            // Cek jika langkah ini sudah terlewati atau orderan utama sudah berstatus Selesai
                            if ($index < $activeStepIndex || ($isMainOrderSelesai && $step === 'Selesai')) {
                                $class = 'completed';
                            } elseif ($index === $activeStepIndex && !$isMainOrderSelesai) {
                                $class = 'active';
                            }
                        @endphp
                        <div class="tracker-step-item {{ $class }}">
                            <div class="step-node">
                                @if($index < $activeStepIndex || ($isMainOrderSelesai && $step === 'Selesai'))
                                    ✓
                                @else
                                    {{ $index + 1 }}
                                @endif
                            </div>
                            <span class="step-label">{{ $stepLabels[$step] }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="detail-card-grid">
            
            <div class="profile-card">
                <h3 class="card-title">Informasi Pemesanan</h3>
                <div class="info-list">
                    <div class="info-item">
                        <span class="info-label">ID Pemesanan:</span>
                        <span class="info-value">#ORD-{{ $pemesanan->id_pemesanan }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Tanggal Booking:</span>
                        <span class="info-value">{{ \Carbon\Carbon::parse($pemesanan->tanggal_pemesanan)->translatedFormat('d F Y') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Jenis Pemesanan:</span>
                        <span class="info-value">{{ $pemesanan->jenis_pemesanan }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Layanan Pemesanan:</span>
                        <span class="info-value">{{ $pemesanan->layanan_pemesanan }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Estimasi Barang:</span>
                        <span class="info-value">{{ $pemesanan->jumlah_brg }} Pcs</span>
                    </div>
                    <div class="info-item" style="border-bottom: none;">
                        <span class="info-label">Status Booking:</span>
                        <span class="info-value">
                            <span class="badge-status {{ strtolower($pemesanan->status_pemesanan) }}">
                                {{ $pemesanan->status_pemesanan }}
                            </span>
                        </span>
                    </div>
                </div>
            </div>

            <div class="profile-card">
                <h3 class="card-title">Alamat Penjemputan / Pengiriman</h3>
                <div class="info-list">
                    @if($pemesanan->alamat)
                        <div class="info-item">
                            <span class="info-label">Label Alamat:</span>
                            <span class="info-value">{{ $pemesanan->alamat->label_alamat }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Provinsi:</span>
                            <span class="info-value">{{ ucwords(strtolower(\Laravolt\Indonesia\Models\Province::find($pemesanan->alamat->province_id)?->name ?? '-')) }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Kota/Kabupaten:</span>
                            <span class="info-value">{{ ucwords(strtolower(\Laravolt\Indonesia\Models\City::find($pemesanan->alamat->regency_id)?->name ?? '-')) }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Kecamatan:</span>
                            <span class="info-value">{{ ucwords(strtolower(\Laravolt\Indonesia\Models\District::find($pemesanan->alamat->district_id)?->name ?? '-')) }}</span>
                        </div>
                        <div class="info-item" style="border-bottom: none; flex-direction: column; gap: 5px;">
                            <span class="info-label">Alamat Lengkap:</span>
                            <span class="info-value" style="text-align: left; margin-top: 5px; font-weight: normal; color: #475569;">
                                {{ $pemesanan->alamat->alamat_lengkap }}
                            </span>
                        </div>
                    @else
                        <div style="color: #64748b; font-style: italic; text-align: center; padding: 20px;">
                            Alamat tidak tersedia.
                        </div>
                    @endif
                </div>
            </div>

        </div>

        @if($isProcessed)
            <div class="detail-container" style="margin-top: 30px;">
                <h3 class="detail-section-title">
                    <img src="{{ asset('img/icon/Purchase Order.png') }}" alt="Harga" style="width: 20px; height: 20px;">
                    Rincian Biaya & Pembayaran
                </h3>

                <div class="detail-card-grid" style="margin-bottom: 0;">
                    <div class="info-list">
                        <div class="info-item">
                            <span class="info-label">Berat Timbangan:</span>
                            <span class="info-value">{{ $pemesanan->pesanan->berat ?? '-' }} Kg</span>
                        </div>
                        <div class="info-item" style="border-bottom: none;">
                            <span class="info-label">Total Biaya Cucian:</span>
                            <span class="info-value" style="color: #0c7cd5; font-size: 18px; font-weight: bold;">
                                Rp {{ number_format($pemesanan->pesanan->harga ?? 0, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <div class="info-list">
                        <div class="info-item">
                            <span class="info-label">Status Pembayaran:</span>
                            <span class="info-value">
                                @php
                                    $statusBayar = $pemesanan->pesanan->pembayaran->status_pembayaran ?? 'Belum Lunas';
                                @endphp
                                <span class="badge-status {{ strtolower($statusBayar) }}">
                                    {{ $statusBayar }}
                                </span>
                            </span>
                        </div>
                        @if($pemesanan->pesanan->pembayaran && $pemesanan->pesanan->pembayaran->tanggal_pembayaran)
                            <div class="info-item" style="border-bottom: none;">
                                <span class="info-label">Tanggal Pembayaran:</span>
                                <span class="info-value">
                                    {{ \Carbon\Carbon::parse($pemesanan->pesanan->pembayaran->tanggal_pembayaran)->translatedFormat('d F Y H:i') }} WIB
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <div style="margin-top: 30px; text-align: left;">
            <a href="{{ route('pelanggan.pesanan_anda') }}" wire:navigate class="btn-back-tracker">
                ← Kembali ke Pesanan Anda
            </a>
        </div>

    </div>
</div>