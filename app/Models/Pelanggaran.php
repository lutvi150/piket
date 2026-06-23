<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    /** @use HasFactory<\Database\Factories\PelanggaranFactory> */
    use HasFactory;
    protected $table    = 'pelanggaran';
    protected $fillable = [
        'id_siswa',
        'jenis_pelanggaran',
        'tanggal_pelanggaran',
        'poin',
        'tindakan_sanksi',
        'keterangan',
    ];
    public function siswa()
    {
        return $this->belongsTo(SiswaModel::class, 'id_siswa');
    }

}
