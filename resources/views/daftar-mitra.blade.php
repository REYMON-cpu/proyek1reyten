<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Mitra</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#F4F7F6] text-[#2D433E]">

    <div class="container mx-auto px-6 py-12 max-w-4xl">

        <div class="flex justify-between items-center mb-10">
            <a href="/dashboard" class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-[#2D433E] shadow-sm hover:bg-[#5E887E] hover:text-white transition-all">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="text-right">
                <h1 class="text-3xl font-extrabold tracking-tight">Formulir Mitra</h1>
                <p class="text-[#5E887E] font-medium text-sm">Lengkapi Profil & Dokumen Anda</p>
            </div>
        </div>

        <form action="/daftar-mitra" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <div class="bg-white p-10 rounded-[45px] shadow-sm border border-white">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-10 h-10 bg-[#5E887E]/10 text-[#5E887E] rounded-xl flex items-center justify-center">
                        <i class="fas fa-user-edit"></i>
                    </div>
                    <h2 class="text-xl font-bold">Data Pribadi</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase text-gray-400 ml-2">Nama Lengkap & Gelar</label>
                        <input type="text" name="nama" required placeholder="Contoh: drh. Jinten Anggraeni" class="w-full p-4 rounded-2xl bg-[#F8FBF0] border-none focus:ring-2 focus:ring-[#5E887E] outline-none transition-all">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase text-gray-400 ml-2">Pilih Peran</label>
                        <select name="peran" required class="w-full p-4 rounded-2xl bg-[#F8FBF0] border-none focus:ring-2 focus:ring-[#5E887E] outline-none transition-all">
                            <option value="dokter">Dokter Hewan</option>
                            <option value="sitter">Pet Sitter</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase text-gray-400 ml-2">Spesialisasi / Keahlian</label>
                        <input type="text" name="spesialisasi" required placeholder="Contoh: Spesialis Kucing & Kelinci / Cat Lover Sitter" class="w-full p-4 rounded-2xl bg-[#F8FBF0] border-none focus:ring-2 focus:ring-[#5E887E] outline-none transition-all">
                    </div>


                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase text-gray-400 ml-2">Harga Jasa (Rp)</label>
                        <input type="number" name="harga" required placeholder="Misal: 150000" class="w-full p-4 rounded-2xl bg-[#F8FBF0] border-none focus:ring-2 focus:ring-[#5E887E] outline-none transition-all">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase text-gray-400 ml-2">Pengalaman (Tahun)</label>
                        <input type="number" name="pengalaman" required placeholder="Misal: 2" class="w-full p-4 rounded-2xl bg-[#F8FBF0] border-none focus:ring-2 focus:ring-[#5E887E] outline-none transition-all">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase text-gray-400 ml-2">Foto Profil Mitra</label>
                        <input type="file" name="foto_profil" accept="image/*" required class="w-full p-3 rounded-2xl bg-[#F8FBF0] border-none text-sm text-gray-400 outline-none file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#5E887E]/10 file:text-[#5E887E] hover:file:bg-[#5E887E]/20">
                    </div>

                    <div class="md:col-span-2 space-y-2">
                        <label class="text-xs font-bold uppercase text-gray-400 ml-2">Tentang Anda (Bio)</label>
                        <textarea name="bio" required placeholder="Ceritakan keahlian dan kecintaanmu pada hewan..." class="w-full p-4 rounded-2xl bg-[#F8FBF0] border-none focus:ring-2 focus:ring-[#5E887E] outline-none h-32 transition-all"></textarea>
                    </div>
                </div>
            </div>

            <div class="bg-white p-10 rounded-[45px] shadow-sm border border-white">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-10 h-10 bg-[#D9B08C]/10 text-[#D9B08C] rounded-xl flex items-center justify-center">
                        <i class="fas fa-file-upload"></i>
                    </div>
                    <h2 class="text-xl font-bold">Berkas Pendukung</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- KTP -->
                    <label class="relative flex flex-col items-center justify-center h-40 bg-[#F8FBF0] rounded-[30px] border-2 border-dashed border-gray-200 hover:border-[#5E887E] transition-all cursor-pointer group">
                        <input type="file" name="berkas_ktp" required class="absolute inset-0 opacity-0 cursor-pointer">
                        <i class="fas fa-id-card text-2xl text-gray-300 mb-2 group-hover:text-[#5E887E]"></i>
                        <p class="text-[11px] font-bold text-center px-4">UPLOAD KTP</p>
                    </label>

                    <!-- SIP -->
                    <label class="relative flex flex-col items-center justify-center h-40 bg-[#F8FBF0] rounded-[30px] border-2 border-dashed border-gray-200 hover:border-[#5E887E] transition-all cursor-pointer group">
                        <input type="file" name="berkas_sip" class="absolute inset-0 opacity-0 cursor-pointer">
                        <i class="fas fa-file-medical text-2xl text-gray-300 mb-2 group-hover:text-[#5E887E]"></i>
                        <p class="text-[11px] font-bold text-center px-4">UPLOAD SIP (KHUSUS DOKTER)</p>
                    </label>

                    <!-- SKCK -->
                    <label class="relative flex flex-col items-center justify-center h-40 bg-[#F8FBF0] rounded-[30px] border-2 border-dashed border-gray-200 hover:border-[#D9B08C] transition-all cursor-pointer group">
                        <input type="file" name="berkas_skck" required class="absolute inset-0 opacity-0 cursor-pointer">
                        <i class="fas fa-shield-check text-2xl text-gray-300 mb-2 group-hover:text-[#D9B08C]"></i>
                        <p class="text-[11px] font-bold text-center px-4">UPLOAD SKCK</p>
                    </label>

                    <!-- Sertifikat -->
                    <label class="relative flex flex-col items-center justify-center h-40 bg-[#F8FBF0] rounded-[30px] border-2 border-dashed border-gray-200 hover:border-blue-400 transition-all cursor-pointer group">
                        <input type="file" name="berkas_sertifikat[]" class="absolute inset-0 opacity-0 cursor-pointer" multiple>
                        <i class="fas fa-award text-2xl text-gray-300 mb-2 group-hover:text-blue-400"></i>
                        <p class="text-[11px] font-bold text-center px-4">SERTIFIKAT LAINNYA</p>
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <a href="/dashboard" class="py-5 bg-white border-2 border-gray-100 rounded-[30px] font-bold text-center text-gray-400 hover:text-red-500 transition-all">
                    Batal
                </a>
                <button type="submit" class="py-5 bg-[#2D433E] text-white rounded-[30px] font-black text-lg hover:bg-[#5E887E] transition-all shadow-xl">
                    Daftar Sekarang
                </button>
            </div>
        </form>
    </div>

    <script>
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function() {
            let fileName = this.files[0].name;
            let label = this.closest('label').querySelector('p');
            label.innerText = "Terpilih: " + fileName;
            label.classList.add('text-[#5E887E]'); //
        });
    });
</script>
</body>
</html>

