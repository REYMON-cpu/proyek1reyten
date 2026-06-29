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
        Schema::table('pemesanan', function (Blueprint $table) {
            $table->foreign(['id_user'], 'pemesanan_ibfk_1')->references(['id_user'])->on('user')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['id_hewan'], 'pemesanan_ibfk_2')->references(['id_hewan'])->on('hewan')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['id_layanan'], 'pemesanan_ibfk_3')->references(['id_layanan'])->on('layanan')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['id_penyedia'], 'pemesanan_ibfk_4')->references(['id_penyedia'])->on('penyedia_jasa')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemesanan', function (Blueprint $table) {
            $table->dropForeign('pemesanan_ibfk_1');
            $table->dropForeign('pemesanan_ibfk_2');
            $table->dropForeign('pemesanan_ibfk_3');
            $table->dropForeign('pemesanan_ibfk_4');
        });
    }
};
