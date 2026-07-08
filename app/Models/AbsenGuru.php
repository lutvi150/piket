<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsenGuru extends Model
{
    /** @use HasFactory<\Database\Factories\AbsenGuruFactory> */
    use HasFactory;
    protected $table = 'absen_guru';
    protected $fillable = [
        'guru_id',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'status',
        'keterangan',
    ];
    protected $casts = [
        'tanggal' => 'date:Y-m-d',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
    public $timestamps = true;
}
