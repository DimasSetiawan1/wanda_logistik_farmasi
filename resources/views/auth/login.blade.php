@extends('layouts.guest')

@section('title', 'Masuk Sistem')

@section('content')
    <div class="w-full max-w-md relative z-10">
        <div class="bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl overflow-hidden border border-slate-100">
            <!-- Logo & Header Section -->
            <div class="bg-gradient-to-br from-[#04aabe] via-cyan-600 to-slate-900 p-8 text-center text-white relative">
                <div class="inline-flex p-3.5 bg-white rounded-2xl shadow-lg mb-2">
                    <img src="{{ asset('assets/logo.jpeg') }}" alt="Logo RS Puspa Husada"
                        class="h-16 w-auto object-contain rounded-lg">
                </div>
                <p class="text-cyan-50 text-xs font-semibold tracking-wider uppercase mt-1">Logistik Farmasi</p>
            </div>

            <!-- Form Body -->
            <div class="p-8">
                <div class="mb-6 text-center">
                    <h3 class="text-xl font-bold text-slate-800">Selamat Datang Kembali</h3>
                    <p class="text-sm text-slate-500 mt-1">Silakan masuk menggunakan nama pengguna & kata sandi Anda</p>
                </div>

                @if($errors->any())
                    <div
                        class="mb-6 bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl text-sm flex items-center gap-3">
                        <i class="fa-solid fa-triangle-exclamation text-rose-500 text-base"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Nama Pengguna</label>
                        <div class="relative">
                            <div
                                class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-user text-sm"></i>
                            </div>
                            <input type="text" name="username" value="{{ old('username') }}"
                                class="w-full pl-10 pr-4 py-3 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#04aabe] focus:border-[#04aabe] transition-all font-medium text-slate-800 placeholder-slate-400"
                                placeholder="Nama Pengguna" required autofocus>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Kata Sandi</label>
                        <div class="relative">
                            <div
                                class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-lock text-sm"></i>
                            </div>
                            <input type="password" name="password"
                                class="w-full pl-10 pr-4 py-3 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#04aabe] focus:border-[#04aabe] transition-all font-medium text-slate-800 placeholder-slate-400"
                                placeholder="••••••••" required>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-sm pt-1">
                        <label class="flex items-center gap-2 cursor-pointer text-slate-600 hover:text-slate-800">
                            <input type="checkbox" name="remember"
                                class="w-4 h-4 text-[#04aabe] rounded border-slate-300 focus:ring-[#04aabe]">
                            <span class="text-xs font-medium">Ingat Sesi Saya</span>
                        </label>
                    </div>

                    <button type="submit"
                        class="w-full py-3.5 px-4 bg-[#04aabe] hover:bg-[#03899c] text-white font-bold rounded-xl shadow-lg shadow-[#04aabe]/30 hover:shadow-[#04aabe]/40 transition-all flex items-center justify-center gap-2 text-sm">
                        <i class="fa-solid fa-right-to-bracket"></i>
                        <span>Masuk ke Sistem</span>
                    </button>
                </form>

                <div class="mt-8 pt-6 border-t border-slate-100 text-center text-xs text-slate-400">
                    &copy; {{ date('Y') }} RS Puspa Husada Bekasi. Seluruh hak cipta dilindungi.
                </div>
            </div>
        </div>
    </div>
@endsection