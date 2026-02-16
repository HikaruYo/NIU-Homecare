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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id('booking_id');
            // FK ke tabel 'users' di kolom 'user_id'
            $table->foreignId('user_id')->constrained('users', 'user_id');
            $table->timestamp('tanggal_booking');
            $table->enum('status', ['diterima', 'ditolak', 'menunggu', 'dibatalkan']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
