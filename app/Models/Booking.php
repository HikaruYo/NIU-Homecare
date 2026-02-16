<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    protected $primaryKey = 'booking_id';

    protected $fillable = [
        'user_id',
        'tanggal_booking',
        'status'
    ];

    protected $casts = [
        'tanggal_booking' => 'date'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function bookingSlots(): HasMany
    {
        return $this->hasMany(BookingSlot::class, 'booking_id', 'booking_id');
    }

    public function bookingLayanans(): HasMany
    {
        return $this->hasMany(BookingLayanan::class, 'booking_id', 'booking_id');
    }

    public function transaksi(): HasOne
    {
        return $this->hasOne(DetailTransaksi::class, 'booking_id', 'booking_id');
    }
}
