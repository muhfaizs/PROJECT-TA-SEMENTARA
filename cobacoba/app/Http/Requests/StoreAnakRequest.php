<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnakRequest extends FormRequest
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
            'ibu_id' => ['required', 'exists:ibus,id'],
            'nik' => ['nullable', 'digits:16', 'unique:anaks,nik'],
            'nama' => ['required', 'string', 'max:100'],
            'tgl_lahir' => ['required', 'date', 'before_or_equal:today'],
            'jk' => ['required', 'in:L,P'],
            'bb_lahir' => ['nullable', 'numeric', 'min:0.5', 'max:10'],
            'tb_lahir' => ['nullable', 'numeric', 'min:20', 'max:100'],
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
            'ibu_id.required' => 'Ibu wajib dipilih',
            'ibu_id.exists' => 'Data ibu tidak valid',
            'nik.digits' => 'NIK harus 16 digit',
            'nik.unique' => 'NIK sudah terdaftar',
            'nama.required' => 'Nama wajib diisi',
            'nama.max' => 'Nama maksimal 100 karakter',
            'tgl_lahir.required' => 'Tanggal lahir wajib diisi',
            'tgl_lahir.before_or_equal' => 'Tanggal lahir tidak boleh di masa depan',
            'jk.required' => 'Jenis kelamin wajib dipilih',
            'jk.in' => 'Jenis kelamin tidak valid',
            'bb_lahir.numeric' => 'Berat badan lahir harus berupa angka',
            'bb_lahir.min' => 'Berat badan lahir minimal 0.5 kg',
            'bb_lahir.max' => 'Berat badan lahir maksimal 10 kg',
            'tb_lahir.numeric' => 'Tinggi badan lahir harus berupa angka',
            'tb_lahir.min' => 'Tinggi badan lahir minimal 20 cm',
            'tb_lahir.max' => 'Tinggi badan lahir maksimal 100 cm',
        ];
    }
}
