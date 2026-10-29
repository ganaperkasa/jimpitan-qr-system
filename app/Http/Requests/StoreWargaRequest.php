<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreWargaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $rules = [
            'nama' => ['required', 'string', 'max:100'],
            'no_rumah' => ['required', 'string', 'max:20'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'no_hp' => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s]+$/'],
        ];

        // Saat mengubah data warga, status ikut divalidasi.
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['status'] = ['required', Rule::in(['aktif', 'nonaktif'])];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama warga wajib diisi.',
            'no_rumah.required' => 'Nomor rumah wajib diisi.',
            'no_hp.regex' => 'Nomor HP hanya boleh berisi angka, spasi, tanda + atau -.',
            'status.in' => 'Status harus aktif atau nonaktif.',
        ];
    }
}
