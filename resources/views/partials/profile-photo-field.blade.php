<div class="mb-5 flex items-center gap-4 flex-wrap">
    <button type="button" class="profile-avatar-preview w-20 h-20 rounded-full bg-gradient-to-br from-blue-600 to-blue-400 text-white flex items-center justify-center font-bold text-xl overflow-hidden shrink-0 cursor-pointer" onclick="openPhotoViewer()">
        @if(auth()->user()->profile_photo_url)
            <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover" id="current-profile-photo">
        @else
            <span>{{ auth()->user()->initials }}</span>
        @endif
    </button>
    <div class="flex-1 min-w-[220px]">
        <label class="block text-xs font-semibold text-gray-500 mb-1">Foto Profil</label>
        <input class="inp w-full" type="file" name="profile_photo" id="profile-photo-input" accept="image/jpeg,image/png,image/jpg,image/webp">
        <input type="hidden" name="cropped_profile_photo" id="cropped-profile-photo">
        <div class="text-[0.72rem] text-gray-500 mt-1">Pilih foto, lalu atur posisi kotak profil sebelum disimpan. Format JPG, PNG, atau WebP. Maksimal 2MB.</div>
        @if(auth()->user()->profile_photo)
            <label class="inline-flex items-center gap-2 mt-2 text-xs font-semibold text-red-600">
                <input type="checkbox" name="remove_profile_photo" value="1">
                Hapus foto profil saat ini
            </label>
        @endif
    </div>
</div>

<div class="profile-modal fixed inset-0 bg-black/60 z-50 hidden items-center justify-center p-4" id="profile-crop-modal">
    <div class="bg-white rounded-2xl p-6 w-full max-w-lg shadow-xl">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-gray-200">
            <div class="font-bold text-gray-900">Atur Foto Profil</div>
            <button type="button" class="w-8 h-8 rounded-lg bg-gray-100 text-gray-500 hover:bg-red-100 hover:text-red-600" onclick="closeProfileCrop()">x</button>
        </div>
        <div class="crop-stage mx-auto" id="crop-stage">
            <img id="crop-image" alt="Preview foto profil">
            <div class="crop-mask"></div>
            <div class="crop-box"></div>
        </div>
        <div class="mt-4">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Zoom</label>
            <input type="range" min="1" max="3" step="0.01" value="1" id="crop-zoom" class="w-full">
        </div>
        <div class="mt-5 flex justify-end gap-2">
            <button type="button" class="btn btn-ghost" onclick="closeProfileCrop()">Batal</button>
            <button type="button" class="btn btn-primary" onclick="applyProfileCrop()">Gunakan Foto</button>
        </div>
    </div>
</div>

