<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SlotJadwal;
use Carbon\Carbon;

class SlotJadwalSeeder extends Seeder
{
    public function run(): void
    {
        $startDate = Carbon::today();
        $endDate   = Carbon::today()->addMonths(3); // generate 3 bulan mulai dari hari ini

        $startTime = Carbon::createFromTime(9, 0);  // 09.00
        $endTime   = Carbon::createFromTime(19, 0); // 19.00

        while ($startDate <= $endDate) {

            $time = $startTime->copy();

            while ($time <= $endTime) {

                SlotJadwal::create([
                    'tanggal' => $startDate->format('Y-m-d'),
                    'waktu'   => $time->format('H:i'),
                ]);

                $time->addMinutes(30); // interval 30 menit
            }

            $startDate->addDay();
        }
    }
}
