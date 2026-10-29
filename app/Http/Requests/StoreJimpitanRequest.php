<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJimpitanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /** Nominal dikirim dengan pemisah ribuan ("2.000"); ambil angkanya saja. */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'nominal' => (int) preg_replace('/\D/', '', (string) $this->input('nominal')),
        ]);
    }

    public function rules(): array
    {
        $tanggal = ['required', 'date', 'before_or_equal:today'];

        // Petugas hanya boleh mencatat 7 hari ke belakang; admin tidak dibatasi.
        if (! $this->user()->isAdmin()) {
            $tanggal[] = 'after_or_equal:'.now()->subDays(7)->toDateString();
        }

        return [
            'warga_id' => ['required', 'integer', 'exists:warga,id'],
            'tanggal' => $tanggal,
            'nominal' => ['required', 'integer', 'min:1', 'max:10000000'],
            'catatan' => ['nullable', 'string', 'max:255'],
            'token' => ['required', 'uuid'],
        ];
    }

    public function messages(): array
    {
        return [
            'nominal.min' => 'Nominal harus lebih dari 0.',
            'nominal.max' => 'Nominal terlalu besar. Periksa kembali angkanya.',
            'tanggal.before_or_equal' => 'Tanggal tidak boleh lebih dari hari ini.',
            'tanggal.after_or_equal' => 'Petugas hanya dapat mencatat sampai 7 hari ke belakang.',
        ];
    }
}
