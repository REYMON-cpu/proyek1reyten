<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - GoPet</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap" rel="stylesheet">

    <style>
        body{
            font-family:'Quicksand',sans-serif;
        }
    </style>
</head>

<body class="bg-[#FDF5E6] flex justify-center items-center min-h-screen">

<div class="bg-white rounded-3xl shadow-xl w-full max-w-md p-10">

    <h2 class="text-3xl font-bold text-center text-[#5E887E]">
        Reset Password
    </h2>

    <p class="text-center text-gray-500 mt-2 mb-8">
        Masukkan password baru untuk akun GoPet.
    </p>

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded-xl mb-4 text-center">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('reset.password') }}" method="POST">

        @csrf

        <input type="hidden"
               name="email"
               value="{{ $email }}">

        <div class="mb-4">
            <label class="block text-sm font-bold text-[#5E887E] mb-2">
                Password Baru
            </label>

            <input
                type="password"
                name="password"
                required
                class="w-full border rounded-xl p-4"
                placeholder="Masukkan password baru">
        </div>

        <div class="mb-6">
            <label class="block text-sm font-bold text-[#5E887E] mb-2">
                Konfirmasi Password
            </label>

            <input
                type="password"
                name="konfirmasi"
                required
                class="w-full border rounded-xl p-4"
                placeholder="Ulangi password">
        </div>

        <button
            type="submit"
            class="w-full bg-[#5E887E] text-white rounded-xl py-4 font-bold hover:bg-[#4a6b63]">

            Simpan Password

        </button>

    </form>

    <div class="text-center mt-6">

        <a href="{{ url('/') }}"
           class="text-[#5E887E] font-bold hover:underline">

            Kembali ke Login

        </a>

    </div>

</div>

</body>
</html>