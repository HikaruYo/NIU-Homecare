<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingSlot extends Model
{
    protected $primaryKey = 'booking_slot_id';

    protected $fillable = [
        'booking_id',
        'slot_jadwal_id'
    ];

    // Relasi ke Booking Utama
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'booking_id');
    }

    // Relasi ke Master Slot Jadwal (Ini yang dicari oleh error tadi)
    public function slotJadwal(): BelongsTo
    {
        return $this->belongsTo(SlotJadwal::class, 'slot_jadwal_id', 'slot_jadwal_id');
    }
}
