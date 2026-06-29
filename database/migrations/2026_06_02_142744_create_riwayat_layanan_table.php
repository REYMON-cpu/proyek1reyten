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
        Schema::create('riwayat_layanan', function (Blueprint $table) {
            $table->integer('id_riwayat', true);
            $table->integer('id_pemesanan')->unique(); 
            $table->text('catatan')->nullable();
            $table->date('tanggal');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_layanan');
    }
};
