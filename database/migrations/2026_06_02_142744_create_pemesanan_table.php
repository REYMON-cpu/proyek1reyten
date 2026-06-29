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
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->integer('id_pemesanan', true);
            $table->integer('id_user');
            $table->integer('id_hewan');
            $table->integer('id_layanan');
            $table->integer('id_penyedia');
            $table->date('tanggal');
            $table->text('alamat');
            $table->string('status', 50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanan');
    }
};
