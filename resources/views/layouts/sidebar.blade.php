<aside id="sidebar" 
       :class="sidebarOpen ? 'translate-x-0 shadow-2xl' : '-translate-x-full'"
       class="fixed top-0 bottom-0 left-0 z-50 w-64 bg-slate-900 text-slate-300 transition-transform duration-300 ease-in-out lg:translate-x-0 flex flex-col border-r border-slate-800">
    
    <!-- Brand Logo & Header -->
    <div class="p-4 bg-slate-950/80 border-b border-slate-800/80 shrink-0 text-center flex flex-col items-center justify-center">
        <div class="p-1.5 bg-white rounded-xl shadow-sm inline-block">
            <img src="{{ asset('assets/logo.jpeg') }}" alt="Logo RS Puspa Husada" class="h-10 w-auto object-contain rounded-lg">
        </div>
        <div class="mt-2">
            <p class="text-[11px] text-[#04aabe] font-bold tracking-wider uppercase">Logistik Farmasi</p>
        </div>
    </div>

    <!-- Navigation Menu -->
    <div class="flex-1 overflow-y-auto py-4 px-3 space-y-6 custom-scrollbar">
        <!-- Main Navigation -->
        <div>
            <div class="px-3 mb-2 text-[10px] font-bold text-slate-400 tracking-wider uppercase">Menu Utama</div>
            <div class="space-y-1">
                <a href="{{ route('dashboard') }}" @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('dashboard') ? 'bg-[#04aabe] text-white shadow-lg shadow-[#04aabe]/30' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}">
                    <i class="fa-solid fa-house w-4 text-center text-xs"></i>
                    <span>Beranda</span>
                </a>

                <a href="{{ route('medicines.index') }}" @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('medicines.*') ? 'bg-[#04aabe] text-white shadow-lg shadow-[#04aabe]/30' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}">
                    <i class="fa-solid fa-pills w-4 text-center text-xs"></i>
                    <span>Data Obat</span>
                </a>

                @if(!Auth::user()->isKepalaInstalasi())
                <a href="{{ route('demand-data.index') }}" @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('demand-data.*') ? 'bg-[#04aabe] text-white shadow-lg shadow-[#04aabe]/30' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}">
                    <i class="fa-solid fa-chart-line w-4 text-center text-xs"></i>
                    <span>{{ Auth::user()->isInstalasiFarmasi() ? 'Data Pemakaian' : 'Data Permintaan' }}</span>
                </a>
                @endif
            </div>
        </div>

        @if(!Auth::user()->isInstalasiFarmasi())
        <!-- Optimasi & Batas Stok -->
        <div>
            <div class="px-3 mb-2 text-[10px] font-bold text-slate-400 tracking-wider uppercase">Optimasi & Batas Stok</div>
            <div class="space-y-1">
                @if(Auth::user()->isAdmin())
                <a href="{{ route('eoq.index') }}" @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('eoq.index') ? 'bg-[#04aabe] text-white shadow-lg shadow-[#04aabe]/30' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}">
                    <i class="fa-solid fa-sliders w-4 text-center text-xs"></i>
                    <span>Parameter Optimasi Stok</span>
                </a>
                @endif

                <a href="{{ route('eoq.result') }}" @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('eoq.result') ? 'bg-[#04aabe] text-white shadow-lg shadow-[#04aabe]/30' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}">
                    <i class="fa-solid fa-calculator w-4 text-center text-xs"></i>
                    <span>Hasil Optimasi Stok</span>
                </a>

                <a href="{{ route('minmax.result') }}" @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('minmax.result') ? 'bg-[#04aabe] text-white shadow-lg shadow-[#04aabe]/30' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}">
                    <i class="fa-solid fa-chart-column w-4 text-center text-xs"></i>
                    <span>Hasil Batas Persediaan</span>
                </a>

                <a href="{{ route('minmax.monitoring') }}" @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('minmax.monitoring') ? 'bg-[#04aabe] text-white shadow-lg shadow-[#04aabe]/30' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}">
                    <i class="fa-solid fa-heart-pulse w-4 text-center text-xs"></i>
                    <span>Monitoring Batas Stok</span>
                </a>
            </div>
        </div>

        <!-- Evaluasi & Prioritas -->
        <div>
            <div class="px-3 mb-2 text-[10px] font-bold text-slate-400 tracking-wider uppercase">Evaluasi & Prioritas</div>
            <div class="space-y-1">
                <a href="{{ route('evaluation.abc') }}" @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('evaluation.abc') ? 'bg-[#04aabe] text-white shadow-lg shadow-[#04aabe]/30' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}">
                    <i class="fa-solid fa-chart-pie w-4 text-center text-xs"></i>
                    <span>Prioritas Kategori Stok</span>
                </a>

                <a href="{{ route('evaluation.eoq') }}" @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('evaluation.eoq') ? 'bg-[#04aabe] text-white shadow-lg shadow-[#04aabe]/30' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}">
                    <i class="fa-solid fa-scale-balanced w-4 text-center text-xs"></i>
                    <span>Evaluasi Biaya Persediaan</span>
                </a>
            </div>
        </div>

        <!-- Laporan & Pengaturan -->
        <div>
            <div class="px-3 mb-2 text-[10px] font-bold text-slate-400 tracking-wider uppercase">Laporan & Pengaturan</div>
            <div class="space-y-1">
                <a href="{{ route('reports.index') }}" @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('reports.*') ? 'bg-[#04aabe] text-white shadow-lg shadow-[#04aabe]/30' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}">
                    <i class="fa-solid fa-file-pdf w-4 text-center text-xs"></i>
                    <span>Laporan Sistem</span>
                </a>

                @if(Auth::user()->isAdmin())
                <a href="{{ route('users.index') }}" @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('users.*') ? 'bg-[#04aabe] text-white shadow-lg shadow-[#04aabe]/30' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}">
                    <i class="fa-solid fa-users-gear w-4 text-center text-xs"></i>
                    <span>Kelola Pengguna</span>
                </a>
                @endif
            </div>
        </div>
        @endif
    </div>

    <!-- User Profile Footer -->
    <div class="p-4 bg-slate-950/90 border-t border-slate-800/80 flex items-center justify-between shrink-0">
        <div class="flex items-center gap-3 overflow-hidden">
            <div class="w-8 h-8 rounded-xl bg-[#04aabe]/20 text-[#04aabe] flex items-center justify-center font-bold text-xs shrink-0 border border-[#04aabe]/30">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="overflow-hidden">
                <p class="text-xs font-bold text-white truncate leading-tight">{{ Auth::user()->name }}</p>
                <span class="inline-block text-[10px] font-semibold text-[#04aabe]">
                    @if(Auth::user()->isAdmin()) Administrator
                    @elseif(Auth::user()->isInstalasiFarmasi()) Instalasi Farmasi
                    @elseif(Auth::user()->isKepalaInstalasi()) Kepala Instalasi
                    @else {{ Auth::user()->role }}
                    @endif
                </span>
            </div>
        </div>
    </div>
</aside>
