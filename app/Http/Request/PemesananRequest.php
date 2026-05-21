<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PemesananRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_pelanggan'      => ['required', 'exists:Pelanggan,id_pelanggan'],
            'jenis_pemesanan'   => ['required', 'in:Kiloan,Satuan'],
            'layanan_pemesanan' => ['required', 'in:Cepat,Biasa'],
            'jumlah_brg'        => ['required', 'integer', 'min:1'],
            'tanggal_pemesanan' => ['required', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'id_pelanggan.required'      => 'Pelanggan wajib dipilih.',
            'id_pelanggan.exists'        => 'Pelanggan tidak ditemukan.',
            'jenis_pemesanan.required'   => 'Jenis pemesanan wajib dipilih.',
            'jenis_pemesanan.in'         => 'Jenis pemesanan harus Kiloan atau Satuan.',
            'layanan_pemesanan.required' => 'Layanan pemesanan wajib dipilih.',
            'layanan_pemesanan.in'       => 'Layanan pemesanan harus Cepat atau Biasa.',
            'jumlah_brg.required'        => 'Jumlah barang wajib diisi.',
            'jumlah_brg.integer'         => 'Jumlah barang harus berupa angka.',
            'jumlah_brg.min'             => 'Jumlah barang minimal 1.',
            'tanggal_pemesanan.required' => 'Tanggal pemesanan wajib diisi.',
            'tanggal_pemesanan.date'     => 'Format tanggal tidak valid.',
        ];
    }
}
