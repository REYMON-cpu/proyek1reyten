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
        Schema::create('chat_pesan', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_pemilik')->nullable();
            $table->integer('id_penyedia')->nullable();
            $table->enum('pengirim', ['pemilik', 'penyedia'])->default('pemilik');
            $table->text('pesan');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_pesan');
    }
};
