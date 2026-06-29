<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes - Proyek Aplikasi GoPet
|--------------------------------------------------------------------------
*/

// ==========================================
// 0. HALAMAN LOGIN UTAMA
// ==========================================
Route::get('/', function () {
    return view('index');
});

// PROSES LOGIN
Route::post('/login/proses', function (Request $request) {
    $email    = $request->input('email');
    $password = $request->input('password');
    $role     = $request->input('role');

    $user = DB::table('user')
              ->where('email', $email)
              ->where('password', $password)
              ->where('role', $role)
              ->first();

    if ($user) {
        // Simpan data user ke sesi
        session([
            'id_user' => $user->id_user,
            'nama'    => $user->nama,
            'email'   => $user->email,
            'role'    => $user->role,
            'jenis'   => $user->jenis
        ]);

        // Jika Penyedia Jasa, cari id_penyedia dari tabel penyedia_jasa
        if ($user->role === 'Penyedia Jasa') {
            $provider = DB::table('penyedia_jasa')
                          ->where('nama', 'like', '%' . $user->nama . '%')
                          ->orWhere('nama', $user->nama)
                          ->first();

            if ($provider) {
                session(['id_penyedia' => $provider->id_penyedia]);
            }
        }

        if ($user->role === 'Admin') {
            return redirect('/dashboard-admin')->with('success', 'Selamat datang kembali, ' . $user->nama . '!');
        } elseif ($user->role === 'Penyedia Jasa') {
            if ($user->jenis === 'sitter') {
                return redirect('/dashboard-sitter')->with('success', 'Selamat datang kembali, ' . $user->nama . '!');
            } else {
                return redirect('/dashboard-dokter')->with('success', 'Selamat datang kembali, ' . $user->nama . '!');
            }
        } else {
            return redirect('/dashboard')->with('success', 'Selamat datang kembali, ' . $user->nama . '!');
        }
    }

    return back()->with('error', 'Email, Password, atau Role salah. Silakan coba lagi!');
})->name('login.proses');


// ==========================================
// FITUR DAFTAR AKUN (REGISTER)
// ==========================================
Route::get('/register', function () {
    return view('register');
});

Route::post('/register', function (Request $request) {
    $nama       = $request->input('nama');
    $email      = $request->input('email');
    $password   = $request->input('password');
    $role_input = $request->input('role');

    // Cek email sudah dipakai
    $cek_email = DB::table('user')->where('email', $email)->first();
    if ($cek_email) {
        return back()->with('error', 'Email sudah terdaftar! Gunakan email lain.');
    }

    // Tentukan role dan jenis
    if ($role_input === 'Penyedia Jasa (Dokter)') {
        $role  = 'Penyedia Jasa';
        $jenis = 'dokter';
    } elseif ($role_input === 'Penyedia Jasa (Pet Sitter)') {
        $role  = 'Penyedia Jasa';
        $jenis = 'sitter';
    } else {
        $role  = $role_input; // 'Pemilik Hewan' atau 'Admin'
        $jenis = $role_input; // simpan sama dengan role untuk non-penyedia
    }

    DB::table('user')->insert([
        'nama'     => $nama,
        'email'    => $email,
        'password' => $password,
        'role'     => $role,
        'jenis'    => $jenis,
    ]);

    // Jika Penyedia Jasa, otomatis buat entry di penyedia_jasa (status Pending)
    if ($role === 'Penyedia Jasa') {
        $cek_penyedia = DB::table('penyedia_jasa')->where('nama', $nama)->first();
        if (!$cek_penyedia) {
            DB::table('penyedia_jasa')->insert([
                'nama'       => $nama,
                'jenis'      => $jenis,
                'no_hp'      => '-',
                'spesialis'  => ($jenis === 'sitter') ? 'Pet Sitter' : 'Dokter Hewan',
                'pengalaman' => 0,
                'tarif'      => 0,
                'status'     => 'Pending',
                'dokumen'    => null,
            ]);
        }
    }

    return redirect('/')
        ->with('success', 'Akun berhasil dibuat! Silakan login.' . ($role === 'Penyedia Jasa' ? ' Akun Anda menunggu persetujuan Admin.' : ''));
});


