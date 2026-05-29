{{-- resources/views/partials/modals.blade.php --}}

{{-- ===== MODAL LOGIN ===== --}}
<div class="modal-overlay fixed inset-0 z-[500] bg-black/55 backdrop-blur-lg flex items-center justify-center"
     id="modal-login">
  <div class="modal-box bg-white rounded-[20px] p-[38px] w-full max-w-[420px] relative shadow-[0_28px_72px_rgba(0,0,0,0.15)] max-h-[90vh] overflow-y-auto mx-4">

    <button class="absolute top-3 right-3 w-7 h-7 rounded-full bg-[#f7f8fc] cursor-pointer text-[0.82rem] flex items-center justify-center text-[#5a6080] hover:bg-[#d0d5e8] border-none"
            onclick="closeModal('login')">✕</button>

    <div class="flex items-center gap-2 mb-4">
      <img src="{{ asset('Logo_Kspm_Bg.png') }}" alt="KSPM" class="h-7 w-auto" onerror="this.style.display='none'">
      <span class="text-[0.83rem] font-bold text-[#1a2fb5]">KSPM SV IPB</span>
    </div>

    <div class="text-[1.3rem] font-extrabold text-[#0d0f1a] mb-1">Masuk ke Akun</div>
    <div class="text-[0.83rem] text-[#5a6080] mb-5">Akses fitur eksklusif anggota KSPM SV IPB.</div>

    <div class="alert-box alert-err" id="login-err">Email atau password salah.</div>

    <div class="mb-3">
      <label class="text-[0.75rem] font-semibold text-[#5a6080] mb-1 block">Email</label>
      <input class="w-full px-3 py-2.5 border-[1.5px] border-[#d0d5e8] rounded-lg text-[0.875rem] bg-[#f7f8fc] outline-none focus:border-[#1a2fb5] focus:bg-white"
             type="email" id="login-email" placeholder="email@apps.ipb.ac.id">
    </div>

    <div class="mb-3">
      <label class="text-[0.75rem] font-semibold text-[#5a6080] mb-1 block">Password</label>
      <div class="relative">
        <input class="w-full px-3 py-2.5 pr-10 border-[1.5px] border-[#d0d5e8] rounded-lg text-[0.875rem] bg-[#f7f8fc] outline-none focus:border-[#1a2fb5] focus:bg-white"
               type="password" id="login-pass" placeholder="••••••••">
        <button type="button" onclick="togglePassVis('login-pass')"
                class="absolute right-3 top-1/2 -translate-y-1/2 bg-transparent border-none cursor-pointer text-[#5a6080]">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
          </svg>
        </button>
      </div>
      <a class="text-[#1a2fb5] text-[0.75rem] cursor-pointer float-right mt-1 font-medium hover:underline"
         onclick="switchModal('login','forgot')">Lupa password?</a>
    </div>

    <button class="w-full py-3 rounded-[9px] font-bold text-[0.88rem] bg-[#1a2fb5] text-white border-none cursor-pointer hover:bg-[#1e38cc] mt-1"
            onclick="doLogin()">Masuk</button>

    <div class="text-center text-[0.8rem] text-[#5a6080] mt-3">
      Belum punya akun?
      <a class="text-[#1a2fb5] cursor-pointer hover:underline" onclick="switchModal('login','register')">Daftar sekarang</a>
    </div>

  </div>
</div>

