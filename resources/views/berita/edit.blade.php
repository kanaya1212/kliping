@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- TAMBAHAN CSS SELECT2 -->
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

    <div class="bg-white shadow rounded px-4 py-3 text-sm text-gray-500 mb-6">
        <a href="{{ route('berita.index') }}" class="text-gray-700 hover:underline">
            Berita
        </a>
        <span class="mx-2">></span>
        <span class="text-gray-700 font-medium">Edit Berita</span>
    </div>

    <div class="bg-white shadow rounded-xl p-8">

        <h2 class="text-2xl font-bold text-[#064469] mb-6 border-b pb-2">
            Edit Berita
        </h2>

        <form action="{{ route('berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- TANGGAL -->
            <div class="mb-6">
                <label class="block font-semibold text-gray-700 mb-2">
                    Tanggal <span class="text-red-500">*</span>
                </label>
                <input type="date" name="tanggal"
                    value="{{ old('tanggal', $berita->tanggal) }}"
                    class="w-full px-4 py-3 rounded-md border border-gray-200 shadow-sm focus:ring-2 focus:ring-[#064469]">
            </div>

            <!-- JUDUL -->
            <div class="mb-6">
                <label class="block font-semibold text-gray-700 mb-2">
                    Judul Berita <span class="text-red-500">*</span>
                </label>
                <input type="text" name="judul"
                    value="{{ old('judul', $berita->judul) }}"
                    class="w-full px-4 py-3 rounded-md border border-gray-200 shadow-sm focus:ring-2 focus:ring-[#064469]">
            </div>

            <!-- MEDIA -->
            <div class="mb-6">
                <label class="block font-semibold text-gray-700 mb-2">
                    Media Berita <span class="text-red-500">*</span>
                </label>

                <select name="media[]" id="mediaSelect" multiple required
                    class="w-full px-4 py-3 rounded-md border border-gray-200 shadow-sm">

                    <!-- TAMBAHAN OPTION KOSONG -->
                    <option></option>

                    @foreach($korans as $k)
                        <option value="{{ $k->media }}"
                            @if(in_array($k->media, old('media', array_map('trim', explode(',', $berita->media ?? '')))))
                                selected
                            @endif>
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
                <select name="kategori"
                    class="w-full px-4 py-3 rounded-md border border-gray-200 shadow-sm">
                    <option value="Regional" {{ $berita->kategori == 'Regional' ? 'selected' : '' }}>Regional</option>
                    <option value="Nasional" {{ $berita->kategori == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                </select>
            </div>

            <!-- SENTIMEN -->
            <div class="mb-6">
                <label class="block font-semibold text-gray-700 mb-2">
                    Sentimen 
                </label>
                <select name="sentimen"
                    class="w-full px-4 py-3 rounded-md border border-gray-200 shadow-sm">
                    <option value="Netral" {{ $berita->sentimen == 'Netral' ? 'selected' : '' }}>Netral</option>
                    <option value="Positif" {{ $berita->sentimen == 'Positif' ? 'selected' : '' }}>Positif</option>
                    <option value="Negatif" {{ $berita->sentimen == 'Negatif' ? 'selected' : '' }}>Negatif</option>
                </select>
            </div>

            <!-- RINGKASAN -->
            <div class="mb-6">
                <label class="block font-semibold text-gray-700 mb-2">
                    Ringkasan Berita
                </label>
                <textarea name="ringkasan" rows="4"
                    class="w-full px-4 py-3 rounded-md border border-gray-200 shadow-sm">{{ old('ringkasan', $berita->ringkasan) }}</textarea>
            </div>

            <!-- GAMBAR -->
            <div class="mb-10">
                <label class="block font-semibold text-gray-700 mb-2">
                    Upload Gambar Berita
                </label>

                @if($berita->gambar)
                    <img src="{{ asset('storage/'.$berita->gambar) }}"
                        onclick="showImage(this.src)"
                        class="w-32 mb-3 rounded shadow cursor-pointer hover:opacity-80 transition">
                @endif

                <input
                type="file"
                name="gambar"
                accept=".jpg,.jpeg,.png"
                class="w-full px-4 py-3 rounded-md border shadow-sm
                {{ $errors->has('gambar') ? 'border-red-500' : 'border-gray-200' }}">

                @error('gambar')
                    <small class="text-red-500 block mt-1">
                        {{ $message }}
                    </small>
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

                <button class="px-6 py-2 bg-[#064469] text-white rounded hover:bg-[#053656]">
                    Simpan
                </button>
            </div>

        </form>

    </div>

</div>

<!-- MODAL PREVIEW GAMBAR -->
<div id="imageModal" style="display:none;"
    class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50">

    <span onclick="closeImage()"
        class="absolute top-5 right-5 text-white text-3xl cursor-pointer">&times;</span>

    <img id="previewImage" class="max-w-3xl max-h-[80vh] rounded shadow">
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    $('#mediaSelect').select2({
        placeholder: "Silahkan Pilih Media",
        width: '100%',
        allowClear: true
    });
});

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