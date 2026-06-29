<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * 1. PAKSA LARAVEL UNTUK MENEMBAK TABEL KUSTOM 'user' (TANPA HURUF S)
     */
    protected $table = 'user';

    /**
     * 2. BERITAHU LARAVEL KALAU PRIMARY KEY DI TABEL KAMU ADALAH 'id_user'
     */
    protected $primaryKey = 'id_user';

    /**
     * Kolom-kolom di database yang diizinkan untuk diisi massal.
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
    ];

    /**
     * Sembunyikan password saat data di-serialize (keamanan internal).
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Konfigurasi casting tipe data dari Laravel.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            // 'password' => 'hashed', // DI-NONAKTIFKAN: Supaya Laravel mau menerima password teks biasa (Plaintext) di database
        ];
    }
}