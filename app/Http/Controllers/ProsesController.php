<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Services\ProsesService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProsesController extends Controller
{
    public function __construct(protected ProsesService $prosesService) {}

    /**
     * Tampilkan daftar semua proses.
     */
    public function index(): View
    {
        $prosesList = $this->prosesService->getAllProses();

        return view('admin.proses.index', compact('prosesList'));
    }

    /**
     * Tampilkan detail satu proses.
     */
    public function show(int $id): View
    {
        $proses = $this->prosesService->findProses($id);

        return view('admin.proses.show', compact('proses'));
    }

    /**
     * Buat proses baru untuk pesanan.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'id_pesanan' => 'required|integer|exists:pesanans,id',
        ]);

        try {
            $this->prosesService->createProses($request->id_pesanan);
            return redirect()->route('admin.proses.index')
                ->with('success', 'Proses berhasil dibuat.');
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors(['id_pesanan' => $e->getMessage()]);
        }
    }

    /**
     * Update step proses secara manual.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'proses' => 'required|in:Menunggu,Pencucian,Penyetrikaan,Pengantaran,Selesai',
        ]);

        $this->prosesService->updateProses($id, $request->proses);

        return back()->with('success', 'Proses berhasil diperbarui.');
    }

    /**
     * Majukan step ke tahap berikutnya (tombol ceklis di dashboard).
     */
    public function advance(int $id): RedirectResponse
    {
        try {
            $this->prosesService->advanceProses($id);
            return back()->with('success', 'Proses berhasil dilanjutkan ke tahap berikutnya.');
        } catch (\LogicException $e) {
            return back()->withErrors(['proses' => $e->getMessage()]);
        }
    }

    /**
     * Hapus data proses.
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->prosesService->deleteProses($id);

        return redirect()->route('admin.proses.index')
            ->with('success', 'Proses berhasil dihapus.');
    }
}
