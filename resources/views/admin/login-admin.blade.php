<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - KSPM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-800 text-white text-3xl shadow-lg shadow-blue-500/20 mb-4">
                💼
            </div>
            <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Selamat Datang Kembali</h1>
            <p class="text-sm text-gray-500 mt-1">Masuk ke Dashboard Admin KSPM</p>
        </div>

        <div class="bg-white rounded-3xl p-6 md:p-8 shadow-xl shadow-gray-200/50 border border-gray-100">
            
            {{-- Alert Error --}}
            @if ($errors->any())
                <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-2xl flex items-start gap-3 text-red-800 text-sm">
                    <span class="shrink-0 mt-0.5">⚠️</span>
                    <div>
                        <div class="font-bold">Login Gagal</div>
                        <ul class="list-disc list-inside mt-0.5 text-xs text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- Alert Success --}}
            @if (session('success'))
                <div class="mb-5 p-4 bg-green-50 border border-green-200 rounded-2xl flex items-start gap-3 text-green-800 text-sm">
                    <span class="shrink-0 mt-0.5">✅</span>
                    <div class="text-xs text-green-700">{{ session('success') }}</div>
                </div>
            @endif

            <form action="{{ route('admin.login.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="login_field" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Username atau Email
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-base">👤</span>
                        <input 
                            type="text" 
                            id="login_field" 
                            name="login"
                            value="{{ old('login') }}"
                            required 
                            autofocus
                            class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition placeholder-gray-400 text-gray-900" 
                            placeholder="Masukkan username atau email">
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label for="password" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Password
                        </label>
                        <a href="{{ route('admin.forgot-password') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700">
                            Lupa Password?
                        </a>
                    </div>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-base">🔒</span>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required 
                            class="w-full pl-11 pr-12 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition placeholder-gray-400 text-gray-900" 
                            placeholder="••••••••">
                        
                        <button 
                            type="button" 
                            onclick="togglePassword()" 
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition text-sm">
                            <span id="eye-icon">👁️</span>
                        </button>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <input 
                        type="checkbox" 
                        id="remember" 
                        name="remember" 
                        class="w-4 h-4 border-gray-300 rounded cursor-pointer accent-blue-600">
                    <label for="remember" class="text-xs font-bold text-gray-600 cursor-pointer">
                        Ingat saya
                    </label>
                </div>

                <button 
                    type="submit" 
                    class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white font-semibold rounded-xl text-sm shadow-lg shadow-blue-500/20 transition transform active:scale-[0.98]">
                    Masuk Sekarang
                </button>
            </form>
        </div>

        <p class="text-center text-xs text-gray-400 mt-8">
            &copy; 2026 KSPM. All rights reserved.
        </p>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerText = '🙈';
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerText = '👁️';
            }
        }
    </script>
</body>
</html>