{{-- ===== MODAL REGISTER ===== --}}
<div class="modal-overlay fixed inset-0 z-[500] bg-black/55 backdrop-blur-lg flex items-center justify-center"
     id="modal-register">
  <div class="modal-box bg-white rounded-[20px] p-[38px] w-full max-w-[420px] relative shadow-[0_28px_72px_rgba(0,0,0,0.15)] max-h-[90vh] overflow-y-auto mx-4">

    <button class="absolute top-3 right-3 w-7 h-7 rounded-full bg-[#f7f8fc] cursor-pointer text-[0.82rem] flex items-center justify-center text-[#5a6080] hover:bg-[#d0d5e8] border-none"
            onclick="closeModal('register')">✕</button>

    <div class="flex items-center gap-2 mb-4">
      <img src="{{ asset('Logo_Kspm_Bg.png') }}" alt="KSPM" class="h-7 w-auto" onerror="this.style.display='none'">
      <span class="text-[0.83rem] font-bold text-[#1a2fb5]">KSPM SV IPB</span>
    </div>

    <div class="text-[1.3rem] font-extrabold text-[#0d0f1a] mb-1">Daftar Akun</div>
    <div class="text-[0.83rem] text-[#5a6080] mb-5">Buat akun untuk mengakses fitur dan konten eksklusif KSPM SV IPB.</div>

    <div class="alert-box alert-ok" id="reg-ok">✅ Akun berhasil dibuat!</div>
    <div class="alert-box alert-err" id="reg-err">Harap isi semua field yang wajib.</div>

    {{-- Category Toggle --}}
    <div class="flex gap-2 mb-4">
      <div class="cat-radio active flex-1 p-2 rounded-lg border-[1.5px] text-center text-[0.8rem] font-semibold cursor-pointer select-none"
           onclick="setCat('ipb', this)">🎓 Mahasiswa IPB</div>
      <div class="cat-radio flex-1 p-2 rounded-lg border-[1.5px] border-[#d0d5e8] text-center text-[0.8rem] font-semibold text-[#5a6080] cursor-pointer select-none"
           onclick="setCat('umum', this)">👤 Umum</div>
    </div>

    <div class="mb-3">
      <label class="text-[0.75rem] font-semibold text-[#5a6080] mb-1 block">Nama Lengkap *</label>
      <input class="w-full px-3 py-2.5 border-[1.5px] border-[#d0d5e8] rounded-lg text-[0.875rem] bg-[#f7f8fc] outline-none focus:border-[#1a2fb5] focus:bg-white"
             type="text" id="reg-name" placeholder="Masukkan nama lengkap kamu">
    </div>

    <div class="mb-3">
      <label class="text-[0.75rem] font-semibold text-[#5a6080] mb-1 block">Username *</label>
      <input class="w-full px-3 py-2.5 border-[1.5px] border-[#d0d5e8] rounded-lg text-[0.875rem] bg-[#f7f8fc] outline-none focus:border-[#1a2fb5] focus:bg-white"
             type="text" id="reg-username" placeholder="username">
    </div>

    <div class="mb-3">
      <label class="text-[0.75rem] font-semibold text-[#5a6080] mb-1 block" id="label-email">Email IPB *</label>
      <input class="w-full px-3 py-2.5 border-[1.5px] border-[#d0d5e8] rounded-lg text-[0.875rem] bg-[#f7f8fc] outline-none focus:border-[#1a2fb5] focus:bg-white"
             type="email" id="reg-email" placeholder="nama@apps.ipb.ac.id">
    </div>

    <div class="mb-3">
      <label class="text-[0.75rem] font-semibold text-[#5a6080] mb-1 block">Password *</label>
      <div class="relative">
        <input class="w-full px-3 py-2.5 pr-10 border-[1.5px] border-[#d0d5e8] rounded-lg text-[0.875rem] bg-[#f7f8fc] outline-none focus:border-[#1a2fb5] focus:bg-white"
               type="password" id="reg-pass" placeholder="Min. 8 karakter">
        <button type="button" onclick="togglePassVis('reg-pass')"
                class="absolute right-3 top-1/2 -translate-y-1/2 bg-transparent border-none cursor-pointer text-[#5a6080]">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
          </svg>
        </button>
      </div>
    </div>

    <div class="mb-3">
      <label class="text-[0.75rem] font-semibold text-[#5a6080] mb-1 block">Konfirmasi Password *</label>
      <div class="relative">
        <input class="w-full px-3 py-2.5 pr-10 border-[1.5px] border-[#d0d5e8] rounded-lg text-[0.875rem] bg-[#f7f8fc] outline-none focus:border-[#1a2fb5] focus:bg-white"
               type="password" id="reg-pass2" placeholder="Ulangi password">
        <button type="button" onclick="togglePassVis('reg-pass2')"
                class="absolute right-3 top-1/2 -translate-y-1/2 bg-transparent border-none cursor-pointer text-[#5a6080]">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
          </svg>
        </button>
      </div>
    </div>

    <button class="w-full py-3 rounded-[9px] font-bold text-[0.88rem] bg-[#1a2fb5] text-white border-none cursor-pointer hover:bg-[#1e38cc] mt-1"
            onclick="showReg()">Buat Akun</button>

    <div class="text-center text-[0.8rem] text-[#5a6080] mt-3">
      Sudah punya akun?
      <a class="text-[#1a2fb5] cursor-pointer hover:underline" onclick="switchModal('register','login')">Masuk di sini</a>
    </div>

  </div>
</div>

{{-- ===== MODAL FORGOT PASSWORD ===== --}}
<div class="modal-overlay fixed inset-0 z-[500] bg-black/55 backdrop-blur-lg flex items-center justify-center"
     id="modal-forgot">
  <div class="modal-box bg-white rounded-[20px] p-[38px] w-full max-w-[420px] relative shadow-[0_28px_72px_rgba(0,0,0,0.15)] max-h-[90vh] overflow-y-auto mx-4">

    <button class="absolute top-3 right-3 w-7 h-7 rounded-full bg-[#f7f8fc] cursor-pointer text-[0.82rem] flex items-center justify-center text-[#5a6080] hover:bg-[#d0d5e8] border-none"
            onclick="closeModal('forgot')">✕</button>

    <div class="text-[1.3rem] font-extrabold text-[#0d0f1a] mb-1">Lupa Password</div>
    <div class="text-[0.83rem] text-[#5a6080] mb-5">Masukkan email kamu untuk link reset password.</div>

    <div class="alert-box alert-ok" id="forgot-ok">📧 Link reset telah dikirim!</div>
    <div class="alert-box alert-err" id="forgot-err">Email tidak ditemukan.</div>

    <div class="mb-3">
      <label class="text-[0.75rem] font-semibold text-[#5a6080] mb-1 block">Email Terdaftar</label>
      <input class="w-full px-3 py-2.5 border-[1.5px] border-[#d0d5e8] rounded-lg text-[0.875rem] bg-[#f7f8fc] outline-none focus:border-[#1a2fb5] focus:bg-white"
             type="email" id="forgot-email" placeholder="email@apps.ipb.ac.id">
    </div>

    <button class="w-full py-3 rounded-[9px] font-bold text-[0.88rem] bg-[#1a2fb5] text-white border-none cursor-pointer hover:bg-[#1e38cc] mt-1"
            onclick="doForgot()">Kirim Link Reset</button>

    <div class="text-center text-[0.8rem] text-[#5a6080] mt-3">
      <a class="text-[#1a2fb5] cursor-pointer hover:underline" onclick="switchModal('forgot','login')">← Kembali ke Login</a>
    </div>

  </div>
</div>
