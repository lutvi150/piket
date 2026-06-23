<?php
namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PelanggaranRequest extends FormRequest
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
            'id_siswa'            => 'required|exists:siswa,id',
            'jenis_pelanggaran'   => 'required|string',
            'tanggal_pelanggaran' => 'required|date',
            'poin'                => 'required|integer',
            'tindakan_sanksi'     => 'nullable|string',
            'keterangan'          => 'nullable|string',
        ];

    }
    public function messages()
    {
        return [
            'id_siswa.required'            => 'ID siswa wajib diisi',
            'id_siswa.exists'              => 'ID siswa tidak valid',
            'jenis_pelanggaran.required'   => 'Jenis pelanggaran wajib diisi',
            'jenis_pelanggaran.string'     => 'Jenis pelanggaran harus berupa keteragan',
            'tanggal_pelanggaran.required' => 'Tanggal pelanggaran wajib diisi',
            'tanggal_pelanggaran.date'     => 'Tanggal pelanggaran harus berupa tanggal yang valid',
            'poin.required'                => 'Poin wajib diisi',
            'poin.integer'                 => 'Poin harus berupa angka bulat',
            'tindakan_sanksi.string'       => 'Tindakan sanksi harus berupa text',
            'keterangan.string'            => 'Keterangan harus berupa text',
        ];
    }
}