// ==========================================
// 1. DASHBOARD PEMILIK HEWAN
// ==========================================
Route::get('/dashboard', function () {
    if (!session()->has('id_user')) {
        return redirect('/')->with('error', 'Silakan login terlebih dahulu!');
    }

    $id_user = session('id_user');
    $nama    = session('nama');

    $hewan         = DB::table('hewan')->where('id_user', $id_user)->get();
    $layanan       = DB::table('layanan')->get();
    $daftar_rating = DB::table('review_ratings')->orderBy('id', 'desc')->get();

    // Ambil riwayat rekam medis (dokter) dan catatan harian (sitter) dari database
    $riwayat_medis = DB::table('rekam_medis')
        ->join('penyedia_jasa', 'rekam_medis.id_penyedia', '=', 'penyedia_jasa.id_penyedia')
        ->where('rekam_medis.id_user', $id_user)
        ->select('rekam_medis.*', 'penyedia_jasa.nama as nama_penyedia', 'penyedia_jasa.jenis as jenis_penyedia')
        ->orderBy('rekam_medis.id', 'desc')
        ->get();

    return view('dashboard', [
        'nama'           => $nama,
        'hewan'          => $hewan,
        'daftar_layanan' => $layanan,
        'daftar_rating'  => $daftar_rating,
        'riwayat_medis'  => $riwayat_medis,
    ]);
});


// ==========================================
// PILIH DOKTER & SITTER
// ==========================================
Route::get('/pilih-dokter', function () {
    $dokter = DB::table('penyedia_jasa')
                ->where('jenis', 'dokter')
                ->where('status', 'Disetujui')
                ->get();
    return view('pilih-dokter', ['daftar_dokter' => $dokter]);
});

Route::get('/pilih-sitter', function () {
    $sitter = DB::table('penyedia_jasa')
                ->where('jenis', 'sitter')
                ->where('status', 'Disetujui')
                ->get();
    return view('pilih-sitter', ['daftar_sitter' => $sitter]);
});

// Halaman daftar mitra (formulir pendaftaran)
Route::get('/daftar-mitra', function () {
    return view('daftar-mitra');
});

Route::post('/daftar-mitra', function (Request $request) {
    $nama        = $request->input('nama');
    $jenis       = $request->input('peran'); // 'dokter' atau 'sitter'
    $spesialis   = $request->input('spesialisasi');
    $tarif       = $request->input('harga');
    $pengalaman  = $request->input('pengalaman');

    // Handle upload file KTP
    $dokumen_name = 'Belum ada dokumen';
    if ($request->hasFile('berkas_ktp') && $request->file('berkas_ktp')->isValid()) {
        $file         = $request->file('berkas_ktp');
        $dokumen_name = time() . '_ktp_' . $file->getClientOriginalName();
        $destPath     = public_path('uploads');
        if (!file_exists($destPath)) {
            mkdir($destPath, 0777, true);
        }
        $file->move($destPath, $dokumen_name);
    } elseif ($request->hasFile('berkas_sip') && $request->file('berkas_sip')->isValid()) {
        $file         = $request->file('berkas_sip');
        $dokumen_name = time() . '_sip_' . $file->getClientOriginalName();
        $destPath     = public_path('uploads');
        if (!file_exists($destPath)) {
            mkdir($destPath, 0777, true);
        }
        $file->move($destPath, $dokumen_name);
    }

    DB::table('penyedia_jasa')->insert([
        'nama'       => $nama,
        'jenis'      => $jenis,
        'no_hp'      => '081234567890',
        'spesialis'  => $spesialis,
        'pengalaman' => $pengalaman ?? 0,
        'tarif'      => $tarif ?? 0,
        'status'     => 'Pending',
        'dokumen'    => $dokumen_name,
    ]);

    return redirect('/dashboard')->with('success', 'Pendaftaran mitra berhasil diajukan! Menunggu persetujuan admin.');
});

// Halaman chat (legacy static)
Route::get('/chat', function () {
    return view('chat');
});


// ==========================================
// CHAT SITTER ↔ PEMILIK HEWAN
// ==========================================

