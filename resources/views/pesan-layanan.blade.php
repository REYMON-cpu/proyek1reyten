<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Layanan Dokter Hewan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#F4F7F6] text-[#2D433E] min-h-screen flex flex-col justify-between">

    <!-- Navbar -->
    <nav class="w-full bg-white border-b border-[#5E887E]/10 py-4 sticky top-0 z-50 backdrop-blur-md bg-white/80 px-6 md:px-12 flex items-center justify-between">
       <a href="{{ $dokter->jenis == 'sitter' ? '/pilih-sitter' : '/pilih-dokter' }}" class="mr-3 text-gray-400 hover:text-[#5E887E] hover:scale-110 transition-all duration-200 text-lg" title="Kembali">
    <i class="fa-solid fa-arrow-left"></i>
</a>
            <img src="{{ asset('images/logo hijau.svg') }}" alt="Logo" class="h-12 w-auto">
            <span class="text-xl font-bold text-[#5E887E]">Go<span class="text-[#D9B08C]">Pet</span></span>
        </div>
        <span class="text-xs font-bold bg-[#F8FBF0] border border-[#5E887E]/20 text-[#5E887E] px-4 py-2 rounded-full hidden sm:block">
            <i class="fa-solid fa-clock-rotate-left mr-1.5"></i> Respon Cepat & <span class="italic">Home Visit</span>
        </span>
    </nav>

    <!-- Main Content -->
    <main class="w-full max-w-3xl mx-auto px-6 py-10 flex-grow">
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold tracking-tight">Formulir Pemesanan</h1>
            <p class="text-[#5E887E] font-medium text-sm mt-1">Lengkapi data di bawah ini untuk mengonfirmasi kunjungan dokter ke lokasi Anda.</p>
        </div>

        <!-- FORM UTAMA -->
        <form action="/proses-pemesanan" method="POST" class="space-y-8">
            @csrf
            
            <!-- ANTI-NULL FIX: Mengambil ID langsung dari rute parameter URL -->
            <input type="hidden" name="id_mitra" value="{{ $id_terpilih }}">

            <!-- Tampilan Card Dokter Dinamis -->
            <div class="bg-[#5E887E] p-6 rounded-[35px] text-white flex items-center gap-5 shadow-lg shadow-[#5E887E]/20">
                <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center text-2xl">
                    <i class="fas fa-user-md"></i>
                </div>
                <div>
                    <p class="text-xs opacity-80 font-bold uppercase tracking-widest">Anda Memesan Layanan:</p>
                    <h3 class="text-xl font-bold italic">drh. {{ $dokter->nama ?? 'Nama Jasa Tidak Ditemukan' }}</h3>
                    <p class="text-xs bg-white/20 px-3 py-1 rounded-full inline-block mt-1">
                        Biaya Kunjungan: Rp {{ isset($dokter->tarif) ? number_format($dokter->tarif, 0, ',', '.') : '0' }}
                    </p>
                </div>
            </div>

            <!-- BAGIAN 1: DATA HEWAN PELIHARAAN -->
            <div class="bg-white rounded-[35px] p-8 border border-white shadow-sm space-y-6">
                <div class="flex items-center gap-3 border-b border-gray-100 pb-3 mb-2">
                    <span class="w-8 h-8 rounded-xl bg-[#FFFBF7] text-[#D9B08C] flex items-center justify-center text-sm font-bold">1</span>
                    <h2 class="text-lg font-bold text-[#2D433E]">Informasi Anabul (Hewan Peliharaan)</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-500 uppercase tracking-wider block">Nama Hewan</label>
                        <input type="text" name="nama_hewan" required placeholder="Contoh: Kicaw, Meong" class="w-full px-4 py-3 rounded-2xl border border-gray-100 focus:outline-none focus:border-[#5E887E] focus:ring-2 focus:ring-[#5E887E]/20 bg-[#F4F7F6] text-sm font-medium transition-all">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-500 uppercase tracking-wider block">Jenis Hewan</label>
                        <select name="jenis_hewan" required class="w-full px-4 py-3 rounded-2xl border border-gray-100 focus:outline-none focus:border-[#5E887E] focus:ring-2 focus:ring-[#5E887E]/20 bg-[#F4F7F6] text-sm font-medium transition-all">
                            <option value="kucing">Kucing</option>
                            <option value="anjing">Anjing</option>
                            <option value="burung">Burung</option>
                            <option value="kelinci">Kelinci</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider block">Umur Hewan</label>
                    <input type="text" name="umur_hewan" placeholder="Contoh: 3 Tahun atau 5 Bulan" class="w-full px-4 py-3 rounded-2xl border border-gray-100 focus:outline-none focus:border-[#5E887E] focus:ring-2 focus:ring-[#5E887E]/20 bg-[#F4F7F6] text-sm font-medium transition-all">
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider block">Riwayat Penyakit / Kesehatan (Opsional)</label>
                    <textarea name="riwayat_kesehatan" rows="3" placeholder="Tuliskan jika anabul pernah operasi, alergi obat, atau riwayat penyakit bawaan..." class="w-full px-4 py-3 rounded-2xl border border-gray-100 focus:outline-none focus:border-[#5E887E] focus:ring-2 focus:ring-[#5E887E]/20 bg-[#F4F7F6] text-sm font-medium transition-all resize-none"></textarea>
                </div>
            </div>

            <!-- BAGIAN 2: JADWAL KUNJUNGAN & LOKASI -->
            <div class="bg-white rounded-[35px] p-8 border border-white shadow-sm space-y-6">
                <div class="flex items-center gap-3 border-b border-gray-100 pb-3 mb-2">
                    <span class="w-8 h-8 rounded-xl bg-[#F8FBF0] text-[#5E887E] flex items-center justify-center text-sm font-bold">2</span>
                    <h2 class="text-lg font-bold text-[#2D433E]">Waktu Kunjungan & Detail Alamat Rumah</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-500 uppercase tracking-wider block">Tanggal Kunjungan</label>
                        <input type="date" name="tanggal_kunjungan" required class="w-full px-4 py-3 rounded-2xl border border-gray-100 focus:outline-none focus:border-[#5E887E] focus:ring-2 focus:ring-[#5E887E]/20 bg-[#F4F7F6] text-sm font-medium transition-all">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-500 uppercase tracking-wider block">Jam Kunjungan</label>
                        <input type="time" name="jam_kunjungan" required class="w-full px-4 py-3 rounded-2xl border border-gray-100 focus:outline-none focus:border-[#5E887E] focus:ring-2 focus:ring-[#5E887E]/20 bg-[#F4F7F6] text-sm font-medium transition-all">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider block">Alamat Lengkap Rumah</label>
                    <textarea name="alamat" required rows="3" placeholder="Tulis jalan, nomor rumah, nomor RT/RW, kelurahan/kecamatan, serta patokan lokasi..." class="w-full px-4 py-3 rounded-2xl border border-gray-100 focus:outline-none focus:border-[#5E887E] focus:ring-2 focus:ring-[#5E887E]/20 bg-[#F4F7F6] text-sm font-medium transition-all resize-none"></textarea>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider block">Keluhan Utama & Catatan Tambahan</label>
                    <textarea name="catatan" rows="3" placeholder="Contoh: Kucing saya lemas tidak mau makan sejak kemarin malam, muntah busa kuning 2 kali..." class="w-full px-4 py-3 rounded-2xl border border-gray-100 focus:outline-none focus:border-[#5E887E] focus:ring-2 focus:ring-[#5E887E]/20 bg-[#F4F7F6] text-sm font-medium transition-all resize-none"></textarea>
                </div>
            </div>

            <!-- Tombol Konfirmasi Pembayaran/Pemesanan -->
            <button type="submit" class="w-full bg-[#2D433E] hover:bg-[#5E887E] text-white font-bold py-4 rounded-[20px] shadow-lg hover:shadow-xl transition-all duration-300 active:scale-[0.99] text-center text-sm flex items-center justify-center gap-2">
                <i class="fa-solid fa-circle-check"></i> Konfirmasi Pemesanan & Cari Dokter
            </button>
        </form>
    </main>

    <!-- Footer -->
    <footer class="w-full bg-white border-t border-gray-100 py-6 text-center text-xs text-gray-400">
        <p>&copy; 2026 GoPet Team. All rights reserved.</p>
    </footer>

</body>
</html>