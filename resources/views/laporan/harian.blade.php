@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<div class="space-y-6" style="font-family: 'Poppins', sans-serif;">

    <!-- HEADER -->
    <div>
        <h2 class="text-2xl font-bold text-[#064469]">
            Laporan Kliping Harian
        </h2>
        <p class="text-gray-500">
            Rekapitulasi monitoring berita koran per hari
        </p>
    </div>

    <!-- FILTER (HANYA TANGGAL) -->
    <div class="bg-white rounded-xl shadow p-4">
        <form method="GET" class="flex items-center gap-3">

            <input type="date" name="tanggal"
                value="{{ request('tanggal') }}"
                onchange="this.form.submit()"
                class="px-4 h-11 rounded-lg border border-gray-300">

            @if(request('tanggal'))
           <a href="{{ route('laporan.harian.download', request('tanggal')) }}"
            class="ml-auto flex items-center gap-2 border-2 border-[#064469] text-[#064469] px-4 py-2 rounded-xl bg-white hover:bg-[#064469] hover:text-white transition-all duration-300">

                <img src="{{ asset('icons/icon_unduh.png') }}"
                    class="w-5 h-5">

                <span>Unduh Semua Laporan</span>

            </a>
            @endif

        </form>
    </div>

    <!-- TABLE -->
    @if(request('tanggal'))

    <div class="bg-white rounded-xl shadow p-4">

        <h3 class="text-lg font-semibold text-[#064469] mb-4 border-b pb-2">
            Hasil Laporan Tanggal {{ \Carbon\Carbon::parse(request('tanggal'))->format('d/m/Y') }}
        </h3>

        <table class="w-full text-sm">

            <thead class="bg-gray-100">
                <tr class="text-left">
                    <th class="p-3">No</th>
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">Judul</th>
                    <th class="p-3">Media</th>
                    <th class="p-3">Kategori</th>
                    <th class="p-3">Sentimen</th>
                    <th class="p-3">Gambar</th>
                    <th class="p-3">Ringkasan</th>
                </tr>
            </thead>

            <tbody>
                @forelse($beritas as $b)
                <tr class="border-b hover:bg-gray-50">

                    <td class="p-3">{{ $loop->iteration }}</td>

                    <td class="p-3">
                        {{ \Carbon\Carbon::parse($b->tanggal)->format('d/m/Y') }}
                    </td>

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

                    <td class="p-3">
                        @if($b->gambar)
                            <img src="{{ asset('storage/'.$b->gambar) }}"
                                class="w-14 h-14 object-cover rounded cursor-pointer preview-img">
                        @else
                            -
                        @endif
                    </td>

                    <td class="p-3 max-w-[250px]">
                        {{ \Illuminate\Support\Str::limit($b->ringkasan, 100) }}
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center p-4 text-gray-500">
                        Tidak ada data
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>

    </div>

    @endif

</div>

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