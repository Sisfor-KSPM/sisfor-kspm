<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password Admin - KSPM</title>
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
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-amber-500 to-red-600 text-white text-3xl shadow-lg shadow-amber-500/20 mb-4">
                🔑
            </div>
            <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Pemulihan Password Admin</h1>
            <p class="text-sm text-gray-500 mt-1">Kami akan mengirimkan instruksi reset ke email Anda</p>
        </div>

        <div id="form-card" class="bg-white rounded-3xl p-6 md:p-8 shadow-xl shadow-gray-200/50 border border-gray-100 block">
            
            {{-- Alert Error --}}
            @if ($errors->any())
                <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-2xl flex items-start gap-3 text-red-800 text-sm">
                    <span class="shrink-0 mt-0.5">⚠️</span>
                    <div class="text-xs text-red-700">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Alert Status Sukses --}}
            @if (session('status'))
                <div class="mb-5 p-4 bg-green-50 border border-green-200 rounded-2xl flex items-start gap-3 text-green-800 text-sm">
                    <span class="shrink-0 mt-0.5">✅</span>
                    <div class="text-xs text-green-700">
                        {{ session('status') }}
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.forgot-password.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Alamat Email Admin
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
                            class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-amber-500 focus:bg-white transition placeholder-gray-400 text-gray-900" 
                            placeholder="admin@kspm.com">
                    </div>
                </div>

                <button 
                    type="submit" 
                    class="w-full py-3 px-4 bg-gradient-to-r from-amber-500 to-red-600 hover:from-amber-600 hover:to-red-700 text-white font-semibold rounded-xl text-sm shadow-lg shadow-amber-500/20 transition transform active:scale-[0.98]">
                    Kirim Link Reset
                </button>

                <div class="text-center pt-2">
                    <a href="{{ route('admin.login') }}" class="text-xs font-bold text-gray-500 hover:text-amber-600 transition flex items-center justify-center gap-1">
                        <span>⬅️</span> Kembali ke Halaman Login
                    </a>
                </div>
            </form>
        </div>

        <div id="success-card" class="bg-white rounded-3xl p-6 md:p-8 shadow-xl shadow-gray-200/50 border border-gray-100 hidden text-center space-y-5">
            <div class="w-16 h-16 bg-green-50 rounded-full flex items-center justify-center text-3xl mx-auto text-green-500">
                📩
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900">Periksa Email Anda</h3>
                <p class="text-sm text-gray-500 mt-2 leading-relaxed">
                    Kami telah mengirimkan tautan pemulihan password ke email Anda. Silakan periksa folder kotak masuk atau spam dalam waktu 1 jam.
                </p>
            </div>
            <div class="pt-2">
                <a href="{{ route('admin.login') }}" class="inline-block w-full py-3 px-4 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl text-sm transition">
                    Kembali ke Login
                </a>
            </div>
        </div>

        <p class="text-center text-xs text-gray-400 mt-8">
            &copy; 2026 KSPM. All rights reserved.
        </p>
    </div>

    <script>
        // Otomatis pindah ke screen sukses jika backend Laravel mengirimkan session status berhasil
        @if (session('status'))
            document.getElementById('form-card').classList.replace('block', 'hidden');
            document.getElementById('success-card').classList.replace('hidden', 'block');
        @endif
    </script>
</body>
</html>
