<?php
namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AbsenGuruRequest extends FormRequest
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
            // 'guru_id'    => ['required', 'exists:guru,id'],
            // 'tanggal'    => ['required', 'date'],
            // 'jam_masuk'  => ['nullable', 'date_format:H:i:s'],
            // 'jam_keluar' => ['nullable', 'date_format:H:i:s'],
            // 'status'     => ['required', 'in:H,I,S,A'],
            // 'keterangan' => ['nullable', 'string', 'max:255'],
        ];
    }
}
