<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed default Users
        DB::table('user')->insert([
            [
                'nama' => 'Admin Utama',
                'email' => 'admin@gmail.com',
                'password' => '12345678', // Plaintext as designed in web.php
                'role' => 'Admin',
                'jenis' => 'Admin',
            ],
            [
                'nama' => 'Budi Pemilik',
                'email' => 'pemilik@gmail.com',
                'password' => '12345678',
                'role' => 'Pemilik Hewan',
                'jenis' => 'Pemilik Hewan',
            ],
            [
                'nama' => 'Drh. Sarah',
                'email' => 'dokter@gmail.com',
                'password' => '12345678',
                'role' => 'Penyedia Jasa',
                'jenis' => 'dokter',
            ],
            [
                'nama' => 'Sitter Rian',
                'email' => 'sitter@gmail.com',
                'password' => '12345678',
                'role' => 'Penyedia Jasa',
                'jenis' => 'sitter',
            ],
        ]);

        // 2. Seed default Layanan (id_layanan = 1 is default in web.php)
        DB::table('layanan')->insert([
            [
                'id_layanan' => 1,
                'nama_layanan' => 'Home Visit & Check-up',
                'harga' => 150000,
                'deskripsi' => 'Pemeriksaan kesehatan anabul kesayangan Anda langsung di rumah oleh dokter hewan atau pet sitter profesional.',
            ],
            [
                'id_layanan' => 2,
                'nama_layanan' => 'Pet Boarding / Penitipan',
                'harga' => 100000,
                'deskripsi' => 'Penitipan hewan peliharaan dengan fasilitas nyaman dan perawatan berkala.',
            ]
        ]);

        // 3. Seed default Penyedia Jasa (Mitra)
        DB::table('penyedia_jasa')->insert([
            [
                'nama' => 'Sarah Amanda',
                'jenis' => 'dokter',
                'no_hp' => '081234567801',
                'spesialis' => 'Spesialis Kucing & Kelinci',
                'pengalaman' => 4,
                'tarif' => 175000,
                'status' => 'Disetujui',
                'dokumen' => 'SIP-Sarah.pdf',
            ],
            [
                'nama' => 'Jinten Anggraeni',
                'jenis' => 'dokter',
                'no_hp' => '081234567802',
                'spesialis' => 'Spesialis Anjing & Kucing',
                'pengalaman' => 3,
                'tarif' => 150000,
                'status' => 'Disetujui',
                'dokumen' => 'SIP-Jinten.pdf',
            ],
            [
                'nama' => 'Rian Hidayat',
                'jenis' => 'sitter',
                'no_hp' => '081234567803',
                'spesialis' => 'Professional Pet Sitter',
                'pengalaman' => 2,
                'tarif' => 85000,
                'status' => 'Disetujui',
                'dokumen' => 'Cert-Rian.pdf',
            ],
            [
                'nama' => 'Bambang Kusuma',
                'jenis' => 'sitter',
                'no_hp' => '081234567804',
                'spesialis' => 'Large Dog Specialist Sitter',
                'pengalaman' => 5,
                'tarif' => 120000,
                'status' => 'Pending',
                'dokumen' => 'Cert-Bambang.pdf',
            ],
        ]);
    }
}
