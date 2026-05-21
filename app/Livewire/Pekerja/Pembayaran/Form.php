<?php

namespace App\Livewire\Pekerja\Pembayaran;

use App\Services\PembayaranService;
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

    // Dropdown Data
    public $pesananList = [];

    protected function rules(): array
    {
        return [
            'id_pesanan' => 'required|exists:pesanan,id_pesanan',
            'harga_pembayaran' => 'required|numeric|min:0',
            'tanggal_pembayaran' => 'required|date',
        ];
    }

    protected function messages(): array
    {
        return [
            'id_pesanan.required' => 'Pesanan wajib dipilih.',
            'id_pesanan.exists' => 'Pesanan tidak valid.',

            'harga_pembayaran.required' => 'Harga pembayaran wajib diisi.',
            'harga_pembayaran.numeric' => 'Harga pembayaran harus berupa angka.',
            'harga_pembayaran.min' => 'Harga pembayaran tidak boleh negatif.',

            'tanggal_pembayaran.required' => 'Tanggal pembayaran wajib diisi.',
            'tanggal_pembayaran.date' => 'Format tanggal tidak valid.',
        ];
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

            $this->fill([
                'id_pesanan' => $pembayaran->id_pesanan,
                'harga_pembayaran' => (string) $pembayaran->harga_pembayaran,
                'tanggal_pembayaran' => Carbon::parse(
                    $pembayaran->tanggal_pembayaran
                )->format('Y-m-d\TH:i'),
            ]);
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

            $service->update($this->editId, $validated);

            session()->flash(
                'success',
                'Pembayaran berhasil diperbarui.'
            );
        } else {

            $service->store($validated);

            session()->flash(
                'success',
                'Pembayaran berhasil ditambahkan.'
            );
        }

        $this->closeModal();

        $this->dispatch('pembayaran-saved');
    }

    private function resetForm(): void
    {
        $this->reset([
            'id_pesanan',
            'harga_pembayaran',
            'tanggal_pembayaran',
            'editId',
        ]);

        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.pekerja.pembayaran.form');
    }
}
