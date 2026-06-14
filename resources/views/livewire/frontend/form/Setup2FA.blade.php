<div class="register-page-container">
    <div class="register-card">

        <h2>AKTIFKAN VERIFIKASI 2 LANGKAH</h2>

        <div class="alert alert-info mb-4">
            <strong>Pendaftaran hampir selesai!</strong><br>
            Scan QR Code di bawah menggunakan aplikasi
            Google Authenticator, lalu masukkan kode OTP yang muncul.
        </div>

        @if ($qrCodeSvg)
        <div class="qr-container">
            <div class="qr-wrapper">
                {!! $qrCodeSvg !!}
            </div>
        </div>
        @endif

        <form wire:submit.prevent="enable">

            <div class="input-group">
                <label>Secret Key :</label>
                <input
                    type="text"
                    readonly
                    value="{{ $secret }}">
            </div>

            <div class="input-group">
                <label>Kode OTP Google Authenticator :</label>
                <input
                    type="text"
                    maxlength="6"
                    wire:model="otp_code"
                    placeholder="Masukkan 6 digit kode">

                @error('otp_code')
                <span class="text-danger">
                    {{ $message }}
                </span>
                @enderror
            </div>

            <div class="form-actions-group">
                <button
                    type="submit"
                    class="btn-next btn-submit-registration">

                    <span wire:loading.remove wire:target="enable">
                        SELESAIKAN PENDAFTARAN
                    </span>

                    <span wire:loading wire:target="enable">
                        MEMVERIFIKASI...
                    </span>

                </button>
            </div>

        </form>

    </div>
</div>

<style>
    .qr-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 25px 0;
    }

    .qr-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 15px;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .qr-wrapper svg {
        display: block;
        margin: 0 auto;
    }

    .alert-info {
        padding: 12px 15px;
        border-radius: 10px;
        background: #eef6ff;
        border: 1px solid #cfe2ff;
        color: #084298;
        line-height: 1.6;
    }
</style>