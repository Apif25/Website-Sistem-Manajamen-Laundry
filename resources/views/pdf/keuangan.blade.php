<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan</title>

    <style>
        * {
            font-family: sans-serif;
        }

        body {
            margin: 20px;
            color: #222;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header h2 {
            margin: 0;
            font-size: 24px;
        }

        .header p {
            margin: 4px 0;
            color: #666;
            font-size: 13px;
        }

        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 4px 0;
            font-size: 13px;
        }

        .summary {
            margin-bottom: 20px;
        }

        .summary-box {
            display: inline-block;
            width: 30%;
            border: 1px solid #ddd;
            padding: 10px;
            margin-right: 8px;
            border-radius: 6px;
        }

        .summary-title {
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
        }

        .summary-value {
            font-size: 16px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead {
            background: #f1f1f1;
        }

        table th,
        table td {
            border: 1px solid #dcdcdc;
            padding: 10px;
            font-size: 12px;
        }

        table th {
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .text-end {
            text-align: right;
        }

        .badge-masuk {
            color: green;
            font-weight: bold;
        }

        .badge-keluar {
            color: red;
            font-weight: bold;
        }

        .footer {
            margin-top: 50px;
        }

        .signature {
            width: 220px;
            text-align: center;
            float: right;
        }

        .signature-space {
            height: 70px;
        }
    </style>
</head>

<body>

    {{-- Header --}}
    <div class="header">
        <h2>LAPORAN KEUANGAN LAUNDRY</h2>

        <p>
            Bulan {{ $namaBulan }} {{ $tahun }}
        </p>
    </div>

    {{-- Informasi --}}
    <table class="info-table">
        <tr>
            <td width="20%">Tanggal Cetak</td>
            <td width="2%">:</td>
            <td>{{ now()->format('d M Y H:i') }}</td>
        </tr>

        <tr>
            <td>Total Data</td>
            <td>:</td>
            <td>{{ $data->count() }} transaksi</td>
        </tr>
    </table>

    {{-- Summary --}}
    <div class="summary">

        <div class="summary-box">
            <div class="summary-title">
                Total Pemasukan
            </div>

            <div class="summary-value">
                Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
            </div>
        </div>

        <div class="summary-box">
            <div class="summary-title">
                Total Pengeluaran
            </div>

            <div class="summary-value">
                Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
            </div>
        </div>

        <div class="summary-box">
            <div class="summary-title">
                Saldo
            </div>

            <div class="summary-value">
                Rp {{ number_format($saldo, 0, ',', '.') }}
            </div>
        </div>

    </div>

    {{-- Table --}}
    <table>

        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Kategori</th>
                <th>Keterangan</th>
                <th>Nominal</th>
                <th>Pekerja</th>
            </tr>
        </thead>

        <tbody>

            @forelse ($data as $item)

            <tr>

                <td class="text-center">
                    {{ $loop->iteration }}
                </td>

                <td class="text-center">
                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}
                </td>

                <td class="text-center">

                    @if ($item->jenis === 'Pemasukan')

                    <span class="badge-masuk">
                        Pemasukan
                    </span>

                    @else

                    <span class="badge-keluar">
                        Pengeluaran
                    </span>

                    @endif

                </td>

                <td class="text-center">
                    {{ $item->kategori }}
                </td>

                <td>
                    {{ $item->keterangan ?? '-' }}
                </td>

                <td class="text-end">
                    Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                </td>

                <td class="text-center">
                    {{ $item->pekerja?->nama_pekerja ?? '-' }}
                </td>

            </tr>

            @empty

            <tr>
                <td colspan="7" class="text-center">
                    Tidak ada data keuangan
                </td>
            </tr>

            @endforelse

        </tbody>

    </table>

    {{-- Footer --}}
    <div class="footer">

        <div class="signature">

            <p>
                Mengetahui,
            </p>

            <div class="signature-space"></div>

            <p>
                <strong>Admin Laundry</strong>
            </p>

        </div>

    </div>

</body>

</html>