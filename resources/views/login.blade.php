<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DKJ Sales Tool – Masuk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-slate-100 flex">

    {{-- ===================== LEFT PANEL ===================== --}}
    <div class="hidden lg:flex lg:w-1/2 xl:w-5/12 bg-[#0f2942] flex-col justify-between p-12 relative overflow-hidden">

        {{-- Background decoration --}}
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-[#1a3d5c] opacity-60"></div>
            <div class="absolute bottom-0 -left-16 w-72 h-72 rounded-full bg-[#163352] opacity-50"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] rounded-full bg-[#122e4a] opacity-40"></div>
        </div>

        {{-- Logo & Brand --}}
        <div class="relative z-10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-sky-500 rounded-xl flex items-center justify-center shadow-lg shadow-sky-500/30">
                    <img src="{{ asset('images/logo_dkj.jpg') }}" alt="DKJ Logo"
                    class="w-10 h-10 rounded-xl object-contain bg-white p-1 shadow-lg">
                </div>
                <span class="text-white font-bold text-xl tracking-tight">PT. Dunia Kimia Jaya</span>
            </div>
        </div>

        {{-- Center content --}}
        <div class="relative z-10 space-y-6">
            <div class="w-14 h-1 bg-sky-500 rounded-full"></div>
            <h1 class="text-4xl font-bold text-white leading-tight">
                Halo, <span class="text-sky-400">Selamat</span><br>Datang Kembali!
            </h1>
            <p class="text-slate-400 text-base leading-relaxed max-w-sm">
                Masuk ke akun Anda untuk mengakses <strong class="text-slate-300">DKJ Sales Report</strong>
                dan mengelola laporan penjualan Anda.
            </p>

            {{-- Feature highlights --}}
            <div class="space-y-3 pt-2">
                @foreach ([
                    ['icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'label' => 'Data Preparation & Preview'],
                    ['icon' => 'M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z', 'label' => 'Sales Report Summary'],
                    ['icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'label' => 'Resume All Business'],
                ] as $feature)
                <div class="flex items-center gap-3">
                    <div class="w-7 h-7 rounded-lg bg-sky-500/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $feature['icon'] }}"/>
                        </svg>
                    </div>
                    <span class="text-slate-400 text-sm">{{ $feature['label'] }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Footer --}}
        <div class="relative z-10">
            <p class="text-slate-500 text-xs">© {{ date('Y') }} PT. Dunia Kimia Jaya</p>
        </div>
    </div>

    {{-- ===================== RIGHT PANEL (FORM) ===================== --}}
    <div class="flex-1 flex items-center justify-center px-6 py-12 lg:px-12">
        <div class="w-full max-w-md">

            {{-- Mobile logo --}}
            <div class="flex items-center gap-2 mb-8 lg:hidden">
                <div class="w-8 h-8 bg-sky-500 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <span class="font-bold text-[#0f2942] text-lg">DKJ <span class="text-sky-500">Sales Tool</span></span>
            </div>

            {{-- Heading --}}
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-slate-800">Masuk ke Akun</h2>
                <p class="text-slate-500 text-sm mt-1">Masukkan username dan kata sandi Anda</p>
            </div>

            {{-- Error from session (server-side) --}}
            @if (session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4">
                <div class="flex gap-3">
                    <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                </div>
            </div>
            @endif

            {{-- Inline error (shown by JS) --}}
            <div id="login-error" class="hidden mb-6 bg-red-50 border border-red-200 rounded-xl p-4">
                <div class="flex gap-3">
                    <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm text-red-700 font-semibold">Username atau kata sandi salah.</p>
                </div>
            </div>

            {{-- Login Form --}}
            <div class="space-y-5">

                {{-- Username --}}
                <div>
                    <label for="username" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Username
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </span>
                        <input
                            type="text"
                            id="username"
                            placeholder="Username (admin)"
                            class="w-full pl-10 pr-4 py-2.5 text-sm border border-slate-200 rounded-xl bg-white
                                   text-slate-800 placeholder-slate-400
                                   focus:outline-none focus:ring-2 focus:ring-sky-500/30 focus:border-sky-500 transition-all"
                        >
                    </div>
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Kata Sandi
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </span>
                        <input
                            type="password"
                            id="password"
                            placeholder="Password (password)"
                            class="w-full pl-10 pr-4 py-2.5 text-sm border border-slate-200 rounded-xl bg-white
                                   text-slate-800 placeholder-slate-400
                                   focus:outline-none focus:ring-2 focus:ring-sky-500/30 focus:border-sky-500 transition-all"
                        >
                    </div>
                </div>

                {{-- Submit --}}
                <button
                    id="loginBtn"
                    type="button"
                    class="w-full py-3 px-4 bg-[#0f2942] hover:bg-[#163352] text-white font-semibold text-sm rounded-xl
                           transition-all duration-200 shadow-lg shadow-slate-900/20 hover:shadow-xl hover:shadow-slate-900/25
                           focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 mt-1
                           flex items-center justify-center gap-2"
                >
                    <span id="loginBtnText">Masuk ke Sistem</span>
                    <svg id="loginSpinner" class="hidden w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                </button>

            </div>

            {{-- Hint --}}
            <p class="text-center text-xs text-slate-400 mt-6">
                Login default: <span class="font-mono text-slate-500">admin</span> /
                <span class="font-mono text-slate-500">password</span>
            </p>

        </div>
    </div>

    <script>
        const VALID_USER = 'admin';
        const VALID_PASS = 'password';

        function attemptLogin() {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value;
            const errorEl  = document.getElementById('login-error');
            const btnText  = document.getElementById('loginBtnText');
            const spinner  = document.getElementById('loginSpinner');
            const btn      = document.getElementById('loginBtn');

            errorEl.classList.add('hidden');

            if (username === VALID_USER && password === VALID_PASS) {
                btn.disabled  = true;
                btnText.textContent = 'Masuk…';
                spinner.classList.remove('hidden');

                setTimeout(() => {
                    document.getElementById('login-wrapper')?.classList.add('hidden');
                    document.getElementById('app-wrapper')?.style &&
                        (document.getElementById('app-wrapper').style.display = 'flex');

                    // If using blade layout redirect, trigger it here:
                    // window.location.href = '/dashboard';
                    btn.disabled = false;
                    btnText.textContent = 'Masuk ke Sistem';
                    spinner.classList.add('hidden');
                }, 600);
                window.location.href = '/dashboard';
            } else {
                errorEl.classList.remove('hidden');
                document.getElementById('password').value = '';
                document.getElementById('password').focus();
            }
        }

        document.getElementById('loginBtn').addEventListener('click', attemptLogin);

        ['username', 'password'].forEach(id => {
            document.getElementById(id).addEventListener('keydown', e => {
                if (e.key === 'Enter') attemptLogin();
            });
        });

        // Auto-focus username field on load
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('username').focus();
        });
    </script>

</body>
</html>