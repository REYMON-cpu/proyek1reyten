<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Akun</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Quicksand', sans-serif; overflow-x: hidden; }

        @keyframes kartuMasuk {
            from { opacity: 0; transform: scale(0.9) translateY(30px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        @keyframes slideTeks {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes getar {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-8px); }
            75% { transform: translateX(8px); }
        }

        .anim-getar { animation: getar 0.4s ease-in-out;}
        .anim-kartu { animation: kartuMasuk 0.8s ease-out forwards; }
        .anim-konten { opacity: 0; animation: slideTeks 0.6s ease-out 0.5s forwards; }

        @media screen and (max-width: 480px) {
            .anim-kartu {
                padding: 32px 20px !important;
            }

            #otp-inputs input {
                width: 3.25rem !important;
                height: 3.25rem !important;
                font-size: 1.25rem !important;
            }

            #otp-inputs {
                gap: 8px !important;
                justify-content: center !important;
            }
        }
    </style>
</head>

<body class="bg-[#FDF5E6] flex items-center justify-center min-h-screen p-4">

    <div class="anim-kartu bg-white rounded-[30px] shadow-2xl overflow-hidden max-w-md w-full p-10 text-center">

        <div class="anim-konten flex justify-center mb-6">
            <div class="bg-[#5E887E] p-4 rounded-full shadow-inner">
                <img src="{{ asset('images/logo putih.svg') }}" alt="Logo" class="h-10 w-auto">
            </div>
        </div>

        <div class="anim-konten">
            <h2 class="text-2xl font-bold text-[#4A4A4A] mb-2">Verifikasi Email Kamu</h2>
            <p class="text-gray-500 mb-8 text-sm">Kami telah mengirimkan kode OTP ke email kamu. Masukkan kodenya di bawah ya!</p>
        </div>


        <form action="#" class="space-y-8 anim-konten">
            <div class="flex justify-between gap-2" id="otp-inputs">
                <input type="text" name="otp[]" maxlength="1" class="w-14 h-14 text-center text-2xl font-bold rounded-xl bg-gray-50 border border-gray-100 focus:border-[#5E887E] focus:ring-2 focus:ring-[#5E887E]/20 outline-none transition-all duration-300">
                <input type="text" name="otp[]" maxlength="1" class="w-14 h-14 text-center text-2xl font-bold rounded-xl bg-gray-50 border border-gray-100 focus:border-[#5E887E] focus:ring-2 focus:ring-[#5E887E]/20 outline-none transition-all duration-300">
                <input type="text" name="otp[]" maxlength="1" class="w-14 h-14 text-center text-2xl font-bold rounded-xl bg-gray-50 border border-gray-100 focus:border-[#5E887E] focus:ring-2 focus:ring-[#5E887E]/20 outline-none transition-all duration-300">
                <input type="text" name="otp[]" maxlength="1" class="w-14 h-14 text-center text-2xl font-bold rounded-xl bg-gray-50 border border-gray-100 focus:border-[#5E887E] focus:ring-2 focus:ring-[#5E887E]/20 outline-none transition-all duration-300">
            </div>

            @if(session('error'))
                <p class="text-red-400 text-xs mb-4 anim-getar text-center">
                    {{ session('error') }}
                </p>
            @endif

            <button type="submit" class="w-full bg-[#5E887E] hover:bg-[#4a6b63] text-white font-bold py-4 rounded-xl shadow-lg transition-all duration-300 transform active:scale-95">
                Verifikasi Sekarang
            </button>
        </form>

        <div class="anim-konten mt-8">
            <p class="text-sm text-gray-500">
                Belum terima kode? <br>
                <a href="#" class="text-[#5E887E] font-bold hover:underline">
                    Kirim ulang kode <span id="timer">(00:59)</span>
                </a>
            </p>
        </div>
    </div>

    <script>
        const inputs = document.querySelectorAll('#otp-inputs input');
        const otpContainer = document.getElementById('otp-inputs');
        const form = document.querySelector('form');

        inputs.forEach((input, index) => {
            if (index === 0) input.focus();
            input.addEventListener('input', (e) => {
                if (e.target.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });


        form.addEventListener('submit', (e) => {
            const values = Array.from(inputs).map(input => input.value).join('')
            if (values.length < 4) {
                e.preventDefault();
                otpContainer.classList.add('anim-getar');
                setTimeout(() => {
                    otpContainer.classList.remove('anim-getar');
                }, 400);
            }
        });


        let waktu = 59;
        const displayTimer = document.getElementById('timer');
        const jalankanTimer = setInterval(() => {
            waktu--;
            let detik = waktu < 10 ? '0' + waktu : waktu;

            if (displayTimer) {
                displayTimer.innerHTML = `(00:${detik})`;
            }

            if (waktu <= 0) {
                clearInterval(jalankanTimer);
                displayTimer.innerHTML = "Sekarang";
                displayTimer.parentElement.style.cursor = "pointer";
            }
        }, 1000);

        inputs[0].addEventListener('paste', (e) => {
            const pasteData = e.clipboardData.getData('text');
            if (pasteData.length === inputs.length) {
                inputs.forEach((input, index) => {
                    input.value = pasteData[index];
                });
                inputs[inputs.length - 1].focus();
            }
        });
    </script>
</body>
</html>
