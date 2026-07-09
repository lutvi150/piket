<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AbsenRequest extends FormRequest
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
            'tanggal'=>'required|date',
            'masuk'=>'required',
            'keluar'=>'required',
            'id_mapel'=>'required|exists:mapel,id',
            'id_kelas'=>'required|exists:kelas,id',
        ];
    }
    public function messages(): array
    {
        return [
            'tanggal.required' => 'Tanggal wajib diisi',
            'tanggal.date' => 'Tanggal harus berupa tanggal',
            'masuk.required' => 'Waktu masuk wajib diisi',
            'keluar.required' => 'Waktu keluar wajib diisi',
            'id_mapel.required' => 'Mapel wajib diisi',
            'id_mapel.exists' => 'Mapel tidak ditemukan',
            'id_kelas.required' => 'Kelas wajib diisi',
            'id_kelas.exists'=> 'Kelas tidak ditemukan',
        ];
    }
    public function attributes(): array
    {
        return [
            'tanggal' => 'Tanggal',
            'masuk' => 'Waktu Masuk',
            'keluar' => 'Waktu Keluar',
            'mapel' => 'Mapel',
            'id_kelas' => 'Kelas',
        ];
    }
}
