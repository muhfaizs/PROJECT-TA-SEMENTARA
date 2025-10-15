<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIbuRequest extends FormRequest
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
            'nik' => ['required', 'digits:16', 'unique:ibus,nik'],
            'nama' => ['required', 'string', 'max:100'],
            'tgl_lahir' => ['required', 'date', 'before:today'],
            'hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
            'posyandu_id' => ['required', 'exists:posyandus,id'],
            'hpht' => ['nullable', 'date', 'before_or_equal:today'],
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
            'nik.required' => 'NIK wajib diisi',
            'nik.digits' => 'NIK harus 16 digit',
            'nik.unique' => 'NIK sudah terdaftar',
            'nama.required' => 'Nama wajib diisi',
            'nama.max' => 'Nama maksimal 100 karakter',
            'tgl_lahir.required' => 'Tanggal lahir wajib diisi',
            'tgl_lahir.before' => 'Tanggal lahir harus sebelum hari ini',
            'posyandu_id.required' => 'Posyandu wajib dipilih',
            'posyandu_id.exists' => 'Posyandu tidak valid',
            'hpht.date' => 'Format tanggal HPHT tidak valid',
            'hpht.before_or_equal' => 'HPHT tidak boleh di masa depan',
        ];
    }
}
