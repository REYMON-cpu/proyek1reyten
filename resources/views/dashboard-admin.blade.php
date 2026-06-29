<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght=600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght=400;600;700;800&display=swap');
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #FAF9F6;
            color: #2D433E;
        }
        .sidebar-link.active {
            background-color: #5E887E;
            color: white;
            box-shadow: 0 10px 25px -5px rgba(94, 136, 126, 0.3);
        }
    </style>
</head>
<body class="antialiased bg-[#FAF9F6] flex h-screen overflow-hidden relative">


    <aside id="sidebar" class="fixed inset-y-0 left-0 w-80 bg-white border-r border-[#5E887E]/10 flex flex-col justify-between p-6 h-full z-[60] transform transition-transform duration-300 ease-in-out">
        <div class="space-y-10">

            <div class="flex items-center justify-between px-2">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo hijau.svg') }}" alt="Logo" class="h-12 w-auto">
                    <div>
                        <h2 class="text-xl font-bold text-[#5E887E] tracking-tight">Go<span class="text-[#D9B08C]">Pet</span></h2>
                        <span class="text-[10px] font-bold text-[#5E887E] uppercase tracking-widest block -mt-1">Admin Panel</span>
                    </div>
                </div>
                <button onclick="toggleSidebar()" class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-500 hover:bg-[#E8F0EE] lg:hidden">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>


            <nav class="space-y-2">
                <p class="text-[10px] font-extrabold uppercase tracking-[0.2em] text-gray-400 px-3 mb-4">Utama</p>

                <button onclick="switchTab('dashboard')" id="btn-tab-dashboard" class="sidebar-link active w-full text-left flex items-center gap-4 px-4 py-4 rounded-2xl font-bold text-sm transition-all duration-300">
                    <i class="fa-solid fa-chart-pie text-lg w-6 text-center"></i> Dashboard
                </button>

                <button onclick="switchTab('mitra')" id="btn-tab-mitra" class="sidebar-link text-gray-400 hover:text-[#5E887E] hover:bg-[#E8F0EE]/50 w-full text-left flex items-center gap-4 px-4 py-4 rounded-2xl font-bold text-sm transition-all duration-300">
                    <i class="fa-solid fa-user-doctor text-lg w-6 text-center"></i> Data Dokter & Sitter
                </button>

                <button onclick="switchTab('pelanggan')" id="btn-tab-pelanggan" class="sidebar-link text-gray-400 hover:text-[#5E887E] hover:bg-[#E8F0EE]/50 w-full text-left flex items-center gap-4 px-4 py-4 rounded-2xl font-bold text-sm transition-all duration-300">
                    <i class="fa-solid fa-users text-lg w-6 text-center"></i> Data Pelanggan
                </button>

                <button onclick="switchTab('pemesanan')" id="btn-tab-pemesanan" class="sidebar-link text-gray-400 hover:text-[#5E887E] hover:bg-[#E8F0EE]/50 w-full text-left flex items-center gap-4 px-4 py-4 rounded-2xl font-bold text-sm transition-all duration-300">
                    <i class="fa-solid fa-clipboard-list text-lg w-6 text-center"></i> Data Pemesanan
                </button>

                <button onclick="switchTab('kontak')" id="btn-tab-kontak" class="sidebar-link text-gray-400 hover:text-[#5E887E] hover:bg-[#E8F0EE]/50 w-full text-left flex items-center gap-4 px-4 py-4 rounded-2xl font-bold text-sm transition-all duration-300">
                    <i class="fa-solid fa-envelope text-lg w-6 text-center"></i> Hubungi GoPet
                </button>
            </nav>
        </div>


        <div class="border-t border-[#5E887E]/10 pt-4">
            <a href="{{ url('/logout') }}" class="w-full flex items-center justify-between px-4 py-4 rounded-2xl font-bold text-sm text-red-500 hover:bg-red-50 transition-all duration-300">
                <span class="flex items-center gap-4">
                    <i class="fa-solid fa-arrow-right-from-bracket text-lg w-6 text-center"></i> Keluar Aplikasi
                </span>
            </a>
        </div>
    </aside>


    <div id="main-content" class="flex-1 flex flex-col h-full overflow-y-auto pl-80 transition-all duration-300 ease-in-out">

        <header class="bg-transparent px-6 md:px-10 pt-6 flex justify-between items-center z-40">
            <div class="flex items-center gap-4">
                <button onclick="toggleSidebar()" class="w-12 h-12 bg-white rounded-2xl border border-gray-100 shadow-sm flex items-center justify-center text-gray-600 hover:text-[#5E887E] transition-all">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <div>
                    <h1 id="page-main-title" class="text-xl md:text-3xl font-black text-[#2D433E] tracking-tight">Selamat Datang, Admin!</h1>
                    <p id="page-main-desc" class="text-xs md:text-sm text-gray-400 font-medium mt-0.5 hidden sm:block">Pemantauan data metrik dan verifikasi berkas kemitraan aplikasi GoPet.</p>
                </div>
            </div>
        </header>


        <div id="tab-dashboard" class="tab-content">
            <main class="px-6 md:px-10 py-8 space-y-10">

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-[30px] border border-[#5E887E]/5 shadow-[0_10px_30px_-15px_rgba(0,0,0,0.03)] flex justify-between items-center">
                        <div class="space-y-2">
                            <p class="text-xs font-bold uppercase tracking-wider text-gray-400">Pengguna Terdaftar</p>
                            <h3 class="text-2xl font-black text-[#2D433E]">{{ $total_users }} <span class="text-xs font-medium text-gray-400">User</span></h3>
                        </div>
                        <div class="w-14 h-14 bg-[#D9B08C]/10 rounded-2xl flex items-center justify-center text-[#D9B08C] text-2xl"><i class="fa-solid fa-users"></i></div>
                    </div>

                    <div class="bg-white p-6 rounded-[30px] border border-[#5E887E]/5 shadow-[0_10px_30px_-15px_rgba(0,0,0,0.03)] flex justify-between items-center">
                        <div class="space-y-2">
                            <p class="text-xs font-bold uppercase tracking-wider text-gray-400">Mitra Terverifikasi</p>
                            <h3 class="text-2xl font-black text-[#2D433E]">{{ $total_mitra }} <span class="text-xs font-medium text-gray-400">Mitra</span></h3>
                        </div>
                        <div class="w-14 h-14 bg-[#2D433E]/10 rounded-2xl flex items-center justify-center text-[#2D433E] text-2xl"><i class="fa-solid fa-user-shield"></i></div>
                    </div>

                    <div class="bg-white p-6 rounded-[30px] border border-[#5E887E]/5 shadow-[0_10px_30px_-15px_rgba(0,0,0,0.03)] flex justify-between items-center">
                        <div class="space-y-2">
                            <p class="text-xs font-bold uppercase tracking-wider text-gray-400">Butuh Verifikasi</p>
                            <h3 class="text-2xl font-black text-amber-600">{{ $pending_mitra }} <span class="text-xs font-medium text-gray-400">Berkas</span></h3>
                        </div>
                        <div class="w-14 h-14 bg-amber-500/10 rounded-2xl flex items-center justify-center text-amber-600 text-2xl"><i class="fa-solid fa-file-signature"></i></div>
                    </div>
                </div>


                <div class="w-full bg-white rounded-[40px] border border-gray-100 p-6 md:p-8 shadow-[0_20px_50px_-20px_rgba(0,0,0,0.02)]">
                    <div class="mb-6">
                        <h3 class="text-xl font-extrabold text-[#2D433E]">Persetujuan Dokumen Mitra</h3>
                        <p class="text-[12px] font-extrabold text-gray-400 mt-1">Lakukan validasi berkas STR Dokter Hewan atau ID Sitter sebelum diaktifkan.</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-200 text-[11px] font-extrabold text-gray-400 uppercase tracking-widest">
                                    <th class="pb-4 pl-2">Calon Mitra</th>
                                    <th class="pb-4">Profesi</th>
                                    <th class="pb-4">Dokumen Hewan/Sitter</th>
                                    <th class="pb-4 text-center">Konfirmasi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 text-sm font-medium text-[#2D433E]">
                                @forelse($pending_mitra_list as $m)
                                <tr class="hover:bg-[#FAF9F6]/50 transition-colors">
                                    <td class="py-4 pl-2"><div class="font-bold">{{ $m->nama }}</div></td>
                                    <td class="py-4"><span class="px-2.5 py-1 @if($m->jenis == 'sitter') bg-[#D9B08C]/10 text-[#D9B08C] @else bg-[#E8F0EE] text-[#5E887E] @endif rounded-full text-xs font-bold">{{ $m->jenis == 'sitter' ? 'Pet Sitter' : 'Dokter Hewan' }}</span></td>
                                    <td class="py-4">
                                        @if($m->dokumen)
                                            <a href="#" onclick="alert('Membuka berkas {{ $m->dokumen }}')" class="text-xs text-blue-500 underline font-semibold"><i class="fa-solid fa-file mr-1"></i>{{ $m->dokumen }}</a>
                                        @else
                                            <span class="text-xs text-gray-400 font-semibold">No Document</span>
                                        @endif
                                    </td>
                                    <td class="py-4">
                                        <div class="flex justify-center gap-2">
                                            <form action="{{ route('mitra.approve', $m->id_penyedia) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="px-3 py-1.5 bg-green-600 text-white rounded-xl text-xs font-bold hover:bg-green-700 transition-all">Terima</button>
                                            </form>
                                            <form action="{{ route('mitra.reject', $m->id_penyedia) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="px-3 py-1.5 bg-red-50 text-red-500 rounded-xl text-xs font-bold hover:bg-red-500 hover:text-white transition-all">Tolak</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-center text-xs text-gray-400">Tidak ada pengajuan mitra baru.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="w-full bg-white rounded-[40px] border border-gray-100 p-6 md:p-8 shadow-[0_20px_50px_-20px_rgba(0,0,0,0.02)] mt-8">
                    <div class="mb-6">
                        <h3 class="text-xl font-extrabold text-[#2D433E]">Pengajuan Tarif Baru</h3>
                        <p class="text-[12px] font-extrabold text-gray-400 mt-1">Daftar usulan tarif dari mitra yang menunggu verifikasi Admin.</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-200 text-[11px] font-extrabold text-gray-400 uppercase tracking-widest">
                                    <th class="pb-4 pl-2">Penyedia Jasa</th>
                                    <th class="pb-4">Profesi</th>
                                    <th class="pb-4">Tarif Lama</th>
                                    <th class="pb-4">Tarif Baru</th>
                                    <th class="pb-4">Tanggal</th>
                                    <th class="pb-4">Dokumen</th>
                                    <th class="pb-4">Catatan</th>
                                    <th class="pb-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 text-sm font-medium text-[#2D433E]">
                                @forelse($pending_tarif_list as $t)
                                <tr class="hover:bg-[#FAF9F6]/50 transition-colors">
                                    <td class="py-4 pl-2"><div class="font-bold">{{ $t->nama_mitra }}</div></td>
                                    <td class="py-4"><span class="px-2.5 py-1 @if($t->jenis == 'sitter') bg-[#D9B08C]/10 text-[#D9B08C] @else bg-[#E8F0EE] text-[#5E887E] @endif rounded-full text-xs font-bold">{{ $t->jenis == 'sitter' ? 'Pet Sitter' : 'Dokter Hewan' }}</span></td>
                                    <td class="py-4 font-semibold">Rp {{ number_format($t->tarif_lama ?? 0, 0, ',', '.') }}</td>
                                    <td class="py-4 font-semibold">Rp {{ number_format($t->tarif_baru, 0, ',', '.') }}</td>
                                    <td class="py-4 text-gray-500 text-xs">{{ date('d M Y', strtotime($t->created_at)) }}</td>
                                    <td class="py-4">
                                        @if($t->dokumen)
                                            <a href="{{ asset('uploads/pengajuan_tarif/' . $t->dokumen) }}" target="_blank" class="text-xs text-blue-500 underline font-semibold"><i class="fa-solid fa-file-arrow-down mr-1"></i>{{ $t->dokumen }}</a>
                                        @else
                                            <span class="text-xs text-gray-400 font-semibold">Tidak ada berkas</span>
                                        @endif
                                    </td>
                                    <td class="py-4 text-xs text-gray-500">{{ strlen($t->alasan) > 60 ? substr($t->alasan, 0, 60) . '...' : $t->alasan }}</td>
                                    <td class="py-4">
                                        <div class="flex justify-center gap-2">
                                            <form action="{{ route('pengajuan.tarif.approve', $t->id_pengajuan) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="px-3 py-1.5 bg-green-600 text-white rounded-xl text-xs font-bold hover:bg-green-700 transition-all">Acc</button>
                                            </form>
                                            <form action="{{ route('pengajuan.tarif.reject', $t->id_pengajuan) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="px-3 py-1.5 bg-red-50 text-red-500 rounded-xl text-xs font-bold hover:bg-red-500 hover:text-white transition-all">Tolak</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="py-4 text-center text-xs text-gray-400">Tidak ada pengajuan tarif terbaru.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>


        <!-- TAB 2: DATA DOKTER & PET SITTER (MITRA)   -->

        <div id="tab-mitra" class="tab-content hidden">
            <main class="px-6 md:px-10 py-8 space-y-6">
                <div class="w-full bg-white rounded-[40px] border border-gray-100 p-6 md:p-8 shadow-[0_20px_50px_-20px_rgba(0,0,0,0.02)]">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                        <div>
                            <h3 class="text-xl font-extrabold text-[#2D433E]">Daftar Dokter & Pet Sitter Active</h3>
                            <p class="text-[12px] font-extrabold text-gray-400 mt-1">Kelola data seluruh mitra penanganan hewan yang aktif di platform.</p>
                        </div>
                        <button onclick="openMitraModal('create')" class="px-4 py-2.5 bg-[#5E887E] text-white rounded-xl text-xs font-bold hover:bg-[#4d7168] transition-all flex items-center justify-center gap-2 shadow-md">
                            <i class="fa-solid fa-plus"></i> Tambah Mitra Baru
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-200 text-[11px] font-extrabold text-gray-400 uppercase tracking-widest">
                                    <th class="pb-4 pl-2">Nama Lengkap</th>
                                    <th class="pb-4">Profesi</th>
                                    <th class="pb-4">Pengalaman</th>
                                    <th class="pb-4">Tarif Jasa</th>
                                    <th class="pb-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="mitra-table-body" class="divide-y divide-gray-50 text-sm font-medium text-[#2D433E]">
                                @forelse($approved_mitra_list as $m)
                                <tr id="mitra-row-{{ $m->id_penyedia }}" class="hover:bg-[#FAF9F6]/50 transition-colors">
                                    <td class="py-4 pl-2">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-[#5E887E]/10 flex items-center justify-center font-bold text-[#5E887E]">
                                                {{ strtoupper(substr($m->nama, 0, 2)) }}
                                            </div>
                                            <div>
                                                <div class="font-bold cell-nama">{{ $m->nama }}</div>
                                                <div class="text-[11px] text-gray-400 cell-dokumen-id">Doc: {{ $m->dokumen ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4">
                                        <span class="px-2.5 py-1 @if($m->jenis == 'sitter') bg-[#D9B08C]/10 text-[#D9B08C] @else bg-[#E8F0EE] text-[#5E887E] @endif rounded-full text-xs font-bold block w-max cell-profesi">{{ $m->jenis == 'sitter' ? 'Pet Sitter' : 'Dokter' }}</span>
                                    </td>
                                    <td class="py-4">
                                        <div class="text-xs font-semibold cell-pengalaman">{{ $m->pengalaman }} Tahun</div>
                                        <div class="text-[11px] text-green-600 font-semibold"><i class="fa-solid fa-circle-check text-[10px] mr-1"></i>Verified</div>
                                    </td>
                                    <td class="py-4 font-bold text-[#2D433E]">
                                        <span class="cell-tarif">Rp {{ number_format($m->tarif, 0, ',', '.') }}</span><span class="text-[10px] text-gray-400 font-medium">/{{ $m->jenis == 'sitter' ? 'hari' : 'visit' }}</span>
                                    </td>
                                    <td class="py-4">
                                        <div class="flex justify-center gap-2">
                                            <button onclick="openMitraModal('edit', {{ $m->id_penyedia }})" class="w-8 h-8 bg-amber-50 text-amber-600 rounded-lg text-xs flex items-center justify-center hover:bg-amber-500 hover:text-white transition-all"><i class="fa-solid fa-pen-to-square"></i></button>
                                            <button onclick="deleteMitraRow({{ $m->id_penyedia }}, '{{ $m->nama }}')" class="w-8 h-8 bg-red-50 text-red-500 rounded-lg text-xs flex items-center justify-center hover:bg-red-500 hover:text-white transition-all"><i class="fa-solid fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-4 text-center text-xs text-gray-400">Tidak ada mitra aktif.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>


        <!-- TAB 3: DATA PELANGGAN                      -->
        <div id="tab-pelanggan" class="tab-content hidden">
            <main class="px-6 md:px-10 py-8 space-y-6">
                <div class="w-full bg-white rounded-[40px] border border-gray-100 p-6 md:p-8 shadow-[0_20px_50px_-20px_rgba(0,0,0,0.02)]">
                    <div class="mb-6">
                        <h3 class="text-xl font-extrabold text-[#2D433E]">Daftar Pengguna</h3>
                        <p class="text-[12px] font-extrabold text-gray-400 mt-1">Data esensial pengguna terdaftar (Nama, Email, dan Kontrol Akses).</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-200 text-[11px] font-extrabold text-gray-400 uppercase tracking-widest">
                                    <th class="pb-4 pl-2">Nama Lengkap</th>
                                    <th class="pb-4">Alamat Email</th>
                                    <th class="pb-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="customer-table-body" class="divide-y divide-gray-50 text-sm font-medium text-[#2D433E]">
                                @forelse($users_list->where('role', 'Pemilik Hewan') as $u)
                                <tr id="cust-row-{{ $u->id_user }}" class="hover:bg-[#FAF9F6]/50 transition-colors">
                                    <td class="py-4 pl-2">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-[#5E887E]/10 flex items-center justify-center font-bold text-[#5E887E]">
                                                {{ strtoupper(substr($u->nama, 0, 2)) }}
                                            </div>
                                            <div>
                                                <div class="font-bold cell-cust-nama">{{ $u->nama }}</div>
                                                <div class="text-[11px] text-gray-400">ID: CUST-{{ $u->id_user }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 text-gray-500 cell-cust-email">{{ $u->email }}</td>
                                    <td class="py-4">
                                        <div class="flex justify-center gap-2">
                                            <button onclick="openCustomerModal('edit', {{ $u->id_user }})" class="w-8 h-8 bg-amber-50 text-amber-600 rounded-lg text-xs flex items-center justify-center hover:bg-amber-500 hover:text-white transition-all"><i class="fa-solid fa-pen-to-square"></i></button>
                                            <button onclick="deleteCustomerRow({{ $u->id_user }}, '{{ $u->nama }}')" class="w-8 h-8 bg-red-50 text-red-500 rounded-lg text-xs flex items-center justify-center hover:bg-red-500 hover:text-white transition-all"><i class="fa-solid fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="py-4 text-center text-xs text-gray-400">Tidak ada pelanggan terdaftar.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>

        <!-- TAB 4: DATA PEMESANAN (ORDERS) -->
        <div id="tab-pemesanan" class="tab-content hidden">
            <main class="px-6 md:px-10 py-8 space-y-6">
                <div class="w-full bg-white rounded-[40px] border border-gray-100 p-6 md:p-8 shadow-[0_20px_50px_-20px_rgba(0,0,0,0.02)]">
                    <div class="mb-6">
                        <h3 class="text-xl font-extrabold text-[#2D433E]">Daftar Pemesanan Layanan</h3>
                        <p class="text-[12px] font-extrabold text-gray-400 mt-1">Data pemesanan yang diajukan oleh pemilik hewan di platform GoPet.</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-200 text-[11px] font-extrabold text-gray-400 uppercase tracking-widest">
                                    <th class="pb-4 pl-2">Pemilik Hewan</th>
                                    <th class="pb-4">Nama Hewan</th>
                                    <th class="pb-4">Penyedia Jasa</th>
                                    <th class="pb-4">Tanggal Kunjungan</th>
                                    <th class="pb-4">Alamat</th>
                                    <th class="pb-4">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 text-sm font-medium text-[#2D433E]">
                                @forelse($bookings as $b)
                                <tr class="hover:bg-[#FAF9F6]/50 transition-colors">
                                    <td class="py-4 pl-2"><div class="font-bold">{{ $b->nama_pemilik }}</div></td>
                                    <td class="py-4">{{ $b->nama_hewan }} ({{ $b->jenis_hewan }})</td>
                                    <td class="py-4"><span class="font-semibold text-[#5E887E]">drh. {{ $b->nama_mitra }}</span></td>
                                    <td class="py-4">{{ $b->tanggal }}</td>
                                    <td class="py-4 text-xs text-gray-500 max-w-xs truncate" title="{{ $b->alamat }}">{{ $b->alamat }}</td>
                                    <td class="py-4">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold
                                            @if($b->status === 'Pending') bg-amber-100 text-amber-700
                                            @elseif($b->status === 'Disetujui' || $b->status === 'Berlangsung') bg-blue-100 text-blue-700
                                            @elseif($b->status === 'Ditolak') bg-red-100 text-red-700
                                            @else bg-green-100 text-green-700 @endif">
                                            {{ $b->status }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="py-4 text-center text-xs text-gray-400">Belum ada pemesanan layanan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>

        <!-- TAB 5: DATA HUBUNGI GOPET (CONTACT MESSAGES) -->
        <div id="tab-kontak" class="tab-content hidden">
            <main class="px-6 md:px-10 py-8 space-y-6">
                <div class="w-full bg-white rounded-[40px] border border-gray-100 p-6 md:p-8 shadow-[0_20px_50px_-20px_rgba(0,0,0,0.02)]">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                        <div>
                            <h3 class="text-xl font-extrabold text-[#2D433E]">Daftar Pesan Kontak (Hubungi GoPet)</h3>
                            <p class="text-[12px] font-extrabold text-gray-400 mt-1">Daftar feedback, keluhan, dan pesan yang dikirimkan oleh pengguna melalui form Hubungi Kami.</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-200 text-[11px] font-extrabold text-gray-400 uppercase tracking-widest">
                                    <th class="pb-4 pl-2">Nama Lengkap</th>
                                    <th class="pb-4">Email</th>
                                    <th class="pb-4">Pesan</th>
                                    <th class="pb-4">Tanggal Masuk</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 text-sm font-medium text-[#2D433E]">
                                @forelse($kontak_pesan as $kp)
                                <tr class="hover:bg-[#FAF9F6]/50 transition-colors">
                                    <td class="py-4 pl-2 font-bold">{{ $kp->nama_lengkap }}</td>
                                    <td class="py-4 text-[#5E887E] font-semibold">{{ $kp->email }}</td>
                                    <td class="py-4 text-xs text-gray-600 whitespace-pre-line max-w-lg leading-relaxed">{{ $kp->pesan }}</td>
                                    <td class="py-4 text-xs text-gray-400">{{ date('d M Y, H:i', strtotime($kp->created_at)) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-center text-xs text-gray-400">Belum ada pesan hubungi GoPet.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>

    </div>

    <!-- MODAL POPUP FORM 1: DOKTER & SITTER -->
    <div id="mitraModal" class="fixed inset-0 bg-[#2D433E]/40 backdrop-blur-sm z-[100] hidden flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-[32px] w-full max-w-lg p-6 md:p-8 border border-gray-100 shadow-2xl transform transition-all duration-300 scale-95 opacity-0 my-8" id="modalMitraContainer">
            <div class="flex items-center justify-between mb-5">
                <h4 id="modalMitraTitle" class="text-lg font-black text-[#2D433E]">Tambah Partner Kemitraan</h4>
                <button onclick="closeMitraModal()" class="w-8 h-8 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-gray-100"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <form id="formMitra" onsubmit="saveMitra(event)" class="space-y-4">
                <input type="hidden" id="mitraId">
                <div class="border-b border-gray-100 pb-3">
                    <p class="text-xs font-extrabold text-[#5E887E] uppercase tracking-wider mb-3"><i class="fa-solid fa-user text-[10px] mr-1"></i> Data Profil Pendaftar</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Nama Lengkap & Gelar</label>
                            <input type="text" id="inputNama" required class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none focus:border-[#5E887E]">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Profesi</label>
                            <select id="inputProfesi" class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none">
                                <option value="Dokter">Dokter</option>
                                <option value="Pet Sitter">Pet Sitter</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-3">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Profesi</label>
                            <input type="text" id="inputSpesialisasi" required class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Harga Jasa</label>
                            <input type="text" id="inputTarif" required class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-3">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Pengalaman Kerja</label>
                            <input type="text" id="inputPengalaman" required class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">No. STR / Kode Sertifikat</label>
                            <input type="text" id="inputDokumen" required class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none">
                        </div>
                    </div>
                </div>
                <div class="pt-2 flex gap-3">
                    <button type="button" onclick="closeMitraModal()" class="flex-1 py-2.5 bg-gray-50 text-gray-500 rounded-xl text-xs font-bold hover:bg-gray-100">Batal</button>
                    <button type="submit" class="flex-1 py-2.5 bg-[#5E887E] text-white rounded-xl text-xs font-bold hover:bg-[#4d7168]">Simpan Partner</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL POPUP FORM 2: PELANGGAN -->
    <div id="customerModal" class="fixed inset-0 bg-[#2D433E]/40 backdrop-blur-sm z-[100] hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-[32px] w-full max-w-sm p-6 md:p-8 border border-gray-100 shadow-2xl transform transition-all duration-300 scale-95 opacity-0" id="modalCustomerContainer">
            <div class="flex items-center justify-between mb-5">
                <h4 class="text-md font-black text-[#2D433E]">Ubah Data Akun User</h4>
                <button onclick="closeCustomerModal()" class="w-8 h-8 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-gray-100"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form id="formPelanggan" onsubmit="saveCustomer(event)" class="space-y-4">
                <input type="hidden" id="customerId">
                <div>
                    <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                    <input type="text" id="inputCustNama" required class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none focus:border-[#5E887E]">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Alamat Email</label>
                    <input type="email" id="inputCustEmail" required class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none focus:border-[#5E887E]">
                </div>
                <div class="pt-2 flex gap-3">
                    <button type="button" onclick="closeCustomerModal()" class="flex-1 py-2.5 bg-gray-50 text-gray-500 rounded-xl text-xs font-bold hover:bg-gray-100">Batal</button>
                    <button type="submit" class="flex-1 py-2.5 bg-[#5E887E] text-white rounded-xl text-xs font-bold hover:bg-[#4d7168]">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                mainContent.classList.add('pl-80');
            } else {
                sidebar.classList.add('-translate-x-full');
                mainContent.classList.remove('pl-80');
            }
        }

        function switchTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.getElementById(`tab-${tabName}`).classList.remove('hidden');

            document.getElementById('btn-tab-dashboard').className = "sidebar-link text-gray-400 hover:text-[#5E887E] hover:bg-[#E8F0EE]/50 w-full text-left flex items-center gap-4 px-4 py-4 rounded-2xl font-bold text-sm transition-all duration-300";
            document.getElementById('btn-tab-mitra').className = "sidebar-link text-gray-400 hover:text-[#5E887E] hover:bg-[#E8F0EE]/50 w-full text-left flex items-center gap-4 px-4 py-4 rounded-2xl font-bold text-sm transition-all duration-300";
            document.getElementById('btn-tab-pelanggan').className = "sidebar-link text-gray-400 hover:text-[#5E887E] hover:bg-[#E8F0EE]/50 w-full text-left flex items-center gap-4 px-4 py-4 rounded-2xl font-bold text-sm transition-all duration-300";
            if (document.getElementById('btn-tab-pemesanan')) {
                document.getElementById('btn-tab-pemesanan').className = "sidebar-link text-gray-400 hover:text-[#5E887E] hover:bg-[#E8F0EE]/50 w-full text-left flex items-center gap-4 px-4 py-4 rounded-2xl font-bold text-sm transition-all duration-300";
            }
            if (document.getElementById('btn-tab-kontak')) {
                document.getElementById('btn-tab-kontak').className = "sidebar-link text-gray-400 hover:text-[#5E887E] hover:bg-[#E8F0EE]/50 w-full text-left flex items-center gap-4 px-4 py-4 rounded-2xl font-bold text-sm transition-all duration-300";
            }

            const mainTitle = document.getElementById('page-main-title');
            const mainDesc = document.getElementById('page-main-desc');

            if(tabName === 'dashboard') {
                document.getElementById('btn-tab-dashboard').className = "sidebar-link active w-full text-left flex items-center gap-4 px-4 py-4 rounded-2xl font-bold text-sm transition-all duration-300";
                mainTitle.innerText = "Selamat Datang, Admin!";
                mainDesc.innerText = "Pemantauan data metrik dan verifikasi berkas kemitraan aplikasi GoPet.";
            }

            if(tabName === 'mitra') {
                document.getElementById('btn-tab-mitra').className = "sidebar-link active w-full text-left flex items-center gap-4 px-4 py-4 rounded-2xl font-bold text-sm transition-all duration-300";
                mainTitle.innerText = "Manajemen Partner Kemitraan 🩺";
                mainDesc.innerText = "Validasi data kerja penanganan medis (Dokter Hewan) dan pengasuhan (Pet Sitter).";
            }

            if(tabName === 'pelanggan') {
                document.getElementById('btn-tab-pelanggan').className = "sidebar-link active w-full text-left flex items-center gap-4 px-4 py-4 rounded-2xl font-bold text-sm transition-all duration-300";
                mainTitle.innerText = "Manajemen Pengguna Aplikasi 🐾";
                mainDesc.innerText = "Daftar pengawasan akun konsumen terdaftar (Nama Lengkap & Email aktif).";
            }

            if(tabName === 'pemesanan') {
                if (document.getElementById('btn-tab-pemesanan')) {
                    document.getElementById('btn-tab-pemesanan').className = "sidebar-link active w-full text-left flex items-center gap-4 px-4 py-4 rounded-2xl font-bold text-sm transition-all duration-300";
                }
                mainTitle.innerText = "Daftar Pemesanan Layanan 🐾";
                mainDesc.innerText = "Pemantauan data pemesanan yang diajukan oleh pemilik hewan.";
            }

            if(tabName === 'kontak') {
                if (document.getElementById('btn-tab-kontak')) {
                    document.getElementById('btn-tab-kontak').className = "sidebar-link active w-full text-left flex items-center gap-4 px-4 py-4 rounded-2xl font-bold text-sm transition-all duration-300";
                }
                mainTitle.innerText = "Pesan Hubungi GoPet ✉️";
                mainDesc.innerText = "Daftar feedback dan laporan kendala teknis dari form Hubungi Kami.";
            }

            if(tabName === 'tarif') {
                document.getElementById('btn-tab-tarif').className = "sidebar-link active w-full text-left flex items-center gap-4 px-4 py-4 rounded-2xl font-bold text-sm transition-all duration-300";
                mainTitle.innerText = "Persetujuan Tarif Dokter 💰";
                mainDesc.innerText = "Verifikasi dokumen usulan kenaikan tarif kunjungan dan persetujuan dari atasan klinik.";
            }
        }

        // MITRA
        let currentMitraId = 2;
        function openMitraModal(mode, id = null) {
            const modal = document.getElementById('mitraModal');
            const container = document.getElementById('modalMitraContainer');
            modal.classList.remove('hidden');
            setTimeout(() => { container.classList.remove('scale-95', 'opacity-0'); }, 10);

            if (mode === 'create') {
                document.getElementById('modalMitraTitle').innerText = "Tambah Mitra Baru";
                document.getElementById('formMitra').reset();
                document.getElementById('mitraId').value = "";
            } else if (mode === 'edit') {
                document.getElementById('modalMitraTitle').innerText = "Ubah Informasi Mitra";
                document.getElementById('mitraId').value = id;
                const row = document.getElementById(`mitra-row-${id}`);
                document.getElementById('inputNama').value = row.querySelector('.cell-nama').innerText;
                document.getElementById('inputProfesi').value = row.querySelector('.cell-profesi').innerText;
                document.getElementById('inputPengalaman').value = row.querySelector('.cell-pengalaman').innerText;
                document.getElementById('inputSpesialisasi').value = row.querySelector('.cell-spesialisasi').innerText;
                document.getElementById('inputTarif').value = row.querySelector('.cell-tarif').innerText;
                document.getElementById('inputDokumen').value = row.querySelector('.cell-dokumen-id').innerText.replace('SIP: ', '').replace('Cert: ', '');
            }
        }
        function closeMitraModal() {
            const container = document.getElementById('modalMitraContainer');
            container.classList.add('scale-95', 'opacity-0');
            setTimeout(() => { document.getElementById('mitraModal').classList.add('hidden'); }, 200);
        }
        function saveMitra(e) {
            e.preventDefault();
            const id = document.getElementById('mitraId').value;
            const nama = document.getElementById('inputNama').value;
            const profesi = document.getElementById('inputProfesi').value;
            const pengalaman = document.getElementById('inputPengalaman').value;
            const spesialisasi = document.getElementById('inputSpesialisasi').value;
            const tarif = document.getElementById('inputTarif').value;
            const dokumen = document.getElementById('inputDokumen').value;

            const badgeColor = profesi === 'Dokter' ? 'bg-[#E8F0EE] text-[#5E887E]' : 'bg-[#D9B08C]/10 text-[#D9B08C]';
            const docPrefix = profesi === 'Dokter' ? 'SIP: ' : 'Cert: ';
            const tarifSuffix = profesi === 'Dokter' ? '/visit' : '/hari';
            const inisial = nama.split(' ').map(n => n[0]).join('').substring(0,2).toUpperCase();

            if (id) {
                const row = document.getElementById(`mitra-row-${id}`);
                row.querySelector('.cell-nama').innerText = nama;
                row.querySelector('.cell-profesi').innerText = profesi;
                row.querySelector('.cell-profesi').className = `px-2.5 py-1 ${badgeColor} rounded-full text-xs font-bold block w-max cell-profesi`;
                row.querySelector('.cell-spesialisasi').innerText = spesialisasi;
                row.querySelector('.cell-pengalaman').innerText = pengalaman;
                row.querySelector('.cell-tarif').innerText = tarif;
                row.querySelector('.cell-dokumen-id').innerText = docPrefix + dokumen;
            } else {
                currentMitraId++;
                const tbody = document.getElementById('mitra-table-body');
                const newRow = document.createElement('tr');
                newRow.id = `mitra-row-${currentMitraId}`;
                newRow.className = "hover:bg-[#FAF9F6]/50 transition-colors";
                newRow.innerHTML = `<td class="py-4 pl-2"><div class="flex items-center gap-3"><div class="w-10 h-10 rounded-xl bg-[#5E887E]/10 flex items-center justify-center font-bold text-[#5E887E]">${inisial}</div><div><div class="font-bold cell-nama">${nama}</div><div class="text-[11px] text-gray-400 cell-dokumen-id">${docPrefix+dokumen}</div></div></div></td><td class="py-4"><span class="px-2.5 py-1 ${badgeColor} rounded-full text-xs font-bold block w-max cell-profesi">${profesi}</span><span class="text-[11px] text-gray-400 block mt-1 cell-spesialisasi">${spesialisasi}</span></td><td class="py-4"><div class="text-xs font-semibold cell-pengalaman">${pengalaman}</div><div class="text-[11px] text-green-600 font-semibold"><i class="fa-solid fa-circle-check text-[10px] mr-1"></i>Verified</div></td><td class="py-4 font-bold text-[#2D433E]"><span class="cell-tarif">${tarif}</span><span class="text-[10px] text-gray-400 font-medium">${tarifSuffix}</span></td><td class="py-4"><div class="flex justify-center gap-2"><button onclick="openMitraModal('edit', ${currentMitraId})" class="w-8 h-8 bg-amber-50 text-amber-600 rounded-lg text-xs flex items-center justify-center hover:bg-amber-500 hover:text-white transition-all"><i class="fa-solid fa-pen-to-square"></i></button><button onclick="deleteMitraRow(${currentMitraId}, '${nama}')" class="w-8 h-8 bg-red-50 text-red-500 rounded-lg text-xs flex items-center justify-center hover:bg-red-500 hover:text-white transition-all"><i class="fa-solid fa-trash"></i></button></div></td>`;
                tbody.appendChild(newRow);
            }
            closeMitraModal();
        }
        function deleteMitraRow(id, nama) {
            if (confirm(`Yakin menghapus hak kemitraan aktif dari "${nama}"?`)) { document.getElementById(`mitra-row-${id}`).remove(); }
        }

        // CUSTOMER
        function openCustomerModal(mode, id = null) {
            const modal = document.getElementById('customerModal');
            const container = document.getElementById('modalCustomerContainer');
            modal.classList.remove('hidden');
            setTimeout(() => { container.classList.remove('scale-95', 'opacity-0'); }, 10);

            if (mode === 'edit') {
                document.getElementById('customerId').value = id;
                const row = document.getElementById(`cust-row-${id}`);
                document.getElementById('inputCustNama').value = row.querySelector('.cell-cust-nama').innerText;
                document.getElementById('inputCustEmail').value = row.querySelector('.cell-cust-email').innerText;
            }
        }
        function closeCustomerModal() {
            document.getElementById('customerModal').classList.add('hidden');
        }
        function saveCustomer(e) {
            e.preventDefault();
            const id = document.getElementById('customerId').value;
            const nama = document.getElementById('inputCustNama').value;
            const email = document.getElementById('inputCustEmail').value;
            const inisial = nama.split(' ').map(n => n[0]).join('').substring(0,2).toUpperCase();

            if (id) {
                const row = document.getElementById(`cust-row-${id}`);
                row.querySelector('.cell-cust-nama').innerText = nama;
                row.querySelector('.cell-cust-email').innerText = email;
                row.querySelector('.w-10').innerText = inisial;
            }
            closeCustomerModal();
        }
        function deleteCustomerRow(id, nama) {
            if (confirm(`Apakah kamu yakin ingin menghapus permanen akun user milik "${nama}"?`)) { document.getElementById(`cust-row-${id}`).remove(); }
        }
    </script>
</body>
</html>
