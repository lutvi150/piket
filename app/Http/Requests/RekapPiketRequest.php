<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RekapPiketRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'tanggal'    => 'required|date',
            'jenis'      => 'required|in:guru,siswa',
            'piket_id'   => 'required|integer',
            'id_kelas'   => 'nullable|exists:kelas,id',
            'id_mapel'   => 'nullable|exists:mapel,id',
            'terlambat'  => 'nullable|integer|min:0',
            'status'     => 'required|in:S,I,A',
            'keterangan' => 'nullable|string|max:1000',
            'lampiran'=>'nullable|file|mimes:pdf|max:2048'
        ];
    }

    /**
     * Pesan validasi.
     */
    public function messages(): array
    {
        return [
            'tanggal.required'    => 'Tanggal wajib diisi.',
            'tanggal.date'        => 'Format tanggal tidak valid.',
            'jenis.required'      => 'Jenis piket wajib dipilih.',
            'jenis.in'            => 'Jenis piket harus guru atau siswa.',
            'piket_id.required'   => 'Data guru atau siswa wajib dipilih.',
            'piket_id.integer'    => 'Data guru atau siswa tidak valid.',
            'id_kelas.exists'     => 'Data kelas tidak ditemukan.',
            'id_mapel.exists'     => 'Data mata pelajaran tidak ditemukan.',
            'terlambat.integer'   => 'Jumlah keterlambatan harus berupa angka.',
            'terlambat.min'       => 'Jumlah keterlambatan tidak boleh kurang dari 0.',
            'status.required'     => 'Status kehadiran wajib dipilih.',
            'status.in'           => 'Status kehadiran harus S, I, atau A.',
            'keterangan.string'   => 'Keterangan harus berupa teks.',
            'keterangan.max'      => 'Keterangan maksimal 1000 karakter.',
            'lampiran.file'=> 'Lampiran harus berupa file PDF.',
            'lampiran.mimes'   => 'Lampiran harus berupa file PDF.',
            'lampiran.max'      => 'Lampiran maksimal 2 MB.',
        ];
    }

    /**
     * Nama atribut yang lebih mudah dibaca.
     */
    public function attributes(): array
    {
        return [
            'tanggal'    => 'tanggal',
            'jenis'      => 'jenis piket',
            'piket_id'   => 'guru atau siswa',
            'kelas_id'   => 'kelas',
            'mapel_id'   => 'mata pelajaran',
            'terlambat'  => 'keterlambatan',
            'status'     => 'status kehadiran',
            'keterangan' => 'keterangan',
        ];
    }
}