// Halaman chat pemilik dengan sitter tertentu
Route::get('/chat-sitter/{id_penyedia}', function ($id_penyedia) {
    if (!session()->has('id_user')) {
        return redirect('/')
            ->with('error', 'Silakan login terlebih dahulu!');
    }

    $sitter = DB::table('penyedia_jasa')->where('id_penyedia', $id_penyedia)->first();
    if (!$sitter) {
        return redirect('/pilih-sitter')
            ->with('error', 'Penyedia jasa tidak ditemukan!');
    }

    $id_pemilik = session('id_user');
    $pemilik    = DB::table('user')->where('id_user', $id_pemilik)->first();

    $pesan_list = DB::table('chat_pesan')
        ->where('id_pemilik', $id_pemilik)
        ->where('id_penyedia', $id_penyedia)
        ->orderBy('id', 'asc')
        ->get();

    return view('chat-sitter', [
        'sitter'     => $sitter,
        'pemilik'    => $pemilik,
        'pesan_list' => $pesan_list,
    ]);
})->name('chat.sitter');

// Kirim pesan (pemilik → sitter)
Route::post('/chat-sitter/kirim', function (Request $request) {
    if (!session()->has('id_user')) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $id_pemilik  = session('id_user');
    $id_penyedia = $request->input('id_penyedia');
    $pesan       = trim($request->input('pesan', ''));
    $pengirim    = $request->input('pengirim', 'pemilik'); // 'pemilik' atau 'penyedia'

    if (!$pesan || !$id_penyedia) {
        return response()->json(['error' => 'Data tidak lengkap'], 422);
    }

    // Jika pengirim adalah penyedia, gunakan id_pemilik dari request
    if ($pengirim === 'penyedia') {
        $id_pemilik = $request->input('id_pemilik', $id_pemilik);
    }

    $id = DB::table('chat_pesan')->insertGetId([
        'id_pemilik'  => $id_pemilik,
        'id_penyedia' => $id_penyedia,
        'pengirim'    => $pengirim,
        'pesan'       => $pesan,
        'created_at'  => now(),
    ]);

    return response()->json(['success' => true, 'id' => $id, 'created_at' => now()->format('H:i')]);
})->name('chat.kirim');

// API: ambil pesan terbaru (polling)
Route::get('/api/chat-pesan/{id_penyedia}', function ($id_penyedia) {
    if (!session()->has('id_user')) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    $id_pemilik = session('id_user');
    $since_id   = request()->query('since_id', 0);

    $pesan_list = DB::table('chat_pesan')
        ->where('id_pemilik', $id_pemilik)
        ->where('id_penyedia', $id_penyedia)
        ->where('id', '>', $since_id)
        ->orderBy('id', 'asc')
        ->get();

    return response()->json($pesan_list);
});

// API: ambil daftar pemilik yang chat dengan sitter (untuk dashboard sitter)
Route::get('/api/chat-list-sitter', function () {
    if (!session()->has('id_penyedia')) {
        return response()->json([]);
    }
    $id_penyedia = session('id_penyedia');

    // Ambil pemilik unik yang pernah chat dengan sitter ini
    $pemilik_list = DB::table('chat_pesan')
        ->join('user', 'chat_pesan.id_pemilik', '=', 'user.id_user')
        ->where('chat_pesan.id_penyedia', $id_penyedia)
        ->select(
            'user.id_user',
            'user.nama as nama_pemilik',
            DB::raw('MAX(chat_pesan.id) as last_id'),
            DB::raw('MAX(chat_pesan.pesan) as last_pesan'),
            DB::raw('SUM(CASE WHEN chat_pesan.pengirim = \'pemilik\' THEN 1 ELSE 0 END) as unread')
        )
        ->groupBy('user.id_user', 'user.nama')
        ->orderBy('last_id', 'desc')
        ->get();

    return response()->json($pemilik_list);
});

// API: ambil pesan chat antara sitter dan pemilik tertentu
Route::get('/api/chat-sitter/{id_pemilik}', function ($id_pemilik) {
    if (!session()->has('id_penyedia')) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    $id_penyedia = session('id_penyedia');
    $since_id    = request()->query('since_id', 0);

    $pesan_list = DB::table('chat_pesan')
        ->where('id_pemilik', $id_pemilik)
        ->where('id_penyedia', $id_penyedia)
        ->where('id', '>', $since_id)
        ->orderBy('id', 'asc')
        ->get();

    return response()->json($pesan_list);
});


