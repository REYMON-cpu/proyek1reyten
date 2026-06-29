<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Pet Sitter — GoPet</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .card-sitter:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(94,136,126,0.12); }
        .card-sitter { transition: transform 0.25s ease, box-shadow 0.25s ease; }
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
            <input type="text" id="searchInput" onkeyup="filterSitter()" placeholder="Cari nama pet sitter..."
                class="w-full pl-10 pr-4 py-2.5 rounded-2xl border border-gray-100 text-sm focus:outline-none focus:border-[#5E887E] focus:ring-2 focus:ring-[#5E887E] bg-[#F8FBF0] transition-all">
        </div>
    </nav>

    <main class="w-full px-6 md:px-12 py-10 flex-grow">
        <div class="mb-10">
            <h1 class="text-3xl font-extrabold tracking-tight">Pilih Pet Sitter</h1>
            <p class="text-[#5E887E] font-medium text-sm mt-1">Sitter kami telah diverifikasi identitasnya lewat KTP, SKCK, dan sertifikat keahlian mendasar.</p>
        </div>

        @if(session('success'))
        <div class="mb-6 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-2xl text-sm font-semibold">
            <i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}
        </div>
        @endif

        <div id="sitter-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 w-full">

            @forelse($daftar_sitter as $sitter)
            <div class="sitter-card card-sitter bg-white rounded-[35px] p-6 border border-white shadow-sm flex flex-col justify-between"
                 data-nama="{{ strtolower($sitter->nama) }}">
                <div>
                    <div class="relative w-24 h-24 mx-auto mb-4">
                        <img src="https://api.dicebear.com/7.x/adventurer/svg?seed={{ urlencode($sitter->nama) }}"
                             alt="{{ $sitter->nama }}"
                             class="w-full h-full rounded-2xl bg-[#F8FBF0] object-cover border border-gray-100">
                        <span class="absolute -bottom-1 -right-1 w-6 h-6 bg-[#D9B08C] border-2 border-white rounded-full flex items-center justify-center" title="Identitas Aman">
                            <i class="fa-solid fa-shield text-white text-[10px]"></i>
                        </span>
                    </div>

                    <div class="text-center mb-4">
                        <h3 class="font-bold text-lg text-[#2D433E]">{{ $sitter->nama }}</h3>
                        <p class="text-xs font-semibold text-[#5E887E] bg-[#F4F7F6] px-3 py-1 rounded-full inline-block mt-1">
                            {{ $sitter->spesialis ?? 'Pet Sitter' }}
                        </p>
                    </div>

                    <div class="border-t border-b border-gray-100 py-3 my-4 space-y-2 text-sm text-[#2D433E]">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-xs flex items-center gap-1.5">
                                <i class="fa-solid fa-briefcase w-4 text-[#5E887E]"></i> Pengalaman:
                            </span>
                            <span class="font-bold text-xs">{{ $sitter->pengalaman ?? 0 }} Tahun</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-xs flex items-center gap-1.5">
                                <i class="fa-solid fa-id-card w-4 text-[#D9B08C]"></i> Dokumen:
                            </span>
                            @if($sitter->dokumen && $sitter->dokumen !== 'Belum ada dokumen' && $sitter->dokumen !== null)
                                <span class="text-xs text-emerald-600 font-bold bg-emerald-50 px-2 py-0.5 rounded-md">Terverifikasi</span>
                            @else
                                <span class="text-xs text-gray-400 font-semibold">Belum ada</span>
                            @endif
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-xs flex items-center gap-1.5">
                                <i class="fa-solid fa-star w-4 text-yellow-400"></i> Status:
                            </span>
                            <span class="text-xs text-emerald-600 font-bold bg-emerald-50 px-2 py-0.5 rounded-md">Disetujui</span>
                        </div>
                    </div>
                </div>

                <div class="mt-2">
                    <div class="flex items-baseline justify-between mb-3 px-1">
                        <span class="text-xs text-gray-400">Tarif Jasa:</span>
                        @if($sitter->tarif && $sitter->tarif > 0)
                            <span class="text-lg font-extrabold text-[#5E887E]">
                                Rp {{ number_format($sitter->tarif, 0, ',', '.') }}<span class="text-[10px] font-normal text-gray-400">/hari</span>
                            </span>
                        @else
                            <span class="text-sm font-semibold text-gray-400 italic">Belum ditentukan</span>
                        @endif
                    </div>

                    <div class="flex gap-2">
                        @if(session()->has('id_user'))
                        <a href="{{ url('/chat-sitter/' . $sitter->id_penyedia) }}"
                           class="w-12 h-12 bg-[#F8FBF0] hover:bg-[#5E887E]/10 border border-[#5E887E]/20 text-[#5E887E] rounded-2xl flex items-center justify-center transition-all shadow-sm active:scale-95"
                           title="Hubungi Sitter via Chat">
                            <i class="fa-solid fa-comment-dots text-lg"></i>
                        </a>
                        @else
                        <a href="/"
                           class="w-12 h-12 bg-[#F8FBF0] hover:bg-[#5E887E]/10 border border-[#5E887E]/20 text-[#5E887E] rounded-2xl flex items-center justify-center transition-all shadow-sm active:scale-95"
                           title="Login untuk chat">
                            <i class="fa-solid fa-comment-dots text-lg"></i>
                        </a>
                        @endif
                        <a href="{{ url('/pesan-layanan/' . $sitter->id_penyedia) }}"
                           class="flex-1 bg-[#2D433E] hover:bg-[#5E887E] text-white font-bold py-3 rounded-2xl text-sm transition-all shadow-md active:scale-95 text-center flex items-center justify-center">
                            Pesan Sitter
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-20">
                <div class="w-20 h-20 bg-[#F4F7F6] rounded-3xl flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-paw text-3xl text-[#5E887E]/30"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-400 mb-1">Belum ada Pet Sitter tersedia</h3>
                <p class="text-sm text-gray-300">Pet sitter akan muncul setelah mendaftar dan disetujui oleh Admin.</p>
            </div>
            @endforelse

        </div>
    </main>

    <footer class="w-full bg-white border-t border-gray-100 py-6 text-center text-xs text-gray-400">
        <p>&copy; 2026 GoPet. All rights reserved.</p>
    </footer>

    <script>
        function filterSitter() {
            const query = document.getElementById('searchInput').value.toLowerCase();
            document.querySelectorAll('.sitter-card').forEach(card => {
                const nama = card.getAttribute('data-nama') || '';
                card.style.display = nama.includes(query) ? '' : 'none';
            });
        }
    </script>

</body>
</html>