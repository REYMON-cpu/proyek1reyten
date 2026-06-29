<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pet Sitter — GoPet</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #FAF9F6; color: #2D433E; }
        .sidebar-link.active { background-color: #5E887E; color: white; box-shadow: 0 10px 25px -5px rgba(94,136,126,0.3); }
        .sidebar-link.active i { color: white; }
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(94,136,126,0.2); border-radius: 10px; }
        .modal-overlay { display: none; }
        .modal-overlay.show { display: flex; }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
    </style>
</head>
<body class="antialiased flex h-screen overflow-hidden">

  <!-- SIDEBAR -->
  <aside id="sidebar" class="fixed inset-y-0 left-0 w-72 bg-white border-r border-[#5E887E]/10 flex flex-col justify-between p-6 h-full z-[60] transform transition-transform duration-300 ease-in-out">
    <div class="space-y-8">

      <!-- Logo -->
    <div class="flex items-center justify-between px-2">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo hijau.svg') }}" alt="Logo" class="h-12 w-auto">
            <div>
                <h2 class="text-xl font-bold text-[#5E887E] tracking-tight">Go<span class="text-[#D9B08C]">Pet</span></h2>
                <span class="text-[10px] font-bold text-[#5E887E] uppercase tracking-widest block -mt-1">Sitter Panel</span>
            </div>
        </div>
        <button onclick="toggleSidebar()" class="w-9 h-9 rounded-xl bg-gray-50 flex items-center justify-center text-[#5E887E] hover:bg-gray-100 lg:hidden">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>

      <!-- Nav -->
      <nav class="space-y-1">
        <p class="text-[10px] font-extrabold uppercase tracking-[0.2em] text-[#5E887E] px-3 mb-3">Menu Utama</p>

        <button onclick="switchTab('dashboard')" id="btn-tab-dashboard"
          class="sidebar-link active w-full text-left flex items-center gap-4 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300">
          <i class="fa-solid fa-chart-pie text-base w-5 text-center"></i> Dashboard
        </button>

        <button onclick="switchTab('jadwal')" id="btn-tab-jadwal"
          class="sidebar-link text-[#5E887E] hover:bg-[#E8F0EE]/50 w-full text-left flex items-center gap-4 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300">
          <i class="fa-solid fa-calendar-days text-base w-5 text-center"></i> Jadwal Penitipan
        </button>

        <button onclick="switchTab('catatan')" id="btn-tab-catatan"
          class="sidebar-link text-[#5E887E] hover:bg-[#E8F0EE]/50 w-full text-left flex items-center gap-4 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300">
          <i class="fa-solid fa-clipboard-list text-base w-5 text-center"></i> Catatan Harian
        </button>

        <button onclick="switchTab('chat')" id="btn-tab-chat"
          class="sidebar-link text-[#5E887E] hover:bg-[#E8F0EE]/50 w-full text-left flex items-center gap-4 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300">
          <i class="fa-solid fa-comments text-base w-5 text-center"></i> Chat Pemilik
          @if($chat_list->sum('unread_count') > 0)
          <span id="badge-chat" class="ml-auto bg-[#5E887E] text-white text-[9px] font-bold px-2 py-0.5 rounded-full">{{ $chat_list->sum('unread_count') }}</span>
          @endif
        </button>

        <button onclick="switchTab('profil')" id="btn-tab-profil"
          class="sidebar-link text-[#5E887E] hover:bg-[#E8F0EE]/50 w-full text-left flex items-center gap-4 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300">
          <i class="fa-solid fa-circle-user text-base w-5 text-center"></i> Tarif
        </button>
      </nav>
    </div>

    <!-- Profile & Logout -->
    <div class="space-y-3">
      <div class="flex items-center gap-3 px-3 py-3 bg-[#E8F0EE]/40 rounded-2xl">
        <div class="w-10 h-10 rounded-xl bg-[#5E887E] flex items-center justify-center text-white text-sm font-bold">
          {{ strtoupper(substr($provider->nama ?? session('nama') ?? 'Si', 0, 2)) }}
        </div>
        <div>
          <div class="text-sm font-bold text-[#2D433E]">{{ $provider->nama ?? session('nama') ?? 'Pet Sitter' }}</div>
          <div id="sidebar-status-text" class="text-[10px] text-[#5E887E] font-semibold">● {{ $provider->spesialis ?? 'Pet Sitter Jasa' }}</div>
        </div>
      </div>
      <div class="border-t border-[#5E887E]/10 pt-3">
        <a href="{{ url('/logout') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-red-400 hover:bg-red-50 font-bold text-sm transition-all">
          <i class="fa-solid fa-arrow-right-from-bracket w-5 text-center"></i> Keluar Aplikasi
        </a>
      </div>
    </div>
  </aside>

  <!-- MAIN CONTENT -->
  <div id="main-content" class="flex-1 flex flex-col h-full overflow-y-auto lg:pl-72 transition-all duration-300">

    <!-- TOPBAR -->
    <header class="px-6 md:px-10 pt-6 pb-2 flex justify-between items-center sticky top-0 bg-[#FAF9F6]/90 backdrop-blur-sm z-40">
      <div class="flex items-center gap-4">
        <button onclick="toggleSidebar()" class="w-11 h-11 bg-white rounded-2xl border border-gray-100 shadow-sm flex items-center justify-center text-gray-500 hover:text-[#5E887E] transition-all">
          <i class="fa-solid fa-bars"></i>
        </button>
        <div>
          <h1 id="page-title" class="text-xl md:text-2xl font-black text-[#2D433E] tracking-tight">Halo, Kak {{ $provider->nama ?? session('nama') }}! 🐾</h1>
          <p id="page-desc" class="text-xs text-[#5E887E] font-medium mt-0.5 hidden sm:block">Ringkasan aktivitas penitipan dan status Anda hari ini.</p>
        </div>
      </div>


      <!-- Status Indicator -->
      <div class="flex items-center gap-3">
        <div id="status-pill" class="flex items-center gap-2 px-4 py-2 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-200">
          <div id="status-dot" class="w-2 h-2 rounded-full bg-green-600"></div>
          <span id="status-label">Tersedia</span>
        </div>
      </div>
    </header>

    @if(session('success'))
    <div class="mx-6 md:mx-10 mt-4 px-4 py-3 bg-[#E8F0EE] border border-green-200 text-green-700 rounded-2xl text-xs font-semibold">
      <i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="mx-6 md:mx-10 mt-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-2xl text-xs font-semibold">
      <i class="fa-solid fa-circle-xmark mr-2"></i>{{ session('error') }}
    </div>
    @endif

    <!-- ===== TAB: DASHBOARD ===== -->
    <div id="tab-dashboard" class="tab-content active">
        <main class="px-6 md:px-10 py-6 space-y-8">

       <!-- Metric Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="bg-white p-5 rounded-[28px] border border-[#5E887E]/5 shadow-sm flex justify-between items-center">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-wider text-[#5E887E]">Penitipan Hari Ini</p>
                    <h3 class="text-2xl font-black text-[#2D433E] mt-1">{{ $penitipan_hari_ini }} <span class="text-xs font-medium text-[#5E887E]">sesi</span></h3>
                </div>
                <div class="w-12 h-12 bg-[#5E887E]/10 rounded-2xl flex items-center justify-center text-[#5E887E] text-xl"><i class="fa-solid fa-dog"></i></div>
            </div>

            <div class="bg-white p-5 rounded-[28px] border border-[#5E887E]/5 shadow-sm flex justify-between items-center">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-wider text-[#5E887E]">Menunggu Konfirmasi</p>
                    <h3 class="text-2xl font-black text-amber-600 mt-1">{{ $menunggu_konfirmasi }} <span class="text-xs font-medium text-[#5E887E]">booking</span></h3>
                </div>
                <div class="w-12 h-12 bg-amber-500/10 rounded-2xl flex items-center justify-center text-amber-600 text-xl"><i class="fa-solid fa-clock"></i></div>
            </div>

            <div class="bg-white p-5 rounded-[28px] border border-[#5E887E]/5 shadow-sm flex justify-between items-center">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-wider text-[#5E887E]">Total Hewan yang telah diasuh</p>
                    <h3 class="text-2xl font-black text-[#2D433E] mt-1">{{ $total_hewan_diasuh }} <span class="text-xs font-medium text-[#5E887E]">hewan</span></h3>
                </div>
                <div class="w-12 h-12 bg-teal-500/10 rounded-2xl flex items-center justify-center text-teal-600 text-xl"><i class="fa-solid fa-circle-check"></i></div>
            </div>
        </div>

        <!-- Jadwal Hari Ini + Chat Preview -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

          <!-- Jadwal Preview -->
          <div class="bg-white rounded-[32px] border border-gray-100 p-6 shadow-sm">
            <div class="flex justify-between items-start mb-5">
              <div>
                <h3 class="text-base font-extrabold text-[#2D433E]">Jadwal Hari Ini</h3>
                <p class="text-xs text-[#5E887E] mt-0.5">{{ date('l, d M Y') }}</p>
              </div>
              <button onclick="switchTab('jadwal')" class="text-xs font-bold text-[#5E887E] hover:underline">Lihat Semua →</button>
            </div>
            <div class="space-y-3">
              @forelse(collect($bookings)->take(3) as $booking)
              <div class="flex items-center gap-3 p-3 rounded-2xl bg-[#FAF9F6] border border-gray-50">
                <div class="text-center min-w-[44px]">
                  <div class="text-[10px] font-bold text-[#5E887E]">{{ \Carbon\Carbon::parse($booking->tanggal)->format('H:i') ?? '09:00' }}</div>
                </div>
                <div class="w-9 h-9 rounded-xl bg-[#5E887E]/10 flex items-center justify-center text-[#5E887E] text-xs font-bold">
                  {{ strtoupper(substr($booking->nama_pemilik ?? 'CU', 0, 2)) }}
                </div>
                <div class="flex-1">
                  <div class="text-xs font-bold text-[#2D433E]">{{ $booking->nama_pemilik }}</div>
                  <div class="text-[10px] text-gray-400">{{ $booking->nama_hewan }} — {{ $booking->jenis_hewan }}</div>
                </div>
                <span class="px-2.5 py-1 
                  @if($booking->status === 'Pending') bg-amber-100 text-amber-700
                  @elseif($booking->status === 'Disetujui' || $booking->status === 'Berlangsung') bg-blue-100 text-blue-700
                  @else bg-green-100 text-green-700 @endif rounded-full text-[10px] font-bold">
                  {{ $booking->status }}
                </span>
              </div>
              @empty
              <p class="text-xs text-gray-400 text-center py-4">Belum ada jadwal hari ini, Cees!</p>
              @endforelse
            </div>
          </div>

          <!-- Chat Preview -->
          <div class="bg-white rounded-[32px] border border-gray-100 p-6 shadow-sm">
            <div class="flex justify-between items-start mb-5">
              <div>
                <h3 class="text-base font-extrabold text-[#2D433E]">Pesan Masuk</h3>
                <p class="text-xs text-[#5E887E] mt-0.5">Chat dari pemilik hewan</p>
              </div>
              <button onclick="switchTab('chat')" class="text-xs font-bold text-[#5E887E] hover:underline">Lihat Semua →</button>
            </div>
            <div class="space-y-3">
              @forelse(collect($chat_list)->take(3) as $chat)
              <div onclick="switchTab('chat'); openChatModal({{ $chat->id_user }}, '{{ addslashes($chat->nama_pemilik) }}')"
                   class="flex items-center gap-3 p-3 rounded-2xl hover:bg-[#FAF9F6] cursor-pointer transition-all border border-transparent hover:border-gray-50">
                <div class="w-2 h-2 rounded-full {{ $chat->unread_count > 0 ? 'bg-[#5E887E]' : 'bg-transparent' }} flex-shrink-0"></div>
                <div class="w-9 h-9 rounded-xl bg-[#D9B08C]/10 flex items-center justify-center text-[#D9B08C] text-xs font-bold flex-shrink-0">
                  {{ strtoupper(substr($chat->nama_pemilik, 0, 2)) }}
                </div>
                <div class="flex-1 min-w-0">
                  <div class="text-xs font-bold text-[#2D433E]">{{ $chat->nama_pemilik }}</div>
                  <div class="text-[10px] text-[#5E887E] truncate">{{ $chat->last_pesan }}</div>
                </div>
                <div class="text-[10px] text-[#5E887E] font-semibold flex-shrink-0">
                  {{ $chat->last_time ? \Carbon\Carbon::parse($chat->last_time)->format('H:i') : '' }}
                </div>
              </div>
              @empty
              <p class="text-xs text-[#5E887E]/60 text-center py-4">Belum ada pesan masuk, Cees!</p>
              @endforelse
            </div>
          </div>
        </div>

      </main>
    </div>

    <!-- ===== TAB: JADWAL PENITIPAN ===== -->
    <div id="tab-jadwal" class="tab-content">
      <main class="px-6 md:px-10 py-6">
        <div class="bg-white rounded-[32px] border border-gray-100 p-6 md:p-8 shadow-sm">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
              <h3 class="text-lg font-extrabold text-[#2D433E]">Jadwal Penitipan</h3>
              <p class="text-xs text-[#5E887E] mt-0.5">Kelola sesi penjagaan dan konfirmasi booking harian.</p>
            </div>
            <button onclick="openJadwalModal('create')" class="px-4 py-2.5 bg-[#5E887E] text-white rounded-xl text-xs font-bold hover:bg-[#4d7168] transition-all flex items-center gap-2 shadow-md">
              <i class="fa-solid fa-plus"></i> Tambah Jadwal
            </button>
          </div>

          <div class="space-y-3" id="jadwal-list">
            @forelse($bookings as $booking)
            <div id="jadwal-row-{{ $booking->id_pemesanan }}" class="flex flex-wrap items-center gap-3 p-4 rounded-2xl border border-gray-50 
              @if($booking->status === 'Pending') bg-amber-50/30 border-amber-50
              @elseif($booking->status === 'Disetujui' || $booking->status === 'Berlangsung') bg-blue-50/30 border-blue-50
              @else bg-[#FAF9F6]/60 @endif hover:bg-[#FAF9F6] transition-all">
              <div class="text-xs font-bold text-[#5E887E] w-12">{{ \Carbon\Carbon::parse($booking->tanggal)->format('H:i') ?? '09:00' }}</div>
              <div class="w-10 h-10 rounded-xl bg-[#5E887E]/10 flex items-center justify-center text-[#5E887E] text-xs font-bold">
                {{ strtoupper(substr($booking->nama_pemilik ?? 'CU', 0, 2)) }}
              </div>
              <div class="flex-1 min-w-[120px]">
                <div class="text-sm font-bold text-[#2D433E] cell-j-nama">{{ $booking->nama_pemilik }}</div>
                <div class="text-[10px] text-[#5E887E] cell-j-hewan">{{ $booking->nama_hewan }} — {{ $booking->jenis_hewan }} • {{ $booking->alamat }}</div>
              </div>
              <span class="px-2.5 py-1 
                @if($booking->status === 'Pending') bg-amber-100 text-amber-700
                @elseif($booking->status === 'Disetujui' || $booking->status === 'Berlangsung') bg-blue-100 text-blue-700
                @else bg-green-100 text-green-700 @endif rounded-full text-[10px] font-bold cell-j-status">
                {{ $booking->status }}
              </span>
              <div class="flex gap-2">
                @if($booking->status === 'Pending')
                  <form action="{{ route('pemesanan.update-status', $booking->id_pemesanan) }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="status" value="Berlangsung">
                    <button type="submit" class="w-8 h-8 bg-green-50 text-green-600 rounded-lg text-xs flex items-center justify-center hover:bg-green-500 hover:text-white transition-all" title="Terima"><i class="fa-solid fa-check"></i></button>
                  </form>
                  <form action="{{ route('pemesanan.update-status', $booking->id_pemesanan) }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="status" value="Ditolak">
                    <button type="submit" class="w-8 h-8 bg-red-50 text-red-400 rounded-lg text-xs flex items-center justify-center hover:bg-red-500 hover:text-white transition-all" title="Tolak"><i class="fa-solid fa-xmark"></i></button>
                  </form>
                @elseif($booking->status === 'Berlangsung')
                  <form action="{{ route('pemesanan.update-status', $booking->id_pemesanan) }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="status" value="Selesai">
                    <button type="submit" class="w-8 h-8 bg-green-50 text-green-600 rounded-lg text-xs flex items-center justify-center hover:bg-green-500 hover:text-white transition-all" title="Tandai Selesai"><i class="fa-solid fa-check"></i></button>
                  </form>
                @endif
              </div>
            </div>
            @empty
            <p class="text-xs text-gray-400 text-center py-4">Belum ada jadwal penitipan masuk, Cees!</p>
            @endforelse
          </div>
        </div>
      </main>
    </div>

    <!-- ===== TAB: CATATAN HARIAN ===== -->
    <div id="tab-catatan" class="tab-content">
      <main class="px-6 md:px-10 py-6">
        <div class="bg-white rounded-[32px] border border-gray-100 p-6 md:p-8 shadow-sm">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
              <h3 class="text-lg font-extrabold text-[#2D433E]">Catatan Perawatan Harian</h3>
              <p class="text-xs text-[#5E887E] mt-0.5">Riwayat aktivitas dan kondisi seluruh hewan yang dititipkan.</p>
            </div>
            <button onclick="openCatatanModal('create')" class="px-4 py-2.5 bg-[#5E887E] text-white rounded-xl text-xs font-bold hover:bg-[#4d7168] transition-all flex items-center gap-2 shadow-md">
              <i class="fa-solid fa-plus"></i> Tambah Catatan
            </button>
          </div>
          <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="border-b border-gray-100 text-[10px] font-extrabold text-[#5E887E] uppercase tracking-widest">
                  <th class="pb-4 pl-2">Nama Hewan</th>
                  <th class="pb-4">Pemilik</th>
                  <th class="pb-4">Layanan</th>
                  <th class="pb-4">Kondisi & Catatan</th>
                  <th class="pb-4">Tanggal</th>
                  <th class="pb-4 text-center">Aksi</th>
                </tr>
              </thead>
              <tbody id="catatan-table-body" class="divide-y divide-gray-50 text-sm font-medium text-[#2D433E]">
                @forelse($catatan_list as $catatan)
                <tr id="catatan-row-{{ $catatan->id }}" class="hover:bg-[#FAF9F6]/50 transition-colors">
                  <td class="py-4 pl-2">
                    <div class="font-bold cell-c-hewan">{{ $catatan->nama_hewan }}</div>
                    <div class="text-[10px] text-[#5E887E] cell-c-jenis">{{ $catatan->jenis_hewan }}</div>
                  </td>
                  <td class="py-4 text-xs cell-c-pemilik">{{ $catatan->nama_pemilik }}</td>
                  <td class="py-4">
                    <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded-full text-[10px] font-bold cell-c-layanan">{{ $catatan->jenis_layanan }}</span>
                  </td>
                  <td class="py-4 text-xs cell-c-catatan">{{ $catatan->catatan }}</td>
                  <td class="py-4 text-[10px] text-[#5E887E] cell-c-tanggal">{{ $catatan->tanggal }}</td>
                  <td class="py-4">
                    <div class="flex justify-center gap-2">
                      <button onclick="openCatatanModal('edit', {{ $catatan->id }})" class="w-8 h-8 bg-amber-50 text-amber-600 rounded-lg text-xs flex items-center justify-center hover:bg-amber-500 hover:text-white transition-all" title="Edit"><i class="fa-solid fa-pen-to-square"></i></button>
                      <form action="{{ route('rekam-medis.delete', $catatan->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus catatan ini?')">
                        @csrf
                        <button type="submit" class="w-8 h-8 bg-red-50 text-red-400 rounded-lg text-xs flex items-center justify-center hover:bg-red-500 hover:text-white transition-all" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                      </form>
                    </div>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="6" class="text-center py-8 text-gray-400 text-xs font-semibold">Belum ada catatan harian yang ditambahkan.</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </main>
    </div>

    <!-- ===== TAB: CHAT ===== -->
    <div id="tab-chat" class="tab-content">
      <main class="px-6 md:px-10 py-6">
        <div class="bg-white rounded-[32px] border border-gray-100 p-6 md:p-8 shadow-sm">
          <div class="mb-6">
            <h3 class="text-lg font-extrabold text-[#2D433E]">Chat dengan Pemilik Hewan</h3>
            <p class="text-xs text-[#5E887E] mt-0.5">Update perkembangan dan komunikasi langsung via pesan.</p>
          </div>
          <div id="chat-list-container" class="space-y-3">
            @forelse($chat_list as $chat)
            <div class="flex items-center gap-4 p-4 rounded-2xl border border-[#5E887E]/10 hover:bg-[#FAF9F6] cursor-pointer transition-all"
                 onclick="openChatModal({{ $chat->id_user }}, '{{ addslashes($chat->nama_pemilik) }}')">
              <div class="w-2 h-2 rounded-full {{ $chat->unread_count > 0 ? 'bg-[#5E887E]' : 'bg-transparent' }} flex-shrink-0"></div>
              <div class="w-11 h-11 rounded-xl bg-[#D9B08C]/10 flex items-center justify-center text-[#D9B08C] text-sm font-bold flex-shrink-0">
                {{ strtoupper(substr($chat->nama_pemilik, 0, 2)) }}
              </div>
              <div class="flex-1 min-w-0">
                <div class="text-sm font-bold text-[#2D433E]">{{ $chat->nama_pemilik }}</div>
                <div class="text-xs text-[#5E887E] truncate mt-0.5">{{ $chat->last_pesan }}</div>
              </div>
              <div class="flex flex-col items-end gap-1.5 flex-shrink-0">
                <div class="text-[10px] text-[#5E887E] font-semibold">
                  {{ $chat->last_time ? \Carbon\Carbon::parse($chat->last_time)->format('H:i') : '' }}
                </div>
                @if($chat->unread_count > 0)
                <div class="w-5 h-5 rounded-full bg-[#5E887E] flex items-center justify-center text-white text-[9px] font-bold">
                  {{ $chat->unread_count }}
                </div>
                @endif
              </div>
            </div>
            @empty
            <div class="text-center py-12">
              <div class="w-16 h-16 bg-[#F4F7F6] rounded-3xl flex items-center justify-center mx-auto mb-3">
                <i class="fa-solid fa-comments text-2xl text-[#5E887E]/30"></i>
              </div>
              <p class="text-sm font-bold text-gray-400">Belum ada pesan masuk</p>
              <p class="text-xs text-gray-300 mt-1">Pemilik hewan akan menghubungi Anda melalui halaman Pilih Sitter.</p>
            </div>
            @endforelse
          </div>
        </div>
      </main>
    </div>

    <!-- ===== TAB: PROFIL & TARIF ===== -->
    <div id="tab-profil" class="tab-content">
      <main class="px-6 md:px-10 py-6 space-y-6">

        <!-- Status Panel -->
        <div class="bg-white rounded-[32px] border border-gray-100 p-6 md:p-8 shadow-sm">
          <div class="mb-5">
            <h3 class="text-lg font-extrabold text-[#2D433E]">Status Ketersediaan</h3>
            <p class="text-xs text-[#5E887E] mt-0.5">Update status real-time Anda agar terlihat pemilik hewan.</p>
          </div>
          <div class="flex flex-wrap gap-3">
            <button onclick="setStatus('tersedia')" class="status-opt px-5 py-2.5 rounded-full text-xs font-bold border-2 border-green-200 bg-green-50 text-green-800 hover:border-green-500 transition-all selected-status" data-status="tersedia">
              <i class="fa-solid fa-circle-check mr-1.5"></i> Tersedia
            </button>
            <button onclick="setStatus('perjalanan')" class="status-opt px-5 py-2.5 rounded-full text-xs font-bold border-2 border-amber-200 bg-amber-50 text-amber-800 hover:border-amber-500 transition-all" data-status="perjalanan">
              <i class="fa-solid fa-car mr-1.5"></i> Dalam Perjalanan
            </button>
            <button onclick="setStatus('menjaga')" class="status-opt px-5 py-2.5 rounded-full text-xs font-bold border-2 border-blue-200 bg-blue-50 text-blue-800 hover:border-blue-500 transition-all" data-status="menjaga">
              <i class="fa-solid fa-paw mr-1.5"></i> Sedang Menjaga
            </button>
            <button onclick="setStatus('off')" class="status-opt px-5 py-2.5 rounded-full text-xs font-bold border-2 border-teal-200 bg-teal-50 text-teal-800 hover:border-teal-500 transition-all" data-status="off">
              <i class="fa-solid fa-moon mr-1.5"></i> Tidak Bertugas
            </button>
          </div>
        </div>

        <!-- Profil Form -->
        <div class="bg-white rounded-[32px] border border-gray-100 p-6 md:p-8 shadow-sm">
        <div class="mb-5">
            <h3 class="text-lg font-extrabold text-[#2D433E]">Pengajuan Kenaikan Tarif Pet Sitter</h3>
            <p class="text-xs text-[#5E887E] mt-0.5">Formulir ini digunakan untuk mengajukan penyesuaian tarif jasa penitipan. Perubahan akan berlaku setelah diverifikasi oleh Admin.</p>
        </div>

        <form action="{{ route('pengajuan.tarif.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <input type="hidden" name="tarif_sekarang" value="{{ $provider->tarif ?? 0 }}">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            <!-- Nama Lengkap (Disabled/Read-only karena otomatis dari akun) -->
            <div>
                <label class="block text-[10px] font-bold text-[#5E887E] uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                <input type="text" value="{{ $provider->nama ?? session('nama') ?? 'Pet Sitter' }}" disabled class="w-full px-4 py-2.5 bg-[#F5F5F3] border border-gray-100 rounded-xl text-xs font-semibold text-[#5E887E] cursor-not-allowed focus:outline-none">
            </div>

            <!-- Layanan (Disabled/Read-only) -->
            <div>
                <label class="block text-[10px] font-bold text-[#5E887E] uppercase tracking-wider mb-1.5">Layanan</label>
                <input type="text" value="Pet Sitter — Dog Walking & Pet Hotel" disabled class="w-full px-4 py-2.5 bg-[#F5F5F3] border border-gray-100 rounded-xl text-xs font-semibold text-[#5E887E] cursor-not-allowed focus:outline-none">
            </div>

            <!-- Tarif Saat Ini -->
            <div>
                <label class="block text-[10px] font-bold text-[#5E887E] uppercase tracking-wider mb-1.5">Tarif Saat Ini (Per Hari)</label>
                <input type="text" value="Rp {{ $provider && $provider->tarif > 0 ? number_format($provider->tarif, 0, ',', '.') : '0' }}" disabled class="w-full px-4 py-2.5 bg-[#F5F5F3] border border-gray-100 rounded-xl text-xs font-semibold text-[#5E887E] cursor-not-allowed focus:outline-none">
            </div>

            <!-- Usulan Tarif Baru -->
            <div>
                <label class="block text-[10px] font-bold text-[#5E887E] uppercase tracking-wider mb-1.5">Usulan Tarif Baru (Rp)</label>
                <input type="number" name="tarif_baru" placeholder="Contoh: 100000" required class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none focus:border-[#5E887E] focus:ring-1 focus:ring-[#5E887E]/20">
            </div>

            <!-- Upload Berkas Pendukung -->
            <div class="sm:col-span-2">
                <label class="block text-[10px] font-bold text-[#5E887E] uppercase tracking-wider mb-1.5">Upload Berkas Pendukung (Sertifikat/Pengalaman)</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-200 border-dashed rounded-xl bg-[#FAF9F6] hover:border-[#5E887E] transition-colors relative">
                <div class="space-y-1 text-center">
                    <i class="fa-solid fa-cloud-arrow-up text-[#5E887E] text-2xl mb-2 block"></i>
                    <div class="flex text-xs text-[#5E887E] justify-center">
                    <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-bold text-[#5E887E] hover:text-[#4d7168] focus-within:outline-none">
                        <span>Pilih Berkas</span>
                        <input id="file-upload" name="dokumen" type="file" accept=".pdf,.png,.jpg,.jpeg" required class="sr-only">
                    </label>
                    <p class="pl-1 text-[#5E887E] font-medium">atau drag and drop</p>
                    </div>
                    <p class="text-[10px] text-[#5E887E]">PDF, PNG, atau JPG maksimal 5MB</p>
                </div>
                </div>
            </div>

            <!-- Alasan Pengajuan -->
            <div class="sm:col-span-2">
                <label class="block text-[10px] font-bold text-[#5E887E] uppercase tracking-wider mb-1.5">Alasan / Keterangan Pengajuan</label>
                <textarea name="alasan" rows="3" placeholder="Tuliskan alasan penyesuaian tarif di sini..." required class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none focus:border-[#5E887E] focus:ring-1 focus:ring-[#5E887E]/20 resize-none"></textarea>
            </div>
            </div>

            <!-- Tombol Submit -->
            <div class="pt-2">
            <button type="submit" class="px-6 py-2.5 bg-[#5E887E] text-white rounded-xl text-xs font-bold hover:bg-[#4d7168] transition-all shadow-md">
                <i class="fa-solid fa-paper-plane mr-1.5"></i> Kirim Pengajuan ke Admin
            </button>
            </div>
        </form>
        </div>

            </main>
            </div>

        </div>

        <!-- ===== MODAL: JADWAL ===== -->
        <div id="jadwalModal" class="modal-overlay fixed inset-0 bg-[#2D433E]/40 backdrop-blur-sm z-[100] items-center justify-center p-4">
            <div class="bg-white rounded-[28px] w-full max-w-md p-6 border border-gray-100 shadow-2xl">
            <div class="flex items-center justify-between mb-5">
                <h4 id="jadwalModalTitle" class="text-base font-black text-[#2D433E]">Tambah Jadwal Baru</h4>
                <button onclick="closeJadwalModal()" class="w-8 h-8 rounded-xl bg-gray-50 flex items-center justify-center text-[#5E887E] hover:bg-gray-100"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form id="formJadwal" onsubmit="saveJadwal(event)" class="space-y-4">
                <input type="hidden" id="jadwalId">
                <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-[10px] font-bold text-[#5E887E] uppercase tracking-wider mb-1.5">Nama Pemilik</label>
                    <input type="text" id="inputJNama" required class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none focus:border-[#5E887E]">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-[#5E887E] uppercase tracking-wider mb-1.5">Jam</label>
                    <input type="text" id="inputJJam" required placeholder="cth: 14.00" class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none focus:border-[#5E887E]">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-[#5E887E] uppercase tracking-wider mb-1.5">Nama Hewan</label>
                    <input type="text" id="inputJHewan" required placeholder="cth: Bruno — Anjing Golden Retriever" class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none focus:border-[#5E887E]">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-[#5E887E] uppercase tracking-wider mb-1.5">Jenis Layanan</label>
                    <select id="inputJLokasi" class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none">
                    <option value="Dog Walking">Dog Walking</option>
                    <option value="Pet Hotel">Pet Hotel</option>
                    <option value="Day Care">Day Care</option>
                    <option value="Home Visit">Home Visit</option>
                    </select>
                </div>
                </div>
                <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeJadwalModal()" class="flex-1 py-2.5 bg-gray-50 text-[#5E887E] rounded-xl text-xs font-bold hover:bg-gray-100">Batal</button>
                <button type="submit" class="flex-1 py-2.5 bg-[#5E887E] text-white rounded-xl text-xs font-bold hover:bg-[#4d7168]">Simpan</button>
                </div>
            </form>
            </div>
        </div>

  <!-- ===== MODAL: CATATAN HARIAN ===== -->
  <div id="catatanModal" class="modal-overlay fixed inset-0 bg-[#2D433E]/40 backdrop-blur-sm z-[100] items-center justify-center p-4">
    <div class="bg-white rounded-[28px] w-full max-w-md p-6 border border-gray-100 shadow-2xl">
      <div class="flex items-center justify-between mb-5">
        <h4 id="catatanModalTitle" class="text-base font-black text-[#2D433E]">Tambah Catatan Harian</h4>
        <button onclick="closeCatatanModal()" class="w-8 h-8 rounded-xl bg-gray-50 flex items-center justify-center text-[#5E887E] hover:bg-gray-100"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <form id="formCatatan" action="{{ route('rekam-medis.save') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" id="catatanId" name="id">
        <input type="hidden" name="tipe" value="sitter">
        <div class="grid grid-cols-2 gap-3">
          <div class="col-span-2">
            <label class="block text-[10px] font-bold text-[#5E887E] uppercase tracking-wider mb-1.5">Pilih Pasien dari Booking</label>
            <select id="selectCBooking" class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-[#5E887E]/10 rounded-xl text-xs font-semibold focus:outline-none focus:border-[#5E887E]" onchange="autoFillPatientSitter(this)">
              <option value="">-- Pilih Pasien --</option>
              @foreach($bookings as $b)
                <option value="{{ $b->id_pemesanan }}" data-hewan="{{ $b->nama_hewan }}" data-jenis="{{ $b->jenis_hewan }}" data-pemilik="{{ $b->nama_pemilik }}" data-tanggal="{{ $b->tanggal }}">
                  {{ $b->nama_hewan }} ({{ $b->jenis_hewan }}) — {{ $b->nama_pemilik }} ({{ \Carbon\Carbon::parse($b->tanggal)->format('d M Y') }})
                </option>
              @endforeach
            </select>
          </div>
          <div>
            <label class="block text-[10px] font-bold text-[#5E887E] uppercase tracking-wider mb-1.5">Nama Hewan</label>
            <input type="text" id="inputCHewan" name="nama_hewan" required class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none focus:border-[#5E887E]">
          </div>
          <div>
            <label class="block text-[10px] font-bold text-[#5E887E] uppercase tracking-wider mb-1.5">Jenis Hewan</label>
            <input type="text" id="inputCJenis" name="jenis_hewan" required class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none focus:border-[#5E887E]">
          </div>
          <div>
            <label class="block text-[10px] font-bold text-[#5E887E] uppercase tracking-wider mb-1.5">Nama Pemilik</label>
            <input type="text" id="inputCPemilik" name="nama_pemilik" required class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none focus:border-[#5E887E]">
          </div>
          <div>
            <label class="block text-[10px] font-bold text-[#5E887E] uppercase tracking-wider mb-1.5">Tanggal</label>
            <input type="text" id="inputCTanggal" name="tanggal" required placeholder="13 Jun 2026" class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none focus:border-[#5E887E]">
          </div>
          <div class="sm:col-span-2">
            <label class="block text-[10px] font-bold text-[#5E887E] uppercase tracking-wider mb-1.5">Jenis Layanan</label>
            <select id="inputCLayanan" name="jenis_layanan" class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none">
              <option value="Dog Walking">Dog Walking</option>
              <option value="Pet Hotel">Pet Hotel</option>
              <option value="Day Care">Day Care</option>
              <option value="Home Visit">Home Visit</option>
            </select>
          </div>
          <div class="col-span-2">
            <label class="block text-[10px] font-bold text-[#5E887E] uppercase tracking-wider mb-1.5">Kondisi & Catatan</label>
            <textarea id="inputCCatatan" name="catatan" rows="3" required placeholder="Tuliskan kondisi, aktivitas, dan catatan penting lainnya..." class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none focus:border-[#5E887E] focus:ring-1 focus:ring-[#5E887E]/20 resize-none"></textarea>
          </div>
        </div>
        <div class="flex gap-3 pt-2">
          <button type="button" onclick="closeCatatanModal()" class="flex-1 py-2.5 bg-gray-50 text-[#5E887E] rounded-xl text-xs font-bold hover:bg-gray-100">Batal</button>
          <button type="submit" class="flex-1 py-2.5 bg-[#5E887E] text-white rounded-xl text-xs font-bold hover:bg-[#4d7168]">Simpan</button>
        </div>
      </form>
    </div>
  </div>

  <!-- ===== MODAL: CHAT (REAL DATABASE) ===== -->
  <div id="chatModal" class="modal-overlay fixed inset-0 bg-[#2D433E]/40 backdrop-blur-sm z-[100] items-center justify-center p-4">
    <div class="bg-white rounded-[28px] w-full max-w-md border border-gray-100 shadow-2xl flex flex-col" style="max-height:90vh">
      <div class="flex items-center justify-between p-5 border-b border-gray-50">
        <div class="flex items-center gap-3">
          <div id="chatAvatar" class="w-10 h-10 rounded-xl bg-[#D9B08C]/10 flex items-center justify-center text-[#D9B08C] text-sm font-bold"></div>
          <div>
            <div id="chatName" class="text-sm font-bold text-[#2D433E]"></div>
            <div id="chatSub" class="text-[10px] text-[#5E887E]">Pemilik Hewan</div>
          </div>
        </div>
        <button onclick="closeChatModal()" class="w-8 h-8 rounded-xl bg-gray-50 flex items-center justify-center text-[#5E887E] hover:bg-gray-100"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div id="chatMessages" class="flex-1 overflow-y-auto p-5 space-y-3" style="min-height:200px;max-height:50vh">
        <div class="text-center text-xs text-gray-400 py-4">Memuat percakapan...</div>
      </div>
      <div class="p-4 border-t border-gray-50 flex gap-2">
        <input type="text" id="chatInput" placeholder="Ketik pesan..." class="flex-1 px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none focus:border-[#5E887E]">
        <button onclick="sendChat()" class="px-4 py-2.5 bg-[#5E887E] text-white rounded-xl text-xs font-bold hover:bg-[#4d7168] transition-all">
          <i class="fa-solid fa-paper-plane"></i>
        </button>
      </div>
    </div>
  </div>

  <script>
    // ========== SIDEBAR & TAB ==========
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const main = document.getElementById('main-content');
      sidebar.classList.toggle('-translate-x-full');
      if (window.innerWidth >= 1024) {
        main.classList.toggle('lg:pl-72');
      }
    }

    const tabMeta = {
      dashboard: ['Halo, Kak {{ $provider->nama ?? session('nama') }}! 🐾', 'Ringkasan aktivitas penitipan dan status Anda hari ini.'],
      jadwal:    ['Jadwal Penitipan 📅', 'Kelola sesi penjagaan dan konfirmasi booking harian.'],
      catatan:   ['Catatan Perawatan Harian 📋', 'Riwayat aktivitas dan kondisi seluruh hewan yang dititipkan.'],
      chat:      ['Chat Pemilik Hewan 💬', 'Update perkembangan dan komunikasi langsung dengan pemilik.'],
      profil:    ['Tarif Saya ⚙️', 'Update informasi, tarif, dan status ketersediaan real-time.'],
    };

    function switchTab(name) {
      document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
      document.getElementById('tab-' + name).classList.add('active');

      ['dashboard','jadwal','catatan','chat','profil'].forEach(t => {
        const btn = document.getElementById('btn-tab-' + t);
        btn.className = t === name
          ? 'sidebar-link active w-full text-left flex items-center gap-4 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300'
          : 'sidebar-link text-[#5E887E] hover:bg-[#E8F0EE]/50 w-full text-left flex items-center gap-4 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300';
      });

      document.getElementById('page-title').innerText = tabMeta[name][0];
      document.getElementById('page-desc').innerText  = tabMeta[name][1];
    }

    // ========== STATUS ==========
    const statusConfig = {
      tersedia:   { label: 'Tersedia',          dot: 'bg-green-600', pill: 'bg-green-100 text-green-800 border-green-200', sidebar: '● Tersedia' },
      perjalanan: { label: 'Dalam Perjalanan',  dot: 'bg-amber-500', pill: 'bg-amber-100 text-amber-800 border-amber-200', sidebar: '● Dalam Perjalanan' },
      menjaga:    { label: 'Sedang Menjaga',    dot: 'bg-blue-500',  pill: 'bg-blue-100 text-blue-800 border-blue-200',   sidebar: '● Sedang Menjaga' },
      off:        { label: 'Tidak Bertugas',    dot: 'bg-teal-600',  pill: 'bg-teal-100 text-teal-800 border-teal-200',   sidebar: '● Tidak Bertugas' },
    };

    function setStatus(key) {
      const cfg = statusConfig[key];
      const pill = document.getElementById('status-pill');
      const dot  = document.getElementById('status-dot');
      document.getElementById('status-label').innerText = cfg.label;
      pill.className = `flex items-center gap-2 px-4 py-2 rounded-full text-xs font-bold border ${cfg.pill}`;
      dot.className  = `w-2 h-2 rounded-full ${cfg.dot}`;
      document.getElementById('sidebar-status-text').innerText = cfg.sidebar;

      document.querySelectorAll('.status-opt').forEach(b => {
        b.style.boxShadow = b.dataset.status === key ? '0 0 0 2.5px currentColor' : 'none';
      });
    }

    // ========== JADWAL PENITIPAN ==========
    let jadwalCount = 4;

    function openJadwalModal(mode, id = null) {
      document.getElementById('jadwalModal').classList.add('show');
      if (mode === 'create') {
        document.getElementById('jadwalModalTitle').innerText = 'Tambah Jadwal Baru';
        document.getElementById('formJadwal').reset();
        document.getElementById('jadwalId').value = '';
      } else {
        document.getElementById('jadwalModalTitle').innerText = 'Ubah Jadwal';
        document.getElementById('jadwalId').value = id;
        const row = document.getElementById('jadwal-row-' + id);
        document.getElementById('inputJNama').value  = row.querySelector('.cell-j-nama').innerText;
        const hewanFull = row.querySelector('.cell-j-hewan').innerText;
        const parts = hewanFull.split(' • ');
        document.getElementById('inputJHewan').value  = parts[0] || '';
        document.getElementById('inputJLokasi').value = parts[1] || 'Dog Walking';
        document.getElementById('inputJJam').value   = row.querySelector('.text-xs.font-bold.text-\\[\\#5E887E\\]')?.innerText || '';
      }
    }

    function closeJadwalModal() { document.getElementById('jadwalModal').classList.remove('show'); }

    function saveJadwal(e) {
      e.preventDefault();
      const id     = document.getElementById('jadwalId').value;
      const nama   = document.getElementById('inputJNama').value;
      const jam    = document.getElementById('inputJJam').value;
      const hewan  = document.getElementById('inputJHewan').value;
      const layanan = document.getElementById('inputJLokasi').value;
      const inisial = nama.split(' ').map(n => n[0]).join('').substring(0,2).toUpperCase();

      if (id) {
        const row = document.getElementById('jadwal-row-' + id);
        row.querySelector('.cell-j-nama').innerText  = nama;
        row.querySelector('.cell-j-hewan').innerText = hewan + ' • ' + layanan;
      } else {
        jadwalCount++;
        const list = document.getElementById('jadwal-list');
        const div = document.createElement('div');
        div.id = 'jadwal-row-' + jadwalCount;
        div.className = 'flex flex-wrap items-center gap-3 p-4 rounded-2xl border border-amber-50 bg-amber-50/30 hover:bg-amber-50/50 transition-all';
        div.innerHTML = `
          <div class="text-xs font-bold text-[#5E887E] w-12">${jam}</div>
          <div class="w-10 h-10 rounded-xl bg-[#5E887E]/10 flex items-center justify-center text-[#5E887E] text-xs font-bold">${inisial}</div>
          <div class="flex-1 min-w-[120px]">
            <div class="text-sm font-bold text-[#2D433E] cell-j-nama">${nama}</div>
            <div class="text-[10px] text-[#5E887E] cell-j-hewan">${hewan} • ${layanan}</div>
          </div>
          <span class="px-2.5 py-1 bg-amber-100 text-amber-700 rounded-full text-[10px] font-bold cell-j-status">Menunggu</span>
          <div class="flex gap-2">
            <button onclick="terimaJadwal(${jadwalCount})" class="w-8 h-8 bg-green-50 text-green-600 rounded-lg text-xs flex items-center justify-center hover:bg-green-500 hover:text-white transition-all"><i class="fa-solid fa-check"></i></button>
            <button onclick="tolakJadwal(${jadwalCount})" class="w-8 h-8 bg-red-50 text-red-400 rounded-lg text-xs flex items-center justify-center hover:bg-red-500 hover:text-white transition-all"><i class="fa-solid fa-xmark"></i></button>
            <button onclick="openJadwalModal('edit', ${jadwalCount})" class="w-8 h-8 bg-amber-50 text-amber-600 rounded-lg text-xs flex items-center justify-center hover:bg-amber-500 hover:text-white transition-all"><i class="fa-solid fa-pen-to-square"></i></button>
            <button onclick="deleteJadwal(${jadwalCount})" class="w-8 h-8 bg-red-50 text-red-400 rounded-lg text-xs flex items-center justify-center hover:bg-red-500 hover:text-white transition-all"><i class="fa-solid fa-trash"></i></button>
          </div>`;
        list.appendChild(div);
      }
      closeJadwalModal();
    }

    function terimaJadwal(id) {
      const row = document.getElementById('jadwal-row-' + id);
      if (!row) return;
      const badge = row.querySelector('.cell-j-status');
      badge.className = 'px-2.5 py-1 bg-blue-100 text-blue-700 rounded-full text-[10px] font-bold cell-j-status';
      badge.innerText = 'Berlangsung';
      row.className = 'flex flex-wrap items-center gap-3 p-4 rounded-2xl border border-blue-50 bg-blue-50/30 hover:bg-blue-50/50 transition-all';
    }

    function tolakJadwal(id) {
      if (confirm('Yakin menolak jadwal ini?')) document.getElementById('jadwal-row-' + id)?.remove();
    }

    function confirmJadwal(id) {
      const row = document.getElementById('jadwal-row-' + id);
      if (!row) return;
      const badge = row.querySelector('.cell-j-status');
      badge.className = 'px-2.5 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-bold cell-j-status';
      badge.innerText = 'Selesai';
      row.className = 'flex flex-wrap items-center gap-3 p-4 rounded-2xl border border-gray-50 bg-[#FAF9F6]/60 hover:bg-[#FAF9F6] transition-all';
    }

    function deleteJadwal(id) {
      if (confirm('Yakin hapus jadwal ini?')) document.getElementById('jadwal-row-' + id)?.remove();
    }

    // ========== CATATAN HARIAN ==========
    function openCatatanModal(mode, id = null) {
      document.getElementById('catatanModal').classList.add('show');
      if (mode === 'create') {
        document.getElementById('catatanModalTitle').innerText = 'Tambah Catatan Harian';
        document.getElementById('formCatatan').reset();
        document.getElementById('catatanId').value = '';
        if (document.getElementById('selectCBooking')) {
          document.getElementById('selectCBooking').selectedIndex = 0;
        }
      } else {
        document.getElementById('catatanModalTitle').innerText = 'Ubah Catatan Harian';
        document.getElementById('catatanId').value = id;
        const row = document.getElementById('catatan-row-' + id);
        document.getElementById('inputCHewan').value    = row.querySelector('.cell-c-hewan').innerText;
        document.getElementById('inputCJenis').value    = row.querySelector('.cell-c-jenis').innerText;
        document.getElementById('inputCPemilik').value  = row.querySelector('.cell-c-pemilik').innerText;
        document.getElementById('inputCLayanan').value  = row.querySelector('.cell-c-layanan').innerText;
        document.getElementById('inputCCatatan').value  = row.querySelector('.cell-c-catatan').innerText;
        document.getElementById('inputCTanggal').value  = row.querySelector('.cell-c-tanggal').innerText;
        if (document.getElementById('selectCBooking')) {
          document.getElementById('selectCBooking').selectedIndex = 0;
        }
      }
    }

    function closeCatatanModal() { document.getElementById('catatanModal').classList.remove('show'); }

    function autoFillPatientSitter(selectEl) {
      const selectedOption = selectEl.options[selectEl.selectedIndex];
      if (!selectedOption.value) return;

      const namaHewan = selectedOption.getAttribute('data-hewan');
      const jenisHewan = selectedOption.getAttribute('data-jenis');
      const namaPemilik = selectedOption.getAttribute('data-pemilik');
      const tanggal = selectedOption.getAttribute('data-tanggal');

      document.getElementById('inputCHewan').value = namaHewan || '';
      document.getElementById('inputCJenis').value = jenisHewan || '';
      document.getElementById('inputCPemilik').value = namaPemilik || '';

      if (tanggal) {
        try {
          const dateParts = tanggal.split('-');
          if (dateParts.length === 3) {
            const year = dateParts[0];
            const monthIndex = parseInt(dateParts[1]) - 1;
            const day = parseInt(dateParts[2]);
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            document.getElementById('inputCTanggal').value = `${day.toString().padStart(2, '0')} ${months[monthIndex]} ${year}`;
          } else {
            document.getElementById('inputCTanggal').value = tanggal;
          }
        } catch(e) {
          document.getElementById('inputCTanggal').value = tanggal;
        }
      }
    }

    // ========== CHAT MODAL (REAL DATABASE) ==========
    const CSRF_TOKEN   = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').content : '';
    const ID_PENYEDIA  = {{ $provider->id_penyedia ?? 0 }};
    let currentPemilikId = null;
    let chatPollInterval = null;
    let lastChatId = 0;

    function getInisial(nama) {
      return nama.split(' ').map(w => w[0]).join('').substring(0, 2).toUpperCase();
    }

    function escHtml(t) {
      return t.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/\n/g,'<br>');
    }

    function appendChatBubble(pengirim, text, waktu, scroll = true) {
      const msgs = document.getElementById('chatMessages');
      const div  = document.createElement('div');
      const isSitter = pengirim === 'penyedia';
      div.className  = isSitter ? 'flex justify-end' : 'flex justify-start';
      div.innerHTML  = `<div class="max-w-[75%] px-4 py-2.5 rounded-2xl text-xs font-medium ${isSitter ? 'bg-[#5E887E] text-white rounded-br-sm' : 'bg-[#FAF9F6] text-[#2D433E] border border-gray-100 rounded-bl-sm'}">${escHtml(text)}<div class="text-[9px] ${isSitter ? 'text-white/60 text-right' : 'text-gray-400'} mt-1">${waktu}</div></div>`;
      msgs.appendChild(div);
      if (scroll) msgs.scrollTop = msgs.scrollHeight;
    }

    async function openChatModal(idPemilik, namaPemilik) {
      currentPemilikId = idPemilik;
      lastChatId = 0;

      document.getElementById('chatAvatar').innerText = getInisial(namaPemilik);
      document.getElementById('chatName').innerText   = namaPemilik;
      document.getElementById('chatModal').classList.add('show');

      // Muat riwayat chat dari database
      const msgs = document.getElementById('chatMessages');
      msgs.innerHTML = '<div class="text-center text-xs text-gray-400 py-4">Memuat...</div>';

      try {
        const res   = await fetch(`/api/chat-sitter/${idPemilik}`);
        const data  = await res.json();
        msgs.innerHTML = '';
        if (data.length === 0) {
          msgs.innerHTML = '<div class="text-center text-xs text-gray-400 py-4">Belum ada pesan. Mulai percakapan!</div>';
        }
        data.forEach(m => {
          const d = new Date(m.created_at);
          const waktu = d.getHours().toString().padStart(2,'0') + ':' + d.getMinutes().toString().padStart(2,'0');
          appendChatBubble(m.pengirim, m.pesan, waktu, false);
          lastChatId = Math.max(lastChatId, m.id);
        });
        msgs.scrollTop = msgs.scrollHeight;
      } catch(e) {
        msgs.innerHTML = '<div class="text-center text-xs text-red-400 py-4">Gagal memuat pesan.</div>';
      }

      // Mulai polling pesan baru
      if (chatPollInterval) clearInterval(chatPollInterval);
      chatPollInterval = setInterval(pollNewChatMessages, 3000);
    }

    async function pollNewChatMessages() {
      if (!currentPemilikId) return;
      try {
        const res  = await fetch(`/api/chat-sitter/${currentPemilikId}?since_id=${lastChatId}`);
        const msgs = await res.json();
        if (Array.isArray(msgs) && msgs.length > 0) {
          msgs.forEach(m => {
            const d = new Date(m.created_at);
            const waktu = d.getHours().toString().padStart(2,'0') + ':' + d.getMinutes().toString().padStart(2,'0');
            appendChatBubble(m.pengirim, m.pesan, waktu);
            lastChatId = Math.max(lastChatId, m.id);
          });
        }
      } catch(e) {}
    }

    function closeChatModal() {
      document.getElementById('chatModal').classList.remove('show');
      if (chatPollInterval) { clearInterval(chatPollInterval); chatPollInterval = null; }
      currentPemilikId = null;
    }

    async function sendChat() {
      const input = document.getElementById('chatInput');
      const text  = input.value.trim();
      if (!text || !currentPemilikId) return;
      input.value = '';

      const now = new Date();
      const waktu = now.getHours().toString().padStart(2,'0') + ':' + now.getMinutes().toString().padStart(2,'0');
      appendChatBubble('penyedia', text, waktu);

      try {
        const res  = await fetch('/chat-sitter/kirim', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
          body: JSON.stringify({
            id_penyedia: ID_PENYEDIA,
            id_pemilik:  currentPemilikId,
            pesan:       text,
            pengirim:    'penyedia'
          })
        });
        const data = await res.json();
        if (data.id) lastChatId = Math.max(lastChatId, data.id);
      } catch(e) {
        console.error('Gagal kirim pesan:', e);
      }
    }

    document.getElementById('chatInput').addEventListener('keydown', e => { if (e.key === 'Enter') sendChat(); });

    // ========== PENGAJUAN TARIF ==========
    function submitPengajuanTarif(e) {
      e.preventDefault();
      alert('Pengajuan tarif berhasil dikirim ke Admin!');
      e.target.reset();
    }
  </script>
</body>
</html>
