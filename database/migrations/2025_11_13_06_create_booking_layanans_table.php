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
        Schema::create('booking_layanans', function (Blueprint $table) {
            $table->id('booking_layanan_id');
            // FK ke tabel 'bookings' di kolom 'booking_id'
            $table->foreignId('booking_id')->constrained('bookings', 'booking_id');
            // FK ke tabel 'layanans' di kolom 'layanan_id'
            $table->foreignId('layanan_id')->constrained('layanans', 'layanan_id');
            $table->integer('durasi');
            $table->integer('harga');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_layanans');
    }
};
