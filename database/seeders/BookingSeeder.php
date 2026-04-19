<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bookings = [];
        $bookingLayanans = [];

        $bookingId = 400;
        $bookingLayananId = 400;
        $now = now();

        for ($year = 2024; $year <= 2025; $year++) {
            for ($month = 1; $month <= 12; $month++) {
                $tanggalBooking = sprintf('%04d-%02d-10 09:00:00', $year, $month);

                $bookings[] = [
                    'booking_id' => $bookingId,
                    'user_id' => 1,
                    'tanggal_booking' => $tanggalBooking,
                    'status' => 'selesai',
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                $bookingLayanans[] = [
                    'booking_layanan_id' => $bookingLayananId,
                    'booking_id' => $bookingId,
                    'layanan_id' => 2,
                    'durasi' => 60,
                    'harga' => 100000,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                $bookingId++;
                $bookingLayananId++;
            }
        }

        DB::table('booking_layanans')->whereBetween('booking_layanan_id', [400, 423])->delete();
        DB::table('bookings')->whereBetween('booking_id', [400, 423])->delete();

        DB::table('bookings')->insert($bookings);
        DB::table('booking_layanans')->insert($bookingLayanans);
    }
}
