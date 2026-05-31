@extends('layouts.app')

@section('title', 'E-Library')

@section('content')

<section class="bg-white pt-[140px] pb-16">
  <div class="max-w-[1200px] mx-auto px-10">

    <div class="text-[0.72rem] font-bold tracking-[0.1em] uppercase text-[#1a2fb5] mb-2.5">
      E-Library
    </div>

    <h1 class="text-[clamp(2rem,4vw,3.2rem)] font-medium text-[#0d0f1a] leading-[1.1] mb-3">
      Riset & Analisis KSPM
    </h1>

    <p class="text-[0.95rem] text-[#5a6080] leading-[1.8] max-w-[540px] mb-8">
      Koleksi laporan riset, analisis teknikal, dan market outlook dari tim analis KSPM SV IPB.
    </p>

    {{-- TABS --}}
    <div class="flex flex-wrap gap-2 mb-8">

      <button
        class="tab-btn bg-[#1a2fb5] text-white border-[#1a2fb5] px-[18px] py-[7px] rounded-lg text-[0.82rem] font-semibold border-[1.5px] cursor-pointer transition-all duration-200"
        onclick="filterResearch('all', this)">
        Semua
      </button>

      <button
        class="tab-btn bg-white text-[#5a6080] border-[#d0d5e8] px-[18px] py-[7px] rounded-lg text-[0.82rem] font-semibold border-[1.5px] cursor-pointer transition-all duration-200 hover:bg-[#1a2fb5] hover:text-white hover:border-[#1a2fb5]"
        onclick="filterResearch('weekly', this)">
        Weekly Research
      </button>

      <button
        class="tab-btn bg-white text-[#5a6080] border-[#d0d5e8] px-[18px] py-[7px] rounded-lg text-[0.82rem] font-semibold border-[1.5px] cursor-pointer transition-all duration-200 hover:bg-[#1a2fb5] hover:text-white hover:border-[#1a2fb5]"
        onclick="filterResearch('equity', this)">
        Equity Research
      </button>

      <button
        class="tab-btn bg-white text-[#5a6080] border-[#d0d5e8] px-[18px] py-[7px] rounded-lg text-[0.82rem] font-semibold border-[1.5px] cursor-pointer transition-all duration-200 hover:bg-[#1a2fb5] hover:text-white hover:border-[#1a2fb5]"
        onclick="filterResearch('outlook', this)">
        Market Outlook
      </button>

      <button
        class="tab-btn bg-white text-[#5a6080] border-[#d0d5e8] px-[18px] py-[7px] rounded-lg text-[0.82rem] font-semibold border-[1.5px] cursor-pointer transition-all duration-200 hover:bg-[#1a2fb5] hover:text-white hover:border-[#1a2fb5]"
        onclick="filterResearch('casual', this)">
        Casual of the Day
      </button>

      <button
        class="tab-btn bg-white text-[#5a6080] border-[#d0d5e8] px-[18px] py-[7px] rounded-lg text-[0.82rem] font-semibold border-[1.5px] cursor-pointer transition-all duration-200 hover:bg-[#1a2fb5] hover:text-white hover:border-[#1a2fb5]"
        onclick="filterResearch('cme', this)">
        CME
      </button>

    </div>

    {{-- SEARCH --}}
    <div class="relative max-w-[360px] mb-8">

      <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[#5a6080]">
        🔍
      </span>

      <input
        class="w-full pl-10 pr-4 py-2.5 border-[1.5px] border-[#d0d5e8] rounded-[9px] text-[0.875rem] bg-[#f7f8fc] outline-none focus:border-[#1a2fb5]"
        type="text"
        placeholder="Cari laporan riset..."
        id="research-search"
        oninput="searchResearch()"
      >
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5" id="research-grid">
      @forelse($reports as $report)      
        <div
            class="research-card bg-white rounded-xl p-5 border border-gray-100 cursor-pointer"
            onclick="document.getElementById('report-modal-{{ $report->id }}').classList.remove('hidden')">

            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-lg bg-red-100 flex items-center justify-center text-red-800 font-bold">
                    PDF
                </div>

                <div>
                    <div class="font-semibold text-sm text-gray-900">
                        {{ $report->judul_riset }}
                    </div>

                    <div class="text-xs text-gray-500 mt-1">
                        {{ $report->penulis ?: '-' }}
                        ·
                        {{ $report->tanggal_rilis ? \Carbon\Carbon::parse($report->tanggal_rilis)->format('d M Y') : '-' }}
                    </div>
                </div>
            </div>

        </div>
      @empty
        <div class="col-span-1 md:col-span-3 rounded-lg border border-dashed border-gray-200 p-8 text-center text-gray-500">Belum ada laporan riset publik.</div>
      @endforelse
    </div>

  </div>
</section>

{{-- RESEARCH MODAL --}}
@foreach($reports as $report)

<div
    id="report-modal-{{ $report->id }}"
    class="hidden fixed inset-0 z-[999] bg-black/70 backdrop-blur-sm p-5 overflow-y-auto">

    <div class="min-h-full flex items-center justify-center">

        <div class="bg-white rounded-2xl max-w-3xl w-full overflow-hidden">

            {{-- HEADER --}}
            <div class="bg-gradient-to-br from-[#0d1a6e] to-[#1e38cc] text-white p-8 relative">

                <button
                    onclick="document.getElementById('report-modal-{{ $report->id }}').classList.add('hidden')"
                    class="absolute top-4 right-4 w-9 h-9 rounded-full bg-white/10 hover:bg-white/20">

                    ✕

                </button>

                <div class="uppercase text-xs tracking-widest text-white/60 mb-2">
                    {{ $report->kategori }}
                </div>

                <h2 class="text-2xl font-bold">
                    {{ $report->judul_riset }}
                </h2>

            </div>

            {{-- BODY --}}
            <div class="p-8">

                <div class="grid md:grid-cols-3 gap-5 mb-8">

                    <div>
                        <div class="text-xs text-gray-400 uppercase mb-1">
                            Penulis
                        </div>

                        <div class="font-semibold">
                            {{ $report->penulis ?: '-' }}
                        </div>
                    </div>

                    <div>
                        <div class="text-xs text-gray-400 uppercase mb-1">
                            Kategori
                        </div>

                        <div class="font-semibold">
                            {{ $report->kategori }}
                        </div>
                    </div>

                    <div>
                        <div class="text-xs text-gray-400 uppercase mb-1">
                            Tanggal Rilis
                        </div>

                        <div class="font-semibold">
                            {{ $report->tanggal_rilis ? \Carbon\Carbon::parse($report->tanggal_rilis)->format('d F Y') : '-' }}
                        </div>
                    </div>

                </div>

                <div>

                    <h3 class="font-bold text-lg mb-3">
                        Deskripsi
                    </h3>

                    <p class="text-gray-600 leading-7">
                        {{ $report->deskripsi_singkat }}
                    </p>

                </div>

            </div>

            {{-- FOOTER --}}
            <div class="p-8 pt-0 flex gap-3">

                <a
                    href="{{ asset($report->pdf_file) }}"
                    target="_blank"
                    download
                    class="flex-1 text-center bg-[#1a2fb5] hover:bg-[#233ccf] text-white font-bold py-3 rounded-lg">

                    ⬇ Download PDF

                </a>

                <button
                    onclick="document.getElementById('report-modal-{{ $report->id }}').classList.add('hidden')"
                    class="px-6 py-3 border rounded-lg">

                    Tutup

                </button>

            </div>

        </div>

    </div>

</div>

@endforeach
@endsection

@section('styles')
<style>

.research-card{
  transition:all .2s;
  cursor:pointer;
}

.research-card:hover{
  transform:translateY(-4px);
  box-shadow:0 14px 36px rgba(26,47,181,.1);
  border-color:#1a2fb5!important;
}

.modal-overlay{
  opacity:0;
  pointer-events:none;
  transition:all .25s ease;
}

.modal-overlay.open{
  opacity:1;
  pointer-events:auto;
}

.modal-overlay.open .modal-box{
  transform:translateY(0);
}

.modal-box{
  transform:translateY(20px);
  transition:all .25s ease;
}

</style>
@endsection

@section('scripts')
<script>

let currentCategory = 'all';

function openResearch(report)
{
    document.getElementById('rm-type').textContent =
        report.kategori ?? '-';

    document.getElementById('rm-title').textContent =
        report.judul_riset ?? '-';

    document.getElementById('rm-meta').textContent =
        (report.penulis ?? '-') + ' • ' +
        (report.tanggal_rilis ?? '-');

    const categoryEl = document.getElementById('rm-category');
    const authorEl   = document.getElementById('rm-author');
    const dateEl     = document.getElementById('rm-date');

    if(categoryEl)
        categoryEl.textContent = report.kategori ?? '-';

    if(authorEl)
        authorEl.textContent = report.penulis ?? '-';

    if(dateEl)
        dateEl.textContent = report.tanggal_rilis ?? '-';

    const summaryEl = document.getElementById('rm-summary');
    if(summaryEl)
        summaryEl.textContent =
            report.ringkasan ??
            report.deskripsi ??
            'Tidak ada ringkasan.';

    const contentEl = document.getElementById('rm-content');
    if(contentEl)
        contentEl.textContent =
            report.isi_laporan ??
            'Klik tombol download untuk membaca laporan lengkap.';

    document.getElementById('modal-research-download').href =
        '/' + report.pdf_file;

    const modal =
        document.getElementById('modal-research');

    modal.classList.remove('hidden');

    setTimeout(() => {
        modal.classList.add('open');
    }, 10);
}


function filterResearch(category, btn)
{
    currentCategory = category;

    document.querySelectorAll('.tab-btn').forEach(el => {

        el.classList.remove(
            'bg-[#1a2fb5]',
            'text-white',
            'border-[#1a2fb5]'
        );

        el.classList.add(
            'bg-white',
            'text-[#5a6080]',
            'border-[#d0d5e8]'
        );

    });

    btn.classList.add(
        'bg-[#1a2fb5]',
        'text-white',
        'border-[#1a2fb5]'
    );

    btn.classList.remove(
        'bg-white',
        'text-[#5a6080]',
        'border-[#d0d5e8]'
    );

    applyFilters();
}


function searchResearch()
{
    applyFilters();
}


function applyFilters()
{
    const keyword =
        document.getElementById('research-search')
            .value
            .toLowerCase()
            .trim();

    const cards =
        document.querySelectorAll('.research-card');

    cards.forEach(card => {

        const category =
            (card.dataset.cat || '')
            .toLowerCase();

        const title =
            (card.dataset.title || '')
            .toLowerCase();

        const author =
            (card.dataset.author || '')
            .toLowerCase();

        const categoryMatch =
            currentCategory === 'all' ||
            category.includes(currentCategory.toLowerCase());

        const searchMatch =
            keyword === '' ||
            title.includes(keyword) ||
            author.includes(keyword) ||
            category.includes(keyword);

        if(categoryMatch && searchMatch)
        {
            card.style.display = '';
        }
        else
        {
            card.style.display = 'none';
        }

    });

    checkEmptyState();
}


function checkEmptyState()
{
    const cards =
        document.querySelectorAll('.research-card');

    let visible = 0;

    cards.forEach(card => {

        if(card.style.display !== 'none')
        {
            visible++;
        }

    });

    let emptyState =
        document.getElementById('research-empty');

    if(!emptyState)
    {
        emptyState = document.createElement('div');

        emptyState.id = 'research-empty';

        emptyState.className =
            'col-span-full text-center py-12 text-[#5a6080] hidden';

        emptyState.innerHTML =
            'Tidak ada laporan ditemukan.';

        document
            .getElementById('research-grid')
            .appendChild(emptyState);
    }

    if(visible === 0)
    {
        emptyState.classList.remove('hidden');
    }
    else
    {
        emptyState.classList.add('hidden');
    }
}


function closeModal(id)
{
    const modal =
        document.getElementById('modal-' + id);

    modal.classList.remove('open');

    setTimeout(() => {

        modal.classList.add('hidden');

    }, 250);
}


document.addEventListener('keydown', function(e){

    if(e.key === 'Escape')
    {
        closeModal('research');
    }

});

</script>
@endsection