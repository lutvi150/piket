<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelasModel extends Model
{
protected $table = 'kelas';
    protected $fillable = ['nama_kelas', 'id_guru'];
    public $timestamps = true;
    public function siswa()
    {
        return $this->hasMany(SiswaModel::class, 'id_kelas');
    }
    public function guru()
    {
        return $this->belongsTo(GuruModel::class, 'id_guru');
    }
}
