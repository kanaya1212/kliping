@extends('layouts.app')

@section('content')

<!-- FONT POPPINS -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- SELECT2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
.select2-container .select2-selection--multiple {
    min-height: 48px !important;
    border: 1px solid #e5e7eb !important;
    border-radius: 0.375rem !important;
    padding: 6px 12px !important;
}

.select2-container--default .select2-selection--multiple .select2-selection__rendered {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 4px;
}

.select2-container--default.select2-container--focus .select2-selection--multiple {
    border-color: #064469 !important;
    box-shadow: 0 0 0 2px rgba(6, 68, 105, 0.2);
}

.select2-container--default .select2-search--inline .select2-search__field {
    margin-top: 4px;
}
</style>

<div class="p-6" style="font-family: 'Poppins', sans-serif;">

    <!-- Breadcrumb -->
    <div class="bg-white shadow rounded px-4 py-3 text-sm text-gray-500 mb-6">
        <a href="{{ route('berita.index') }}" class="text-gray-700 hover:underline">
            Berita
        </a>
        <span class="mx-2">></span>
        <span class="text-gray-700 font-medium">Tambah Berita</span>
    </div>

    <!-- Card -->
    <div class="bg-white shadow rounded-xl p-8">

        <!-- Title -->
        <h2 class="text-2xl font-bold text-[#064469] mb-6 border-b pb-2">
            Tambah Berita
        </h2>

        {{-- SUCCESS --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('berita.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- TANGGAL -->
            <div class="mb-6">
                <label class="block font-semibold text-gray-700 mb-2">
                    Tanggal <span class="text-red-500">*</span>
                </label>

                <input
                    type="date"
                    name="tanggal"
                    required
                    value="{{ old('tanggal') }}"
                    class="w-full px-4 py-3 rounded-md border border-gray-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#064469]">
            </div>

            <!-- JUDUL -->
            <div class="mb-6">
                <label class="block font-semibold text-gray-700 mb-2">
                    Judul Berita <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    name="judul"
                    required
                    value="{{ old('judul') }}"
                    placeholder="Masukkan judul berita"
                    class="w-full px-4 py-3 rounded-md border border-gray-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#064469]">

            </div>

            <!-- MEDIA -->
            <div class="mb-6">
                <label class="block font-semibold text-gray-700 mb-2">
                    Media Berita <span class="text-red-500">*</span>
                </label>

                <select
                    name="media[]"
                    id="mediaSelect"
                    multiple
                    required
                    class="w-full px-4 py-3 rounded-md border border-gray-200 shadow-sm">

                    @foreach($korans as $k)
                        <option value="{{ $k->media }}">
                            {{ $k->media }} - {{ $k->penerbit }}
                        </option>
                    @endforeach

                </select>
            </div>

            <!-- KATEGORI -->
            <div class="mb-6">
                <label class="block font-semibold text-gray-700 mb-2">
                    Kategori Berita <span class="text-red-500">*</span>
                </label>

                <select
                    name="kategori"
                    required
                    class="w-full px-4 py-3 rounded-md border border-gray-200 shadow-sm">

                    <option value="">Silahkan Pilih Kategori</option>

                    <option value="Regional">
                        Regional
                    </option>

                    <option value="Nasional">
                        Nasional
                    </option>

                </select>
            </div>

            <!-- SENTIMEN -->
            <div class="mb-6">
                <label class="block font-semibold text-gray-700 mb-2">
                    Sentimen
                </label>

                <select
                    name="sentimen"
                    class="w-full px-4 py-3 rounded-md border border-gray-200 shadow-sm">

                    <option value="">
                        Otomatis dari OCR
                    </option>

                    <option value="Positif">
                        Positif
                    </option>

                    <option value="Netral">
                        Netral
                    </option>

                    <option value="Negatif">
                        Negatif
                    </option>

                </select>

                <small class="text-gray-500">
                    Kosongkan untuk analisis sentimen otomatis.
                </small>
            </div>

            <!-- RINGKASAN -->
            <div class="mb-6">
                <label class="block font-semibold text-gray-700 mb-2">
                    Ringkasan Berita
                </label>

                <textarea
                    rows="5"
                    readonly
                    placeholder="Ringkasan akan dibuat otomatis setelah gambar diproses OCR"
                    class="w-full px-4 py-3 rounded-md border border-gray-200 bg-gray-50 shadow-sm resize-none">{{ old('ringkasan') }}</textarea>

                <small class="text-gray-500">
                    Ringkasan otomatis dibuat dari hasil OCR gambar berita.
                </small>
            </div>

            <!-- GAMBAR OCR -->
            <div class="mb-10">
                <label class="block font-semibold text-gray-700 mb-2">
                    Upload Gambar Berita
                </label>

                <input
                type="file"
                name="gambar"
                accept=".jpg,.jpeg,.png"
                class="w-full px-4 py-3 rounded-md border shadow-sm
                @error('gambar') border-red-500 @else border-gray-200 @enderror">

            @error('gambar')
                <small class="text-red-500 block mt-1">{{ $message }}</small>
            @enderror

                <small class="text-gray-500">
                    Upload gambar berita (hanya jpg, jpeg, png, max 2MB)
                </small>
            </div>

            <!-- BUTTON -->
            <div class="flex justify-end gap-3">

                <a href="{{ route('berita.index') }}"
                   class="px-5 py-2 border border-gray-400 rounded text-gray-600 hover:bg-gray-100">
                    Batal
                </a>

                <button
                    type="submit"
                    class="px-6 py-2 bg-[#064469] text-white rounded hover:bg-[#053656]">
                    Simpan
                </button>

            </div>

        </form>

    </div>

</div>

<!-- JQUERY -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- SELECT2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- INIT SELECT2 -->
<script>
$(document).ready(function () {

    $('#mediaSelect').select2({

        placeholder: "Silahkan Pilih Media",

        width: '100%'
    });

});
</script>

@endsection