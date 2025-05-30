<?php

namespace App\Http\Requests;

// use Rules\Password;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password as password;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
//     public function rules(): array
// {
//     return [
//         'username' => ['required', 'string', 'max:255'], // Validasi username
//         'name' => ['required', 'string', 'max:255'], // Validasi nama
//         'email' => [
//             'required', 
//             'string', 
//             'lowercase', 
//             'email', 
//             'max:255',
//             Rule::unique(User::class)->ignore($this->user()->id),
//         ], // Validasi email unik
//         'numberphone' => ['required', 'string', 'min:10', 'max:13'], // Validasi nomor telepon tepat 12 karakter
//         'nik' => ['required', 'string', 'min:16', 'max:16'], // Validasi NIK antara 12-15 karakter
//         'gender' => ['required', 'string', 'max:255'], // Validasi gender sebagai string
//         'password' => ['nullable', 'confirmed', Password::defaults()], // Validasi password opsional, harus sesuai konfirmasi
//         'profile_picture' => [
//             'nullable', // Gambar profil tidak wajib
//             'file', // Memastikan file yang diunggah
//             'image', // Memastikan file yang diunggah adalah gambar
//             'mimes:jpeg,png,jpg,gif', // Menentukan ekstensi gambar yang diizinkan
//             'max:2048', // Membatasi ukuran file (dalam KB, misal 2MB)
//         ],
//     ];
//     }

public function rules(): array
{
    return [
        'username' => ['sometimes', 'string', 'max:255'],
        'name' => ['sometimes', 'string', 'max:255'],
        'email' => [
            'sometimes', 
            'string', 
            'lowercase', 
            'email', 
            'max:255',
            Rule::unique(User::class)->ignore($this->user()->id),
        ],
        'numberphone' => ['sometimes', 'string', 'min:10', 'max:13'],
        'nik' => ['sometimes', 'string', 'min:16', 'max:16'],
        'gender' => ['sometimes', 'string', 'max:255'],
        'password' => ['nullable', 'confirmed', Password::defaults()],
        'profileImage' => [
            'sometimes',
            'image',
            'mimes:jpeg,png,jpg,gif',
            'max:2048',
        ],
    ];
}


}
