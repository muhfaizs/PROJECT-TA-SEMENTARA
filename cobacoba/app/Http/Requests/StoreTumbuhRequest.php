<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTumbuhRequest extends FormRequest
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
            'measured_at' => ['required', 'date', 'before_or_equal:today'],
            'bb_kg' => ['required', 'numeric', 'min:1', 'max:150'],
            'tb_cm' => ['required', 'numeric', 'min:30', 'max:200'],
            'll_cm' => ['nullable', 'numeric', 'min:5', 'max:50'],
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
            'measured_at.required' => 'Tanggal pengukuran wajib diisi',
            'measured_at.date' => 'Format tanggal tidak valid',
            'measured_at.before_or_equal' => 'Tanggal pengukuran tidak boleh di masa depan',
            'bb_kg.required' => 'Berat badan wajib diisi',
            'bb_kg.numeric' => 'Berat badan harus berupa angka',
            'bb_kg.min' => 'Berat badan minimal 1 kg',
            'bb_kg.max' => 'Berat badan maksimal 150 kg',
            'tb_cm.required' => 'Tinggi badan wajib diisi',
            'tb_cm.numeric' => 'Tinggi badan harus berupa angka',
            'tb_cm.min' => 'Tinggi badan minimal 30 cm',
            'tb_cm.max' => 'Tinggi badan maksimal 200 cm',
            'll_cm.numeric' => 'Lingkar lengan harus berupa angka',
            'll_cm.min' => 'Lingkar lengan minimal 5 cm',
            'll_cm.max' => 'Lingkar lengan maksimal 50 cm',
        ];
    }
}
