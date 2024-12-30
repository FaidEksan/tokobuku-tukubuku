<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna diizinkan untuk membuat permintaan ini.
     */
    public function authorize(): bool
    {
        // Set true agar semua pengguna diizinkan
        return true;
    }

    /**
     * Mendapatkan aturan validasi yang berlaku untuk permintaan ini.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255', // Kolom name wajib diisi dan berupa teks maksimal 255 karakter
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Kolom image opsional, harus berupa file gambar dengan ukuran maksimal 2MB
        ];
    }
}