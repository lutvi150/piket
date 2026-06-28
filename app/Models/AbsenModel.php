<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsenModel extends Model
{
    protected $table    = 'absensi';
    protected $fillable = ['tanggal', 'jam_masuk', 'jam_keluar', 'id_mapel', 'id_kelas', 'jumlah_siswa', 'id_guru'];
    public $timestamps  = true;
    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel');
    }
    public function kelas()
    {
        return $this->belongsTo(KelasModel::class, 'id_kelas');
    }
    public function getJamMasukAttribute($value)
    {
        return substr($value, 0, 5);
    }

    public function getJamKeluarAttribute($value)
    {
        return substr($value, 0, 5);
    }

}
