<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat dengan {{ $sitter->nama }} — GoPet</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #F4F7F6; }
        #chat-messages { scroll-behavior: smooth; }
        .bubble-enter { animation: fadeSlideUp 0.25s ease forwards; }
        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col bg-[#F4F7F6] text-[#2D433E]">

    {{-- TOPBAR --}}
    <header class="bg-white border-b border-gray-100 px-4 md:px-8 py-4 flex items-center gap-4 sticky top-0 z-50 shadow-sm">
        <a href="{{ $sitter->jenis === 'dokter' ? '/pilih-dokter' : '/pilih-sitter' }}"
           class="w-10 h-10 rounded-2xl bg-[#F4F7F6] flex-shrink-0 flex items-center justify-center text-[#5E887E] hover:bg-[#5E887E]/10 transition-all">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <img src="https://api.dicebear.com/7.x/adventurer/svg?seed={{ urlencode($sitter->nama) }}"
             alt="{{ $sitter->nama }}"
             class="w-11 h-11 rounded-2xl bg-[#F8FBF0] border border-gray-100 object-cover">
        <div class="flex-1">
            <div class="font-bold text-[#2D433E] text-sm">{{ $sitter->nama }}</div>
            <div class="text-[10px] text-[#5E887E] font-semibold">
                <span class="inline-block w-1.5 h-1.5 rounded-full bg-green-500 mr-1"></span>
                {{ $sitter->spesialis ?? 'Pet Sitter' }}
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ url('/pesan-layanan/' . $sitter->id_penyedia) }}"
               class="px-4 py-2 bg-[#2D433E] text-white text-xs font-bold rounded-xl hover:bg-[#5E887E] transition-all">
                <i class="fa-solid fa-calendar-check mr-1.5"></i>{{ $sitter->jenis === 'dokter' ? 'Pesan Dokter' : 'Pesan Sitter' }}
            </a>
        </div>
    </header>

    {{-- CHAT AREA --}}
    <main class="flex-1 flex flex-col max-w-2xl w-full mx-auto px-4 py-4" style="height: calc(100vh - 140px);">

        {{-- Info sitter --}}
        <div class="bg-white rounded-[28px] p-4 mb-4 border border-gray-100 shadow-sm flex items-center gap-4">
            <img src="https://api.dicebear.com/7.x/adventurer/svg?seed={{ urlencode($sitter->nama) }}"
                 alt="{{ $sitter->nama }}" class="w-14 h-14 rounded-2xl bg-[#F8FBF0]">
            <div class="flex-1">
                <div class="font-bold text-[#2D433E]">{{ $sitter->nama }}</div>
                <div class="text-xs text-[#5E887E]">{{ $sitter->spesialis ?? 'Pet Sitter Profesional' }}</div>
                <div class="flex gap-3 mt-1.5 text-[10px] text-gray-400">
                    <span><i class="fa-solid fa-briefcase text-[#5E887E] mr-1"></i>{{ $sitter->pengalaman ?? 0 }} Tahun</span>
                    @if($sitter->tarif && $sitter->tarif > 0)
                    <span><i class="fa-solid fa-tag text-[#D9B08C] mr-1"></i>Rp {{ number_format($sitter->tarif, 0, ',', '.') }}{{ $sitter->jenis === 'dokter' ? '/visit' : '/hari' }}</span>
                    @endif
                </div>
            </div>
            <span class="px-3 py-1 bg-green-50 text-green-700 text-[10px] font-bold rounded-full border border-green-100">
                <i class="fa-solid fa-circle-check mr-1"></i>Disetujui
            </span>
        </div>

        {{-- Chat messages --}}
        <div id="chat-messages"
             class="flex-1 overflow-y-auto space-y-3 pb-4"
             style="max-height: calc(100vh - 300px); min-height: 200px;">

            {{-- Pesan pembuka dari sistem --}}
            <div class="flex justify-center">
                <span class="text-[10px] text-gray-400 bg-white px-3 py-1 rounded-full border border-gray-100 shadow-sm">
                    Mulai percakapan dengan {{ $sitter->nama }}
                </span>
            </div>

            @foreach($pesan_list as $pesan)
                @if($pesan->pengirim === 'pemilik')
                {{-- Bubble kanan (pemilik) --}}
                <div class="flex justify-end bubble-enter">
                    <div class="max-w-[75%] px-4 py-2.5 rounded-2xl rounded-br-sm bg-[#5E887E] text-white text-sm">
                        {{ $pesan->pesan }}
                        <div class="text-[9px] text-white/60 mt-1 text-right">
                            {{ \Carbon\Carbon::parse($pesan->created_at)->format('H:i') }}
                        </div>
                    </div>
                </div>
                @else
                {{-- Bubble kiri (sitter) --}}
                <div class="flex justify-start gap-2 bubble-enter">
                    <img src="https://api.dicebear.com/7.x/adventurer/svg?seed={{ urlencode($sitter->nama) }}"
                         class="w-8 h-8 rounded-xl bg-[#F8FBF0] flex-shrink-0 self-end" alt="{{ $sitter->nama }}">
                    <div class="max-w-[75%] px-4 py-2.5 rounded-2xl rounded-bl-sm bg-white text-[#2D433E] text-sm border border-gray-100">
                        {{ $pesan->pesan }}
                        <div class="text-[9px] text-gray-400 mt-1">
                            {{ \Carbon\Carbon::parse($pesan->created_at)->format('H:i') }}
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </main>

    {{-- INPUT CHAT --}}
    <div class="bg-white border-t border-gray-100 px-4 py-4 sticky bottom-0">
        <div class="max-w-2xl mx-auto flex gap-3 items-end">
            <div class="flex-1 bg-[#F4F7F6] rounded-2xl px-4 py-2.5 border border-gray-100 focus-within:border-[#5E887E] focus-within:ring-1 focus-within:ring-[#5E887E]/20 transition-all">
                <textarea id="chat-input"
                          rows="1"
                          placeholder="Ketik pesan untuk {{ $sitter->nama }}..."
                          class="w-full bg-transparent text-sm font-medium text-[#2D433E] focus:outline-none resize-none placeholder-gray-400"
                          style="max-height: 120px;"></textarea>
            </div>
            <button id="send-btn"
                    onclick="sendMessage()"
                    class="w-12 h-12 bg-[#5E887E] text-white rounded-2xl flex items-center justify-center hover:bg-[#4d7168] active:scale-95 transition-all shadow-md flex-shrink-0">
                <i class="fa-solid fa-paper-plane"></i>
            </button>
        </div>
    </div>

    <script>
        const ID_PENYEDIA = {{ $sitter->id_penyedia }};
        const CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let lastId        = {{ $pesan_list->isEmpty() ? 0 : $pesan_list->last()->id }};

        const chatMessages = document.getElementById('chat-messages');
        const chatInput    = document.getElementById('chat-input');

        // Auto-resize textarea
        chatInput.addEventListener('input', () => {
            chatInput.style.height = 'auto';
            chatInput.style.height = Math.min(chatInput.scrollHeight, 120) + 'px';
        });

        // Kirim dengan Enter (Shift+Enter untuk newline)
        chatInput.addEventListener('keydown', e => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });

        function scrollToBottom() {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function appendBubble(pengirim, text, waktu) {
            const isPemilik = pengirim === 'pemilik';
            const div = document.createElement('div');
            div.className = 'flex bubble-enter ' + (isPemilik ? 'justify-end' : 'justify-start gap-2');

            if (!isPemilik) {
                div.innerHTML = `
                    <img src="https://api.dicebear.com/7.x/adventurer/svg?seed={{ urlencode($sitter->nama) }}"
                         class="w-8 h-8 rounded-xl bg-[#F8FBF0] flex-shrink-0 self-end" alt="{{ $sitter->nama }}">
                    <div class="max-w-[75%] px-4 py-2.5 rounded-2xl rounded-bl-sm bg-white text-[#2D433E] text-sm border border-gray-100">
                        ${escHtml(text)}
                        <div class="text-[9px] text-gray-400 mt-1">${waktu}</div>
                    </div>`;
            } else {
                div.innerHTML = `
                    <div class="max-w-[75%] px-4 py-2.5 rounded-2xl rounded-br-sm bg-[#5E887E] text-white text-sm">
                        ${escHtml(text)}
                        <div class="text-[9px] text-white/60 mt-1 text-right">${waktu}</div>
                    </div>`;
            }
            chatMessages.appendChild(div);
            scrollToBottom();
        }

        function escHtml(text) {
            return text.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/\n/g,'<br>');
        }

        async function sendMessage() {
            const text = chatInput.value.trim();
            if (!text) return;

            chatInput.value = '';
            chatInput.style.height = 'auto';

            const now = new Date();
            const waktu = now.getHours().toString().padStart(2,'0') + ':' + now.getMinutes().toString().padStart(2,'0');
            appendBubble('pemilik', text, waktu);

            try {
                const res = await fetch('/chat-sitter/kirim', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    body: JSON.stringify({
                        id_penyedia: ID_PENYEDIA,
                        pesan: text,
                        pengirim: 'pemilik'
                    })
                });
                const data = await res.json();
                if (data.id) lastId = data.id;
            } catch(e) {
                console.error('Gagal kirim pesan:', e);
            }
        }

        // Polling: cek pesan baru dari sitter setiap 3 detik
        async function pollNewMessages() {
            try {
                const res = await fetch(`/api/chat-pesan/${ID_PENYEDIA}?since_id=${lastId}`);
                const msgs = await res.json();
                if (Array.isArray(msgs) && msgs.length > 0) {
                    msgs.forEach(m => {
                        if (m.pengirim !== 'pemilik') { // Hanya tampilkan balasan dari sitter
                            const d = new Date(m.created_at);
                            const waktu = d.getHours().toString().padStart(2,'0') + ':' + d.getMinutes().toString().padStart(2,'0');
                            appendBubble('penyedia', m.pesan, waktu);
                        }
                        lastId = Math.max(lastId, m.id);
                    });
                }
            } catch(e) {}
        }

        // Scroll ke bawah saat halaman load
        scrollToBottom();

        // Mulai polling setiap 3 detik
        setInterval(pollNewMessages, 3000);
    </script>

</body>
</html>
