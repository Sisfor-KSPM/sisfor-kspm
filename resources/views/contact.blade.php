@extends('layouts.app')

@section('title', 'KSPM SV IPB — Contact')

@section('styles')
.nav-link.active{color:#1a2fb5!important;background:#e8ecfb!important}
@endsection

@section('content')
<!-- HERO -->
<div class="bg-gradient-to-br from-[#0d1a6e] via-[#1e38cc] to-[#2d4ee0] pt-[100px] pb-[60px] text-white relative overflow-hidden mt-[68px]">
  <div class="max-w-[1200px] mx-auto px-10 relative z-[2]">
    <div class="inline-flex items-center gap-2 bg-white/[.12] border border-white/20 text-white/90 px-4 py-1.5 rounded-full text-[0.72rem] font-bold tracking-[0.07em] uppercase mb-[18px]">💬 Hubungi Kami</div>
    <h1 class="text-[clamp(2.2rem,4vw,3.4rem)] font-medium leading-[1.1] mb-3.5">Contact Us</h1>
    <p class="text-[0.96rem] text-white/65 leading-[1.75] max-w-[560px]">Ada pertanyaan atau saran? Kami siap membantu. Kirimkan pesan dan tim kami akan segera merespons.</p>
  </div>
</div>

<!-- CONTACT SECTION -->
<section class="bg-[#f7f8fc] py-20 pb-24">
  <div class="max-w-[1200px] mx-auto px-10 grid grid-cols-1 md:grid-cols-2 gap-16 items-start">

    <!-- Info -->
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

      <!-- Social links -->
      <div class="mt-8">
        <div class="text-[0.75rem] font-bold text-[#5a6080] uppercase tracking-[0.08em] mb-3">Follow Us</div>
        <div class="flex gap-2.5">
          <a class="w-[42px] h-[42px] rounded-[11px] bg-white border border-[#d0d5e8] flex items-center justify-center text-[#5a6080] no-underline transition-all hover:bg-[#e8ecfb] hover:border-[#1a2fb5] hover:text-[#1a2fb5]" href="#"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg></a>
          <a class="w-[42px] h-[42px] rounded-[11px] bg-white border border-[#d0d5e8] flex items-center justify-center text-[#5a6080] no-underline transition-all hover:bg-[#e8ecfb] hover:border-[#1a2fb5] hover:text-[#1a2fb5]" href="#"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg></a>
          <a class="w-[42px] h-[42px] rounded-[11px] bg-white border border-[#d0d5e8] flex items-center justify-center text-[#5a6080] no-underline transition-all hover:bg-[#e8ecfb] hover:border-[#1a2fb5] hover:text-[#1a2fb5]" href="#"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22.54 6.42a2.78 2.78 0 00-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46A2.78 2.78 0 001.46 6.42 29 29 0 001 12a29 29 0 00.46 5.58A2.78 2.78 0 003.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.4a2.78 2.78 0 001.95-1.95A29 29 0 0023 12a29 29 0 00-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02"/></svg></a>
          <a class="w-[42px] h-[42px] rounded-[11px] bg-white border border-[#d0d5e8] flex items-center justify-center text-[#5a6080] no-underline transition-all hover:bg-[#e8ecfb] hover:border-[#1a2fb5] hover:text-[#1a2fb5]" href="#"><svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.75a8.19 8.19 0 004.79 1.52V6.84a4.85 4.85 0 01-1.02-.15z"/></svg></a>
        </div>
      </div>
    </div>

    <!-- Form -->
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

<!-- FAQ -->
<section class="bg-white py-20 pb-24">
  <div class="max-w-[800px] mx-auto px-10">
    <div class="text-center mb-10">
      <div class="text-[0.72rem] font-bold tracking-[0.1em] uppercase text-[#1a2fb5] mb-2.5">FAQ</div>
      <h2 class="text-[clamp(1.8rem,2.5vw,2.4rem)] font-medium text-[#0d0f1a] leading-[1.2]">Pertanyaan yang Sering Diajukan</h2>
    </div>
    <div class="flex flex-col gap-3" id="faq-list"></div>
  </div>
</section>

<script>
function sendMessage(){
  var n=document.getElementById('c-name');var e=document.getElementById('c-email');var m=document.getElementById('c-message');
  if(!n.value||!e.value||!m.value){showToast('⚠️ Mohon isi semua field wajib.');return;}
  n.value='';e.value='';m.value='';
  showToast('✅ Pesan terkirim! Kami akan segera merespons.');
}

/* FAQ */
var faqs = [
  {
    q: 'Bagaimana cara bergabung dengan KSPM SV IPB?',
    a: 'Kamu bisa bergabung melalui program Open Recruitment yang kami adakan setiap tahun. Pantau media sosial kami untuk info terbaru atau klik tombol "Open Recruitment" di navbar.'
  },
  {
    q: 'Apakah KSPM SV IPB terbuka untuk umum?',
    a: 'Website dan konten edukasi kami dapat diakses oleh siapapun. Namun untuk menjadi anggota aktif, kamu harus mahasiswa aktif SV IPB University.'
  },
  {
    q: 'Bagaimana cara mengakses laporan riset KSPM?',
    a: 'Laporan riset tersedia di halaman E-Library. Beberapa konten bisa diakses gratis, sedangkan laporan lengkap memerlukan akun member.'
  },
  {
    q: 'Apakah ada biaya untuk mengikuti event KSPM?',
    a: 'Sebagian besar event kami gratis untuk mahasiswa IPB. Beberapa program khusus seperti Sekolah Pasar Modal mungkin ada biaya pendaftaran yang sangat terjangkau.'
  },
  {
    q: 'Bagaimana cara berkolaborasi atau sponsorship dengan KSPM?',
    a: 'Untuk informasi kemitraan dan sponsorship, silakan hubungi kami melalui email atau form kontak di halaman ini. Tim PR kami akan segera respons.'
  }
];

var faqEl = document.getElementById('faq-list');
if (faqEl) {
  faqEl.innerHTML = faqs.map(function(f, i) {
    return '<div class="bg-white border border-[#d0d5e8] rounded-[14px] overflow-hidden" data-aos="fade-up" data-aos-delay="' + (i * 60) + '">' +
      '<button class="w-full flex items-center justify-between px-6 py-4 text-left cursor-pointer bg-transparent border-none outline-none" onclick="toggleFaq(' + i + ', this)">' +
        '<span class="text-[0.92rem] font-semibold text-[#0d0f1a]">' + f.q + '</span>' +
        '<span class="text-[#1a2fb5] text-lg font-bold faq-icon flex-shrink-0 ml-4">+</span>' +
      '</button>' +
      '<div class="faq-body px-6 pb-4 hidden">' +
        '<p class="text-[0.88rem] text-[#5a6080] leading-[1.75]">' + f.a + '</p>' +
      '</div>' +
    '</div>';
  }).join('');
}

function toggleFaq(i, btn) {
  var body = btn.nextElementSibling; 
  var icon = btn.querySelector('.faq-icon');
  var open = !body.classList.contains('hidden');
  body.classList[open ? 'add' : 'remove']('hidden');
  icon.textContent = open ? '+' : '−';
}
</script>
@endsection
