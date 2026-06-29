<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckAbsenModel extends Model
{
    protected $table = 'check_absensi';
    protected $fillable = ['id', 'id_absensi', 'id_siswa', 'status', 'keterangan'];
    public $timestamps = true;   
}
