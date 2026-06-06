<?php

namespace App\Services;

use App\Models\Pembayaran;
use App\Models\Pesanan;
use App\Repositories\KeuanganRepository;
use App\Repositories\PembayaranRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PembayaranService
{
    public function __construct(
        protected PembayaranRepository $repository,
        protected KeuanganRepository $keuanganRepository,
        protected MidtransService $midtransService
    ) {}

    public function getAll(string $search = ''): Collection
    {
        return $this->repository->getAll($search);
    }

    public function findById(int $id): ?Pembayaran
    {
        return $this->repository->findById($id);
    }

    public function findByOrderId(string $orderId): ?Pembayaran
    {
        return $this->repository->findByOrderId($orderId);
    }

    /**
     * Pembayaran manual
     */
    public function store(array $data): Pembayaran
    {
        return DB::transaction(function () use ($data) {

            $pembayaran = $this->repository->create([
                'id_pesanan'         => $data['id_pesanan'],
                'harga_pembayaran'   => $data['harga_pembayaran'],
                'tanggal_pembayaran' => $data['tanggal_pembayaran'],
                'status_pembayaran'  => 'settlement',
            ]);

            $this->keuanganRepository->create([
                'id_pembayaran' => $pembayaran->id_pembayaran,
                'tanggal'       => $pembayaran->tanggal_pembayaran,
                'jenis'         => 'Pemasukan',
                'kategori'      => 'Cucian Biasa',
                'jumlah'        => $pembayaran->harga_pembayaran,
                'keterangan'    => 'Pembayaran pesanan #' . $pembayaran->id_pesanan,
                'id_pekerja'    => Auth::guard('pekerja')->user()->id_pekerja,
            ]);

            return $pembayaran;
        });
    }

    /**
     * Pembayaran Online via Midtrans Snap
     */
    public function storeViaMidtrans(
        array $data,
        array $customer
    ): Pembayaran {

        return DB::transaction(function () use ($data, $customer) {

            $pembayaran = $this->repository->create([
                'id_pesanan'         => $data['id_pesanan'],
                'harga_pembayaran'   => $data['harga_pembayaran'],
                'tanggal_pembayaran' => now(),
                'midtrans_order_id'  => 'PAY-' . $data['id_pesanan'] . '-' . Str::upper(Str::random(8)),
                'payment_type'       => 'snap',
                'status_pembayaran'  => 'pending',
            ]);

            $snapToken = $this->midtransService->createSnapToken(
                $pembayaran,
                $customer
            );

            $this->repository->update(
                $pembayaran->id_pembayaran,
                [
                    'snap_token' => $snapToken,
                    'expired_at' => now()->addDay(),
                ]
            );

            return $pembayaran->fresh();
        });
    }

    /**
     * Handle Webhook Midtrans
     */
    public function handleWebhook(array $notifData): void
    {
        DB::transaction(function () use ($notifData) {

            $pembayaran = $this->repository
                ->findByOrderId($notifData['order_id']);

            if (! $pembayaran) {
                return;
            }

            $alreadySettled =
                $pembayaran->status_pembayaran === 'settlement';

            $this->repository->update(
                $pembayaran->id_pembayaran,
                [
                    'midtrans_transaction_id' =>
                    $notifData['transaction_id'] ?? null,

                    'payment_type' =>
                    $notifData['payment_type'] ?? 'snap',

                    'status_pembayaran' =>
                    $notifData['status'],

                    'tanggal_pembayaran' =>
                    $notifData['status'] === 'settlement'
                        ? now()
                        : $pembayaran->tanggal_pembayaran,
                ]
            );

            if (
                ! $alreadySettled &&
                $notifData['status'] === 'settlement'
            ) {

                $pembayaran->refresh();

                $this->keuanganRepository->create([
                    'id_pembayaran' => $pembayaran->id_pembayaran,
                    'tanggal'       => $pembayaran->tanggal_pembayaran,
                    'jenis'         => 'Pemasukan',
                    'kategori'      => 'Cucian Biasa',
                    'jumlah'        => $pembayaran->harga_pembayaran,
                    'keterangan'    => 'Pembayaran online pesanan #' . $pembayaran->id_pesanan,
                    'id_pekerja'    => null,
                ]);

                if ($pembayaran->pesanan) {

                    $pembayaran->pesanan()->update([
                        'status' => 'dibayar',
                    ]);
                }
            }
        });
    }

    /**
     * Update Pembayaran Manual
     */
    public function update(
        int $id,
        array $data
    ): Pembayaran {

        return $this->repository->update(
            $id,
            [
                'id_pesanan'         => $data['id_pesanan'],
                'harga_pembayaran'   => $data['harga_pembayaran'],
                'tanggal_pembayaran' => $data['tanggal_pembayaran'],
            ]
        );
    }

    public function destroy(int $id): void
    {
        $this->repository->delete($id);
    }

    public function getAllPesanan(): Collection
    {
        return Pesanan::select('id_pesanan')
            ->oldest('id_pesanan')
            ->get();
    }
}
