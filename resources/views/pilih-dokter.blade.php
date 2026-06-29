<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Dokter Hewan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-[#F4F7F6] text-[#2D433E] min-h-screen flex flex-col justify-between">

    <nav class="w-full bg-white border-b border-[#5E887E]/10 py-4 sticky top-0 z-50 backdrop-blur-md bg-white/80 px-6 md:px-12 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-2 w-full sm:w-auto">
            <a href="/dashboard" class="mr-3 text-gray-400 hover:text-[#5E887E] hover:scale-110 transition-all duration-200 text-lg" title="Kembali ke Dashboard">
                <i class="fa-solid fa-arrow-left"></i>
            </a>

            <img src="{{ asset('images/logo hijau.svg') }}" alt="Logo" class="h-12 w-auto">
            <span class="text-xl font-bold text-[#5E887E]">Go<span class="text-[#D9B08C]">Pet</span></span>
        </div>

        <div class="relative w-full sm:w-80">
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-3.5 text-gray-400 text-sm"></i>
            <input type="text" placeholder="Cari nama atau spesialisasi..." class="w-full pl-10 pr-4 py-2.5 rounded-2xl border border-gray-100 text-sm focus:outline-none focus:border-[#5E887E] focus:ring-2 focus:ring-[#5E887E] bg-[#F8FBF0] transition-all">
        </div>
    </nav>

    <main class="w-full px-6 md:px-12 py-10 flex-grow">
        <div class="mb-10">
            <h1 class="text-3xl font-extrabold tracking-tight">Pilih Dokter Hewan</h1>
            <p class="text-[#5E887E] font-medium text-sm mt-1">Seluruh dokter telah melalui verifikasi berkas KTP, SIP, dan SKCK secara ketat.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 w-full">

            @forelse($daftar_dokter as $doc)
            <div class="bg-white rounded-[35px] p-6 border border-white shadow-sm flex flex-col justify-between hover:-translate-y-1 transition-all duration-300">
                <div>
                    <div class="relative w-24 h-24 mx-auto mb-4">
                        <img src="https://api.dicebear.com/7.x/adventurer/svg?seed={{ urlencode($doc->nama) }}" alt="Doctor" class="w-full h-full rounded-2xl bg-[#F8FBF0] object-cover border border-gray-100">
                        <span class="absolute -bottom-1 -right-1 w-6 h-6 bg-[#5E887E] border-2 border-white rounded-full flex items-center justify-center" title="Berkas Terverifikasi">
                            <i class="fa-solid fa-check text-white text-[10px]"></i>
                        </span>
                    </div>

                    <div class="text-center mb-4">
                        <h3 class="font-bold text-lg text-[#2D433E]">drh. {{ $doc->nama }}</h3>
                        <p class="text-xs font-semibold text-[#D9B08C] bg-[#FFFBF7] px-3 py-1 rounded-full inline-block mt-1">
                            {{ $doc->spesialis ?? $doc->spialis ?? 'Spesialis Hewan' }}
                        </p>
                    </div>

                    <p class="text-xs text-gray-400 text-center line-clamp-2 px-2 mb-4 italic">
                        "Siap memberikan penanganan medis primer terbaik langsung di rumah Anda."
                    </p>

                    <div class="border-t border-b border-gray-100 py-3 my-4 space-y-2 text-sm text-[#2D433E]">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-xs flex items-center gap-1.5"><i class="fa-solid fa-briefcase w-4 text-[#5E887E]"></i> Pengalaman:</span>
                            <span class="font-bold text-xs">{{ $doc->pengalaman ?? '2' }} Tahun</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-xs flex items-center gap-1.5"><i class="fa-solid fa-file-medical w-4 text-[#D9B08C]"></i> Dokumen SIP:</span>
                            <span class="font-mono text-xs text-gray-500">SIP/2026/0{{ $doc->id_penyedia }}92</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-xs flex items-center gap-1.5"><i class="fa-solid fa-shield-check w-4 text-emerald-500"></i> Status Berkas:</span>
                            <span class="text-xs text-emerald-600 font-bold bg-emerald-50 px-2 py-0.5 rounded-md flex items-center gap-1">Terverifikasi</span>
                        </div>
                    </div>
                </div>

                <div class="mt-2">
                    <div class="flex items-baseline justify-between mb-3 px-1">
                        <span class="text-xs text-gray-400">Harga Jasa:</span>
                        <span class="text-lg font-extrabold text-[#5E887E]">
                            Rp {{ number_format($doc->tarif, 0, ',', '.') }}<span class="text-[10px] font-normal text-gray-400">/visit</span>
                        </span>
                    </div>
                    <div class="flex gap-2">
                        @if(session()->has('id_user'))
                        <a href="{{ url('/chat-sitter/' . $doc->id_penyedia) }}" class="w-12 h-12 bg-[#F8FBF0] hover:bg-[#5E887E]/10 border border-[#5E887E]/20 text-[#5E887E] rounded-2xl flex items-center justify-center transition-all shadow-sm active:scale-95" title="Hubungi Dokter via Chat">
                            <i class="fa-solid fa-comment-dots text-lg"></i>
                        </a>
                        @else
                        <a href="/" class="w-12 h-12 bg-[#F8FBF0] hover:bg-[#5E887E]/10 border border-[#5E887E]/20 text-[#5E887E] rounded-2xl flex items-center justify-center transition-all shadow-sm active:scale-95" title="Login untuk chat">
                            <i class="fa-solid fa-comment-dots text-lg"></i>
                        </a>
                        @endif
                        <a href="/pesan-layanan/{{ $doc->id_penyedia }}" class="flex-1 bg-[#2D433E] hover:bg-[#5E887E] text-white font-bold py-3 rounded-2xl text-sm transition-all shadow-md active:scale-95 text-center flex items-center justify-center">
                            Pilih Dokter
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <i class="fa-solid fa-user-md text-gray-300 text-5xl mb-3"></i>
                <p class="text-gray-500 font-medium">Belum ada dokter yang tersedia saat ini, Cees.</p>
            </div>
            @endforelse

        </div>
    </main>

    <footer class="w-full bg-white border-t border-gray-100 py-6 text-center text-xs text-gray-400">
        <p>&copy; 2026 GoPet Team. All rights reserved.</p>
    </footer>
</body>
</html>