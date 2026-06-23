<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapGuru extends Model
{
    /** @use HasFactory<\Database\Factories\RekapGuruFactory> */
    use HasFactory;
    protected $table = 'rekap_guru';
    protected $fillable = [];
    public $timestamps = true;
}
