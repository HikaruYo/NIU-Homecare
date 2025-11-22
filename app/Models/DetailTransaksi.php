<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailTransaksi extends Model
{
    protected $primaryKey = 'transaksi_id';

    protected $fillable = [
        'booking_id',
        'tanggal_transaksi',
        'nominal',
        'status_pembayaran'
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'booking_id');
    }
}
