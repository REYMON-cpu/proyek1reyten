<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #FAF9F6; }
    </style>
</head>
<body class="antialiased min-h-screen flex items-center justify-center p-4 relative overflow-hidden">

    <div class="absolute top-[-20%] left-[-10%] w-[500px] h-[500px] rounded-full bg-[#5E887E]/5 blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-[-20%] right-[-10%] w-[500px] h-[500px] rounded-full bg-[#D9B08C]/10 blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-md bg-white rounded-[40px] border border-[#5E887E]/10 p-8 md:p-10 shadow-[0_25px_60px_-15px_rgba(94,136,126,0.08)] relative z-10">

        <div class="text-center mb-8">
            <h2 class="text-2xl font-black text-[#5E887E] tracking-tight mb-2">Buat Akun GoPet</h2>
            <p class="text-xs text-gray-400 font-medium">Lengkapi data di bawah untuk memulai petualanganmu.</p>
        </div>

        @if(session('error'))
            <div class="bg-red-50 text-red-600 p-3 rounded-xl text-xs font-bold text-center mb-5">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ url('/register') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-[11px] font-extrabold text-gray-400 uppercase tracking-widest mb-2">Nama Lengkap</label>
                <input type="text" name="nama" required placeholder="Nama kamu"
                    class="w-full px-4 py-3.5 bg-[#FAF9F6] border border-gray-100 rounded-2xl text-xs font-semibold text-[#2D433E] focus:outline-none focus:border-[#5E887E] focus:bg-white transition-all">
            </div>

            <div>
                <label class="block text-[11px] font-extrabold text-gray-400 uppercase tracking-widest mb-2">Alamat Email</label>
                <input type="email" name="email" required placeholder="contoh@gopet.com"
                    class="w-full px-4 py-3.5 bg-[#FAF9F6] border border-gray-100 rounded-2xl text-xs font-semibold text-[#2D433E] focus:outline-none focus:border-[#5E887E] focus:bg-white transition-all">
            </div>

            <div>
                <label class="block text-[11px] font-extrabold text-gray-400 uppercase tracking-widest mb-2">Kata Sandi</label>
                <input type="password" name="password" required placeholder="••••••••"
                    class="w-full px-4 py-3.5 bg-[#FAF9F6] border border-gray-100 rounded-2xl text-xs font-semibold text-[#2D433E] focus:outline-none focus:border-[#5E887E] focus:bg-white transition-all">
            </div>

            <div>
                <label class="block text-[11px] font-extrabold text-gray-400 uppercase tracking-widest mb-2">Daftar Sebagai</label>
                <select name="role" required class="w-full px-4 py-3.5 bg-[#FAF9F6] border border-gray-100 rounded-2xl text-xs font-semibold text-[#2D433E] focus:outline-none focus:border-[#5E887E] focus:bg-white transition-all">
                    <option value="Pemilik Hewan">Pemilik Hewan</option>
                    <option value="Penyedia Jasa (Dokter)">Penyedia Jasa (Dokter)</option>
                    <option value="Penyedia Jasa (Pet Sitter)">Penyedia Jasa (Pet Sitter)</option>
                    <option value="Admin">Admin</option>
                </select>
            </div>

            <button type="submit" class="w-full py-4 mt-2 bg-[#5E887E] text-white rounded-2xl text-xs font-bold hover:bg-[#4d7168] transition-all shadow-md active:scale-[0.98]">
                Daftar Sekarang
            </button>
        </form>

        <div class="text-center mt-6 text-xs text-gray-400 font-medium">
            Sudah punya akun? <a href="{{ url('/') }}" class="text-[#5E887E] font-bold hover:underline">Login di sini</a>
        </div>
    </div>
</body>
</html>
