<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - KSPM SV IPB</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: rgba(0, 0, 0, 0.55); /* Menyamai backdrop modal */
            backdrop-filter: blur(16px);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">

    {{-- Container mirip Modal Box --}}
    <div class="bg-white rounded-[20px] p-[38px] w-full max-w-[420px] relative shadow-[0_28px_72px_rgba(0,0,0,0.15)] mx-4">
        
        {{-- Header Logo KSPM --}}
        <div class="flex items-center gap-2 mb-4">
            <img src="{{ asset('Logo_Kspm_Bg.png') }}" alt="KSPM" class="h-7 w-auto" onerror="this.style.display='none'">
            <span class="text-[0.83rem] font-bold text-[#1a2fb5]">KSPM SV IPB</span>
        </div>

        <div class="text-[1.3rem] font-extrabold text-[#0d0f1a] mb-1">Masuk ke Akun</div>
        <div class="text-[0.83rem] text-[#5a6080] mb-5">Akses fitur eksklusif anggota KSPM SV IPB.</div>

        {{-- Alert Error dari Backend Laravel --}}
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-red-600 text-[0.8rem] font-medium">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        {{-- Alert Success dari Backend Laravel --}}
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg text-green-700 text-[0.8rem] font-medium">
                {{ session('success') }}
            </div>
        @endif

        {{-- Form Login --}}
        <form action="{{ route('user.login.store') }}" method="POST">
            @csrf

            {{-- Input Username / Email --}}
            <div class="mb-3">
                <label for="login_field" class="text-[0.75rem] font-semibold text-[#5a6080] mb-1 block">Email atau Username</label>
                <input class="w-full px-3 py-2.5 border-[1.5px] border-[#d0d5e8] rounded-lg text-[0.875rem] bg-[#f7f8fc] outline-none focus:border-[#1a2fb5] focus:bg-white"
                       type="text" 
                       id="login_field" 
                       name="login"
                       value="{{ old('login') }}"
                       required 
                       autofocus
                       placeholder="email@apps.ipb.ac.id">
            </div>

            {{-- Input Password --}}
            <div class="mb-3">
                <label for="password" class="text-[0.75rem] font-semibold text-[#5a6080] mb-1 block">Password</label>
                <div class="relative">
                    <input class="w-full px-3 py-2.5 pr-10 border-[1.5px] border-[#d0d5e8] rounded-lg text-[0.875rem] bg-[#f7f8fc] outline-none focus:border-[#1a2fb5] focus:bg-white"
                           type="password" 
                           id="password" 
                           name="password"
                           required
                           placeholder="••••••••">
                    
                    {{-- Toggle Mata Password --}}
                    <button type="button" onclick="togglePassword()"
                            class="absolute right-3 top-1/2 -translate-y-1/2 bg-transparent border-none cursor-pointer text-[#5a6080]">
                        <svg id="eye-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
                
                {{-- Lupa Password (dibiarkan ke route forgot-password asli) --}}
                <a href="{{ route('user.forgot-password') }}" class="text-[#1a2fb5] text-[0.75rem] cursor-pointer float-right mt-1 font-medium hover:underline">
                    Lupa password?
                </a>
                <div class="clear-both"></div>
            </div>

            {{-- Remember Me (Tersembunyi tapi aktif jika dibutuhkan, atau ditampilkan. Disini saya tampilkan dengan gaya UI modal) --}}
            <div class="mb-5 flex items-center gap-2">
                 <input type="checkbox" id="remember" name="remember" class="w-3.5 h-3.5 border-[#d0d5e8] rounded cursor-pointer accent-[#1a2fb5]">
                 <label for="remember" class="text-[0.75rem] font-medium text-[#5a6080] cursor-pointer select-none">
                     Ingat saya
                 </label>
            </div>

            {{-- Tombol Submit --}}
            <button type="submit" class="w-full py-3 rounded-[9px] font-bold text-[0.88rem] bg-[#1a2fb5] text-white border-none cursor-pointer hover:bg-[#1e38cc] transition-colors">
                Masuk
            </button>
        </form>

        {{-- Link ke Register --}}
        <div class="text-center text-[0.8rem] text-[#5a6080] mt-4">
            Belum punya akun?
            <a href="{{ route('login') }}" class="text-[#1a2fb5] font-semibold hover:underline">Daftar sekarang</a>
        </div>

    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                // Mengubah icon menjadi mata dicoret (eye-off)
                eyeIcon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
            } else {
                passwordInput.type = 'password';
                // Mengembalikan icon mata normal
                eyeIcon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
            }
        }
    </script>
</body>
</html>