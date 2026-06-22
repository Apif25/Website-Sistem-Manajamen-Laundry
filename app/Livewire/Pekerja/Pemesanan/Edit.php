<?php

namespace App\Livewire\Pekerja\Pemesanan;

use Livewire\Component;
use App\Models\Pelanggan;
use App\Models\Pemesanan;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Services\PemesananService;

#[Layout('backend.layouts.app')]
#[Title('Edit Pemesanan')]
class Edit extends Component
{
    public $id;

    public $id_pelanggan = '';
    public $jenis_pemesanan = '';
    public $layanan_pemesanan = '';
    public $jumlah_brg = '';
    public $tanggal_pemesanan = '';

    public $pelanggan = [];

    protected PemesananService $pemesananService;

    public function boot(PemesananService $pemesananService): void
    {
        $this->pemesananService = $pemesananService;
    }

    public function mount(Pemesanan $pemesanan): void
    {
        $this->id = $pemesanan->id_pemesanan;

        $this->pelanggan = Pelanggan::all();

        $this->id_pelanggan      = $pemesanan->id_pelanggan;
        $this->jenis_pemesanan   = $pemesanan->jenis_pemesanan;
        $this->layanan_pemesanan = $pemesanan->layanan_pemesanan;
        $this->jumlah_brg        = $pemesanan->jumlah_brg;
        $this->tanggal_pemesanan = \Carbon\Carbon::parse(
            $pemesanan->tanggal_pemesanan
        )->format('Y-m-d');
    }

    protected function rules(): array
    {
        return [
            'id_pelanggan'      => 'required|exists:pelanggan,id_pelanggan',
            'jenis_pemesanan'   => 'required|string|max:50',
            'layanan_pemesanan' => 'required|string|max:50',
            'jumlah_brg'        => 'required|integer|min:1',
            'tanggal_pemesanan' => 'required|date',
        ];
    }

    protected $messages = [
        'id_pelanggan.required'      => 'Pelanggan wajib dipilih.',
        'jenis_pemesanan.required'   => 'Jenis pemesanan wajib diisi.',
        'layanan_pemesanan.required' => 'Layanan pemesanan wajib diisi.',
        'jumlah_brg.required'        => 'Jumlah barang wajib diisi.',
        'jumlah_brg.integer'         => 'Jumlah barang harus berupa angka.',
        'tanggal_pemesanan.required' => 'Tanggal pemesanan wajib diisi.',
    ];

    public function update(): void
    {
        $validated = $this->validate();

        $this->pemesananService->update($this->id, $validated);

        session()->flash('success', 'Pemesanan berhasil diperbarui.');

        $this->redirect(route('pekerja.pemesanan.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.pekerja.pemesanan.edit');
    }
}
