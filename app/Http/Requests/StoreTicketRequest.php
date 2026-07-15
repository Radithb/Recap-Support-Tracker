<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Authorisasi ditangani oleh middleware di route
    }

    public function rules(): array
    {
        return [
            'aplikasi_id' => ['required', 'exists:master_aplikasis,aplikasi_id'],
            'permasalahan' => ['required', 'string', 'min:10'],
            'lampiran' => ['nullable', 'file', 'mimes:jpeg,png,jpg,mp4,pdf', 'max:5120'], // Max 5MB
        ];
    }
    
    public function messages(): array
    {
        return [
            'aplikasi_id.required' => 'Aplikasi wajib dipilih.',
            'aplikasi_id.exists' => 'Aplikasi tidak valid.',
            'permasalahan.required' => 'Deskripsi permasalahan wajib diisi.',
            'lampiran.max' => 'Ukuran lampiran maksimal 5MB.',
            'lampiran.mimes' => 'Format lampiran harus berupa gambar (JPEG, PNG, JPG), video (MP4), atau dokumen (PDF).',
        ];
    }
}
