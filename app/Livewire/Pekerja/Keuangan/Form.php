<?php

namespace App\Livewire\Pekerja\Keuangan;

use App\Services\KeuanganService;
use Livewire\Attributes\On;
use Livewire\Component;

class Form extends Component
{
    public bool $showModal = false;
    public string $mode = 'create';
    public ?int $editId = null;

    // Form fields
    public ?int $id_pembayaran = null;
    public string $tanggal = '';
    public string $jenis = '';
    public string $kategori = '';
    public string $jumlah = '';
    public string $keterangan = '';
    public ?int $id_pekerja = null;

    // Dropdown data
    public $pembayaranList = [];
    public $pekerjaList = [];
    public $jenisList = [];
    public $kategoriList = [];

    protected function rules(): array
    {
        return [
            'id_pembayaran' => 'nullable|exists:pembayaran,id_pembayaran',
            'tanggal'       => 'required|date',
            'jenis'         => 'required|in:Pemasukan,Pengeluaran',
            'kategori'      => 'required|in:Cucian Cepat,Cucian Biasa,Perbaikan,Gaji,Listrik,Air,Lingkungan',
            'jumlah'        => 'required|numeric|min:0',
            'keterangan'    => 'required|string|max:1000',
            'id_pekerja'    => 'required|exists:pekerja,id_pekerja',
        ];
    }

    protected function messages(): array
    {
        return [
            'id_pembayaran.exists'   => 'Pembayaran tidak valid.',
            'tanggal.required'       => 'Tanggal wajib diisi.',
            'tanggal.date'           => 'Format tanggal tidak valid.',
            'jenis.required'         => 'Jenis wajib dipilih.',
            'jenis.in'               => 'Jenis tidak valid.',
            'kategori.required'      => 'Kategori wajib dipilih.',
            'kategori.in'            => 'Kategori tidak valid.',
            'jumlah.required'        => 'Jumlah wajib diisi.',
            'jumlah.numeric'         => 'Jumlah harus berupa angka.',
            'jumlah.min'             => 'Jumlah tidak boleh negatif.',
            'keterangan.required'    => 'Keterangan wajib diisi.',
            'keterangan.max'         => 'Keterangan maksimal 1000 karakter.',
            'id_pekerja.required'    => 'Pekerja wajib dipilih.',
            'id_pekerja.exists'      => 'Pekerja tidak valid.',
        ];
    }

    #[On('open-form-keuangan')]
    public function openModal(
        string $mode,
        ?int $id,
        KeuanganService $service
    ): void {
        $this->resetForm();

        $this->mode           = $mode;
        $this->editId         = $id;
        $this->pembayaranList = $service->getAllPembayaran();
        $this->pekerjaList    = $service->getAllPekerja();
        $this->jenisList      = $service->getJenisOptions();
        $this->kategoriList   = $service->getKategoriOptions();

        if ($mode === 'edit' && $id) {
            $data = $service->findById($id);

            $this->id_pembayaran = $data->id_pembayaran;
            $this->tanggal       = \Carbon\Carbon::parse($data->tanggal)
                ->format('Y-m-d\TH:i');

            $this->jenis      = $data->jenis;
            $this->kategori   = $data->kategori;
            $this->jumlah     = $data->jumlah;
            $this->keterangan = $data->keterangan;
            $this->id_pekerja = $data->id_pekerja;
        }

        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function save(KeuanganService $service): void
    {
        $this->validate();

        $data = [
            'id_pembayaran' => $this->id_pembayaran ?: null,
            'tanggal'       => $this->tanggal,
            'jenis'         => $this->jenis,
            'kategori'      => $this->kategori,
            'jumlah'        => $this->jumlah,
            'keterangan'    => $this->keterangan,
            'id_pekerja'    => $this->id_pekerja,
        ];

        if ($this->mode === 'edit' && $this->editId) {

            $service->update($this->editId, $data);

            session()->flash(
                'success',
                'Data keuangan berhasil diperbarui.'
            );
        } else {

            $service->store($data);

            session()->flash(
                'success',
                'Data keuangan berhasil ditambahkan.'
            );
        }

        $this->closeModal();

        $this->dispatch('keuangan-saved');
    }

    private function resetForm(): void
    {
        $this->reset([
            'id_pembayaran',
            'tanggal',
            'jenis',
            'kategori',
            'jumlah',
            'keterangan',
            'id_pekerja',
            'editId',
            'pembayaranList',
            'pekerjaList',
            'jenisList',
            'kategoriList',
        ]);

        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.pekerja.keuangan.form');
    }
}
