<?php
// app/Http/Controllers/WebhookController.php

namespace App\Http\Controllers;

use App\Services\MidtransService;
use App\Services\PembayaranService;

class WebhookController extends Controller
{
    public function __construct(
        private MidtransService   $midtransService,
        private PembayaranService $pembayaranService
    ) {}

    public function midtrans()
    {
        try {
            $notifData = $this->midtransService->handleNotification();
            $this->pembayaranService->handleWebhook($notifData);

            return response()->json(['status' => 'ok'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}