// ==========================================
// 3. PROSES SIMPAN FORM RATING
// ==========================================
Route::post('/review/store', function (Request $request) {
    DB::table('review_ratings')->insert([
        'customer_name' => $request->input('customer_name'),
        'pet_name'      => $request->input('pet_name'),
        'rating'        => $request->input('rating_value', 5),
        'experience'    => $request->input('experience'),
    ]);

    return back()->with('success', 'Rating berhasil disimpan!');
})->name('review.store');


// =========================================================================
// 4. HALAMAN PESAN LAYANAN
// =========================================================================
Route::get('/pesan-layanan/{id}', function ($id) {
    $dokter = DB::table('penyedia_jasa')->where('id_penyedia', $id)->first();

    if (!$dokter) {
        return redirect('/pilih-dokter')->with('error', 'Penyedia jasa tidak ditemukan!');
    }

    return view('pesan-layanan', [
        'dokter'      => $dokter,
        'id_terpilih' => $id,
    ]);
});


// =========================================================================
// 5. PROSES SIMPAN FORM PEMESANAN
// =========================================================================
Route::post('/proses-pemesanan', function (Request $request) {
    if (!session()->has('id_user')) {
        return redirect('/')->with('error', 'Silakan login terlebih dahulu!');
    }

    $id_user = session('id_user');

    // Simpan data hewan
    $id_hewan = DB::table('hewan')->insertGetId([
        'id_user'          => $id_user,
        'nama_hewan'       => $request->input('nama_hewan', 'Tidak diketahui'),
        'jenis'            => $request->input('jenis_hewan', 'lainnya'),
        'umur'             => $request->input('umur_hewan', '-'),
        'riwayat_penyakit' => $request->input('riwayat_kesehatan', '-'),
    ]);

    // Simpan pemesanan
    DB::table('pemesanan')->insert([
        'id_user'     => $id_user,
        'id_hewan'    => $id_hewan,
        'id_layanan'  => 1,
        'id_penyedia' => $request->input('id_mitra') ?? 1,
        'tanggal'     => $request->input('tanggal_kunjungan') ?? date('Y-m-d'),
        'alamat'      => $request->input('alamat', '-'),
        'status'      => 'Pending',
    ]);

    return redirect('/dashboard')->with('success', 'Pemesanan berhasil dibuat! Dokter/Sitter akan segera menghubungi Anda.');
});


// ==========================================
// 6. PROSES SIMPAN FORM KONTAK
// ==========================================
Route::post('/kontak-store', function (Request $request) {
    $request->validate([
        'nama_lengkap' => 'required|string|max:100',
        'email'        => 'required|email|max:100',
        'pesan'        => 'required|string',
    ]);

    DB::table('kontak_pesan')->insert([
        'nama_lengkap' => $request->nama_lengkap,
        'email'        => $request->email,
        'pesan'        => $request->pesan,
        'created_at'   => now(),
    ]);

    return back()->with('success', 'Pesan Anda berhasil dikirim ke tim GoPet! Terima kasih atas masukan Anda.');
})->name('kontak.store');


