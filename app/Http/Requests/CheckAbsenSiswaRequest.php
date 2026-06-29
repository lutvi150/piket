<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CheckAbsenSiswaRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_absensi'=>'required|exists:absensi,id',
            'id_siswa'=>'required|exists:siswa,id',
            'status'=>'required',
           'keterangan'          => 'nullable|string',
        ];
    }
    public function messages(): array
    {
        return [
            'id_absensi.required' => 'ID absensi wajib diisi.',
            'id_absensi.exists' => 'ID absensi tidak valid.',
            'id_siswa.required' => 'ID siswa wajib diisi.',
            'id_siswa.exists' => 'ID siswa tidak valid.',
            'status.required' => 'Status absen wajib diisi.',
            'keterangan.string'=>'Keterangan harus berupa text.'
        ];
    }
    public function attributes(): array
    {
        return [
            'id_absensi' => 'ID absensi',
            'id_siswa' => 'ID siswa',
            'status' => 'Status absen',
        ];
    }
}
