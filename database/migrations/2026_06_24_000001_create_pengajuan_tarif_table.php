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
        Schema::create('pengajuan_tarif', function (Blueprint $table) {
            $table->id('id_pengajuan');
            $table->integer('id_penyedia');
            $table->string('jenis', 50)->nullable();
            $table->integer('tarif_lama')->nullable();
            $table->integer('tarif_baru');
            $table->text('alasan')->nullable();
            $table->string('dokumen', 255)->nullable();
            $table->string('status', 20)->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_tarif');
    }
};
