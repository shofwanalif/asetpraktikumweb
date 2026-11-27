<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// Form Request ini sudah LENGKAP - tidak perlu diubah.
// Gunakan sebagai referensi format penulisan Form Request Validation
// yang membedakan aturan untuk POST (required) dan PATCH (sometimes).

class StoreBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isPatch = $this->isMethod('PATCH');

        return [
            'title' => $isPatch ? 'sometimes|string|max:255' : 'required|string|max:255',
            'author' => $isPatch ? 'sometimes|string|max:255' : 'required|string|max:255',
            'file_path' => $isPatch
                ? 'sometimes|nullable|image|mimes:jpg,jpeg,png,webp|max:10240'
                : 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul buku wajib diisi',
            'author.required' => 'Nama penulis wajib diisi',
            'file_path.image' => 'File sampul harus berupa gambar',
            'file_path.mimes' => 'Format sampul harus JPG, JPEG, PNG, atau WEBP',
            'file_path.max' => 'Ukuran sampul maksimal 10 MB',
        ];
    }
}
