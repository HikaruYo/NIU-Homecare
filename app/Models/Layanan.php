<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $table = 'layanans';
    protected $primaryKey = 'layanan_id';

    protected $fillable = [
        'nama_layanan',
        'nominal',
        'deskripsi',
        'durasi',
        'is_flexible_duration',
        'harga_per_30menit'
    ];
}
