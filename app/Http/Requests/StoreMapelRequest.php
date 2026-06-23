<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMapelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
     public function rules(): array
    {
        return [
            'nama_mapel' => 'required|string|max:100|unique:mapel,nama_mapel',
        ];
    }
      public function messages()
    {
        return [
            'nama_mapel.required' => 'Nama mata pelajaran wajib diisi',
            'nama_mapel.string' => 'Nama mata pelajaran harus berupa string',
            'nama_mapel.max' => 'Nama mata pelajaran maksimal 100 karakter',
            'nama_mapel.unique' => 'Nama mata pelajaran sudah digunakan',
        ];
    }
}
