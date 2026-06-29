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
        Schema::create('penyedia_jasa', function (Blueprint $table) {
            $table->integer('id_penyedia', true);
            $table->string('nama', 100);
            $table->string('jenis', 50);
            $table->string('no_hp', 20)->nullable();
            $table->string('spesialis', 100)->nullable();
            $table->integer('pengalaman')->nullable();
            $table->integer('tarif')->nullable();
            $table->string('status', 20)->default('Pending');
            $table->string('dokumen', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyedia_jasa');
    }
};
