<?php

namespace App\Livewire\Pekerja\Pembayaran;

use App\Services\PembayaranService;
use App\Models\Pesanan;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class Form extends Component
{
    public bool $showModal = false;
    public string $mode = 'create';
    public ?int $editId = null;

    // Form Fields
    public ?int $id_pesanan = null;
    public string $harga_pembayaran = '';
    public string $tanggal_pembayaran = '';

    // Midtrans Snap
    public ?string $snap_token = null;
    public ?string $status_pembayaran = null;

    // Dropdown Data
    public $pesananList = [];

    protected function rules(): array
    {
        return [
            'id_pesanan'         => 'required|exists:pesanan,id_pesanan',
            'harga_pembayaran'   => 'required|numeric|min:0',
            'tanggal_pembayaran' => 'required|date',
        ];
    }

    protected function messages(): array
    {
        return [
            'id_pesanan.required' => 'Pesanan wajib dipilih.',
            'id_pesanan.exists'   => 'Pesanan tidak valid.',

            'harga_pembayaran.required' => 'Harga pembayaran wajib diisi.',
            'harga_pembayaran.numeric'  => 'Harga pembayaran harus berupa angka.',
            'harga_pembayaran.min'      => 'Harga pembayaran tidak boleh negatif.',

            'tanggal_pembayaran.required' => 'Tanggal pembayaran wajib diisi.',
            'tanggal_pembayaran.date'     => 'Format tanggal tidak valid.',
        ];
    }

    /**
     * AUTO FILL HARGA SAAT PESANAN DIPILIH
     */
    public function updatedIdPesanan($value): void
    {
        if (empty($value)) {
            $this->harga_pembayaran = '';
            return;
        }

        $pesanan = collect($this->pesananList)
            ->firstWhere('id_pesanan', (int) $value);

        if ($pesanan) {
            $this->harga_pembayaran = (string) $pesanan->harga;
        }
    }


    #[On('open-form')]
    public function openModal(
        string $mode,
        ?int $id,
        PembayaranService $service
    ): void {

        $this->resetForm();

        $this->mode = $mode;
        $this->editId = $id;
        $this->pesananList = $service->getAllPesanan();

        if ($mode === 'edit' && $id) {

            $pembayaran = $service->findById($id);

            if ($pembayaran) {

                $this->fill([
                    'id_pesanan' => $pembayaran->id_pesanan,

                    'harga_pembayaran' => (string)
                    $pembayaran->harga_pembayaran,

                    'tanggal_pembayaran' => Carbon::parse(
                        $pembayaran->tanggal_pembayaran
                    )->format('Y-m-d\TH:i'),

                    'snap_token' => $pembayaran->snap_token,
                    'status_pembayaran' => $pembayaran->status_pembayaran,
                ]);
            }
        }

        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;

        $this->resetForm();
    }

    public function save(PembayaranService $service): void
    {
        $validated = $this->validate();

        if ($this->mode === 'edit' && $this->editId) {

            $service->update(
                $this->editId,
                [
                    'id_pesanan'         => $validated['id_pesanan'],
                    'harga_pembayaran'   => $validated['harga_pembayaran'],
                    'tanggal_pembayaran' => $validated['tanggal_pembayaran'],
                ]
            );

            session()->flash(
                'success',
                'Pembayaran berhasil diperbarui.'
            );
        } else {

            $customer = [
                'first_name' => 'Pelanggan',
                'email'      => 'noreply@example.com',
                'phone'      => '08123456789',
            ];

            $pembayaran = $service->storeViaMidtrans(
                [
                    'id_pesanan'       => $validated['id_pesanan'],
                    'harga_pembayaran' => $validated['harga_pembayaran'],
                ],
                $customer
            );

            $this->editId = $pembayaran->id_pembayaran;

            $this->snap_token = $pembayaran->snap_token;

            $this->status_pembayaran =
                $pembayaran->status_pembayaran;

            session()->flash(
                'success',
                'Transaksi Midtrans berhasil dibuat.'
            );

            $this->dispatch(
                'open-snap',
                token: $this->snap_token
            );
        }

        $this->dispatch('pembayaran-saved');
    }

    #[On('refresh-payment-status')]
    public function refreshStatus(
        PembayaranService $service
    ): void {

        if (! $this->editId) {
            return;
        }

        $pembayaran = $service->findById(
            $this->editId
        );

        if ($pembayaran) {

            $this->status_pembayaran =
                $pembayaran->status_pembayaran;

            $this->snap_token =
                $pembayaran->snap_token;
        }
    }

    private function resetForm(): void
    {
        $this->reset([
            'id_pesanan',
            'harga_pembayaran',
            'tanggal_pembayaran',
            'editId',
            'snap_token',
            'status_pembayaran',
        ]);

        $this->resetValidation();
    }

    public function render()
    {
        return view(
            'livewire.pekerja.pembayaran.form'
        );
    }
}
