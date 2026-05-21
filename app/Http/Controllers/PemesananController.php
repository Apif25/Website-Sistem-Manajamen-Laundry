<?php

namespace App\Http\Controllers;

use App\Http\Requests\PemesananRequest;
use App\Models\Pemesanan;
use App\Models\Pelanggan;
use App\Services\PemesananService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class PemesananController extends Controller
{
    public function __construct(
        protected PemesananService $pemesananService
    ) {}

    public function index(): View
    {
        $pemesanans = $this->pemesananService->getAll();

        return view('pekerja.pemesanan.index', compact('pemesanans'));
    }

    public function show(Pemesanan $pemesanan): View
    {
        return view('pekerja.pemesanan.show', compact('pemesanan'));
    }

    public function create(): View
    {
        $pelanggans = Pelanggan::all();

        return view('pekerja.pemesanan.create', compact('pelanggans'));
    }

    public function store(PemesananRequest $request): RedirectResponse
    {
        $this->pemesananService->create($request->validated());

        return redirect()->route('pekerja.pemesanan.index')
            ->with('success', 'Pemesanan berhasil ditambahkan.');
    }

    public function edit(Pemesanan $pemesanan): View
    {
        $pelanggans = Pelanggan::all();

        return view('pekerja.pemesanan.edit', compact('pemesanan', 'pelanggans'));
    }

    public function update(PemesananRequest $request, Pemesanan $pemesanan): RedirectResponse
    {
        $this->pemesananService->update($pemesanan->id_pemesanan, $request->validated());

        return redirect()->route('pekerja.pemesanan.index')
            ->with('success', 'Data pemesanan berhasil diperbarui.');
    }

    public function destroy(Pemesanan $pemesanan): RedirectResponse
    {
        $this->pemesananService->delete($pemesanan->id_pemesanan);

        return redirect()->route('pekerja.pemesanan.index')
            ->with('success', 'Pemesanan berhasil dihapus.');
    }
}
