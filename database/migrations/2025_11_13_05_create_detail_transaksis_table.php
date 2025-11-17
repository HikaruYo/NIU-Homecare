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
        Schema::create('detail_transaksis', function (Blueprint $table) {
            $table->id('detail_transaksi_id');
            // FK ke tabel 'bookings' di kolom 'booking_id'
            $table->foreignId('booking_id')->constrained('bookings', 'booking_id');
            $table->timestamp('tanggal_transaksi');
            $table->integer('nominal');
            $table->enum('status_pembayaran', ['pending', 'lunas']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksis');
    }
};
