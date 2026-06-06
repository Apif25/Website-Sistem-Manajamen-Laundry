<?php

namespace App\Livewire\Pekerja\Pembayaran;

use App\Models\Pembayaran;
use App\Models\Pesanan;
use App\Services\PembayaranService;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('backend.layouts.app')]
class PembayaranProcess extends Component
{
    public string  $step             = 'select';
    public int     $idPesanan;
    public int     $idPembayaran     = 0;
    public string  $paymentType      = '';
    public string  $errorMessage     = '';
    public ?string $qrCodeUrl        = null;
    public ?string $deeplinkUrl      = null;
    public ?string $expiredAt        = null;
    public string  $statusPembayaran = 'pending';

    protected PembayaranService $pembayaranService;

    public function boot(PembayaranService $pembayaranService): void
    {
        $this->pembayaranService = $pembayaranService;
    }

    public function mount(int $idPesanan): void
    {
        $this->idPesanan = $idPesanan;

        // Lanjutkan jika ada pembayaran pending yang belum expired
        $existing = Pembayaran::where('id_pesanan', $idPesanan)
            ->where('status_pembayaran', 'pending')
            ->whereNotNull('midtrans_order_id')
            ->latest()
            ->first();

        if ($existing && $existing->expired_at?->isFuture()) {
            $this->loadPembayaran($existing);
            $this->step = 'waiting';
        }
    }

    #[Computed]
    public function pesanan(): Pesanan
    {
        return Pesanan::findOrFail($this->idPesanan);
    }

    public function bayar(): void
    {
        $this->resetErrorBag();
        $this->errorMessage = '';

        $this->validate([
            'paymentType' => 'required|in:qris,gopay',
        ], [
            'paymentType.required' => 'Pilih metode pembayaran terlebih dahulu.',
        ]);

        try {
            $pekerja  = auth()->guard('pekerja')->user();

            $customer = [
                'first_name' => $pekerja->nama,   // sesuaikan kolom nama pekerja kamu
                'email'      => $pekerja->email ?? 'noreply@example.com',
                'phone'      => $pekerja->telepon ?? '08000000000',
            ];

            $pembayaran = $this->pembayaranService->storeViaMidtrans([
                'id_pesanan'       => $this->idPesanan,
                'harga_pembayaran' => $this->pesanan->total_harga, // sesuaikan kolom total pesanan kamu
                'payment_type'     => $this->paymentType,
            ], $customer);

            $this->loadPembayaran($pembayaran);
            $this->step = 'waiting';
        } catch (\Exception $e) {
            $this->errorMessage = 'Gagal memproses pembayaran: ' . $e->getMessage();
        }
    }

    // Dipanggil wire:poll di blade setiap 5 detik
    public function checkStatus(): void
    {
        if ($this->step !== 'waiting' || ! $this->idPembayaran) return;

        $pembayaran = Pembayaran::find($this->idPembayaran);

        if (! $pembayaran) return;

        $this->statusPembayaran = $pembayaran->status_pembayaran;

        if ($this->statusPembayaran === 'settlement') {
            $this->step = 'success';
        } elseif (in_array($this->statusPembayaran, ['expire', 'cancel', 'deny'])) {
            $this->step = 'failed';
        }
    }

    public function ulangi(): void
    {
        $this->step             = 'select';
        $this->paymentType      = '';
        $this->errorMessage     = '';
        $this->idPembayaran     = 0;
        $this->qrCodeUrl        = null;
        $this->deeplinkUrl      = null;
        $this->expiredAt        = null;
        $this->statusPembayaran = 'pending';
    }

    private function loadPembayaran(Pembayaran $pembayaran): void
    {
        $this->idPembayaran      = $pembayaran->id_pembayaran;
        $this->qrCodeUrl         = $pembayaran->qr_code_url;
        $this->deeplinkUrl       = $pembayaran->deeplink_url;
        $this->expiredAt         = $pembayaran->expired_at?->format('H:i, d M Y');
        $this->statusPembayaran  = $pembayaran->status_pembayaran;
    }

    public function render()
    {
        return view('livewire.pekerja.pembayaran.pembayaran-process');
    }
}
