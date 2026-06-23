<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiswaRequest extends FormRequest
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
            'nama_siswa'             => 'required|string|max:100',
            'jenis_kelamin'          => 'required|in:L,P', // sesuaikan value radio
            'nisn'              => 'required|numeric|unique:siswa,nisn',
            'id_kelas'               => 'required|exists:kelas,id',
            'foto'                   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
    public function messages()
    {
        return [
            'nama_siswa.required' => 'Nama siswa wajib diisi',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih',
            'nisn.required' => 'NISN wajib diisi',
            'nisn.numeric' => 'NISN harus berupa angka',
            'nisn.unique' => 'NISN sudah digunakan',
            'id_kelas.required' => 'Kelas wajib dipilih',
            'id_kelas.exists' => 'Kelas tidak valid',
            'foto.image' => 'File harus berupa gambar',
            'foto.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
            'foto.max' => 'Ukuran gambar maksimal 2MB',
        ];
    }
}
