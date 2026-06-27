<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuruModel extends Model
{
    protected $table    = "guru";
    protected $fillable = [
        'id_user',
        'nama_guru',
        'nip',
        'jenis_kelamin',
        'golongan',
        'jabatan',
        'foto',
        'alamat',
        'no_hp',
    ];
    public $timestamps = true;
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    
    public function getFotoUrlAttribute()
    {
        if ($this->foto && file_exists(public_path('uploads/guru/' . $this->foto))) {
            return asset('uploads/guru/' . $this->foto);
        }

        return asset('assets/images/default.png');
    }
    public function rekapPiket(){
        return $this->morphMany(RekapPiket::class, 'piket');
    }
}
