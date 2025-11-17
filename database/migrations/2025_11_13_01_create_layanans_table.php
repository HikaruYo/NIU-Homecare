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
        Schema::create('layanans', function (Blueprint $table) {
            $table->id('layanan_id');
            $table->string('nama_layanan');
            $table->integer('nominal');
            $table->text('deskripsi');
            $table->integer('durasi');
            $table->boolean('is_flexible_duration')->default(false);
            $table->integer('harga_per_30menit')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanans');
    }
};
