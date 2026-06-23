<?php
namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class GuruRequest extends FormRequest
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
            'email'         => 'required|email|unique:users,email',
            'nama_guru'     => 'required|min:3',
            // 'nip'           => 'required|regex:/^[0-9]{18}$/|unique:guru,nip,',
            'nip'           => 'required|numeric|unique:guru,nip,',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat'        => 'required',
            'no_hp'         => 'required|digits_between:10,15',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png',
        ];
    }
    public function messages()
    {
        return [
            'email.required'         => 'Email wajib diisi',
            'email.email'            => 'Format email tidak valid',
            'email.unique'           => 'Email sudah digunakan',
            'nama_guru.required'     => 'Nama guru wajib diisi',
            'nama_guru.min'          => 'Nama guru minimal 3 karakter',
            'nip.required'           => 'NIP wajib diisi',
            'nip.unique'             => 'NIP sudah digunakan',
            'nip.numeric'            => 'NIP harus berupa angka',
            // 'nip.min' => 'NIP minimal 18 digit',
            // 'nip.max' => 'NIP maksimal 18 digit',
            // 'nip.regex' => 'NIP harus terdiri dari 18 digit angka',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih',
            'jenis_kelamin.in'       => 'Jenis kelamin tidak valid',
            'alamat.required'        => 'Alamat wajib diisi',
            'no_hp.required'         => 'No HP wajib diisi',
            'no_hp.numeric'          => 'No HP harus berupa angka',
            'no_hp.digits_between'   => 'No HP harus terdiri dari 10 hingga 15 digit',
            // 'no_hp.min' => 'No HP minimal 10 digit',
            // 'no_hp.max' => 'No HP maksimal 15 digit',
            // 'no_hp.regex' => 'No HP harus terdiri dari 15 digit angka',
            'foto.image'             => 'File harus berupa gambar',
            'foto.mimes'             => 'Format gambar harus jpg, jpeg, atau png',
        ];
    }
}
