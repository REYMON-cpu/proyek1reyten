<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== PENYEDIA_JASA TARIF AFTER APPROVAL ===\n";
$providers = DB::table('penyedia_jasa')->select('nama', 'tarif', 'status')->get();
foreach ($providers as $p) {
    echo json_encode($p) . "\n";
}

echo "\n=== PENGAJUAN_TARIF STATUS ===\n";
$pengajuan = DB::table('pengajuan_tarif')->select('id_pengajuan', 'id_penyedia', 'tarif_baru', 'status')->get();
foreach ($pengajuan as $p) {
    echo json_encode($p) . "\n";
}
