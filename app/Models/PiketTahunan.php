<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PiketTahunan extends Model
{
    /** @use HasFactory<\Database\Factories\PiketTahunanFactory> */
    use HasFactory;
    protected $table = 'piket_tahunan';
    protected $fillable = [
        'hari',
        'id_guru',
    ];
    public $timestamps = true;
    public function guru() {
        return $this->belongsTo(GuruModel::class, 'id_guru');
    }
}
