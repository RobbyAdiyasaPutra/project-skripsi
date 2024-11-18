<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCriteriaModelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Pastikan hanya pengguna yang terautentikasi yang dapat memperbarui data
        // Anda dapat menambahkan logika lebih lanjut jika perlu, misalnya memeriksa peran pengguna
        return auth()->check();
        
        // Jika ada kebutuhan untuk memeriksa peran atau izin, Anda dapat menggunakan:
        // return auth()->user()->hasRole('admin'); // atau cek izin lainnya
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Aturan validasi untuk kolom 'name' (misal: nama kriteria)
            'name' => 'required|string|max:255',

            // Aturan validasi untuk kolom 'description' (misal: deskripsi kriteria)
            'description' => 'nullable|string|max:500',

            // Aturan validasi untuk kolom 'value' (misal: nilai kriteria)
            'value' => 'nullable|numeric|min:0|max:100',

            // Tambahkan aturan validasi lain sesuai dengan data yang diterima
        ];
    }

    /**
     * Custom method untuk memodifikasi data sebelum validasi, jika diperlukan.
     */
    protected function prepareForValidation()
    {
        // Menambahkan logika khusus atau modifikasi data sebelum validasi jika diperlukan
        // Misalnya, menyiapkan nilai default atau merapikan input
        $this->merge([
            // contoh penggabungan data, misalnya memperbaiki format input
        ]);
    }
}
