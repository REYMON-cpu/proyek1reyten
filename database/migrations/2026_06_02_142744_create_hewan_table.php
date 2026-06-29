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
        Schema::create('hewan', function (Blueprint $table) {
            $table->integer('id_hewan', true);
            $table->integer('id_user')->index('id_user');
            $table->string('nama_hewan', 100);
            $table->string('jenis', 50);
            $table->string('umur', 20);
            $table->text('riwayat_penyakit')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hewan');
    }
};
