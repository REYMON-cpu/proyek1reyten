<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght=400;600;700;800&display=swap');
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #FAF9F6;
        }
    </style>
</head>
<body class="antialiased min-h-screen flex items-center justify-center p-4 relative overflow-hidden">


    <div class="absolute top-[-20%] left-[-10%] w-[500px] h-[500px] rounded-full bg-[#5E887E]/5 blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-[-20%] right-[-10%] w-[500px] h-[500px] rounded-full bg-[#D9B08C]/10 blur-3xl pointer-events-none"></div>


    <div class="w-full max-w-md bg-white rounded-[40px] border border-[#5E887E]/10 p-8 md:p-10 shadow-[0_25px_60px_-15px_rgba(94,136,126,0.08)] relative z-10">


        <div class="text-center mb-8">
            <div class="flex items-center justify-center gap-3 mb-3">
                <img src="{{ asset('images/logo hijau.svg') }}" alt="Logo GoPet" class="h-12 w-auto" onerror="this.style.display='none'">
                <h2 class="text-2xl font-black text-[#5E887E] tracking-tight">Go<span class="text-[#D9B08C]">Pet</span></h2>
            </div>
            <h3 class="text-xl font-black text-[#2D433E]">Selamat Datang Kembali!</h3>
            <p class="text-xs text-gray-400 font-medium mt-1">Masuk untuk mengelola sistem dan verifikasi berkas GoPet.</p>
        </div>

        <form action="#" method="POST" class="space-y-5">

            <div>
                <label for="email" class="block text-[11px] font-extrabold text-gray-400 uppercase tracking-widest mb-2">Alamat Email Admin</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                        <i class="fa-solid fa-envelope text-sm"></i>
                    </div>
                    <input type="email" id="email" name="email" required placeholder="admin@gopet.com"
                        class="w-full pl-11 pr-4 py-3.5 bg-[#FAF9F6] border border-gray-100 rounded-2xl text-xs font-semibold text-[#2D433E] placeholder-gray-300 focus:outline-none focus:border-[#5E887E] focus:bg-white transition-all duration-300">
                </div>
            </div>

            <div>
                <label for="password" class="block text-[11px] font-extrabold text-gray-400 uppercase tracking-widest mb-2">Kata Sandi</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                        <i class="fa-solid fa-lock text-sm"></i>
                    </div>
                    <input type="password" id="password" name="password" required placeholder="••••••••"
                        class="w-full pl-11 pr-12 py-3.5 bg-[#FAF9F6] border border-gray-100 rounded-2xl text-xs font-semibold text-[#2D433E] placeholder-gray-300 focus:outline-none focus:border-[#5E887E] focus:bg-white transition-all duration-300">
                    <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-[#5E887E]">
                        <i id="password-icon" class="fa-solid fa-eye text-xs"></i>
                    </button>
                </div>
            </div>


            <div class="flex items-center">
                <input id="remember_me" name="remember" type="checkbox"
                    class="h-4 w-4 text-[#5E887E] focus:ring-[#5E887E]/30 border-gray-200 rounded-lg">
                <label for="remember_me" class="ml-2 block text-xs text-gray-400 font-semibold select-none cursor-pointer">
                    Ingat akun saya di perangkat ini
                </label>
            </div>

            <div class="pt-2">
                <button type="submit"
                    class="w-full py-4 bg-[#5E887E] text-white rounded-2xl text-xs font-bold hover:bg-[#4d7168] transition-all duration-300 shadow-md shadow-[#5E887E]/10 active:scale-[0.98]">
                    Masuk ke Dashboard
                </button>
            </div>
        </form>

        <div class="text-center mt-8 pt-5 border-t border-gray-50">
            <p class="text-[10px] font-bold text-gray-300 uppercase tracking-widest">&copy; 2026 GoPet Ecosystem. All Rights Reserved.</p>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('password-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
