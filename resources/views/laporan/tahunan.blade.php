@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<div class="space-y-6" style="font-family: 'Poppins', sans-serif;">

    <div>
        <h2 class="text-2xl font-bold text-[#064469]">
            Laporan Kliping Tahunan
        </h2>
        <p class="text-gray-500">
            Rekapitulasi monitoring berita koran per tahun
        </p>
    </div>

    <!-- FILTER -->
    <div class="bg-white rounded-xl shadow p-4">
        <form method="GET" id="filterForm" class="flex items-center gap-3">

            <input 
                type="number" 
                name="tahun"
                id="tahunInput"
                value="{{ request('tahun') }}"
                placeholder="Masukkan Tahun"
                class="px-1 h-11 rounded-lg border border-gray-300 w-40">

            @if(request('tahun'))
            <a href="{{ route('laporan.tahunan.download', ['tahun' => request('tahun')]) }}"
               class="ml-auto flex items-center gap-2 border-2 border-[#064469] text-[#064469] px-4 py-2 rounded-xl bg-white hover:bg-[#064469] hover:text-white transition">

                <img src="{{ asset('icons/icon_unduh.png') }}" class="w-5 h-5">
                <span>Unduh Semua Laporan</span>
            </a>
            @endif

        </form>
    </div>

    @if(request('tahun'))

    <div class="bg-white rounded-xl shadow p-4">

        <h3 class="text-lg font-semibold text-[#064469] mb-4 border-b pb-2">
            Hasil Laporan Tahun {{ $tahun }}
        </h3>

        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
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
                                 onclick="openModal(this.src)"
                                 class="w-14 h-14 object-cover rounded cursor-pointer">
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

<!-- AUTO SUBMIT TANPA ENTER -->
<script>
    let debounceTimer;

    document.getElementById('tahunInput').addEventListener('input', function () {

        clearTimeout(debounceTimer);

        debounceTimer = setTimeout(() => {
            document.getElementById('filterForm').submit();
        }, 1000);

    });
</script>

@endsection