// ==========================================
// DASHBOARD DOKTER
// ==========================================
Route::get('/dashboard-dokter', function () {
    if (!session()->has('id_user')) {
        return redirect('/')->with('error', 'Silakan login terlebih dahulu!');
    }

    // Gunakan id_penyedia dari session jika ada, fallback ke pencarian by nama
    $id_penyedia = session('id_penyedia');
    $provider    = null;

    if ($id_penyedia) {
        $provider = DB::table('penyedia_jasa')->where('id_penyedia', $id_penyedia)->first();
    }

    if (!$provider) {
        $nama     = session('nama');
        $provider = DB::table('penyedia_jasa')
                      ->where('nama', 'like', '%' . $nama . '%')
                      ->first();
        if ($provider) {
            session(['id_penyedia' => $provider->id_penyedia]);
        }
    }

    $bookings = collect();
    if ($provider) {
        $bookings = DB::table('pemesanan')
            ->join('user', 'pemesanan.id_user', '=', 'user.id_user')
            ->join('hewan', 'pemesanan.id_hewan', '=', 'hewan.id_hewan')
            ->where('pemesanan.id_penyedia', $provider->id_penyedia)
            ->select(
                'pemesanan.*',
                'user.nama as nama_pemilik',
                'hewan.nama_hewan',
                'hewan.jenis as jenis_hewan'
            )
            ->orderBy('id_pemesanan', 'desc')
            ->get();
    }

    // Ambil daftar pemilik yang pernah chat dengan dokter ini
    $chat_list = collect();
    if ($provider) {
        $chat_list = DB::table('chat_pesan')
            ->join('user', 'chat_pesan.id_pemilik', '=', 'user.id_user')
            ->where('chat_pesan.id_penyedia', $provider->id_penyedia)
            ->select(
                'user.id_user',
                'user.nama as nama_pemilik',
                DB::raw('MAX(chat_pesan.id) as last_id'),
                DB::raw('(SELECT pesan FROM chat_pesan cp2 WHERE cp2.id_pemilik = user.id_user AND cp2.id_penyedia = ' . $provider->id_penyedia . ' ORDER BY cp2.id DESC LIMIT 1) as last_pesan'),
                DB::raw('(SELECT created_at FROM chat_pesan cp3 WHERE cp3.id_pemilik = user.id_user AND cp3.id_penyedia = ' . $provider->id_penyedia . ' ORDER BY cp3.id DESC LIMIT 1) as last_time'),
                DB::raw('SUM(CASE WHEN chat_pesan.pengirim = \'pemilik\' THEN 1 ELSE 0 END) as unread_count')
            )
            ->groupBy('user.id_user', 'user.nama')
            ->orderBy('last_id', 'desc')
            ->get();
    }

    $rekam_list = collect();
    if ($provider) {
        $rekam_list = DB::table('rekam_medis')
            ->where('id_penyedia', $provider->id_penyedia)
            ->where('tipe', 'dokter')
            ->orderBy('id', 'desc')
            ->get();
    }

    $konsultasi_hari_ini = 0;
    $menunggu_konfirmasi = 0;
    $total_hewan_ditangani = 0;

    if ($provider) {
        $konsultasi_hari_ini = DB::table('pemesanan')
            ->where('id_penyedia', $provider->id_penyedia)
            ->where('status', 'Berlangsung')
            ->count();

        $menunggu_konfirmasi = DB::table('pemesanan')
            ->where('id_penyedia', $provider->id_penyedia)
            ->where('status', 'Pending')
            ->count();

        $total_hewan_ditangani = DB::table('pemesanan')
            ->where('id_penyedia', $provider->id_penyedia)
            ->whereIn('status', ['Berlangsung', 'Selesai'])
            ->count();
    }

    return view('dashboard-dokter', [
        'provider'              => $provider,
        'bookings'              => $bookings,
        'chat_list'             => $chat_list,
        'rekam_list'            => $rekam_list,
        'konsultasi_hari_ini'   => $konsultasi_hari_ini,
        'menunggu_konfirmasi'   => $menunggu_konfirmasi,
        'total_hewan_ditangani' => $total_hewan_ditangani,
    ]);
});


// ==========================================
// HALAMAN LOGIN ADMIN (TERSENDIRI)
// ==========================================
Route::get('/login-admin', function () {
    return view('login-admin');
});


