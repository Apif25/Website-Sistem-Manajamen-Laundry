<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class PelangganRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $pelangganId = $this->route('pelanggan'); // null saat store, ada saat update

        return [
            'nama_pelanggan'       => ['required', 'string', 'max:255'],
            'email'      => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:pelanggans,email,' . $pelangganId, // ignore email sendiri saat update
            ],
            'password'   => $pelangganId
                ? ['nullable', 'confirmed', Password::min(8)]   // opsional saat update
                : ['required', 'confirmed', Password::min(8)],  // wajib saat store
            'id_role'    => ['required', 'integer', 'exists:id_role'],
            'no_telepon' => ['nullable', 'string', 'max:20'],
            'alamat'     => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'id_role.required'   => 'Role wajib dipilih.',
            'id_role.exists'     => 'Role tidak valid.',
            'nama_pelanggan.required'      => 'Nama wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.unique'       => 'Email sudah terdaftar.',
            'password.required'  => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ];
    }
}
