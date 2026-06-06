<?php

namespace App\Services;

use App\Models\Pembayaran;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$clientKey    = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = true;
        Config::$is3ds        = true;
    }

    /**
     * Generate Snap Token
     */
    public function createSnapToken(
        Pembayaran $pembayaran,
        array $customer
    ): string {

        $params = [
            'transaction_details' => [
                'order_id'     => $pembayaran->midtrans_order_id,
                'gross_amount' => (int) $pembayaran->harga_pembayaran,
            ],

            'customer_details' => [
                'first_name' => $customer['first_name'] ?? 'Customer',
                'email'      => $customer['email'] ?? 'customer@example.com',
                'phone'      => $customer['phone'] ?? '08123456789',
            ],

            'callbacks' => [
                'finish' => route('pekerja.pembayaran.finish'),
            ],
        ];

        return Snap::getSnapToken($params);
    }

    /**
     * Handle Midtrans Notification
     */
    public function handleNotification(): array
    {
        $notif = new Notification();

        return [
            'order_id'            => $notif->order_id,
            'transaction_id'      => $notif->transaction_id,
            'payment_type'        => $notif->payment_type,
            'transaction_status'  => $notif->transaction_status,
            'fraud_status'        => $notif->fraud_status ?? null,
            'status'              => $this->resolveStatus(
                $notif->transaction_status,
                $notif->fraud_status ?? null
            ),
        ];
    }

    /**
     * Convert Midtrans Status
     */
    private function resolveStatus(
        string $transactionStatus,
        ?string $fraudStatus
    ): string {

        if ($transactionStatus === 'capture') {
            return $fraudStatus === 'accept'
                ? 'settlement'
                : 'pending';
        }

        return match ($transactionStatus) {
            'settlement' => 'settlement',
            'pending'    => 'pending',
            'deny'       => 'deny',
            'cancel'     => 'cancel',
            'expire'     => 'expire',
            default      => 'pending',
        };
    }
}