// ==========================================
// DASHBOARD ADMIN
// ==========================================
Route::get('/dashboard-admin', function () {
    if (!session()->has('id_user') || session('role') !== 'Admin') {
        return redirect('/')->with('error', 'Silakan login sebagai Admin terlebih dahulu!');
    }

    $total_users   = DB::table('user')->count();
    $total_mitra   = DB::table('penyedia_jasa')->where('status', 'Disetujui')->count();
    $pending_mitra = DB::table('penyedia_jasa')->where('status', 'Pending')->count();

    // PERBAIKAN: Tambahkan hewan.jenis as jenis_hewan agar tidak error di view
    $bookings = DB::table('pemesanan')
        ->join('user', 'pemesanan.id_user', '=', 'user.id_user')
        ->join('hewan', 'pemesanan.id_hewan', '=', 'hewan.id_hewan')
        ->join('penyedia_jasa', 'pemesanan.id_penyedia', '=', 'penyedia_jasa.id_penyedia')
        ->select(
            'pemesanan.*',
            'user.nama as nama_pemilik',
            'hewan.nama_hewan',
            'hewan.jenis as jenis_hewan',
            'penyedia_jasa.nama as nama_mitra',
            'penyedia_jasa.jenis as jenis_mitra'
        )
        ->orderBy('id_pemesanan', 'desc')
        ->get();

    $users_list = DB::table('user')->get();
    $mitra_list = DB::table('penyedia_jasa')->get();
    $pending_mitra_list = DB::table('penyedia_jasa')->where('status', 'Pending')->get();
    $approved_mitra_list = DB::table('penyedia_jasa')->where('status', 'Disetujui')->get();

    $pending_tarif_list = collect();
    if (Schema::hasTable('pengajuan_tarif')) {
        $pending_tarif_list = DB::table('pengajuan_tarif')
            ->join('penyedia_jasa', 'pengajuan_tarif.id_penyedia', '=', 'penyedia_jasa.id_penyedia')
            ->select('pengajuan_tarif.*', 'penyedia_jasa.nama as nama_mitra', 'penyedia_jasa.jenis')
            ->where('pengajuan_tarif.status', 'Pending')
            ->orderBy('pengajuan_tarif.created_at', 'desc')
            ->get();
    }

    $kontak_pesan = DB::table('kontak_pesan')->orderBy('created_at', 'desc')->get();

    return view('dashboard-admin', [
        'total_users'        => $total_users,
        'total_mitra'        => $total_mitra,
        'pending_mitra'      => $pending_mitra,
        'bookings'           => $bookings,
        'users_list'         => $users_list,
        'mitra_list'         => $mitra_list,
        'pending_mitra_list' => $pending_mitra_list,
        'approved_mitra_list'=> $approved_mitra_list,
        'pending_tarif_list' => $pending_tarif_list,
        'kontak_pesan'       => $kontak_pesan,
    ]);
});


// ==========================================
// STORE PENGAJUAN TARIF PENYEDIA JASA
// ==========================================
Route::post('/pengajuan-tarif', function (Request $request) {
    if (!session()->has('id_user') || session('role') !== 'Penyedia Jasa') {
        return redirect('/')->with('error', 'Silakan login sebagai Penyedia Jasa terlebih dahulu!');
    }

    $id_penyedia = session('id_penyedia');
    
    // Jika belum ada di session, cari dari nama
    if (!$id_penyedia) {
        $nama = session('nama');
        $provider = DB::table('penyedia_jasa')
            ->where('nama', 'like', '%' . $nama . '%')
            ->orWhere('nama', $nama)
            ->first();
        if ($provider) {
            $id_penyedia = $provider->id_penyedia;
            session(['id_penyedia' => $id_penyedia]);
        }
    }

    if (!$id_penyedia) {
        return back()->with('error', 'Data penyedia tidak ditemukan. Silakan login ulang.');
    }

    $dokumen = null;
    if ($request->hasFile('dokumen') && $request->file('dokumen')->isValid()) {
        $file = $request->file('dokumen');
        $filename = time() . '_pengajuan_' . preg_replace('/[^A-Za-z0-9_.-]/', '_', $file->getClientOriginalName());
        $destPath = public_path('uploads/pengajuan_tarif');
        if (!file_exists($destPath)) {
            mkdir($destPath, 0777, true);
        }
        $file->move($destPath, $filename);
        $dokumen = $filename;
    }

    $inserted = DB::table('pengajuan_tarif')->insert([
        'id_penyedia' => $id_penyedia,
        'tarif_lama'  => (int) $request->input('tarif_sekarang', 0),
        'tarif_baru'  => (int) $request->input('tarif_baru'),
        'alasan'      => $request->input('alasan', ''),
        'dokumen'     => $dokumen,
        'status'      => 'Pending',
        'created_at'  => now(),
        'updated_at'  => now(),
    ]);

    if ($inserted) {
        return back()->with('success', 'Pengajuan tarif berhasil dikirim ke Admin. Tunggu approval dari Admin.');
    } else {
        return back()->with('error', 'Gagal menyimpan pengajuan tarif. Coba lagi.');
    }
})->name('pengajuan.tarif.store');

