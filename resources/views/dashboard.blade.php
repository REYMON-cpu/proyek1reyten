<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #FAF9F6;
            color: #2D433E;
            overflow-x: hidden;
        }

        .bg-blob {
            position: absolute;
            width: 600px;
            height: 600px;
            background: #E8F0EE;
            filter: blur(100px);
            border-radius: 50%;
            z-index: -1;
        }

        .swiper-pagination-bullet-active {
            background: #5E887E !important;
            width: 28px !important;
            border-radius: 4px !important;
        }

    </style>
</head>

<body class="antialiased relative">

    <div class="bg-blob top-[-150px] left-[-150px] opacity-70"></div>
    <div class="bg-blob bottom-[-150px] right-[-150px] opacity-50"></div>

    <header id="main-nav" class="fixed top-0 w-full z-[100] px-4 md:px-6 py-4 transition-all duration-500">
        <nav class="w-full max-w-[1440px] mx-auto bg-[#5E887E] backdrop-blur-xl rounded-[24px] px-4 md:px-8 py-3 flex justify-between items-center border border-[#5E887E]/20 shadow-[0_15px_30px_-10px_rgba(94,136,126,0.25)]">

            <div class="flex items-center gap-3 relative">
                <div class="w-12 h-12 flex items-center justify-center overflow-hidden bg-white/10 backdrop-blur-md rounded-xl p-1.5 border border-white/20">
                    <img src="{{ asset('images/logo putih.svg') }}" alt="Logo" class="w-full h-full object-contain">
                </div>

                <div>
                    <h2 class="text-xl font-bold tracking-tight text-white">Go<span class="text-[#D9B08C]">Pet</span></h2>
                </div>
            </div>

            <div class="hidden lg:flex gap-8 font-bold text-[13px] uppercase tracking-[0.2em] text-white/80">
                <a href="#" class="hover:text-white transition-colors">Home</a>
                <a href="#penyedia-layanan" class="hover:text-white transition-colors">Layanan</a>
                <a href="javascript:void(0)" onclick="toggleNotificationDropdown(event)" class="hover:text-white transition-colors">Riwayat Medis</a>
                <a href="#tentang-kami" class="hover:text-white transition-colors">Tentang Kami</a>
                <a href="#kontak" class="hover:text-white transition-colors">Kontak</a>
            </div>

            <div class="flex items-center gap-4">
                <!-- Dropdown Lonceng Notifikasi -->
                <div class="relative">
                    <button id="btn-notification" class="relative text-white hover:scale-105 transition-transform p-1 outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span id="notif-badge" class="absolute top-1 right-1 hidden h-2.5 w-2.5 rounded-full bg-red-500 border-2 border-[#5E887E]"></span>
                    </button>

                    <!-- Dropdown Panel -->
                    <div id="dropdown-notification" class="absolute right-0 mt-3 w-80 bg-white rounded-3xl shadow-2xl border border-gray-100 py-4 hidden z-[200] max-h-96 overflow-y-auto">
                        <div class="px-6 py-2 border-b border-gray-100 flex justify-between items-center">
                            <h4 class="font-bold text-[#2D433E] text-sm">Notifikasi Medis & Perawatan</h4>
                            <span class="text-[10px] bg-[#E8F0EE] text-[#5E887E] px-2 py-0.5 rounded-full font-bold uppercase tracking-wider">Terbaru</span>
                        </div>
                        <div class="divide-y divide-gray-50">
                            @forelse($riwayat_medis as $item)
                                <div class="px-6 py-4 hover:bg-gray-50/80 transition-colors flex gap-3 notification-item" data-id="{{ $item->id }}">
                                    <div class="w-10 h-10 rounded-xl flex-shrink-0 flex items-center justify-center text-sm font-bold {{ $item->tipe === 'dokter' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                                        @if($item->tipe === 'dokter')
                                            <i class="fa-solid fa-user-doctor"></i>
                                        @else
                                            <i class="fa-solid fa-paw"></i>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-xs text-gray-700 font-medium">
                                            <span class="font-extrabold text-[#2D433E]">
                                                {{ $item->nama_penyedia }}
                                            </span>
                                            @if($item->tipe === 'dokter')
                                                telah menambahkan rekam medis untuk <span class="font-bold text-[#5E887E]">{{ $item->nama_hewan }}</span>: Diagnosis <span class="italic text-blue-700 font-semibold">{{ $item->diagnosis }}</span>.
                                            @else
                                                telah menambahkan catatan harian untuk <span class="font-bold text-[#D9B08C]">{{ $item->nama_hewan }}</span>: <span class="italic text-gray-500 font-semibold">"{{ $item->catatan }}"</span>.
                                            @endif
                                        </p>
                                        <span class="text-[9px] text-gray-400 font-semibold mt-1 block">{{ $item->tanggal }}</span>
                                    </div>
                                </div>
                            @empty
                                <div class="px-6 py-8 text-center text-gray-400">
                                    <i class="fa-solid fa-bell-slash text-xl mb-2 block opacity-40"></i>
                                    <p class="text-xs font-bold">Belum ada riwayat medis</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="h-6 w-[1px] bg-white/20"></div>

                <div class="flex items-center gap-4">
                    <a href="#" class="flex items-center gap-3 group">
                        <div class="text-right hidden xl:block">
                            <p class="text-[11px] font-extrabold text-white leading-none uppercase tracking-tight" style="font-family: 'Poppins', sans-serif;">
                                {{ $nama ?? 'Guest' }}
                            </p>
                        </div>

                        <div class="relative">
                            <div class="w-9 h-9 rounded-xl overflow-hidden border border-white/20 shadow-sm transition-transform group-hover:scale-105 flex items-center justify-center bg-[#FAF9F6]">
                                @if(isset($profile_photo_path))
                                    <img src="{{ asset('storage/' . $profile_photo_path) }}" alt="Profil" class="w-full h-full object-cover">
                                @else
                                    <span class="text-[#5E887E] text-xs font-bold" style="font-family: 'Poppins', sans-serif;">
                                        {{ strtoupper(substr($nama ?? 'Guest', 0, 2)) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </a>

                    <div class="h-6 w-[1px] bg-white/20"></div>

                    <a href="{{ route('logout') }}" class="text-white/80 hover:text-red-300 text-xs font-bold uppercase tracking-wider flex items-center gap-1 transition-all" title="Keluar">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> <span class="hidden sm:inline">Keluar</span>
                    </a>
                </div>
            </div>

        </nav>
    </header>

    @if(session('success'))
    <div id="toast-success" class="fixed top-24 left-1/2 transform -translate-x-1/2 bg-[#FAF9F6] border-2 border-[#5E887E] text-[#2D433E] px-6 py-4 rounded-3xl z-[200] shadow-2xl flex items-center gap-3 transition-opacity duration-300">
        <div class="w-8 h-8 rounded-full bg-[#E8F0EE] flex items-center justify-center text-[#5E887E]">
            <i class="fa-solid fa-circle-check"></i>
        </div>
        <div class="text-sm font-bold">{{ session('success') }}</div>
        <button onclick="document.getElementById('toast-success').remove()" class="text-gray-400 hover:text-gray-600 ml-2"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <script>
        setTimeout(() => {
            const toast = document.getElementById('toast-success');
            if (toast) {
                toast.classList.add('opacity-0');
                setTimeout(() => toast.remove(), 300);
            }
        }, 5000);
    </script>
    @endif

    @if(session('error'))
    <div id="toast-error" class="fixed top-24 left-1/2 transform -translate-x-1/2 bg-[#FAF9F6] border-2 border-red-500 text-[#2D433E] px-6 py-4 rounded-3xl z-[200] shadow-2xl flex items-center gap-3 transition-opacity duration-300">
        <div class="w-8 h-8 rounded-full bg-red-50 flex items-center justify-center text-red-500">
            <i class="fa-solid fa-circle-xmark"></i>
        </div>
        <div class="text-sm font-bold">{{ session('error') }}</div>
        <button onclick="document.getElementById('toast-error').remove()" class="text-gray-400 hover:text-gray-600 ml-2"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <script>
        setTimeout(() => {
            const toast = document.getElementById('toast-error');
            if (toast) {
                toast.classList.add('opacity-0');
                setTimeout(() => toast.remove(), 300);
            }
        }, 5000);
    </script>
    @endif

    <div class="h-40"></div>

    <main class="max-w-[1440px] mx-auto px-10 min-h-[75vh] flex items-center relative">
        <div class="grid grid-cols-12 gap-20 items-center w-full">


            <div class="col-span-12 lg:col-span-7 relative">
                <div class="absolute -top-8 -left-8 bg-white/90 backdrop-blur px-6 py-4 rounded-[25px] shadow-2xl z-10 flex items-center gap-4 border border-white/50">
                    <div class="w-12 h-12 bg-yellow-400 rounded-full flex items-center justify-center text-2xl shadow-inner">🐾</div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Trusted by</p>
                        <p class="text-sm font-black text-[#2D433E]">500+ pemilik hewan</p>
                    </div>
                </div>

                <div class="swiper mySwiper rounded-[70px] overflow-hidden shadow-[0_60px_120px_-30px_rgba(0,0,0,0.2)] h-[600px] border-[20px] border-white relative">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="{{ asset('images/hero slider 1.png') }}" class="w-full h-full object-cover">
                        </div>
                        <div class="swiper-slide">
                            <img src="{{ asset('images/hero slider 2.png') }}" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <div class="swiper-pagination !bottom-12"></div>
                </div>
            </div>


            <div class="col-span-12 lg:col-span-5">
                <div class="space-y-10">
                    <div class="inline-flex items-center gap-3 bg-[#E8F0EE] px-6 py-2.5 rounded-full">
                        <span class="flex h-2.5 w-2.5 rounded-full bg-[#5E887E] animate-ping"></span>
                        <span class="text-[11px] font-black uppercase tracking-[0.2em] text-[#5E887E]">Tersedia di Bandung</span>
                    </div>

                    <h1 class="text-[84px] font-extrabold leading-[0.9] tracking-tighter text-[#2D433E]">
                        Love your pets <br> <span class="text-[#D9B08C]">like family.</span>
                    </h1>

                    <p class="text-gray-400 text-xl leading-relaxed max-w-md font-medium">
                        Solusi praktis kunjungan dokter hewan dan pengasuh profesional langsung ke rumah Anda.
                    </p>

                    <div class="flex items-center gap-8 pt-3">
                        <a href="#penyedia-layanan" class="px-8 py-4 bg-[#2D3E3B] text-white rounded-full font-bold uppercase tracking-tighter hover:bg-[#5E887E] transition-all shadow-lg hover:scale-105">
                            Booking Sekarang
                        </a>
                        <a href="#pelajari-lebih-lanjut" class="group flex items-center gap-2 font-bold text-[#2D433E] hover:text-[#D9B08C] transition-all">
                            Pelajari Lebih Lanjut
                            <span class="transform transition-transform group-hover:translate-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m9 18 6-6-6-6"/>
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <!--LAYANAN-->

    <section id="penyedia-layanan" class="relative py-24 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/bg layanan.jpg') }}" alt="Background Pawrawat" class="w-full h-full object-cover">
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-black text-white uppercase tracking-[0.1em] drop-shadow-[0_5px_15px_rgba(0,0,0,0.3)] hover:scale-105 transition-transform duration-300 cursor-default">
                Pilih Layanan Kami
            </h2>
                <p class="text-white/80 font-medium mt-4 tracking-wide italic">
                    Tenaga profesional kami siap datang langsung ke lokasi Anda di Bandung.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 max-w-5xl mx-auto">


            <div class="group bg-white p-10 rounded-[40px] shadow-2xl border-2 border-white hover:border-[#5E887E] transition-all duration-500 hover:-translate-y-2">
                <div class="w-20 h-20 bg-[#5E887E]/20 rounded-3xl flex items-center justify-center mb-8 text-[#5E887E]">
                    <i class="fa-solid fa-stethoscope text-4xl"></i>
                </div>
                <h3 class="text-3xl font-extrabold text-[#2D433E] mb-4">Dokter Hewan</h3>
                <p class="text-gray-600 mb-8 text-lg leading-relaxed">
                    Pemeriksaan kesehatan, vaksinasi, dan pengobatan medis tanpa perlu keluar rumah.
                </p>
                <a href="{{ url('/pilih-dokter') }}" class="w-full py-5 bg-[#2D433E] text-white rounded-2xl font-bold text-lg group-hover:bg-[#5E887E] shadow-lg transition-all inline-block text-center">
                    Pesan Dokter Hewan
                </a>
            </div>


            <div class="group bg-white p-10 rounded-[40px] shadow-2xl border-2 border-white hover:border-[#D9B08C] transition-all duration-500 hover:-translate-y-2">
                <div class="w-20 h-20 bg-[#D9B08C]/20 rounded-3xl flex items-center justify-center mb-8 text-[#D9B08C]">
                    <i class="fa-solid fa-paw text-4xl"></i>
                </div>
                <h3 class="text-3xl font-extrabold text-[#2D433E] mb-4">Pet Sitter</h3>
                <p class="text-gray-600 mb-8 text-lg leading-relaxed">
                    Penjagaan anabul, pemberian makan, dan teman bermain saat Anda sedang sibuk.
                </p>
                <a href="{{ url('/pilih-sitter') }}" class="w-full py-5 bg-[#2D433E] text-white rounded-2xl font-bold text-lg group-hover:bg-[#D9B08C] shadow-lg transition-all inline-block text-center">
                    Pesan Pet Sitter
                </a>
            </div>
        </div>
    </section>


    <!--PELAJARI LEBIH LANJUT-->

    <section id="pelajari-lebih-lanjut" class="py-24 bg-[#F8FBF0]">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-black text-[#2D433E] uppercase tracking-tight mb-4">Bagaimana GoPet Bekerja?</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Pelajari langkah mudah untuk mendapatkan perawatan terbaik bagi anabul kesayangan Anda tanpa harus keluar rumah.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">

                <div class="relative text-center">
                    <div class="w-24 h-24 bg-white shadow-xl rounded-full flex items-center justify-center mx-auto mb-6 border-4 border-[#5E887E]/20">
                        <span class="text-3xl font-black text-[#5E887E]">01</span>
                    </div>
                    <h3 class="text-xl font-bold text-[#2D433E] mb-3">Pilih Layanan</h3>
                    <p class="text-gray-600">Pilih antara kunjungan Dokter Hewan atau jasa Pet Sitter sesuai kebutuhan anabulmu melalui website ini.</p>
                    <div class="hidden md:block absolute top-12 -right-6 text-[#5E887E]/30 text-4xl">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>


                <div class="relative text-center">
                    <div class="w-24 h-24 bg-white shadow-xl rounded-full flex items-center justify-center mx-auto mb-6 border-4 border-[#D9B08C]/20">
                        <span class="text-3xl font-black text-[#D9B08C]">02</span>
                    </div>
                    <h3 class="text-xl font-bold text-[#2D433E] mb-3">Atur Jadwal</h3>
                    <p class="text-gray-600">Tentukan lokasi dan pilih waktu kunjungan yang paling nyaman buat kamu dan si anabul.</p>
                    <div class="hidden md:block absolute top-12 -right-6 text-[#5E887E]/30 text-4xl">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>


                <div class="text-center">
                    <div class="w-24 h-24 bg-white shadow-xl rounded-full flex items-center justify-center mx-auto mb-6 border-4 border-[#2D433E]/20">
                        <span class="text-3xl font-black text-[#2D433E]">03</span>
                    </div>
                    <h3 class="text-xl font-bold text-[#2D433E] mb-3">Perawatan Datang</h3>
                    <p class="text-gray-600">Tenaga profesional kami akan datang langsung ke rumahmu. Kamu tinggal duduk manis sambil dapat update real-time!</p>
                </div>
            </div>


            <div class="mt-16 text-center">
                <a href="#penyedia-layanan" class="inline-block py-4 px-10 bg-[#5E887E] text-white rounded-2xl font-bold shadow-lg hover:bg-[#2D433E] transition-all">
                    Mulai Pesan Sekarang
                </a>
            </div>
        </div>
    </section>


    <!--REVIEW-->
    <section id="review-section" class="py-24 bg-[#5E887E]">
    <div class="container mx-auto px-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">

            <div class="lg:col-span-5">
                <div class="sticky top-24">
                    <h2 class="text-4xl font-black text-[#2D433E] mb-6">Kasih Rating <br><span class="text-[#E59651]">Anabulmu.</span></h2>
                    <div class="bg-white rounded-[40px] p-8 shadow-sm border border-gray-100">

                        <form action="{{ route('review.store') }}" method="POST">
                            @csrf
                            <div class="space-y-5">
                                <div>
                                    <label class="text-xs font-bold uppercase tracking-wider text-gray-500 ml-2">Nama Pemilik</label>
                                    <input type="text" name="customer_name" required placeholder="Nama Pemilik Hewan" class="w-full bg-[#F8FBF0] border-0 rounded-2xl py-4 px-6 focus:ring-2 focus:ring-[#D9B08C] transition-all outline-none">
                                </div>

                                <div>
                                    <label class="text-xs font-bold uppercase tracking-wider text-gray-500 ml-2">Nama & Jenis Anabul</label>
                                    <input type="text" name="pet_name" required placeholder="Mochi (Kucing)" class="w-full bg-[#F8FBF0] border-0 rounded-2xl py-4 px-6 focus:ring-2 focus:ring-[#D9B08C] transition-all outline-none">
                                </div>
                                
                                <div>
    <label class="text-xs font-bold uppercase tracking-wider text-gray-500 ml-2">
        Penyedia Jasa
    </label>

    <select name="penyedia_jasa_id"
        required
        class="w-full bg-[#F8FBF0] border-0 rounded-2xl py-4 px-6 focus:ring-2 focus:ring-[#D9B08C] transition-all outline-none">

        <option value="">-- Pilih Penyedia Jasa --</option>

        @foreach($penyedia_jasa as $pj)
            <option value="{{ $pj->id_penyedia}}">
                {{ $pj->nama }} - {{ ucfirst($pj->jenis) }}
            </option>
        @endforeach

    </select>
</div>

                                <div>
                                    <label class="text-xs font-bold uppercase tracking-wider text-gray-500 ml-2">Rating Kepuasan</label>
                                    <div class="flex flex-row-reverse justify-end items-center mt-2 group">
                                        <input type="radio" id="star5" name="rating_value" value="5" class="hidden peer" required />
                                        <label for="star5" class="cursor-pointer text-2xl text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-400 transition-colors"><i class="fas fa-star"></i></label>

                                        <input type="radio" id="star4" name="rating_value" value="4" class="hidden peer" />
                                        <label for="star4" class="cursor-pointer text-2xl text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-400 peer-checked~label:text-yellow-400 hover~label:text-yellow-400 transition-colors"><i class="fas fa-star"></i></label>

                                        <input type="radio" id="star3" name="rating_value" value="3" class="hidden peer" />
                                        <label for="star3" class="cursor-pointer text-2xl text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-400 peer-checked~label:text-yellow-400 hover~label:text-yellow-400 transition-colors"><i class="fas fa-star"></i></label>

                                        <input type="radio" id="star2" name="rating_value" value="2" class="hidden peer" />
                                        <label for="star2" class="cursor-pointer text-2xl text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-400 peer-checked~label:text-yellow-400 hover~label:text-yellow-400 transition-colors"><i class="fas fa-star"></i></label>

                                        <input type="radio" id="star1" name="rating_value" value="1" class="hidden peer" />
                                        <label for="star1" class="cursor-pointer text-2xl text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-400 peer-checked~label:text-yellow-400 hover~label:text-yellow-400 transition-colors"><i class="fas fa-star"></i></label>
                                    </div>
                                </div>

                                <div>
                                    <label class="text-xs font-bold uppercase tracking-wider text-gray-500 ml-2">Cerita Pengalaman</label>
                                    <textarea name="experience" rows="4" required placeholder="Gopet keren banget..." class="w-full bg-[#F8FBF0] border-0 rounded-3xl py-4 px-6 focus:ring-2 focus:ring-[#D9B08C] transition-all outline-none"></textarea>
                                </div>

                                <div>
    <label class="text-xs font-bold uppercase tracking-wider text-gray-500 ml-2">
        Keluhan untuk Penyedia Jasa
        <span class="text-gray-400 normal-case">(Opsional)</span>
    </label>

    <textarea
        name="complaint"
        rows="3"
        placeholder="Tuliskan apabila terdapat keluhan mengenai pelayanan dokter atau pet sitter..."
        class="w-full bg-[#F8FBF0] border-0 rounded-3xl py-4 px-6 focus:ring-2 focus:ring-red-300 transition-all outline-none"></textarea>

    <p class="text-xs text-gray-500 mt-2 px-2">
        Keluhan ini hanya akan dikirim kepada penyedia jasa sebagai bahan evaluasi, tidak akan ditampilkan sebagai ulasan publik.
    </p>
</div>

                                <button type="submit" class="w-full py-4 bg-[#2D433E] text-white font-bold rounded-2xl hover:bg-[#D9B08C] hover:text-[#2D433E] transition-all shadow-lg shadow-[#2D433E]/10">
                                    Kirim Review
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-7">
                <h3 class="text-2xl font-bold text-[#2D433E] mb-8 text-center lg:text-left">Apa Kata Mereka?</h3>
                <div class="space-y-6">

                    @foreach($daftar_rating as $rat)
                    <div class="bg-white p-8 rounded-[35px] shadow-sm border border-gray-50 flex gap-6">
                        <div class="w-16 h-16 rounded-2xl bg-[#D9B08C]/10 flex-shrink-0 flex items-center justify-center text-[#D9B08C]">
                            <i class="fas fa-quote-left text-2xl"></i>
                        </div>
                        <div class="w-full">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h4 class="font-bold text-[#2D433E]">{{ $rat->customer_name }}</h4>
                                    <p class="text-xs text-gray-400">{{ $rat->pet_name }}</p>
                                </div>
                                <div class="flex text-yellow-400 text-xs gap-1">
                                    @for($i = 0; $i < ($rat->rating ?? 5); $i++)
                                        <i class="fas fa-star"></i>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-gray-600 text-sm italic">"{{ $rat->experience }}"</p>
                        </div>
                    </div>
                    @endforeach
                    </div>
            </div>

        </div>
    </div>
</section>



    <!--TENTANG KAMI-->

    <section id="tentang-kami" class="py-24 bg-white relative overflow-hidden">
        <div class="container mx-auto px-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">


                <div class="relative">
                    <div class="absolute -top-10 -left-10 w-40 h-40 bg-[#D9B08C]/10 rounded-full filter blur-3xl"></div>
                    <div class="relative rounded-[60px] overflow-hidden shadow-2xl border-[15px] border-[#F8FBF0]">
                        <img src="{{ asset('images/dog tentang kami.jpg') }}"
                            alt="Tentang Gopet" class="w-full h-[500px] object-cover">
                    </div>

                    <div class="absolute -bottom-6 -right-6 bg-[#5E887E] p-8 rounded-[40px] text-white shadow-xl">
                        <p class="text-4xl font-black italic">#1</p>
                        <p class="text-[10px] uppercase tracking-widest font-bold">Pet Care di Bandung</p>
                    </div>
                </div>


                <div class="space-y-8">
                    <div>
                        <span class="text-[#D9B08C] font-black uppercase tracking-[0.3em] text-xs mb-4 block">Siapa Kami?</span>
                        <h2 class="text-5xl font-extrabold text-[#2D433E] leading-tight">
                            Dedikasi Kami untuk <span class="text-[#E59651]">Anabul</span> Kesayanganmu.
                        </h2>
                    </div>

                    <p class="text-gray-500 text-lg leading-relaxed font-medium">
                        GoPet lahir dari keresahan para pemilik hewan di Bandung yang sulit membagi waktu antara pekerjaan dan kesehatan anabul. Kami percaya bahwa setiap hewan berhak mendapatkan perawatan terbaik tanpa harus merasa stres di perjalanan.
                    </p>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="p-6 bg-[#F8FBF0] rounded-[30px] border border-[#5E887E]/10">
                            <h4 class="font-bold text-[#2D433E] mb-2 flex items-center gap-2">
                                <i class="fas fa-heart text-[#5E887E]"></i> Visi
                            </h4>
                            <p class="text-sm text-gray-400">Menjadi partner utama pemilik hewan dalam memberikan kasih sayang lewat layanan medis profesional.</p>
                        </div>
                        <div class="p-6 bg-[#F8FBF0] rounded-[30px] border border-[#5E887E]/10">
                            <h4 class="font-bold text-[#2D433E] mb-2 flex items-center gap-2">
                                <i class="fas fa-bullseye text-[#5E887E]"></i> Misi
                            </h4>
                            <p class="text-sm text-gray-400">Menyediakan akses kesehatan hewan yang praktis, transparan, dan terpercaya langsung ke rumah.</p>
                        </div>
                    </div>

                    <div class="pt-4">
                        <a href="#kontak" class="inline-flex items-center gap-4 text-[#2D433E] font-bold group">
                            <span class="w-12 h-12 rounded-full bg-[#2D433E] text-white flex items-center justify-center group-hover:bg-[#5E887E] transition-all">
                                <i class="fas fa-arrow-right"></i>
                            </span>
                            Hubungi Kami Lebih Lanjut
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!--FAQ-->

    <section id="faq" class="py-32 bg-[#FAF9F6] relative overflow-hidden">
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-[#E8F0EE] rounded-full filter blur-[120px] opacity-50 -z-10"></div>

        <div class="container mx-auto px-10">
            <div class="flex flex-col lg:flex-row gap-20">


                <div class="lg:w-1/3">
                    <div class="lg:sticky lg:top-40">
                        <h2 class="text-[64px] font-black text-[#2D433E] leading-[0.9] tracking-tighter mb-8">
                            Ada yang <br> <span class="text-[#5E887E]">Ditanyakan?</span>
                        </h2>
                        <p class="text-gray-400 text-lg font-medium max-w-xs mb-10">
                            Kami kumpulkan jawaban paling lengkap buat kamu yang baru mau mulai pakai GoPet.
                        </p>
                        <div class="w-20 h-1 bg-[#D9B08C] rounded-full"></div>
                    </div>
                </div>


                <div class="lg:w-2/3 space-y-6">
                    <div class="faq-card group bg-white rounded-[45px] border-2 border-transparent shadow-[0_15px_40px_-15px_rgba(0,0,0,0.05)] transition-all duration-500 overflow-hidden">
                        <button class="w-full p-10 flex items-center justify-between text-left outline-none" onclick="toggleFaq(this)">
                            <div class="flex items-center gap-8">
                                <div class="num-box w-14 h-14 rounded-2xl bg-[#F8FBF0] text-[#5E887E] flex items-center justify-center text-xl font-black transition-all duration-500">01</div>
                                <h4 class="text-2xl font-bold text-[#2D433E]">Lisensi & Keamanan Medis</h4>
                            </div>
                            <div class="plus-icon w-12 h-12 rounded-full border-2 border-gray-100 flex items-center justify-center transition-all duration-500">
                                <i class="fas fa-plus text-gray-400 transition-transform duration-500"></i>
                            </div>
                        </button>
                        <div class="faq-body max-h-0 opacity-0 transition-all duration-500 ease-in-out">
                            <div class="px-32 pb-12">
                                <p class="text-gray-500 text-lg leading-relaxed">
                                    Semua mitra dokter di GoPet wajib memiliki SIP (Surat Izin Praktik) aktif. Kami melakukan verifikasi ketat sebelum mereka diizinkan melayani anabul kesayanganmu.
                                </p>
                            </div>
                        </div>
                    </div>


                    <div class="faq-card group bg-white rounded-[45px] border-2 border-transparent shadow-[0_15px_40px_-15px_rgba(0,0,0,0.05)] transition-all duration-500 overflow-hidden">
                        <button class="w-full p-10 flex items-center justify-between text-left outline-none" onclick="toggleFaq(this)">
                            <div class="flex items-center gap-8">
                                <div class="num-box w-14 h-14 rounded-2xl bg-[#F8FBF0] text-[#5E887E] flex items-center justify-center text-xl font-black transition-all duration-500">02</div>
                                <h4 class="text-2xl font-bold text-[#2D433E]">Bagaimana cara memesannya?</h4>
                            </div>
                            <div class="plus-icon w-12 h-12 rounded-full border-2 border-gray-100 flex items-center justify-center transition-all duration-500">
                                <i class="fas fa-plus text-gray-400 transition-transform duration-500"></i>
                            </div>
                        </button>
                        <div class="faq-body max-h-0 opacity-0 transition-all duration-500 ease-in-out">
                            <div class="px-32 pb-12">
                                <p class="text-gray-500 text-lg leading-relaxed">
                                    Kamu cukup pilih layanan yang diinginkan, tentukan jadwal kunjungan, dan lakukan konfirmasi pemesanan melalui halaman dashboard.
                                </p>
                            </div>
                        </div>
                    </div>


                    <div class="faq-card group bg-white rounded-[45px] border-2 border-transparent shadow-[0_15px_40px_-15px_rgba(0,0,0,0.05)] transition-all duration-500 overflow-hidden">
                        <button class="w-full p-10 flex items-center justify-between text-left outline-none" onclick="toggleFaq(this)">
                            <div class="flex items-center gap-8">
                                <div class="num-box w-14 h-14 rounded-2xl bg-[#F8FBF0] text-[#5E887E] flex items-center justify-center text-xl font-black transition-all duration-500">03</div>
                                <h4 class="text-2xl font-bold text-[#2D433E]">Di mana area jangkauannya?</h4>
                            </div>
                            <div class="plus-icon w-12 h-12 rounded-full border-2 border-gray-100 flex items-center justify-center transition-all duration-500">
                                <i class="fas fa-plus text-gray-400 transition-transform duration-500"></i>
                            </div>
                        </button>
                        <div class="faq-body max-h-0 opacity-0 transition-all duration-500 ease-in-out">
                            <div class="px-32 pb-12">
                                <p class="text-gray-500 text-lg leading-relaxed">
                                    Saat ini layanan GoPet tersedia untuk seluruh wilayah Kota Bandung dan sekitarnya.
                                </p>
                            </div>
                        </div>
                    </div>


                    <div class="faq-card group bg-white rounded-[45px] border-2 border-transparent shadow-[0_15px_40px_-15px_rgba(0,0,0,0.05)] transition-all duration-500 overflow-hidden">
                        <button class="w-full p-10 flex items-center justify-between text-left outline-none" onclick="toggleFaq(this)">
                            <div class="flex items-center gap-8">
                                <div class="num-box w-14 h-14 rounded-2xl bg-[#F8FBF0] text-[#5E887E] flex items-center justify-center text-xl font-black transition-all duration-500">04</div>
                                <h4 class="text-2xl font-bold text-[#2D433E]">Metode Pembayaran</h4>
                            </div>
                            <div class="plus-icon w-12 h-12 rounded-full border-2 border-gray-100 flex items-center justify-center transition-all duration-500">
                                <i class="fas fa-plus text-gray-400 transition-transform duration-500"></i>
                            </div>
                        </button>
                        <div class="faq-body max-h-0 opacity-0 transition-all duration-500 ease-in-out">
                            <div class="px-32 pb-12">
                                <p class="text-gray-500 text-lg leading-relaxed">
                                    Kami mendukung berbagai metode pembayaran mulai dari QRIS, Transfer Bank, hingga Cash on Delivery untuk memudahkan transaksi kamu.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>



    <!--KONTAK-->

  <section id="kontak" class="py-24 bg-white">
    <div class="container mx-auto px-10">
        <div class="bg-[#5E887E] rounded-[60px] p-10 lg:p-20 overflow-hidden relative">
            <div class="absolute -top-20 -right-20 w-80 h-80 bg-[#5E887E]/20 rounded-full filter blur-3xl"></div>

            <div class="flex flex-col lg:flex-row gap-20 relative z-10">
                <div class="lg:w-1/3 text-white">
                    <h2 class="text-5xl font-black mb-8 leading-tight">Hubungi Tim Go<span class="text-[#D9B08C]">Pet</span></h2>
                    <p class="text-white mb-12">Kami ingin memastikan pengalamanmu menggunakan GoPet selalu nyaman dan lancar. Apakah kamu menemukan kendala teknis saat mengakses fitur atau punya saran pengembangan agar GoPet jadi lebih baik? Beritahu kami melalui formulir ini. Setiap masukanmu sangat berarti bagi perkembangan layanan kami.</p>

                    <div class="space-y-8">
                        <div class="flex items-center gap-6">
                            <div class="w-12 h-12 rounded-2xl bg-[#5E887E] flex items-center justify-center text-xl">
                                <i class="fab fa-whatsapp"></i>
                            </div>
                            <div>
                                <p class="text-xs text-white/40 uppercase tracking-widest font-bold">WhatsApp</p>
                                <p class="font-bold">+62 812-3456-7890</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-6">
                            <div class="w-12 h-12 rounded-2xl bg-[#5E887E] flex items-center justify-center text-xl">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <p class="text-xs text-white/40 uppercase tracking-widest font-bold">Email</p>
                                <p class="font-bold">halo@gopet.com</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-6">
                            <div class="w-12 h-12 rounded-2xl bg-[#5E887E] flex items-center justify-center text-xl">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <p class="text-xs text-white/40 uppercase tracking-widest font-bold">Lokasi</p>
                                <p class="font-bold">Bandung, Jawa Barat</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex-1 bg-white/5 backdrop-blur-sm p-8 md:p-10 rounded-[40px] border border-white/10">
                    <form action="/kontak-store" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label class="text-xs font-bold text-white uppercase tracking-widest block mb-2 ml-2">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" required placeholder="Ketik nama lengkapmu" class="w-full bg-white/10 border border-white/10 rounded-2xl p-4 text-sm text-white placeholder-white/30 focus:outline-none focus:border-[#D9B08C] focus:bg-white/15 transition">
                        </div>

                        <div>
                            <label class="text-xs font-bold text-white uppercase tracking-widest block mb-2 ml-2">Email</label>
                            <input type="email" name="email" required placeholder="Contoh: reymon@gmail.com" class="w-full bg-white/10 border border-white/10 rounded-2xl p-4 text-sm text-white placeholder-white/30 focus:outline-none focus:border-[#D9B08C] focus:bg-white/15 transition">
                        </div>

                        <div>
                            <label class="text-xs font-bold text-white uppercase tracking-widest block mb-2 ml-2">Pesan</label>
                            <textarea name="pesan" rows="4" required placeholder="Halo GoPet, saya ingin bertanya tentang..." class="w-full bg-white/10 border border-white/10 rounded-2xl p-4 text-sm text-white placeholder-white/30 focus:outline-none focus:border-[#D9B08C] focus:bg-white/15 transition resize-none"></textarea>
                        </div>

                        <button type="submit" class="w-full bg-[#D9B08C] hover:bg-[#cda380] text-[#2D433E] py-4 rounded-2xl font-black text-sm tracking-wider uppercase shadow-lg transition transform active:scale-[0.98]">
                            Kirim Pesan Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

    <!--FOOTER-->

    <footer class="bg-[#2D433E] pt-24 pb-8 text-white/70 relative overflow-hidden">
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-[#5E887E]/10 rounded-full filter blur-[80px] -z-0"></div>

        <div class="container mx-auto px-10 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-12 mb-20">
                <div class="md:col-span-4">
                    <div class="flex items-center gap-4 mb-6">
                        <img src="{{ asset('images/logo putih.svg') }}" alt="Logo Gopet" class="h-12 w-auto object-contain">
                        <span class="text-3xl font-black text-white tracking-tighter">GoPet.</span>
                    </div>
                    <p class="leading-relaxed mb-8 max-w-sm text-white/70">
                        Solusi terpercaya untuk perawatan anabul langsung di rumah. Kami membawa kasih sayang dan keahlian medis ke depan pintu kamu.
                    </p>

                    <div class="flex gap-4">
                        <a href="#" class="w-11 h-11 rounded-2xl bg-white/5 flex items-center justify-center hover:bg-[#D9B08C] hover:text-[#2D433E] transition-all duration-300">
                            <i class="fab fa-instagram text-lg"></i>
                        </a>
                        <a href="#" class="w-11 h-11 rounded-2xl bg-white/5 flex items-center justify-center hover:bg-[#D9B08C] hover:text-[#2D433E] transition-all duration-300">
                            <i class="fab fa-tiktok text-lg"></i>
                        </a>
                        <a href="#" class="w-11 h-11 rounded-2xl bg-white/5 flex items-center justify-center hover:bg-[#D9B08C] hover:text-[#2D433E] transition-all duration-300">
                            <i class="fab fa-facebook-f text-lg"></i>
                        </a>
                    </div>
                </div>


                <div class="md:col-span-2">
                    <h4 class="text-white font-bold mb-6 uppercase text-xs tracking-widest">Eksplorasi</h4>
                    <ul class="space-y-4 text-sm font-medium">
                        <li><a href="#tentang-kami" class="hover:text-[#D9B08C] transition-all">Tentang Kami</a></li>
                        <li><a href="#faq" class="hover:text-[#D9B08C] transition-all">FAQ</a></li>
                        <li><a href="#kontak" class="hover:text-[#D9B08C] transition-all">Hubungi Kami</a></li>
                        <li><a href="#penyedia-layanan" class="hover:text-[#D9B08C] transition-all">Layanan Kami</a></li>
                    </ul>
                </div>


                <div class="md:col-span-3">
                    <h4 class="text-white font-bold mb-6 uppercase text-xs tracking-widest">Layanan</h4>
                    <ul class="space-y-4 text-sm font-medium">
                        <li class="flex items-center gap-2">
                            <span class="w-1 h-1 bg-[#D9B08C] rounded-full"></span>
                            <a href="#" class="hover:text-[#D9B08C] transition-all">Pemeriksaan Dokter</a>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-1 h-1 bg-[#D9B08C] rounded-full"></span>
                            <a href="#" class="hover:text-[#D9B08C] transition-all">Pet Sitting & Care</a>
                        </li>
                    </ul>
                </div>


                <div class="md:col-span-3">
                    <h4 class="text-white font-bold mb-6 uppercase text-xs tracking-widest">Kantor Pusat</h4>
                    <div class="space-y-4 text-sm">
                        <div class="flex gap-4">
                            <i class="fas fa-map-marker-alt text-[#D9B08C] mt-1"></i>
                            <p>Jl. Sari Asih No. 54, <br>Sarijadi, Kec. Sukasari, <br>Kota Bandung, Jawa Barat <br>40151</p>
                        </div>
                        <div class="flex gap-4">
                            <i class="fas fa-phone-alt text-[#D9B08C]"></i>
                            <p>+62 812-3456-7890</p>
                        </div>
                        <div class="flex gap-4">
                            <i class="fas fa-envelope text-[#D9B08C]"></i>
                            <p>halo@gopet.com</p>
                        </div>
                    </div>
                </div>
            </div>


            <div class="pt-8 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="text-xs font-medium tracking-wide">
                    &copy; 2026 <span class="text-white">GoPet Team</span>. Developed for Informatics Project.
                </div>
                <div class="flex gap-8 text-xs font-bold uppercase tracking-widest">
                    <a href="#" class="hover:text-[#D9B08C]">Privacy Policy</a>
                    <a href="#" class="hover:text-[#D9B08C]">Terms of Service</a>
                </div>
                <div class="text-xs">
                    Made with ❤️ in <span class="text-white">Bandung</span>
                </div>
            </div>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function toggleFaq(btn) {
            const card = btn.closest('.faq-card');
            const body = card.querySelector('.faq-body');
            const numBox = card.querySelector('.num-box');
            const plusIcon = card.querySelector('.plus-icon');
            const icon = plusIcon.querySelector('i');
            const isOpen = !body.classList.contains('max-h-0');

            document.querySelectorAll('.faq-card').forEach(other => {
                const b = other.querySelector('.faq-body');
                const n = other.querySelector('.num-box');
                const p = other.querySelector('.plus-icon');
                const i = p.querySelector('i');

                b.style.maxHeight = '0px';
                b.classList.add('max-h-0', 'opacity-0');
                other.classList.remove('border-[#5E887E]/30', 'shadow-2xl', 'scale-[1.02]');
                n.classList.replace('bg-[#5E887E]', 'bg-[#F8FBF0]');
                n.classList.replace('text-white', 'text-[#5E887E]');
                p.classList.remove('bg-[#5E887E]', 'border-[#5E887E]');
                i.classList.replace('fa-minus', 'fa-plus');
                i.classList.replace('text-white', 'text-gray-400');
                i.style.transform = 'rotate(0deg)';
            });


            if (!isOpen) {
                body.style.maxHeight = body.scrollHeight + "px";
                body.classList.remove('max-h-0', 'opacity-0');
                card.classList.add('border-[#5E887E]/30', 'shadow-2xl', 'scale-[1.02]');
                numBox.classList.replace('bg-[#F8FBF0]', 'bg-[#5E887E]');
                numBox.classList.replace('text-[#5E887E]', 'text-white');
                plusIcon.classList.add('bg-[#5E887E]', 'border-[#5E887E]');
                icon.classList.replace('fa-plus', 'fa-minus');
                icon.classList.replace('text-gray-400', 'text-white');
                icon.style.transform = 'rotate(180deg)';
            }
        }



        var swiper = new Swiper(".mySwiper", {
            loop: true,
            effect: "fade",
            fadeEffect: {
                crossFade: true
            },
            autoplay: {
                delay: 10000,
                disableOnInteraction: false
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true
            },
        });


        window.onscroll = function() {
            const nav = document.getElementById('main-nav');
            const navContainer = nav.querySelector('nav');
            if (window.scrollY > 50) {
                nav.style.paddingTop = "12px";
                nav.style.paddingBottom = "12px";
                navContainer.style.background = "#5E887E";
            } else {
                nav.style.paddingTop = "24px";
                nav.style.paddingBottom = "24px";
            }
        };


        @if(session('success'))
            Swal.fire({
                title: 'Verifikasi Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonColor: '#5E887E',
                background: '#F8FBF0',
                customClass: {
                    popup: 'rounded-3xl'
                }
            });
        @endif

        // NOTIFIKASI LONCENG & DROPDOWN SCRIPT
        const btnNotif = document.getElementById('btn-notification');
        const dropdownNotif = document.getElementById('dropdown-notification');
        const notifBadge = document.getElementById('notif-badge');
        const notifItems = document.querySelectorAll('.notification-item');

        let lastReadId = parseInt(localStorage.getItem('gopet_last_read_notif') || '0');
        let maxId = 0;
        notifItems.forEach(item => {
            const id = parseInt(item.getAttribute('data-id'));
            if (id > maxId) maxId = id;
        });

        if (maxId > lastReadId) {
            notifBadge.classList.remove('hidden');
        }

        function toggleNotificationDropdown(e) {
            if (e) {
                e.stopPropagation();
            }
            dropdownNotif.classList.toggle('hidden');
            if (!dropdownNotif.classList.contains('hidden')) {
                localStorage.setItem('gopet_last_read_notif', maxId.toString());
                notifBadge.classList.add('hidden');
            }
        }

        if (btnNotif) {
            btnNotif.addEventListener('click', toggleNotificationDropdown);
        }

        document.addEventListener('click', (e) => {
            if (dropdownNotif && !dropdownNotif.contains(e.target) && e.target !== btnNotif) {
                dropdownNotif.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
