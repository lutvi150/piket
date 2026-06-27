<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekapPiket extends Model
{
    protected $table    = 'rekap_piket';
    protected $fillable = [
        'tanggal',
        'kelas_id',
        'mapel_id',
        'jenis',
        'piket_id',
        'piket_type',
        'terlambat',
        'status',
        'keterangan',
        'lampiran',
    ];
    public $timestamps = true;
    public function piket()
    {
        return $this->morphTo();
    }
    public function kelas()
    {
        return $this->belongsTo(KelasModel::class, 'kelas_id');
    }
    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id');
    }
}