Route::post('/pengajuan-tarif/approve/{id}', function ($id) {
    $pengajuan = DB::table('pengajuan_tarif')->where('id_pengajuan', $id)->first();
    if (!$pengajuan) {
        return back()->with('error', 'Data pengajuan tidak ditemukan.');
    }

    DB::table('pengajuan_tarif')->where('id_pengajuan', $id)->update(['status' => 'Disetujui', 'updated_at' => now()]);
    DB::table('penyedia_jasa')->where('id_penyedia', $pengajuan->id_penyedia)->update(['tarif' => $pengajuan->tarif_baru]);

    return back()->with('success', 'Pengajuan tarif berhasil disetujui dan tarif diperbarui.');
})->name('pengajuan.tarif.approve');

Route::post('/pengajuan-tarif/reject/{id}', function ($id) {
    $pengajuan = DB::table('pengajuan_tarif')->where('id_pengajuan', $id)->first();
    if (!$pengajuan) {
        return back()->with('error', 'Data pengajuan tidak ditemukan.');
    }

    DB::table('pengajuan_tarif')->where('id_pengajuan', $id)->update(['status' => 'Ditolak', 'updated_at' => now()]);

    return back()->with('success', 'Pengajuan tarif telah ditolak.');
})->name('pengajuan.tarif.reject');


// ==========================================
// DASHBOARD SITTER
// ==========================================
Route::get('/dashboard-sitter', function () {
    if (!session()->has('id_user')) {
        return redirect('/')
            ->with('error', 'Silakan login terlebih dahulu!');
    }

    // Gunakan id_penyedia dari session jika ada, fallback ke pencarian by nama
    $id_penyedia = session('id_penyedia');
    $provider    = null;

    if ($id_penyedia) {
        $provider = DB::table('penyedia_jasa')->where('id_penyedia', $id_penyedia)->first();
    }

    if (!$provider) {
        $nama     = session('nama');
        $provider = DB::table('penyedia_jasa')
                      ->where('nama', 'like', '%' . $nama . '%')
                      ->first();
        if ($provider) {
            session(['id_penyedia' => $provider->id_penyedia]);
        }
    }

    $bookings = collect();
    if ($provider) {
        $bookings = DB::table('pemesanan')
            ->join('user', 'pemesanan.id_user', '=', 'user.id_user')
            ->join('hewan', 'pemesanan.id_hewan', '=', 'hewan.id_hewan')
            ->where('pemesanan.id_penyedia', $provider->id_penyedia)
            ->select(
                'pemesanan.*',
                'user.nama as nama_pemilik',
                'hewan.nama_hewan',
                'hewan.jenis as jenis_hewan'
            )
            ->orderBy('id_pemesanan', 'desc')
            ->get();
    }

    // Ambil daftar pemilik yang pernah chat dengan sitter ini
    $chat_list = collect();
    if ($provider) {
        $chat_list = DB::table('chat_pesan')
            ->join('user', 'chat_pesan.id_pemilik', '=', 'user.id_user')
            ->where('chat_pesan.id_penyedia', $provider->id_penyedia)
            ->select(
                'user.id_user',
                'user.nama as nama_pemilik',
                DB::raw('MAX(chat_pesan.id) as last_id'),
                DB::raw('(SELECT pesan FROM chat_pesan cp2 WHERE cp2.id_pemilik = user.id_user AND cp2.id_penyedia = ' . $provider->id_penyedia . ' ORDER BY cp2.id DESC LIMIT 1) as last_pesan'),
                DB::raw('(SELECT created_at FROM chat_pesan cp3 WHERE cp3.id_pemilik = user.id_user AND cp3.id_penyedia = ' . $provider->id_penyedia . ' ORDER BY cp3.id DESC LIMIT 1) as last_time'),
                DB::raw('SUM(CASE WHEN chat_pesan.pengirim = \'pemilik\' THEN 1 ELSE 0 END) as unread_count')
            )
            ->groupBy('user.id_user', 'user.nama')
            ->orderBy('last_id', 'desc')
            ->get();
    }

    $catatan_list = collect();
    if ($provider) {
        $catatan_list = DB::table('rekam_medis')
            ->where('id_penyedia', $provider->id_penyedia)
            ->where('tipe', 'sitter')
            ->orderBy('id', 'desc')
            ->get();
    }

    $penitipan_hari_ini = 0;
    $menunggu_konfirmasi = 0;
    $total_hewan_diasuh = 0;

    if ($provider) {
        $penitipan_hari_ini = DB::table('pemesanan')
            ->where('id_penyedia', $provider->id_penyedia)
            ->where('status', 'Berlangsung')
            ->count();

        $menunggu_konfirmasi = DB::table('pemesanan')
            ->where('id_penyedia', $provider->id_penyedia)
            ->where('status', 'Pending')
            ->count();

        $total_hewan_diasuh = DB::table('pemesanan')
            ->where('id_penyedia', $provider->id_penyedia)
            ->whereIn('status', ['Berlangsung', 'Selesai'])
            ->count();
    }

    return view('dashboard-sitter', [
        'provider'            => $provider,
        'bookings'            => $bookings,
        'chat_list'           => $chat_list,
        'catatan_list'        => $catatan_list,
        'penitipan_hari_ini'  => $penitipan_hari_ini,
        'menunggu_konfirmasi' => $menunggu_konfirmasi,
        'total_hewan_diasuh'  => $total_hewan_diasuh,
    ]);
});


