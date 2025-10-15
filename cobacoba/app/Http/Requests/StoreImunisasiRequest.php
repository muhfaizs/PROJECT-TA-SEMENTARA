<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreImunisasiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'vaksin_code' => ['required', 'string', 'max:50'],
            'dosis' => ['nullable', 'string', 'max:20'],
            'given_at' => ['required', 'date', 'before_or_equal:today'],
            'keterangan' => ['nullable', 'string', 'max:500'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'vaksin_code.required' => 'Jenis vaksin wajib dipilih',
            'vaksin_code.max' => 'Kode vaksin terlalu panjang',
            'given_at.required' => 'Tanggal pemberian wajib diisi',
            'given_at.date' => 'Format tanggal tidak valid',
            'given_at.before_or_equal' => 'Tanggal pemberian tidak boleh di masa depan',
            'keterangan.max' => 'Keterangan maksimal 500 karakter',
        ];
    }
}
