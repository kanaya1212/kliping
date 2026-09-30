@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Poppins', sans-serif;
    }

    .card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .table-header {
        background: #f3f4f6;
    }

    .table-row:hover {
        background: #f9fafb;
    }

    .badge {
        padding: 4px 10px;
        border-radius: 9999px;
        font-size: 11px;
        color: white;
    }
</style>

<style>
nav[role="navigation"] {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
nav[role="navigation"] a,
nav[role="navigation"] span {
    background-color: #064469 !important;
    color: white !important;
    padding: 5px 10px;
    border-radius: 6px;
    font-size: 12px;
    border: none !important;
    min-width: 30px;
    text-align: center;
}
nav[role="navigation"] a:hover {
    opacity: 0.85;
}
nav[role="navigation"] span[aria-disabled="true"] {
    opacity: 0.5;
    cursor: not-allowed;
}
nav[role="navigation"] svg {
    width: 12px;
    height: 12px;
    color: white !important;
}
nav[role="navigation"] div {
    background: transparent !important;
}
nav[role="navigation"] .sm\:flex {
    width: 100%;
    justify-content: space-between;
}
</style>

<div class="space-y-6 p-6" style="font-family: 'Poppins', sans-serif;">

    <!-- ================= HEADER ================= -->
    <div>
        <h2 class="text-2xl font-bold text-[#064469]">
            Beranda
        </h2>
    </div>

    <!-- ================= WELCOME ================= -->
    <div class="card p-5 flex items-center gap-4">

        <img src="{{ asset('icons/icon_beranda2.png') }}" class="w-30 h-16">

        <div>
            <h3 class="font-semibold text-gray-800">
                Selamat datang kembali {{ auth()->user()->name }} di E-KLIPING
            </h3>

            <p class="text-gray-500 text-sm mt-1">
                E-Kliping merupakan aplikasi kliping berita berita koran digital  yang digunakan untuk mengelola dan menyimpan berita dari berbagai media
                koran secara terstruktur, sehingga memudahkan pencarian, pemantauan, dan penyajian informasi secara cepat.
            </p>
        </div>

    </div>

    <!-- ================= STATISTIK ================= -->
    <h2 class="text-2xl font-bold text-[#064469]">Statistik</h2>

    <div class="grid grid-cols-4 gap-4">

        <div class="card p-5 text-center">
            <h1 class="text-3xl font-bold text-[#064469]">{{ $hari_ini ?? 0 }}</h1>
            <p class="text-gray-500 mt-2">Kliping Hari Ini</p>
        </div>

        <div class="card p-5 text-center">
            <h1 class="text-3xl font-bold text-[#064469]">{{ $minggu_ini ?? 0 }}</h1>
            <p class="text-gray-500 mt-2">Kliping Minggu Ini</p>
        </div>

        <div class="card p-5 text-center">
            <h1 class="text-3xl font-bold text-[#064469]">{{ $bulan_ini ?? 0 }}</h1>
            <p class="text-gray-500 mt-2">Kliping Bulan Ini</p>
        </div>

        <div class="card p-5 text-center">
            <h1 class="text-3xl font-bold text-[#064469]">{{ $tahun_ini ?? 0 }}</h1>
            <p class="text-gray-500 mt-2">Kliping Pertahun</p>
        </div>

    </div>

    <!-- ================= DAFTAR BERITA ================= -->
    <div class="card p-4">

        <h2 class="text-2xl font-bold text-[#064469] mb-4 border-b pb-2">
            Daftar Berita
        </h2>

        <table class="w-full text-sm">

    <thead class="table-header">
        <tr class="text-left">
            <th class="p-3">No</th>
            <th class="p-3">Tanggal</th>
            <th class="p-3">Judul Berita</th>
            <th class="p-3">Media</th>
            <th class="p-3">Kategori</th>
            <th class="p-3">Sentimen</th>
            <th class="p-3 text-center">Gambar</th>
            <th class="p-3">Ringkasan</th>
            <th class="p-3 text-center">Aksi</th>
        </tr>
    </thead>

    <tbody>
        @forelse($beritas as $b)
        <tr class="border-b table-row">

            <td class="p-3">{{ $beritas->firstItem() + $loop->index }}</td>

            <td class="p-3">
                {{ \Carbon\Carbon::parse($b->tanggal)->format('d/m/Y') }}
            </td>

            <td class="p-3">{{ $b->judul }}</td>

            <td class="p-3">{{ $b->media }}</td>

            <td class="p-3">
                <span class="badge {{ $b->kategori == 'Regional' ? 'bg-blue-500' : 'bg-green-500' }}">
                    {{ $b->kategori }}
                </span>
            </td>

            <td class="p-3">
                <span class="badge
                    @if($b->sentimen == 'Positif') bg-green-500
                    @elseif($b->sentimen == 'Negatif') bg-red-500
                    @else bg-gray-500 @endif">
                    {{ $b->sentimen ?? 'Netral' }}
                </span>
            </td>

            <td class="p-3 text-center">
                @if($b->gambar)
                    <img src="{{ asset('storage/'.$b->gambar) }}"
                        class="w-12 h-12 object-cover mx-auto rounded cursor-pointer preview-img">
                @else
                    <img src="https://via.placeholder.com/50"
                        class="w-12 h-12 object-cover mx-auto rounded opacity-50">
                @endif
            </td>

            <td class="p-3 max-w-[200px]">
                {{ \Illuminate\Support\Str::limit($b->ringkasan, 80) }}
            </td>

            <td class="p-3 text-center">
                <a href="{{ route('berita.show', $b->id) }}"
                class="px-3 py-1 bg-[#064469] text-white rounded text-xs hover:opacity-90">
                    Detail
                </a>
            </td>

        </tr>
        @empty
        <tr>
            <td colspan="9" class="text-center p-4 text-gray-500">
                Belum ada data berita
            </td>
        </tr>
        @endforelse
    </tbody>

</table>

<div class="mt-4">
    {{ $beritas->links() }}
</div>

    </div>

</div>

<!-- MODAL GAMBAR -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50">
    <img id="modalImage" class="max-w-[90%] max-h-[90%] rounded shadow-lg">
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImage');

    document.querySelectorAll('.preview-img').forEach(img => {
        img.addEventListener('click', function () {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            modalImg.src = this.src;
        });
    });

    modal.addEventListener('click', function () {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    });

});
</script>

@endsection