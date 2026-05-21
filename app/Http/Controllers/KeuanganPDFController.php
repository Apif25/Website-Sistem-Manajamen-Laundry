<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class KeuanganPdfController extends Controller
{
    public function generate(Request $request)
    {
        // Ambil bulan & tahun dari URL
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;

        // Ambil data keuangan berdasarkan bulan & tahun
        $data = Keuangan::query()
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->latest('tanggal')
            ->get();

        $totalPemasukan = $data
            ->where('jenis', 'Pemasukan')
            ->sum('jumlah');

        $totalPengeluaran = $data
            ->where('jenis', 'Pengeluaran')
            ->sum('jumlah');

        $saldo = $totalPemasukan - $totalPengeluaran;
        $namaBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        
        $pdf = Pdf::loadView('pdf.keuangan', [
            'data' => $data,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'namaBulan' => $namaBulan[$bulan] ?? '',
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
            'saldo' => $saldo,
        ])->setPaper('A4', 'portrait');

        // Download PDF
        return $pdf->download(
            'laporan-keuangan-' . $bulan . '-' . $tahun . '.pdf'
        );
    }
}
