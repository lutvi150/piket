<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiswaModel extends Model
{
    protected $table    = "siswa";
    protected $fillable = [
        'id_user',
        'nama_siswa',
        'nisn',
        'kelas',
        'jenis_kelamin',
        'id_kelas',
        'foto',
    ];

    public function kelas()
    {
        return $this->belongsTo(KelasModel::class, 'id_kelas');
    }
    public function rekapPiket()
    {
        return $this->morphMany(RekapPiket::class, 'piket');
    }
    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'id_siswa');
    }
    public $timestamps = true;
}
