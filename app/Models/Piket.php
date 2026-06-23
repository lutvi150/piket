<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Piket extends Model
{
    /** @use HasFactory<\Database\Factories\PiketFactory> */
    use HasFactory;
    protected $table = "piket";
    protected $fillable = [
        'tanggal',
        'status_libur',
        'hari',
    ];
    public $timestamps = true;
}
