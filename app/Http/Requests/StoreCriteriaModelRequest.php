<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCriteriaModelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Mengizinkan hanya pengguna yang terautentikasi
        return auth()->check();
        
        // Jika perlu pengecekan berdasarkan role, contoh:
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
            // Validasi untuk field 'name'
            'name' => 'required|string|max:255',

            // Validasi untuk field 'description' (misalnya bisa kosong, maksimal 500 karakter)
            'description' => 'nullable|string|max:500',

            // Validasi untuk field 'value' (contoh nilai, bisa diubah sesuai kebutuhan)
            'value' => 'required|numeric|min:0|max:100',

            // Tambahkan aturan validasi lainnya sesuai kebutuhan
        ];
    }
}
