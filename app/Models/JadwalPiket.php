<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPiket extends Model
{
    protected $table = "jadwal_piket";
    protected $fillable = [
        'tanggal',
        'id_guru',
        'keterangan',
    ];
    public $timestamps = true;
    public function guru()
    {
        return $this->belongsTo(GuruModel::class, 'id_guru');
    }
}
