<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PesananRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_pemesanan'    => ['required', 'exists:Pemesanan,id_pemesanan'],
            'id_pelanggan'    => ['required', 'exists:Pelanggan,id_pelanggan'],
            'Jenis_Pesanan'   => ['required', 'in:Kiloan,Satuan'],
            'Layanan_Pesanan' => ['required', 'in:Cepat,Biasa'],
            'Berat'           => ['required', 'numeric', 'min:0.1'],
            'Harga'           => ['required', 'numeric', 'min:0'],
            'Tanggal_Pesanan' => ['required', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'id_pemesanan.required'    => 'Pemesanan wajib dipilih.',
            'id_pemesanan.exists'      => 'Pemesanan tidak ditemukan.',
            'id_pelanggan.required'    => 'Pelanggan wajib dipilih.',
            'id_pelanggan.exists'      => 'Pelanggan tidak ditemukan.',
            'Jenis_Pesanan.required'   => 'Jenis pesanan wajib dipilih.',
            'Jenis_Pesanan.in'         => 'Jenis pesanan harus Kiloan atau Satuan.',
            'Layanan_Pesanan.required' => 'Layanan pesanan wajib dipilih.',
            'Layanan_Pesanan.in'       => 'Layanan pesanan harus Cepat atau Biasa.',
            'Berat.required'           => 'Berat wajib diisi.',
            'Berat.numeric'            => 'Berat harus berupa angka.',
            'Berat.min'                => 'Berat minimal 0.1.',
            'Harga.required'           => 'Harga wajib diisi.',
            'Harga.numeric'            => 'Harga harus berupa angka.',
            'Harga.min'                => 'Harga tidak boleh negatif.',
            'Tanggal_Pesanan.required' => 'Tanggal pesanan wajib diisi.',
            'Tanggal_Pesanan.date'     => 'Format tanggal tidak valid.',
        ];
    }
}
