<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuruHadir extends Model
{
    protected $table = 'guru_hadir';

    protected $fillable = [
        'tanggal_piket',
        'guru_id',
        'mapel_id',
        'kelas_id',
        'jam_ke',
        'terlambat',
        'status',
        'keterangan',
    ];

    public function guru()
    {
        return $this->belongsTo(GuruModel::class, 'guru_id');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id');
    }

    public function kelas()
    {
        return $this->belongsTo(KelasModel::class, 'kelas_id');
    }
    
}
