@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<div class="p-6 bg-gray-100 min-h-screen" style="font-family: 'Poppins', sans-serif;">

    <div class="bg-white shadow rounded px-4 py-3 mb-6 text-sm text-gray-500">
        <a href="{{ route('koran.index') }}" 
        class="text-gray-700 hover:underline">
            Koran
        </a>

        <span class="mx-2">></span>

        <span class="text-gray-700 font-medium">
            Edit Koran
        </span>
    </div>

    <div class="bg-white shadow rounded-lg p-6">

        <h2 class="text-xl font-bold text-[#064469] border-b pb-2 mb-6">
            Edit Koran
        </h2>

        <!-- 🔥 FIX DISINI -->
        <form action="{{ route('koran.update', $koran->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- MEDIA -->
            <div class="mb-4">
                <label class="block font-semibold mb-2">
                    Media Koran <span class="text-red-500">*</span>
                </label>

                <input type="text" name="media"
                    value="{{ old('media', $koran->media) }}"
                    required
                    class="w-full px-4 py-3 border rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-[#064469]">
            </div>

            <!-- PENERBIT -->
            <div class="mb-4">
                <label class="block font-semibold mb-2">
                    Penerbit Koran <span class="text-red-500">*</span>
                </label>

                <input type="text" name="penerbit"
                    value="{{ old('penerbit', $koran->penerbit) }}"
                    required
                    class="w-full px-4 py-3 border rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-[#064469]">
            </div>

            <!-- KATEGORI -->
            <div class="mb-4">
                <label class="block font-semibold mb-2">
                    Kategori Koran <span class="text-red-500">*</span>
                </label>

                <select name="kategori" required
                    class="w-full px-4 py-3 border rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-[#064469]">
                    <option value="Regional" {{ $koran->kategori == 'Regional' ? 'selected' : '' }}>Regional</option>
                    <option value="Nasional" {{ $koran->kategori == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                </select>
            </div>

            <!-- STATUS -->
            <div class="mb-6">
                <label class="block font-semibold mb-2">
                    Status Koran <span class="text-red-500">*</span>
                </label>

                <select name="status" required
                    class="w-full px-4 py-3 border rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-[#064469]">
                    <option value="Aktif" {{ $koran->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Tidak Aktif" {{ $koran->status == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>

            <!-- BUTTON -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('koran.index') }}"
                   class="px-4 py-2 border border-gray-400 rounded text-gray-600 hover:bg-gray-100">
                    Batal
                </a>

                <button type="submit"
                    class="px-5 py-2 bg-[#064469] text-white rounded hover:bg-[#053656]">
                    Simpan
                </button>
            </div>

        </form>

    </div>

</div>

@endsection