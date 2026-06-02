<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password Admin - KSPM</title>
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
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-600 to-purple-800 text-white text-3xl shadow-lg shadow-indigo-500/20 mb-4">
                🔐
            </div>
            <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Buat Password Admin Baru</h1>
            <p class="text-sm text-gray-500 mt-1">Masukkan password baru yang kuat</p>
        </div>

        <div class="bg-white rounded-3xl p-6 md:p-8 shadow-xl shadow-gray-200/50 border border-gray-100">
            
            {{-- Alert Error --}}
            @if ($errors->any())
                <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-2xl flex items-start gap-3 text-red-800 text-sm">
                    <span class="shrink-0 mt-0.5">⚠️</span>
                    <div>
                        <div class="font-bold">Reset Password Gagal</div>
                        <ul class="list-disc list-inside mt-0.5 text-xs text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.reset-password.store') }}" method="POST" class="space-y-5">
                @csrf
                
                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label for="email" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Email Admin
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-base">✉️</span>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            required 
                            autofocus
                            class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition placeholder-gray-400 text-gray-900" 
                            placeholder="Masukkan email admin Anda">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Password Baru
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-base">🔒</span>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required 
                            class="w-full pl-11 pr-12 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition placeholder-gray-400 text-gray-900" 
                            placeholder="Minimal 8 karakter">
                        
                        <button 
                            type="button" 
                            onclick="togglePassword('password')" 
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition text-sm">
                            <span id="eye-icon-password">👁️</span>
                        </button>
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Konfirmasi Password
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-base">🔐</span>
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            required 
                            class="w-full pl-11 pr-12 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition placeholder-gray-400 text-gray-900" 
                            placeholder="Ulangi password">
                        
                        <button 
                            type="button" 
                            onclick="togglePassword('password_confirmation')" 
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition text-sm">
                            <span id="eye-icon-password_confirmation">👁️</span>
                        </button>
                    </div>
                </div>

                <button 
                    type="submit" 
                    class="w-full py-3 px-4 bg-gradient-to-r from-indigo-600 to-purple-800 hover:from-indigo-700 hover:to-purple-900 text-white font-semibold rounded-xl text-sm shadow-lg shadow-indigo-500/20 transition transform active:scale-[0.98]">
                    Ubah Password
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-gray-100">
                <p class="text-center text-sm text-gray-600">
                    <a href="{{ route('admin.login') }}" class="font-bold text-indigo-600 hover:text-indigo-700 transition">
                        Kembali ke Login
                    </a>
                </p>
            </div>
        </div>

        <p class="text-center text-xs text-gray-400 mt-8">
            &copy; 2026 KSPM. All rights reserved.
        </p>
    </div>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const eyeIcon = document.getElementById('eye-icon-' + fieldId);
            
            if (field.type === 'password') {
                field.type = 'text';
                eyeIcon.innerText = '🙈';
            } else {
                field.type = 'password';
                eyeIcon.innerText = '👁️';
            }
        }
    </script>
</body>
</html>
