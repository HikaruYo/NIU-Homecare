<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
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

    public static function autoCancelPendingHPlusTwo(): int
    {
        $cutoffDate = Carbon::today()->subDays(2);

        $expiredBookings = static::query()
            ->with('bookingSlots')
            ->where('status', 'menunggu')
            ->whereDate('tanggal_booking', '<=', $cutoffDate)
            ->get();

        if ($expiredBookings->isEmpty()) {
            return 0;
        }

        $updatedCount = 0;

        DB::transaction(function () use ($expiredBookings, &$updatedCount) {
            foreach ($expiredBookings as $booking) {
                $slotIds = $booking->bookingSlots->pluck('slot_jadwal_id')->filter()->all();

                if (!empty($slotIds)) {
                    SlotJadwal::whereIn('slot_jadwal_id', $slotIds)->update([
                        'is_available' => true,
                    ]);
                }

                $booking->update([
                    'status' => 'dibatalkan',
                ]);

                $updatedCount++;
            }
        });

        return $updatedCount;
    }
}
