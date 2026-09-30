@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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


<div class="space-y-6" style="font-family: 'Poppins', sans-serif;">

@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon: null,
        title: 'Berhasil!',
        text: @json(session('success')),
        showConfirmButton: false,
        timer: 2000
    });
});
</script>
@endif

<!-- FILTER -->
<div class="bg-white rounded-xl shadow p-4">
    <div class="flex justify-between items-center">

        <form method="GET" class="flex items-center gap-3">

            <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                onchange="this.form.submit()"
                class="px-4 h-11 rounded-lg border border-gray-300">

            <select name="sentimen"
                onchange="this.form.submit()"
                class="px-7 h-11 rounded-lg border border-gray-300">

                <option value="">Semua Sentimen</option>
                <option value="Positif" {{ request('sentimen') == 'Positif' ? 'selected' : '' }}>Positif</option>
                <option value="Negatif" {{ request('sentimen') == 'Negatif' ? 'selected' : '' }}>Negatif</option>
                <option value="Netral" {{ request('sentimen') == 'Netral' ? 'selected' : '' }}>Netral</option>
            </select>

            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Search..."
                class="px-4 h-11 w-64 rounded-lg border border-gray-300">

            <button class="px-5 h-11 rounded-lg bg-gray-200 hover:bg-gray-300">
                Cari
            </button>

        </form>

        <a href="{{ route('berita.create') }}"
           class="bg-[#064469] text-white px-4 py-2 rounded-lg">
            + Tambah Berita
        </a>

    </div>
</div>

<!-- TABLE -->
<div class="bg-white rounded-xl shadow p-4">

    <h2 class="text-2xl font-bold text-[#064469] mb-4 border-b pb-2">
        Daftar Berita
    </h2>

    <table class="w-full text-sm">

        <thead class="bg-gray-100">
        <tr class="text-left">
            <th class="p-3">No</th>
            <th class="p-3">Tanggal</th>
            <th class="p-3">Judul</th>
            <th class="p-3">Media</th>
            <th class="p-3">Kategori</th>
            <th class="p-3">Sentimen</th>
            <th class="p-3 text-center">Gambar</th>
            <th class="p-3">Ringkasan</th>
            <th class="p-3 text-center w-32">Aksi</th>
        </tr>
        </thead>

        <tbody>
        @forelse($beritas as $b)
        <tr class="border-b hover:bg-gray-50">

            <td class="p-3">
                {{ ($beritas->currentPage() - 1) * $beritas->perPage() + $loop->iteration }}
            </td>

            <td class="p-3">{{ \Carbon\Carbon::parse($b->tanggal)->format('d/m/Y') }}</td>

            <td class="p-3">{{ $b->judul }}</td>

            <td class="p-3">{{ $b->media }}</td>

            <td class="p-3">
                <span class="px-3 py-1 rounded-full text-white text-xs
                    {{ $b->kategori == 'Regional' ? 'bg-blue-500' : 'bg-green-500' }}">
                    {{ $b->kategori }}
                </span>
            </td>

            <td class="p-3">
                <span class="px-3 py-1 rounded-full text-white text-xs
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
                    -
                @endif
            </td>

            <td class="p-3 max-w-[250px]">
                {{ \Illuminate\Support\Str::limit($b->ringkasan, 100) }}
            </td>

            <td class="p-3 text-center">
                <div class="inline-flex gap-2">

                    <!-- UNDUH PDF -->
                    <a href="{{ route('berita.export.pdf', $b->id) }}"
                       class="w-10 h-10 flex items-center justify-center rounded bg-green-50 hover:bg-green-100">
                        <img src="{{ asset('icons/icon_unduh.png') }}" class="w-6 h-6">
                    </a>

                    <!-- EDIT -->
                    <a href="{{ route('berita.edit', $b->id) }}"
                       class="w-10 h-10 flex items-center justify-center rounded bg-blue-50 hover:bg-blue-100">
                        <img src="{{ asset('icons/icon_edit.png') }}" class="w-6 h-6">
                    </a>

                    <!-- DELETE -->
                    <form action="{{ route('berita.delete', $b->id) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="button"
                            class="btn-hapus w-10 h-10 flex items-center justify-center rounded bg-red-50 hover:bg-red-100">
                            <img src="{{ asset('icons/icon_sampah.png') }}" class="w-6 h-6">
                        </button>
                    </form>

                </div>
            </td>

        </tr>
        @empty
        <tr>
            <td colspan="9" class="text-center p-4 text-gray-500">
                Data belum ada
            </td>
        </tr>
        @endforelse
        </tbody>

    </table>

    <div class="mt-4">
        {{ $beritas->withQueryString()->links('pagination::tailwind') }}
    </div>

</div>

</div>

<!-- MODAL -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50">
    <img id="modalImage" class="max-w-[90%] max-h-[90%] rounded shadow-lg">
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // HAPUS
    document.querySelectorAll('.btn-hapus').forEach(button => {
        button.addEventListener('click', function () {
            let form = this.closest('form');

            Swal.fire({
                title: 'Apakah Anda Yakin hapus?',
                text: "Data tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#064469',
                cancelButtonColor: '#DD1111',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // ZOOM GAMBAR
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