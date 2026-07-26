<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Logistik Farmasi RS Puspa Husada</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f0fafb',
                            100: '#d9f2f5',
                            200: '#b4e5ec',
                            300: '#7fd3e0',
                            400: '#41b9ce',
                            500: '#04aabe',
                            600: '#03899c',
                            700: '#036e7e',
                            800: '#075967',
                            900: '#0b4a56',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(15, 23, 42, 0.6);
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(51, 65, 85, 0.8);
            border-radius: 4px;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-100 min-h-screen text-slate-800 antialiased selection:bg-[#04aabe] selection:text-white" x-data="{ sidebarOpen: false }">

    <!-- Mobile Sidebar Backdrop Overlay -->
    <div x-show="sidebarOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 z-40 bg-slate-950/60 backdrop-blur-sm lg:hidden" style="display: none;"></div>

    <!-- Sidebar Layout -->
    @include('layouts.sidebar')

    <!-- Main Content Area -->
    <div class="lg:ml-64 flex flex-col min-h-screen">
        <!-- Top Navbar Header -->
        <header class="sticky top-0 z-30 bg-white/95 backdrop-blur-md border-b border-slate-200 shadow-sm px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3 sm:gap-4">
                <!-- Hamburger Button for Mobile -->
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus:outline-none transition-all">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>

                <!-- Page Header Title & Breadcrumb -->
                <div class="flex items-center gap-3">
                    <div>
                        <h2 class="text-base sm:text-lg font-bold text-slate-800 tracking-tight leading-tight">@yield('title', 'Beranda')</h2>
                        <div class="text-xs text-slate-500 flex items-center gap-1.5 mt-0.5">
                            @yield('breadcrumb')
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side Profile & Actions -->
            <div class="flex items-center gap-3 sm:gap-4" x-data="{ dropdownOpen: false }">
                <div class="relative">
                    <button @click="dropdownOpen = !dropdownOpen" @click.away="dropdownOpen = false" class="flex items-center gap-2.5 p-1.5 pr-3 rounded-2xl hover:bg-slate-100 transition-all focus:outline-none">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-[#04aabe] to-cyan-500 text-white flex items-center justify-center font-bold text-xs shadow-md shadow-[#04aabe]/20">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="text-left hidden sm:block">
                            <p class="text-xs font-bold text-slate-800 leading-tight">{{ Auth::user()->name }}</p>
                            <span class="inline-block text-[10px] font-semibold text-[#04aabe]">
                                @if(Auth::user()->isAdmin()) Administrator
                                @elseif(Auth::user()->isInstalasiFarmasi()) Instalasi Farmasi
                                @elseif(Auth::user()->isKepalaInstalasi()) Kepala Instalasi
                                @else {{ Auth::user()->role }}
                                @endif
                            </span>
                        </div>
                        <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 ml-1"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="dropdownOpen" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50" style="display: none;">
                        <div class="px-4 py-2 border-b border-slate-100 sm:hidden">
                            <p class="text-xs font-bold text-slate-800">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] font-medium text-[#04aabe]">
                                @if(Auth::user()->isAdmin()) Administrator 
                                @elseif(Auth::user()->isInstalasiFarmasi()) Instalasi Farmasi 
                                @elseif(Auth::user()->isKepalaInstalasi()) Kepala Instalasi 
                                @endif
                            </p>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 text-left text-xs font-semibold text-rose-600 hover:bg-rose-50 flex items-center gap-2 transition-all">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                <span>Keluar Sistem</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main View Container -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            <!-- Flash Messages -->
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" class="mb-6 bg-brand-50 border border-brand-200 text-brand-900 px-5 py-4 rounded-2xl shadow-sm flex items-center justify-between">
                    <div class="flex items-center gap-3 text-sm font-medium">
                        <i class="fa-solid fa-circle-check text-[#04aabe] text-lg"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-brand-500 hover:text-brand-800">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div x-data="{ show: true }" x-show="show" class="mb-6 bg-rose-50 border border-rose-200 text-rose-800 px-5 py-4 rounded-2xl shadow-sm flex items-center justify-between">
                    <div class="flex items-center gap-3 text-sm font-medium">
                        <i class="fa-solid fa-circle-exclamation text-rose-600 text-lg"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button @click="show = false" class="text-rose-500 hover:text-rose-800">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-slate-200 px-6 py-4 text-center text-xs text-slate-500">
            &copy; {{ date('Y') }} RS Puspa Husada Bekasi — Sistem Informasi Manajemen Logistik Farmasi (Metode EOQ & Min-Max Stock)
        </footer>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.js"></script>
    <script>
        function formatRupiah(num) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(num);
        }
    </script>
    @stack('scripts')
</body>
</html>
