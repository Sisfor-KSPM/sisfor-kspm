<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - KSPM SV IPB</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(16px);
        }

        .cat-radio {
            border: 1.5px solid #d0d5e8;
            color: #5a6080;
            background: #f7f8fc;
            transition: all 0.18s ease;
        }

        .cat-radio.active {
            border-color: #1a2fb5;
            background: #e8ecfb;
            color: #1a2fb5;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4 py-10">

    {{-- Container mirip Modal Box --}}
    <div class="bg-white rounded-[20px] p-[38px] w-full max-w-[420px] relative shadow-[0_28px_72px_rgba(0,0,0,0.15)] mx-4">

        {{-- Header Logo KSPM --}}
        <div class="flex items-center gap-2 mb-4">
            <img src="{{ asset('Logo_Kspm_Bg.png') }}" alt="KSPM" class="h-7 w-auto" onerror="this.style.display='none'">
            <span class="text-[0.83rem] font-bold text-[#1a2fb5]">KSPM SV IPB</span>
        </div>

        <div class="text-[1.3rem] font-extrabold text-[#0d0f1a] mb-1">Daftar Akun</div>
        <div class="text-[0.83rem] text-[#5a6080] mb-5">Buat akun untuk mengakses fitur dan konten eksklusif KSPM SV IPB.</div>

        {{-- Alert Error dari Backend Laravel --}}
        @if ($errors->any())
            <div class="mb-5 p-3 bg-red-50 border border-red-200 rounded-lg text-red-600 text-[0.8rem] font-medium">
                <div class="font-bold mb-1">Pendaftaran Gagal:</div>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('user.register.store') }}" method="POST">
            @csrf

            {{-- Role Toggle: Mahasiswa IPB / Umum --}}
            <div class="flex gap-2 mb-4">
                <div class="cat-radio active flex-1 p-2 rounded-lg text-center text-[0.8rem] font-semibold cursor-pointer select-none"
                     id="cat-ipb"
                     onclick="setRegCat('ipb')">🎓 Mahasiswa IPB</div>
                <div class="cat-radio flex-1 p-2 rounded-lg text-center text-[0.8rem] font-semibold cursor-pointer select-none"
                     id="cat-umum"
                     onclick="setRegCat('umum')">👤 Umum</div>
            </div>

            {{-- Hidden input role yang dikirim ke backend --}}
            <input type="hidden" name="role" id="reg-role" value="{{ old('role', 'ipb') }}">

            {{-- Input Nama Lengkap --}}
            <div class="mb-3">
                <label for="name" class="text-[0.75rem] font-semibold text-[#5a6080] mb-1 block">Nama Lengkap *</label>
                <input class="w-full px-3 py-2.5 border-[1.5px] border-[#d0d5e8] rounded-lg text-[0.875rem] bg-[#f7f8fc] outline-none focus:border-[#1a2fb5] focus:bg-white"
                       type="text"
                       id="name"
                       name="name"
                       value="{{ old('name') }}"
                       required
                       autofocus
                       placeholder="Masukkan nama lengkap Anda">
            </div>

            {{-- Input Username --}}
            <div class="mb-3">
                <label for="username" class="text-[0.75rem] font-semibold text-[#5a6080] mb-1 block">Username *</label>
                <input class="w-full px-3 py-2.5 border-[1.5px] border-[#d0d5e8] rounded-lg text-[0.875rem] bg-[#f7f8fc] outline-none focus:border-[#1a2fb5] focus:bg-white"
                       type="text"
                       id="username"
                       name="username"
                       value="{{ old('username') }}"
                       required
                       placeholder="Pilih username unik Anda">
            </div>

            {{-- Input Email — label & placeholder berubah sesuai role --}}
            <div class="mb-3">
                <label for="email" class="text-[0.75rem] font-semibold text-[#5a6080] mb-1 block" id="label-email">
                    Email IPB *
                </label>
                <input class="w-full px-3 py-2.5 border-[1.5px] border-[#d0d5e8] rounded-lg text-[0.875rem] bg-[#f7f8fc] outline-none focus:border-[#1a2fb5] focus:bg-white"
                       type="email"
                       id="email"
                       name="email"
                       value="{{ old('email') }}"
                       required
                       placeholder="nama@apps.ipb.ac.id">
            </div>

            {{-- Input Password --}}
            <div class="mb-3">
                <label for="password" class="text-[0.75rem] font-semibold text-[#5a6080] mb-1 block">Password *</label>
                <div class="relative">
                    <input class="w-full px-3 py-2.5 pr-10 border-[1.5px] border-[#d0d5e8] rounded-lg text-[0.875rem] bg-[#f7f8fc] outline-none focus:border-[#1a2fb5] focus:bg-white"
                           type="password"
                           id="password"
                           name="password"
                           required
                           placeholder="Minimal 8 karakter">
                    <button type="button" onclick="togglePassword('password')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 bg-transparent border-none cursor-pointer text-[#5a6080]">
                        <svg id="eye-icon-password" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Input Konfirmasi Password --}}
            <div class="mb-5">
                <label for="password_confirmation" class="text-[0.75rem] font-semibold text-[#5a6080] mb-1 block">Konfirmasi Password *</label>
                <div class="relative">
                    <input class="w-full px-3 py-2.5 pr-10 border-[1.5px] border-[#d0d5e8] rounded-lg text-[0.875rem] bg-[#f7f8fc] outline-none focus:border-[#1a2fb5] focus:bg-white"
                           type="password"
                           id="password_confirmation"
                           name="password_confirmation"
                           required
                           placeholder="Ulangi password">
                    <button type="button" onclick="togglePassword('password_confirmation')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 bg-transparent border-none cursor-pointer text-[#5a6080]">
                        <svg id="eye-icon-password_confirmation" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Tombol Submit --}}
            <button type="submit" class="w-full py-3 rounded-[9px] font-bold text-[0.88rem] bg-[#1a2fb5] text-white border-none cursor-pointer hover:bg-[#1e38cc] transition-colors mt-1">
                Buat Akun
            </button>
        </form>

        {{-- Link ke Login --}}
        <div class="text-center text-[0.8rem] text-[#5a6080] mt-4">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-[#1a2fb5] font-semibold hover:underline">Masuk di sini</a>
        </div>

    </div>

    <script>
        // ── Role toggle ──────────────────────────────────────────────
        function setRegCat(cat) {
            document.getElementById('reg-role').value = cat;

            var ipbBtn  = document.getElementById('cat-ipb');
            var umumBtn = document.getElementById('cat-umum');
            var label   = document.getElementById('label-email');
            var emailEl = document.getElementById('email');

            if (cat === 'ipb') {
                ipbBtn.classList.add('active');
                umumBtn.classList.remove('active');
                label.textContent    = 'Email IPB *';
                emailEl.placeholder  = 'nama@apps.ipb.ac.id';
            } else {
                umumBtn.classList.add('active');
                ipbBtn.classList.remove('active');
                label.textContent    = 'Email *';
                emailEl.placeholder  = 'Masukkan email Anda';
            }
        }

        // Restore pilihan lama saat validasi gagal (old input)
        (function () {
            var oldRole = '{{ old('role', 'ipb') }}';
            if (oldRole === 'umum') setRegCat('umum');
        })();

        // ── Toggle visibilitas password ──────────────────────────────
        function togglePassword(fieldId) {
            var field   = document.getElementById(fieldId);
            var eyeIcon = document.getElementById('eye-icon-' + fieldId);

            if (field.type === 'password') {
                field.type = 'text';
                eyeIcon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
            } else {
                field.type = 'password';
                eyeIcon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
            }
        }
    </script>
</body>
</html>