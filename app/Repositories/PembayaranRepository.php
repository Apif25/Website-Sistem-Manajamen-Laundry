<?php

namespace App\Repositories;

use App\Models\Pembayaran;
use Illuminate\Database\Eloquent\Collection;

class PembayaranRepository
{
    public function __construct(protected Pembayaran $model) {}

    public function getAll(string $search = ''): Collection
    {
        return $this->model
            ->with('pesanan')
            ->oldest()
            ->when($search, function ($query) use ($search) {
                $query->where('id_pesanan', 'like', "%{$search}%")
                    ->orWhere('harga_pembayaran', 'like', "%{$search}%")
                    ->orWhere('tanggal_pembayaran', 'like', "%{$search}%");
            })
            ->get();
    }

    public function findById(int $id): Pembayaran
    {
        return $this->model->findOrFail($id);
    }

    public function findByOrderId(string $orderId)
    {
        return Pembayaran::where('midtrans_order_id', $orderId)->first();
    }

    public function create(array $data): Pembayaran
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Pembayaran
    {
        $pembayaran = $this->findById($id);
        $pembayaran->update($data);
        return $pembayaran;
    }

    public function delete(int $id): void
    {
        $this->findById($id)->delete();
    }
}
