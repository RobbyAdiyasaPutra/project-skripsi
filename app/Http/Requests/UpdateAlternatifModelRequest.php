<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAlternatifModelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Mengizinkan hanya pengguna yang terautentikasi untuk mengupdate data alternatif
        return auth()->check();
        
        // Jika menggunakan pengecekan role atau izin lainnya:
        // return auth()->user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Validasi untuk field 'name' jika ada perubahan pada nama alternatif
            'name' => 'required|string|max:255',

            // Validasi untuk field 'description' jika ada perubahan pada deskripsi alternatif
            'description' => 'nullable|string|max:500',

            // Validasi untuk field lainnya yang mungkin ada, misalnya 'value'
            'value' => 'nullable|numeric|min:0|max:100',

            // Jika Anda memiliki field lain, pastikan untuk menambahkannya di sini
        ];
    }

    /**
     * Custom method untuk menentukan aturan validasi berdasarkan id model yang ingin diupdate
     */
    protected function prepareForValidation()
    {
        // Menambahkan logika khusus jika perlu, misalnya membatasi aturan validasi berdasarkan ID.
        $this->merge([
            // Mengubah beberapa data sebelum validasi jika perlu
        ]);
    }
}
