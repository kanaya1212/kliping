@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- 🔥 CUSTOM PAGINATION COLOR -->
<style>
    /* WRAPPER */
    nav[role="navigation"] {
        display: flex;
        justify-content: flex-end;
        gap: 4px;
    }

    /* SEMUA BUTTON (ANGKA + PANAH) */
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

    /* HOVER */
    nav[role="navigation"] a:hover {
        opacity: 0.85;
    }

    /* DISABLED (prev di halaman pertama) */
    nav[role="navigation"] span[aria-disabled="true"] {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* ICON PANAH */
    nav[role="navigation"] svg {
        width: 12px;
        height: 12px;  
        color: white !important;
    }

    /* 🔥 HAPUS WARNA ABU BAWAAN TAILWIND */
    nav[role="navigation"] div {
        background: transparent !important;
    }
</style>

<div class="p-6 bg-gray-100 min-h-screen" style="font-family: 'Poppins', sans-serif;">

    <!-- ================= STATISTIK ================= -->
    <h2 class="text-2xl font-bold text-[#064469] mb-4">Statistik</h2>

    <div class="grid grid-cols-4 gap-4 mb-6">

        <div class="bg-white p-6 rounded-xl shadow text-center">
            <h1 class="text-3xl font-bold text-[#064469]">{{ $total }}</h1>
            <p class="text-gray-500 mt-2">Total Koran</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow text-center">
            <h1 class="text-3xl font-bold text-[#064469]">{{ $aktif }}</h1>
            <p class="text-gray-500 mt-2">Koran Aktif</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow text-center">
            <h1 class="text-3xl font-bold text-[#064469]">{{ $nasional }}</h1>
            <p class="text-gray-500 mt-2">Koran Nasional</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow text-center">
            <h1 class="text-3xl font-bold text-[#064469]">{{ $regional }}</h1>
            <p class="text-gray-500 mt-2">Koran Regional</p>
        </div>

    </div>

    <!-- ================= FILTER ================= -->
    <div class="bg-white p-4 rounded-xl shadow mb-6">

        <div class="flex justify-between items-center">

            <form method="GET" action="/koran" class="flex items-center gap-3">

                <div class="relative">
                    <select name="status"
                        onchange="this.form.submit()"
                        class="appearance-none px-4 pr-10 h-11 rounded-lg border border-gray-300 bg-white text-gray-700
                               focus:outline-none focus:ring-2 focus:ring-[#064469]">

                        <option value="">Semua Status</option>
                        <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Tidak Aktif" {{ request('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>

                    </select>

                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-4 h-4 text-gray-500"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>

                <input type="text" name="search"
                    value="{{ request('search') }}"
                    placeholder="Search media / penerbit"
                    class="px-4 h-11 w-64 rounded-lg border border-gray-300
                           focus:outline-none focus:ring-2 focus:ring-[#064469]">

                <button class="px-5 h-11 rounded-lg bg-gray-200 hover:bg-gray-300">
                    Cari
                </button>

            </form>

            <a href="/koran/create"
               class="bg-[#064469] text-white px-4 py-2 rounded-lg">
                + Tambah Koran
            </a>

        </div>

    </div>

    <!-- ================= TABLE ================= -->
    <div class="bg-white rounded-xl shadow p-4">

        <h2 class="text-2xl font-bold text-[#064469] mb-4 border-b pb-2">
            Daftar Data Koran
        </h2>

        <table class="w-full text-sm">

            <thead class="bg-gray-100">
                <tr class="text-left">
                    <th class="p-3">No</th>
                    <th class="p-3">Media</th>
                    <th class="p-3">Penerbit</th>
                    <th class="p-3">Kategori</th>
                    <th class="p-3">Status</th>
                    <th class="p-3 text-center w-32">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($korans as $k)
                <tr class="border-b hover:bg-gray-50">

                    <td class="p-3">
                        {{ ($korans->currentPage() - 1) * $korans->perPage() + $loop->iteration }}
                    </td>

                    <td class="p-3">{{ $k->media }}</td>
                    <td class="p-3">{{ $k->penerbit }}</td>

                    <td class="p-3">
                        <span class="px-3 py-1 rounded-full text-white text-xs
                            {{ $k->kategori == 'Nasional' ? 'bg-green-500' : 'bg-blue-500' }}">
                            {{ $k->kategori }}
                        </span>
                    </td>

                    <td class="p-3">
                        <span class="px-3 py-1 rounded-full text-white text-xs
                            {{ $k->status == 'Aktif' ? 'bg-green-600' : 'bg-red-500' }}">
                            {{ $k->status }}
                        </span>
                    </td>

                    <td class="p-3 text-center">
                        <div class="inline-flex items-center gap-2">

                            <a href="/koran/edit/{{ $k->id }}"
                            class="w-10 h-10 flex items-center justify-center rounded bg-blue-50 hover:bg-blue-100">
                                <img src="{{ asset('icons/icon_edit.png') }}" class="w-6 h-6">
                            </a>

                            <form action="{{ route('koran.destroy', $k->id) }}" method="POST">
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
                    <td colspan="6" class="text-center p-4 text-gray-500">
                        Data belum ada
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>

        <!-- 🔥 PAGINATION -->
        <div class="mt-4">
            {{ $korans->links('pagination::tailwind') }}
        </div>

    </div>

</div>

<script>
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
</script>
@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: @json(session('success')),
        showConfirmButton: false,
        timer: 2000
    });
});
</script>
@endif

@endsection