@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    body {
        background-color: #f3f4f6;
    }

    body, * {
        font-family: 'Poppins', sans-serif;
    }

    .card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .row-item {
        border-bottom: 1px solid #e5e7eb;
        padding: 12px 0;
    }

    .label {
        font-weight: 600;
        color: #374151;
    }

    .value {
        color: #1f2937;
    }

    .badge {
        padding: 4px 10px;
        border-radius: 9999px;
        font-size: 11px;
        color: white;
    }
</style>

<div class="space-y-6 p-6">

    <!-- BREADCRUMB -->
    <div class="bg-white shadow rounded px-4 py-3 text-sm text-gray-500">
        <a href="{{ route('beranda') }}" class="text-gray-700 hover:underline">
            Beranda
        </a>
        <span class="mx-2">></span>
        <span class="text-gray-700 font-medium">Detail Berita</span>
    </div>

    <!-- CARD UTAMA -->
    <div class="card p-6">

        <!-- ✅ JUDUL DI DALAM CARD -->
        <h2 class="text-2xl font-bold text-[#064469] mb-4 border-b pb-2">
            Detail Berita
        </h2>

        <div class="grid grid-cols-4 gap-4 items-center row-item">
            <div class="label">Tanggal</div>
            <div class="col-span-3 value">
                : {{ \Carbon\Carbon::parse($berita->tanggal)->format('d/m/Y') }}
            </div>
        </div>

        <div class="grid grid-cols-4 gap-4 items-center row-item">
            <div class="label">Judul Berita</div>
            <div class="col-span-3 value">
                : {{ $berita->judul }}
            </div>
        </div>

        <div class="grid grid-cols-4 gap-4 items-center row-item">
            <div class="label">Media Berita</div>
            <div class="col-span-3 value">
                : {{ $berita->media }}
            </div>
        </div>

        <div class="grid grid-cols-4 gap-4 items-center row-item">
            <div class="label">Kategori Berita</div>
            <div class="col-span-3">
                :
                <span class="badge {{ $berita->kategori == 'Regional' ? 'bg-blue-500' : 'bg-green-500' }}">
                    {{ $berita->kategori }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-4 gap-4 items-center row-item">
            <div class="label">Sentimen Berita</div>
            <div class="col-span-3">
                :
                <span class="badge
                    @if($berita->sentimen == 'Positif') bg-green-500
                    @elseif($berita->sentimen == 'Negatif') bg-red-500
                    @else bg-gray-500 @endif">
                    {{ $berita->sentimen ?? 'Netral' }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-4 gap-4 row-item">
            <div class="label">Ringkasan Berita</div>
            <div class="col-span-3 value">
                : {{ $berita->ringkasan ?? '-' }}
            </div>
        </div>

        <!-- GAMBAR -->
        <div class="grid grid-cols-4 gap-4 py-4">
            <div class="label">Gambar Berita</div>

            <div class="col-span-3">
                :
                @if($berita->gambar)
                    <img src="{{ asset('storage/'.$berita->gambar) }}"
                         onclick="showImage(this.src)"
                         class="mt-3 w-44 rounded-lg shadow-sm border cursor-pointer hover:opacity-80 transition">
                @else
                    <span class="text-gray-400">-</span>
                @endif
            </div>
        </div>

        <!-- BUTTON -->
        <div class="mt-6 flex justify-between">
            <a href="{{ route('beranda') }}"
               class="bg-[#064469] text-white px-4 py-2 rounded-lg hover:bg-[#053554]">
                Kembali
            </a>
        </div>

    </div>

</div>

<!-- MODAL -->
<div id="imageModal" style="display:none;"
    class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50">

    <span onclick="closeImage()"
        class="absolute top-5 right-5 text-white text-3xl cursor-pointer">&times;</span>

    <img id="previewImage" class="max-w-3xl max-h-[80vh] rounded shadow">
</div>

<script>
function showImage(src) {
    document.getElementById("previewImage").src = src;
    document.getElementById("imageModal").style.display = "flex";
}

function closeImage() {
    document.getElementById("imageModal").style.display = "none";
}

document.addEventListener("click", function(e) {
    if (e.target.id === "imageModal") {
        closeImage();
    }
});
</script>

@endsection