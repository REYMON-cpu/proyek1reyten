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
        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->id();
            $table->integer('id_penyedia')->index('id_penyedia');
            $table->string('tipe', 20); // 'dokter' or 'sitter'
            $table->string('nama_hewan', 100);
            $table->string('jenis_hewan', 50);
            $table->string('nama_pemilik', 100);
            $table->integer('id_user')->default(0)->index('id_user');
            $table->string('tanggal', 50);
            $table->string('diagnosis', 255)->nullable();
            $table->string('tindakan', 255)->nullable();
            $table->string('jenis_layanan', 100)->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekam_medis');
    }
};
