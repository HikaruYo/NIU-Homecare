<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('booking_slots', function (Blueprint $table) {
            $table->id('booking_slot_id');
            // FK ke tabel 'bookings' di kolom 'booking_id'
            $table->foreignId('booking_id')->constrained('bookings', 'booking_id');
            // FK ke tabel 'slot_jadwals' di kolom 'slot_id'
            $table->foreignId('slot_jadwal_id')->constrained('slot_jadwals', 'slot_jadwal_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_slots');
    }
};
