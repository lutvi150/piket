<?php
    namespace App\Http\Requests;

    use Illuminate\Contracts\Validation\ValidationRule;
    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Validation\Rule;

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
            'guru_id'    => [
                'required',
                'exists:guru,id',
            ],

            'tanggal'    => [
                'required',
                'date',
            ],

            'jam_masuk'  => [
                'nullable',
                'date_format:H:i:s',
                'before_or_equal:jam_keluar',
            ],

            'jam_keluar' => [
                'nullable',
                'date_format:H:i:s',
                'after_or_equal:jam_masuk',
            ],

            'status'     => [
                'required',
                Rule::in(['H', 'I', 'S', 'A']),
            ],

            'keterangan' => [
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'guru_id.required'          => 'Guru wajib dipilih.',
            'guru_id.exists'            => 'Guru tidak ditemukan.',
            'tanggal.required'          => 'Tanggal wajib diisi.',
            'tanggal.date'              => 'Format tanggal tidak valid.',
            'jam_masuk.date_format'     => 'Format jam masuk harus HH:mm:ss.',
            'jam_masuk.before_or_equal' => 'Jam masuk tidak boleh melebihi jam keluar.',
            'jam_keluar.date_format'    => 'Format jam keluar harus HH:mm:ss.',
            'jam_keluar.after_or_equal' => 'Jam keluar tidak boleh lebih awal dari jam masuk.',
            'status.required'           => 'Status kehadiran wajib dipilih.',
            'status.in'                 => 'Status kehadiran tidak valid.',
            'keterangan.max'            => 'Keterangan maksimal 255 karakter.',
        ];
    }

    public function attributes(): array
    {
        return [
            'guru_id'    => 'Guru',
            'tanggal'    => 'Tanggal',
            'jam_masuk'  => 'Jam Masuk',
            'jam_keluar' => 'Jam Keluar',
            'status'     => 'Status Kehadiran',
            'keterangan' => 'Keterangan',
        ];
    }
}