// ==========================================
// UPDATE STATUS PEMESANAN
// ==========================================
Route::post('/pemesanan/update-status/{id}', function (Request $request, $id) {
    $status = $request->input('status');
    DB::table('pemesanan')->where('id_pemesanan', $id)->update(['status' => $status]);
    return back()->with('success', 'Status pemesanan berhasil diperbarui!');
})->name('pemesanan.update-status');


// ==========================================
// APPROVE / REJECT MITRA
// ==========================================
Route::post('/mitra/approve/{id}', function ($id) {
    DB::table('penyedia_jasa')->where('id_penyedia', $id)->update(['status' => 'Disetujui']);
    return back()->with('success', 'Mitra berhasil disetujui!');
})->name('mitra.approve');

Route::post('/mitra/reject/{id}', function ($id) {
    DB::table('penyedia_jasa')->where('id_penyedia', $id)->update(['status' => 'Ditolak']);
    return back()->with('success', 'Mitra berhasil ditolak!');
})->name('mitra.reject');


// ==========================================
// REKAM MEDIS & CATATAN HARIAN (SAVE & DELETE)
// ==========================================
Route::post('/rekam-medis/save', function (Request $request) {
    if (!session()->has('id_user')) {
        return redirect('/')->with('error', 'Silakan login terlebih dahulu!');
    }

    $id = $request->input('id');
    $tipe = $request->input('tipe', 'dokter');
    
    $pemilik_nama = $request->input('nama_pemilik');
    $user = DB::table('user')->where('nama', $pemilik_nama)->first();
    $id_user = $user ? $user->id_user : 0;
    
    $data = [
        'id_penyedia'  => session('id_penyedia'),
        'tipe'         => $tipe,
        'nama_hewan'   => $request->input('nama_hewan'),
        'jenis_hewan'  => $request->input('jenis_hewan'),
        'nama_pemilik' => $pemilik_nama,
        'id_user'      => $id_user,
        'tanggal'      => $request->input('tanggal'),
        'diagnosis'    => $request->input('diagnosis'),
        'tindakan'     => $request->input('tindakan'),
        'jenis_layanan'=> $request->input('jenis_layanan'),
        'catatan'      => $request->input('catatan'),
        'updated_at'   => now(),
    ];
    
    if ($id) {
        DB::table('rekam_medis')->where('id', $id)->update($data);
        $msg = $tipe === 'dokter' ? 'Rekam medis berhasil diperbarui!' : 'Catatan harian berhasil diperbarui!';
    } else {
        $data['created_at'] = now();
        DB::table('rekam_medis')->insert($data);
        $msg = $tipe === 'dokter' ? 'Rekam medis berhasil ditambahkan!' : 'Catatan harian berhasil ditambahkan!';
    }
    
    return back()->with('success', $msg);
})->name('rekam-medis.save');

Route::post('/rekam-medis/delete/{id}', function ($id) {
    if (!session()->has('id_user')) {
        return redirect('/')->with('error', 'Silakan login terlebih dahulu!');
    }
    DB::table('rekam_medis')->where('id', $id)->delete();
    return back()->with('success', 'Data berhasil dihapus!');
})->name('rekam-medis.delete');


// ==========================================
// LOGOUT
// ==========================================
Route::get('/logout', function () {
    session()->flush();
    return redirect('/')->with('success', 'Kamu berhasil keluar. Sampai jumpa!');
})->name('logout');
