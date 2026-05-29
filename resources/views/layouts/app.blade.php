<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>@yield('title', 'KSPM SV IPB')</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config={theme:{extend:{colors:{blue:{DEFAULT:'#1a2fb5',mid:'#1e38cc',light:'#2d4ee0',pale:'#e8ecfb',dark:'#0d1a6e'},dark:'#0d0f1a',muted:'#5a6080',border:'#d0d5e8',cream:'#f7f8fc'},fontFamily:{sans:['Inter','sans-serif']}}}}
</script>
<link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css"/>
<style>
::-webkit-scrollbar{width:5px}::-webkit-scrollbar-thumb{background:#b0b8d8;border-radius:3px}
@keyframes pulse-dot{0%,100%{opacity:1}50%{opacity:0.3}}
@keyframes tick{0%{transform:translateX(0)}100%{transform:translateX(-50%)}}
.navbar.scrolled{box-shadow:0 2px 20px rgba(26,47,181,0.1)}
.mobile-menu{transform:translateX(100%);transition:transform 0.3s ease}
.mobile-menu.open{transform:translateX(0)}
.hamburger.open span:nth-child(1){transform:translateY(7px) rotate(45deg)}
.hamburger.open span:nth-child(2){opacity:0;transform:scaleX(0)}
.hamburger.open span:nth-child(3){transform:translateY(-7px) rotate(-45deg)}
.modal-overlay{opacity:0;pointer-events:none;transition:opacity 0.25s ease}
.modal-overlay .modal-box{transform:translateY(20px);transition:transform 0.25s ease}
.modal-overlay.open{opacity:1!important;pointer-events:all!important}
.modal-overlay.open .modal-box{transform:translateY(0)!important}
.toast{transform:translateY(20px);opacity:0;transition:transform 0.3s ease,opacity 0.3s ease}
.toast.show{transform:translateY(0)!important;opacity:1!important}
.alert-box{display:none;font-size:0.8rem;padding:9px 12px;border-radius:8px;margin-bottom:12px;font-weight:600}
.alert-ok{background:#dcfce7;color:#166534;border:1px solid #bbf7d0}
.alert-err{background:#fee2e2;color:#991b1b;border:1px solid #fecaca}
.nav-link.active{color:#1a2fb5!important;background:#e8ecfb!important}
.mobile-nav-link.active{color:#1a2fb5!important;background:#e8ecfb!important}
.cat-radio.active{border-color:#1a2fb5!important;color:#1a2fb5!important;background:#e8ecfb!important}
@yield('styles')
</style>
</head>
<body class="font-sans text-[#1c1f3a] bg-white overflow-x-hidden">

@include('partials.navbar')
@include('partials.mobile-menu')

<main>
    @yield('content')
</main>

@include('partials.footer')
@include('partials.modals')

<!-- TOAST -->
<div class="toast fixed bottom-7 right-7 z-[999] bg-[#0d0f1a] text-white px-[22px] py-3 rounded-xl text-[0.84rem] font-semibold shadow-[0_12px_32px_rgba(0,0,0,0.25)] max-w-xs leading-[1.4] pointer-events-none" id="toast"></div>

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
AOS.init({duration:600,easing:'ease-out-cubic',once:true,offset:60});

function openModal(id){var el=document.getElementById('modal-'+id);if(el)el.classList.add('open');}
function closeModal(id){var el=document.getElementById('modal-'+id);if(el)el.classList.remove('open');}
function switchModal(from,to){closeModal(from);setTimeout(function(){openModal(to);},180);}
document.querySelectorAll('.modal-overlay').forEach(function(el){el.addEventListener('click',function(e){if(e.target===el)el.classList.remove('open');});});
function showToast(msg){var t=document.getElementById('toast');if(!t)return;t.textContent=msg;t.classList.add('show');setTimeout(function(){t.classList.remove('show');},3200);}
function requireLogin(f){openModal('login');showToast('🔒 '+(f||'Fitur ini')+' hanya untuk member.');}
function togglePassVis(inputId){var inp=document.getElementById(inputId);if(inp)inp.type=inp.type==='password'?'text':'password';}
function setCat(cat,el){
  document.querySelectorAll('.cat-radio').forEach(function(c){c.classList.remove('active');});
  el.classList.add('active');
  var lbl=document.getElementById('label-email');
  var inputEmail=document.getElementById('reg-email');
  if(lbl&&inputEmail){
    if(cat==='umum'){lbl.textContent='Email *';inputEmail.placeholder='contoh@email.com';}
    else{lbl.textContent='Email IPB *';inputEmail.placeholder='nama@apps.ipb.ac.id';}
  }
}
function doLogin(){
  var e=document.getElementById('login-email');
  var p=document.getElementById('login-pass');
  var err=document.getElementById('login-err');
  if(!e.value||!p.value){if(err)err.style.display='block';return;}
  closeModal('login');showToast('Berhasil masuk!');
}
function showReg(){
  var n=document.getElementById('reg-name');
  var u=document.getElementById('reg-username');
  var p=document.getElementById('reg-pass');
  var p2=document.getElementById('reg-pass2');
  var err=document.getElementById('reg-err');
  var ok=document.getElementById('reg-ok');
  if(!n.value||!u.value||!p.value||!p2.value){if(err){err.style.display='block';}return;}
  if(p.value!==p2.value){if(err){err.style.display='block';err.textContent='Password tidak cocok.';}return;}
  if(ok)ok.style.display='block';
  setTimeout(function(){closeModal('register');showToast('✅ Pendaftaran berhasil!');},1200);
}
function doForgot(){
  var e=document.getElementById('forgot-email');
  var ok=document.getElementById('forgot-ok');
  if(!e||!e.value)return;
  if(ok)ok.style.display='block';
  setTimeout(function(){closeModal('forgot');showToast('📧 Link reset dikirim!');},1200);
}
function toggleMobileMenu(){
  var m=document.getElementById('mobile-menu');
  var b=document.getElementById('hamburger-btn');
  if(!m||!b)return;
  var open=m.classList.contains('open');
  m.classList[open?'remove':'add']('open');
  b.classList[open?'remove':'add']('open');
  document.body.style.overflow=open?'':'hidden';
}
function closeMobileMenu(){
  var m=document.getElementById('mobile-menu');
  var b=document.getElementById('hamburger-btn');
  if(m)m.classList.remove('open');
  if(b)b.classList.remove('open');
  document.body.style.overflow='';
}
window.addEventListener('scroll',function(){
  var nb=document.getElementById('navbar');
  if(nb)nb.classList[window.scrollY>40?'add':'remove']('scrolled');
});
</script>
@yield('scripts')
</body>
</html>