<div class="profile-modal fixed inset-0 bg-black/70 z-50 hidden items-center justify-center p-4" id="profile-view-modal" onclick="closePhotoViewer(event)">
    <div class="bg-white rounded-2xl p-4 w-full max-w-md shadow-xl" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between mb-3">
            <div class="font-bold text-gray-900">Foto Profil</div>
            <button type="button" class="w-8 h-8 rounded-lg bg-gray-100 text-gray-500 hover:bg-red-100 hover:text-red-600" onclick="closePhotoViewer()">x</button>
        </div>
        <div class="aspect-square rounded-xl overflow-hidden bg-blue-50 flex items-center justify-center text-blue-700 text-5xl font-bold">
            @if(auth()->user()->profile_photo_url)
                <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
            @else
                {{ auth()->user()->initials }}
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
.profile-modal.open{display:flex!important}
.crop-stage{width:min(360px,82vw);height:min(360px,82vw);position:relative;overflow:hidden;background:#111;border-radius:14px;touch-action:none;cursor:grab;user-select:none}
.crop-stage.dragging{cursor:grabbing}
.crop-stage img{position:absolute;left:0;top:0;user-select:none;max-width:none;z-index:1;pointer-events:none}
.crop-mask{position:absolute;inset:0;background:radial-gradient(circle at center,transparent 0 49%,rgba(0,0,0,.5) 50% 100%);pointer-events:none;z-index:2}
.crop-box{position:absolute;inset:12.5%;border:2px solid #fff;border-radius:50%;pointer-events:none;z-index:3}
.profile-avatar-preview:hover{box-shadow:0 10px 24px rgba(26,47,181,.18)}
</style>
@endpush

@push('scripts')
<script>
(() => {
    const input  = document.getElementById('profile-photo-input');
    const hidden = document.getElementById('cropped-profile-photo');
    const modal  = document.getElementById('profile-crop-modal');
    const stage  = document.getElementById('crop-stage');
    const image  = document.getElementById('crop-image');
    const zoom   = document.getElementById('crop-zoom');

    let naturalWidth = 0, naturalHeight = 0;
    let baseScale = 1, scale = 1;
    let pos  = { x: 0, y: 0 };
    let drag = null;
    let currentDataUrl = '';

    if (!input || !hidden || !modal || !stage || !image || !zoom) return;

    // ── Lock / unlock body scroll ──────────────────────────────────────
    document.body.appendChild(modal);
    document.body.appendChild(document.getElementById('profile-view-modal'));
    function lockScroll()   { document.body.style.overflow = 'hidden'; }
    function unlockScroll() { document.body.style.overflow = '';       }

    // ── File input → buka modal ────────────────────────────────────────
    input.addEventListener('change', () => {
        const file = input.files && input.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = e => {
            currentDataUrl = e.target.result;
            image.onload = () => {
                naturalWidth  = image.naturalWidth;
                naturalHeight = image.naturalHeight;
                zoom.value    = 1;
                modal.classList.add('open');
                lockScroll();
                requestAnimationFrame(() => requestAnimationFrame(resetCrop));
            };
            image.src = currentDataUrl;
        };
        reader.readAsDataURL(file);
    });

    // ── Zoom slider ────────────────────────────────────────────────────
    zoom.addEventListener('input', () => {
        scale = baseScale * Number(zoom.value);
        clampPosition();
        renderCrop();
    });

    // ── Drag — pointer events ──────────────────────────────────────────
    stage.addEventListener('pointerdown', e => {
        e.preventDefault();
        drag = { pointerId: e.pointerId, startX: e.clientX, startY: e.clientY, x: pos.x, y: pos.y };
        stage.setPointerCapture(e.pointerId);
        stage.classList.add('dragging');
    });

    stage.addEventListener('pointermove', e => {
        if (!drag || e.pointerId !== drag.pointerId) return;
        e.preventDefault();
        pos.x = drag.x + e.clientX - drag.startX;
        pos.y = drag.y + e.clientY - drag.startY;
        clampPosition();
        renderCrop();
    });

    stage.addEventListener('pointerup', e => {
        drag = null;
        stage.classList.remove('dragging');
    });
    stage.addEventListener('pointercancel', () => {
        drag = null;
        stage.classList.remove('dragging');
    });

    // Cegah scroll halaman saat pointer di atas stage
    stage.addEventListener('wheel', e => e.preventDefault(), { passive: false });

    // ── Helper functions ───────────────────────────────────────────────
    function resetCrop() {
        const stageSize = stage.clientWidth;
        const cropSize  = stageSize * 0.75;
        baseScale = Math.max(cropSize / naturalWidth, cropSize / naturalHeight);
        scale     = baseScale;
        pos.x = (stageSize - naturalWidth  * scale) / 2;
        pos.y = (stageSize - naturalHeight * scale) / 2;
        zoom.value = 1;
        renderCrop();
    }

    function clampPosition() {
        const stageSize = stage.clientWidth;
        const cropSize  = stageSize * 0.75;
        const cropStart = (stageSize - cropSize) / 2;
        const cropEnd   = cropStart + cropSize;
        pos.x = Math.min(cropStart, Math.max(cropEnd - naturalWidth  * scale, pos.x));
        pos.y = Math.min(cropStart, Math.max(cropEnd - naturalHeight * scale, pos.y));
    }

    function renderCrop() {
        image.style.left   = `${pos.x}px`;
        image.style.top    = `${pos.y}px`;
        image.style.width  = `${naturalWidth  * scale}px`;
        image.style.height = `${naturalHeight * scale}px`;
    }

    // ── Close / apply ──────────────────────────────────────────────────
    window.closeProfileCrop = function () {
        input.value    = '';
        hidden.value   = '';
        currentDataUrl = '';
        modal.classList.remove('open');
        unlockScroll();
    };

    window.applyProfileCrop = function () {
        const stageSize  = stage.clientWidth;
        const cropSize   = stageSize * 0.75;
        const cropStart  = (stageSize - cropSize) / 2;
        const sourceX    = Math.max(0, (cropStart - pos.x) / scale);
        const sourceY    = Math.max(0, (cropStart - pos.y) / scale);
        const sourceSize = cropSize / scale;

        const canvas  = document.createElement('canvas');
        canvas.width  = 512;
        canvas.height = 512;
        const ctx = canvas.getContext('2d');

        const freshImg  = new Image();
        freshImg.onload = function () {
            ctx.drawImage(freshImg, sourceX, sourceY, sourceSize, sourceSize, 0, 0, 512, 512);
            hidden.value = canvas.toDataURL('image/jpeg', 0.9);

            // Update avatar preview
            const avatar = document.querySelector('.profile-avatar-preview');
            if (avatar) {
                let img = avatar.querySelector('img') ;
                if (!img) {
                    avatar.innerHTML = '';
                    img = document.createElement('img');
                    img.className = 'w-full h-full object-cover';
                    avatar.appendChild(img);
                }
                img.src = hidden.value;
            }

            input.value    = '';
            currentDataUrl = '';
            modal.classList.remove('open');
            unlockScroll();
        };
        freshImg.onerror = () => {
            alert('Gagal memproses gambar, coba pilih ulang.');
            modal.classList.remove('open');
            unlockScroll();
        };
        freshImg.src = currentDataUrl;
    };

    // ── Photo viewer ───────────────────────────────────────────────────
    window.openPhotoViewer = function () {
        const viewModal = document.getElementById('profile-view-modal');
        const viewImg   = viewModal?.querySelector('.aspect-square img');
        const viewInit  = viewModal?.querySelector('.aspect-square');

        // Cek apakah ada preview crop sementara
        const tempSrc = hidden.value || 
                        (document.querySelector('.profile-avatar-preview img')?.src ?? '');

        if (viewImg && tempSrc && tempSrc.startsWith('data:')) {
            // Tampilkan preview crop sementara
            viewImg.src = tempSrc;
        }
        // Jika tidak ada preview, biarkan src asli dari server (tidak diubah)

        viewModal?.classList.add('open');
        lockScroll();
    };
    
    window.closePhotoViewer = function (e) {
        if (!e || e.target === document.getElementById('profile-view-modal')) {
            document.getElementById('profile-view-modal')?.classList.remove('open');
            unlockScroll();
        }
    };
})();
</script>
@endpush