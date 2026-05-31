@extends('layouts.app')

@section('title', 'Gallery')

@section('content')

{{-- HERO --}}
<section class="bg-gradient-to-br from-[#0d1a6e] via-[#1e38cc] to-[#2d4ee0] pt-[100px] pb-[60px] text-white relative overflow-hidden mt-[68px]">

    <div class="max-w-[1200px] mx-auto px-10 relative z-[2]">

        <div class="inline-flex items-center gap-2 bg-white/[.12] border border-white/20 text-white/90 px-4 py-1.5 rounded-full text-[0.72rem] font-bold tracking-[0.07em] uppercase mb-[18px]">
            📸 Dokumentasi
        </div>

        <h1 class="text-[clamp(2.2rem,4vw,3.4rem)] font-medium leading-[1.1] mb-3.5">
            Gallery
        </h1>

        <p class="text-[0.96rem] text-white/65 leading-[1.75] max-w-[560px]">
            Memories from our past events.
        </p>

    </div>

</section>

{{-- GALLERY --}}
<section class="bg-[#f7f8fc] py-20 pb-24">

    <div class="max-w-[1200px] mx-auto px-10">

        {{-- FILTER --}}
        <div class="flex flex-wrap gap-2 mb-9 relative z-50">

            <button
                type="button"
                class="gfilter-btn active"
                data-filter="all"
            >
                Semua
            </button>

            <button
                type="button"
                class="gfilter-btn"
                data-filter="investalk"
            >
                Investalk
            </button>

            <button
                type="button"
                class="gfilter-btn"
                data-filter="sekolah"
            >
                Sekolah PM
            </button>

            <button
                type="button"
                class="gfilter-btn"
                data-filter="company"
            >
                Company Visit
            </button>

            <button
                type="button"
                class="gfilter-btn"
                data-filter="kompetisi"
            >
                Kompetisi
            </button>

            <button
                type="button"
                class="gfilter-btn"
                data-filter="internal"
            >
                Internal
            </button>

        </div>

        {{-- GALLERY GRID --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

            @forelse($galleries as $gallery)
                <div
                    class="gallery-item cursor-pointer"
                    data-category="{{ strtolower(trim($gallery->kategori)) }}"
                    onclick="openLightbox('{{ asset($gallery->foto_link) }}', '{{ $gallery->judul }}')"
                >
                    <div class="relative overflow-hidden rounded-[18px] bg-white border border-[#d0d5e8] shadow-sm">
                        <img
                            src="{{ asset($gallery->foto_link) }}"
                            alt="{{ $gallery->judul }}"
                            class="w-full h-[320px] object-cover transition duration-300 hover:scale-[1.03]"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 hover:opacity-100 transition duration-300 flex items-end p-4">
                            <div>
                                <div class="text-white text-[0.88rem] font-bold">
                                    {{ $gallery->judul }}
                                </div>
                                <div class="text-white/70 text-[0.72rem] mt-1">
                                    {{ $gallery->fotografer ?: 'Dokumentasi' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-1 sm:col-span-2 lg:col-span-3 rounded-[18px] border border-dashed border-gray-300 bg-white p-10 text-center text-gray-500">
                    Belum ada foto gallery. Kunjungi admin untuk menambahkan dokumentasi.
                </div>
            @endforelse

        </div>

    </div>

</section>

{{-- LIGHTBOX --}}
<div
    class="fixed inset-0 bg-black/90 z-[999] hidden items-center justify-center p-5"
    id="lightbox"
>

    <button
        class="absolute top-5 right-5 text-white text-3xl"
        onclick="closeLightbox()"
    >
        ✕
    </button>

    <div class="max-w-[900px] w-full">

        <img
            src=""
            id="lightbox-image"
            class="w-full rounded-2xl max-h-[85vh] object-contain"
        >

        <div
            class="text-white text-center mt-4 text-sm"
            id="lightbox-title"
        >
        </div>

    </div>

</div>

@endsection


@section('styles')

<style>

.gallery-item.hidden {
    display: none !important;
}

.gfilter-btn{
    padding:7px 18px;
    border-radius:10px;
    font-size:0.82rem;
    font-weight:600;
    border:1px solid #d0d5e8;
    background:white;
    color:#5a6080;
    cursor:pointer;
    transition:all .25s ease;
}

.gfilter-btn:hover{
    border-color:#1a2fb5;
    color:#1a2fb5;
}

.gfilter-btn.active{
    background:#1a2fb5 !important;
    color:white !important;
    border-color:#1a2fb5 !important;
}

</style>

@endsection


@section('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const filterButtons = document.querySelectorAll('.gfilter-btn');
    const galleryItems = document.querySelectorAll('.gallery-item');

    filterButtons.forEach(button => {

        button.addEventListener('click', function () {

            // RESET BUTTON
            filterButtons.forEach(btn => {
                btn.classList.remove('active');
            });

            // ACTIVE BUTTON
            this.classList.add('active');

            // FILTER VALUE
            const filter = this.dataset.filter;

            // FILTER ITEMS
            galleryItems.forEach(item => {

                const category = item.dataset.category;

                if (filter === 'all' || category === filter) {

                    item.classList.remove('hidden');

                } else {

                    item.classList.add('hidden');

                }

            });

        });

    });

});


function openLightbox(image, title) {

    document.getElementById('lightbox-image').src = image;

    document.getElementById('lightbox-title').innerText = title;

    document.getElementById('lightbox').classList.remove('hidden');

    document.getElementById('lightbox').classList.add('flex');

    document.body.style.overflow = 'hidden';

}


function closeLightbox() {

    document.getElementById('lightbox').classList.remove('flex');

    document.getElementById('lightbox').classList.add('hidden');

    document.body.style.overflow = '';

}

</script>

@endsection