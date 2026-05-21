<?php

namespace App\Http\Controllers;

use App\Http\Requests\PesananRequest;
use App\Models\Pesanan;
use App\Models\Pemesanan;
use App\Models\Pelanggan;
use App\Services\PesananService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class PesananController extends Controller
{
    public function __construct(
        protected PesananService $pesananService
    ) {}

    public function index(): View
    {
        $pesanans = $this->pesananService->getAll();

        return view('pekerja.pesanan.index', compact('pesanans'));
    }

    public function show(Pesanan $pesanan): View
    {
        return view('pekerja.pesanan.show', compact('pesanan'));
    }

    public function create(): View
    {
        $pemesanans = Pemesanan::with('pelanggan')->get();
        $pelanggans = Pelanggan::all();

        return view('pekerja.pesanan.create', compact('pemesanans', 'pelanggans'));
    }

    public function store(PesananRequest $request): RedirectResponse
    {
        $this->pesananService->create($request->validated());

        return redirect()->route('pekerja.pesanan.index')
            ->with('success', 'Pesanan berhasil ditambahkan.');
    }

    public function edit(Pesanan $pesanan): View
    {
        $pemesanans = Pemesanan::with('pelanggan')->get();
        $pelanggans = Pelanggan::all();

        return view('pekerja.pesanan.edit', compact('pesanan', 'pemesanans', 'pelanggans'));
    }

    public function update(PesananRequest $request, Pesanan $pesanan): RedirectResponse
    {
        $this->pesananService->update($pesanan->id_pesanan, $request->validated());

        return redirect()->route('pekerja.pesanan.index')
            ->with('success', 'Data pesanan berhasil diperbarui.');
    }

    public function destroy(Pesanan $pesanan): RedirectResponse
    {
        $this->pesananService->delete($pesanan->id_pesanan);

        return redirect()->route('pekerja.pesanan.index')
            ->with('success', 'Pesanan berhasil dihapus.');
    }
}
