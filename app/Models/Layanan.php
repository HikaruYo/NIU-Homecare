<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $table = 'layanans';
    protected $primaryKey = 'layanan_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nama_layanan',
        'gambar',
        'nominal',
        'deskripsi',
        'durasi',
        'is_flexible_duration',
        'harga_per_30menit'
    ];
}
