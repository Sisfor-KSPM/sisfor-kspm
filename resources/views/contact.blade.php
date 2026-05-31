@extends('layouts.app')

@section('title', 'KSPM SV IPB — Contact')

@section('styles')
<style>
.nav-link.active{color:#1a2fb5!important;background:#e8ecfb!important}
</style>
@endsection

@section('content')
<div class="bg-gradient-to-br from-[#0d1a6e] via-[#1e38cc] to-[#2d4ee0] pt-[100px] pb-[60px] text-white relative overflow-hidden mt-[68px]">
  <div class="max-w-[1200px] mx-auto px-10 relative z-[2]">
    <div class="inline-flex items-center gap-2 bg-white/[.12] border border-white/20 text-white/90 px-4 py-1.5 rounded-full text-[0.72rem] font-bold tracking-[0.07em] uppercase mb-[18px]">💬 Hubungi Kami</div>
    <h1 class="text-[clamp(2.2rem,4vw,3.4rem)] font-medium leading-[1.1] mb-3.5">Contact Us</h1>
    <p class="text-[0.96rem] text-white/65 leading-[1.75] max-w-[560px]">Ada pertanyaan atau saran? Kami siap membantu. Kirimkan pesan dan tim kami akan segera merespons.</p>
  </div>
</div>

<section class="bg-[#f7f8fc] py-20 pb-24">
  <div class="max-w-[1200px] mx-auto px-10 grid grid-cols-1 md:grid-cols-2 gap-16 items-start">

    <div data-aos="fade-right">
      <div class="text-[0.72rem] font-bold tracking-[0.1em] uppercase text-[#1a2fb5] mb-2.5">Kontak</div>
      <h2 class="text-[clamp(1.8rem,2.5vw,2.4rem)] font-medium mb-3 text-[#0d0f1a] leading-[1.2]">Reach Out to Us</h2>
      <p class="text-[0.9rem] text-[#5a6080] leading-[1.75] mb-8">Your feedback is important to us. Whether it's a question about our programs, interest in joining, or a partnership proposal — we'd love to hear from you.</p>

      <div class="flex flex-col gap-5">
        <div class="flex items-start gap-4">
          <div class="w-[46px] h-[46px] bg-[#e8ecfb] rounded-[12px] flex items-center justify-center flex-shrink-0 text-xl"><img src="email.png" alt="email" class="w-6 h-6" onerror="this.outerHTML='📧'"></div>
          <div><div class="text-[0.68rem] font-bold text-[#5a6080] uppercase tracking-[0.06em] mb-0.5">Email</div><div class="text-[0.9rem] font-semibold text-[#0d0f1a]">kspmsvipb@apps.ipb.ac.id</div></div>
        </div>
        <div class="flex items-start gap-4">
          <div class="w-[46px] h-[46px] bg-[#e8ecfb] rounded-[12px] flex items-center justify-center flex-shrink-0 text-xl"><img src="hp.png" alt="phone" class="w-6 h-6" onerror="this.outerHTML='📱'"></div>
          <div><div class="text-[0.68rem] font-bold text-[#5a6080] uppercase tracking-[0.06em] mb-0.5">WhatsApp (PR)</div><div class="text-[0.9rem] font-semibold text-[#0d0f1a]">+62 812-3456-7890</div></div>
        </div>
        <div class="flex items-start gap-4">
          <div class="w-[46px] h-[46px] bg-[#e8ecfb] rounded-[12px] flex items-center justify-center flex-shrink-0 text-xl"><img src="link.png" alt="linktree" class="w-6 h-6" onerror="this.outerHTML='🔗'"></div>
          <div><div class="text-[0.68rem] font-bold text-[#5a6080] uppercase tracking-[0.06em] mb-0.5">Linktree</div><div class="text-[0.9rem] font-semibold text-[#0d0f1a]"><a href="https://linktr.ee/KSPM_SVIPB" target="_blank" class="text-[#1a2fb5] no-underline hover:underline">linktr.ee/KSPM_SVIPB</a></div></div>
        </div>
        <div class="flex items-start gap-4">
          <div class="w-[46px] h-[46px] bg-[#e8ecfb] rounded-[12px] flex items-center justify-center flex-shrink-0 text-xl"><img src="loc.png" alt="location" class="w-6 h-6" onerror="this.outerHTML='📍'"></div>
          <div><div class="text-[0.68rem] font-bold text-[#5a6080] uppercase tracking-[0.06em] mb-0.5">Lokasi</div><div class="text-[0.9rem] font-semibold text-[#0d0f1a]">Kampus SV IPB University, Bogor</div></div>
        </div>
      </div>
    </div>

    <div class="bg-white border border-[#d0d5e8] rounded-[18px] p-8" data-aos="fade-left">
      <div class="text-[1.1rem] font-bold text-[#0d0f1a] mb-1">Kirim Pesan</div>
      <div class="text-[0.83rem] text-[#5a6080] mb-6">Isi form di bawah dan tim kami akan segera merespons.</div>
      <div class="mb-3"><label class="text-[0.75rem] font-semibold text-[#5a6080] mb-1 block">Nama Lengkap *</label><input class="w-full px-3 py-2.5 border-[1.5px] border-[#d0d5e8] rounded-lg text-[0.875rem] bg-[#f7f8fc] outline-none transition-colors focus:border-[#1a2fb5] focus:bg-white" type="text" id="c-name" placeholder="Nama kamu"></div>
      <div class="grid grid-cols-2 gap-2.5 mb-3">
        <div><label class="text-[0.75rem] font-semibold text-[#5a6080] mb-1 block">Email *</label><input class="w-full px-3 py-2.5 border-[1.5px] border-[#d0d5e8] rounded-lg text-[0.875rem] bg-[#f7f8fc] outline-none focus:border-[#1a2fb5] focus:bg-white" type="email" id="c-email" placeholder="email@domain.com"></div>
        <div><label class="text-[0.75rem] font-semibold text-[#5a6080] mb-1 block">No. HP</label><input class="w-full px-3 py-2.5 border-[1.5px] border-[#d0d5e8] rounded-lg text-[0.875rem] bg-[#f7f8fc] outline-none focus:border-[#1a2fb5] focus:bg-white" type="text" placeholder="+62..."></div>
      </div>
      <div class="mb-3"><label class="text-[0.75rem] font-semibold text-[#5a6080] mb-1 block">Subjek *</label><input class="w-full px-3 py-2.5 border-[1.5px] border-[#d0d5e8] rounded-lg text-[0.875rem] bg-[#f7f8fc] outline-none focus:border-[#1a2fb5] focus:bg-white" type="text" id="c-subject" placeholder="Subjek pesan"></div>
      <div class="mb-3"><label class="text-[0.75rem] font-semibold text-[#5a6080] mb-1 block">Kategori</label>
        <select class="w-full px-3 py-2.5 border-[1.5px] border-[#d0d5e8] rounded-lg text-[0.875rem] bg-[#f7f8fc] outline-none focus:border-[#1a2fb5] focus:bg-white cursor-pointer">
          <option>Pertanyaan Umum</option>
          <option>Informasi Membership</option>
          <option>Kemitraan / Sponsorship</option>
          <option>Laporan & Riset</option>
          <option>Lainnya</option>
        </select>
      </div>
      <div class="mb-4"><label class="text-[0.75rem] font-semibold text-[#5a6080] mb-1 block">Pesan *</label><textarea class="w-full px-3 py-2.5 border-[1.5px] border-[#d0d5e8] rounded-lg text-[0.875rem] bg-[#f7f8fc] outline-none min-h-[120px] resize-y focus:border-[#1a2fb5] focus:bg-white" id="c-message" placeholder="Tuliskan pesan kamu..."></textarea></div>
      <button class="w-full py-3 rounded-[9px] font-bold text-[0.875rem] bg-[#1a2fb5] text-white border-none cursor-pointer transition-all hover:bg-[#1e38cc]" onclick="sendMessage()">Kirim Pesan →</button>
    </div>
  </div>
</section>

<section class="bg-white py-20 pb-24">
  <div class="max-w-[800px] mx-auto px-10">
    <div class="text-center mb-10">
      <div class="text-[0.72rem] font-bold tracking-[0.1em] uppercase text-[#1a2fb5] mb-2.5">FAQ</div>
      <h2 class="text-[clamp(1.8rem,2.5vw,2.4rem)] font-medium text-[#0d0f1a] leading-[1.2]">Pertanyaan yang Sering Diajukan</h2>
    </div>
    
    <div class="flex flex-col gap-3" id="faq-list">
      @forelse($faqs as $index => $f)
        <div class="bg-white border border-[#d0d5e8] rounded-[14px] overflow-hidden" data-aos="fade-up" data-aos-delay="{{ $index * 60 }}">
          <button class="w-full flex items-center justify-between px-6 py-4 text-left cursor-pointer bg-transparent border-none outline-none focus:outline-none" onclick="toggleFaq(this)">
            <span class="text-[0.92rem] font-semibold text-[#0d0f1a]">{{ $f->pertanyaan }}</span>
            <span class="text-[#1a2fb5] text-lg font-bold faq-icon flex-shrink-0 ml-4">+</span>
          </button>
          <div class="faq-body px-6 pb-4 hidden">
            <p class="text-[0.88rem] text-[#5a6080] leading-[1.75]">{{ $f->jawaban }}</p>
          </div>
        </div>
      @empty
        <p class="text-center text-gray-500 text-sm">Belum ada pertanyaan FAQ yang tersedia.</p>
      @endforelse
    </div>
  </div>
</section>

<script>
function sendMessage(){
  var n=document.getElementById('c-name');var e=document.getElementById('c-email');var m=document.getElementById('c-message');
  if(!n.value||!e.value||!m.value){alert('⚠️ Mohon isi semua field wajib.');return;}
  n.value='';e.value='';m.value='';
  alert('✅ Pesan terkirim! Kami akan segera merespons.');
}

/* Fungsi Toggle Akordion FAQ */
function toggleFaq(btn) {
  var body = btn.nextElementSibling; 
  var icon = btn.querySelector('.faq-icon');
  var isOpen = !body.classList.contains('hidden');
  
  body.classList[isOpen ? 'add' : 'remove']('hidden');
  icon.textContent = isOpen ? '+' : '−';
}
</script>
@endsection