<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar GoPet</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Quicksand', sans-serif; overflow-x: hidden; }

        @keyframes kartuMasuk {
            from { opacity: 0; transform: scale(0.9) translateY(30px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        @keyframes slideDariKiri {
            from { opacity: 0; transform: translateX(-100px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes zoomGemas {
            from { opacity: 0; transform: scale(0.5); }
            to { opacity: 1; transform: scale(1); }
        }

        .anim-kartu {
            animation: kartuMasuk 1s ease-out forwards;
        }
        .anim-teks {
            opacity: 0;
            animation: slideDariKiri 0.8s ease-out 0.6s forwards;
        }
        .anim-foto {
            opacity: 0;
            animation: zoomGemas 1.2s cubic-bezier(0.34, 1.56, 0.64, 1) 1s forwards;
        }
        .anim-form {
            opacity: 0;
            animation: kartuMasuk 0.8s ease-out 1.3s forwards;
        }
    </style>
</head>

<body class="bg-[#FDF5E6] flex items-center justify-center min-h-screen p-4">


    <div class="anim-kartu bg-white rounded-[30px] shadow-2xl overflow-hidden max-w-5xl w-full flex flex-col md:flex-row">

        <div class="md:w-1/2 bg-[#5E887E] p-10 md:p-12 flex flex-col justify-between text-white">
            <div class="anim-teks">
                <div class="flex items-center gap-2 mb-10">
                    <img src="{{ asset('images/logo putih.svg') }}" alt="Logo" class="h-12 w-auto">
                    <h2 class="text-3xl font-bold tracking-tight">GoPet</h2>
                </div>

                <h1 class="text-4xl lg:text-5xl font-bold leading-tight mb-6">
                    Bikin anabul makin happy dan terawat.
                </h1>
                <p class="text-lg opacity-90 leading-relaxed mb-8">
                    Booking jasa pet care gak pakai ribet. Mulai dari pet sitting sampai konsultasi ahli, semua ada di GoPet!
                </p>
            </div>
            <div class="w-full anim-foto">
                <img src="{{ asset('images/gopet form.jpeg') }}"
                     alt="Anabul"
                     class="w-full h-56 lg:h-64 object-cover rounded-[20px] shadow-md border-2 border-white/20 transition-transform duration-500 hover:scale-105">
            </div>
        </div>


        <div class="md:w-1/2 p-10 md:p-14 flex flex-col justify-center bg-white anim-form">
            <h2 class="text-3xl font-bold text-[#4A4A4A] mb-2">Buat Akun</h2>
            <p class="text-gray-500 mb-8">Lengkapi data di bawah untuk bergabung dengan komunitas GoPet.</p>

            <form action="#" class="space-y-5">
                <div>
                    <label class="block text-sm font-bold text-[#5E887E] mb-1">Nama Lengkap</label>
                    <input type="text" class="w-full px-4 py-3.5 rounded-xl bg-gray-50 border border-gray-100 focus:border-[#5E887E] focus:bg-white outline-none transition-all duration-300" placeholder="Nama lengkap">
                </div>

                <div>
                    <label class="block text-sm font-bold text-[#5E887E] mb-1">Email</label>
                    <input type="email" class="w-full px-4 py-3.5 rounded-xl bg-gray-50 border border-gray-100 focus:border-[#5E887E] focus:bg-white outline-none transition-all duration-300" placeholder="contoh@gmail.com">
                </div>

                <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
                    <div>
                        <label class="block text-sm font-bold text-[#5E887E] mb-1">Nomor Telepon</label>
                        <input type="tel" class="w-full px-4 py-3.5 rounded-xl bg-gray-50 border border-gray-100 focus:border-[#5E887E] focus:bg-white outline-none" placeholder="0812xxxxxxxx">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-[#5E887E] mb-1">Password</label>
                        <input type="password" class="w-full px-4 py-3.5 rounded-xl bg-gray-50 border border-gray-100 focus:border-[#5E887E] focus:bg-white outline-none" placeholder="••••••••">
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-[#5E887E] hover:bg-[#4a6b63] text-white font-bold py-4 rounded-xl shadow-lg transition-all duration-300 active:scale-95">
                        Daftar Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
-->
