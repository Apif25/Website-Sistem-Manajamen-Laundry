<div class="max-w-md mx-auto mt-10 px-4">

    {{-- STEP: SELECT --}}
    @if($step === 'select')
    <div class="bg-white rounded-xl shadow p-6">

        <h2 class="text-xl font-bold text-gray-800 mb-1">Pembayaran</h2>

        <p class="text-sm text-gray-500 mb-1">
            Pesanan #{{ $this->pesanan->id_pesanan }}
        </p>

        <p class="text-2xl font-bold text-blue-600 mb-6">
            Rp {{ number_format($this->pesanan->total_harga, 0, ',', '.') }}
        </p>

        @if($errorMessage)
        <div class="bg-red-50 border border-red-200 text-red-600 text-sm rounded-lg px-4 py-3 mb-4">
            {{ $errorMessage }}
        </div>
        @endif

        <p class="text-sm font-medium text-gray-700 mb-3">
            Pilih Metode Pembayaran
        </p>

        <div class="grid grid-cols-2 gap-3 mb-6">

            <button
                type="button"
                wire:click="$set('paymentType', 'qris')"
                class="border-2 rounded-xl p-4 transition
                    {{ $paymentType === 'qris' ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}">

                <div class="text-2xl mb-1">▣</div>
                <div class="text-sm font-semibold">QRIS</div>
                <div class="text-xs text-gray-400">E-wallet</div>

            </button>

            <button
                type="button"
                wire:click="$set('paymentType', 'gopay')"
                class="border-2 rounded-xl p-4 transition
                    {{ $paymentType === 'gopay' ? 'border-green-500 bg-green-50' : 'border-gray-200' }}">

                <div class="text-2xl mb-1">💚</div>
                <div class="text-sm font-semibold">GoPay</div>
                <div class="text-xs text-gray-400">Gojek</div>

            </button>

        </div>

        @error('paymentType')
        <p class="text-red-500 text-xs mb-3">{{ $message }}</p>
        @enderror

        <button
            wire:click="bayar"
            wire:loading.attr="disabled"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl">

            <span wire:loading.remove wire:target="bayar">
                Bayar Sekarang
            </span>

            <span wire:loading wire:target="bayar">
                Memproses...
            </span>

        </button>

    </div>
    @endif

    {{-- STEP: WAITING --}}
    @if($step === 'waiting')
    <div class="bg-white rounded-xl shadow p-6 text-center"
        wire:poll.5000ms="checkStatus">

        <div class="bg-yellow-100 text-yellow-700 text-xs px-3 py-1 rounded-full inline-block mb-4">
            Menunggu Pembayaran
        </div>

        <h2 class="text-lg font-bold mb-2">
            Selesaikan Pembayaran
        </h2>

        <p class="text-sm text-gray-500 mb-2">
            Rp {{ number_format($this->pesanan->total_harga, 0, ',', '.') }}
        </p>

        @if($expiredAt)
        <p class="text-xs text-red-500 mb-4">
            Berlaku sampai: {{ $expiredAt }}
        </p>
        @endif

        @if($qrCodeUrl)
        <p class="text-sm mb-3">Scan QRIS:</p>

        <img
            src="{{ $qrCodeUrl }}"
            class="mx-auto w-52 h-52 border rounded-lg"
            alt="QRIS">
        @endif

        @if($deeplinkUrl)
        <p class="text-sm mt-4 mb-2">Atau buka GoPay:</p>

        <a
            href="{{ $deeplinkUrl }}"
            target="_blank"
            class="inline-block bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg">

            Buka GoPay
        </a>
        @endif

        <p class="text-xs text-gray-400 mt-5">
            Auto update setiap 5 detik...
        </p>

    </div>
    @endif

    {{-- STEP: SUCCESS --}}
    @if($step === 'success')
    <div class="bg-white rounded-xl shadow p-6 text-center">

        <div class="text-5xl mb-3">✅</div>

        <h2 class="text-xl font-bold text-green-600 mb-2">
            Pembayaran Berhasil
        </h2>

        <p class="text-sm text-gray-500 mb-2">
            Pesanan #{{ $this->pesanan->id_pesanan }}
        </p>

        <p class="text-lg font-bold mb-5">
            Rp {{ number_format($this->pembayaran->harga_pembayaran, 0, ',', '.') }}
        </p>

        <a
            href="{{ route('pekerja.pesanan.index') }}"
            class="block bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl">

            Kembali ke Pesanan
        </a>

    </div>
    @endif

    {{-- STEP: FAILED --}}
    @if($step === 'failed')
    <div class="bg-white rounded-xl shadow p-6 text-center">

        <div class="text-5xl mb-3">❌</div>

        <h2 class="text-xl font-bold text-red-600 mb-2">
            Pembayaran Gagal
        </h2>

        <p class="text-sm text-gray-500 mb-4">
            Status: {{ $statusPembayaran }}
        </p>

        <button
            wire:click="ulangi"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl">

            Coba Lagi
        </button>

    </div>
    @endif

</div>