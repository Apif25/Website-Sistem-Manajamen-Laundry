<?php

namespace App\Http\Controllers;

use App\Services\PembayaranService;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function __construct(protected PembayaranService $service) {}

    /**
     * Tampilkan halaman index pembayaran (full-page Livewire).
     */
    public function index()
    {
        return view('livewire.pekerja.pembayaran-index');
    }
}
