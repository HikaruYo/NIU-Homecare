<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SlotJadwal extends Model
{
    use HasFactory;

    protected $table = 'slot_jadwals';
    protected $primaryKey = 'slot_jadwal_id';
    public $timestamps = true;

    protected $fillable = [
        'tanggal',
        'waktu',
        'is_available',
        'is_disabled',
    ];
}
