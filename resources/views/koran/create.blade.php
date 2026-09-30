@extends('layouts.app')

@section('content')

<!-- TAMBAHAN FONT POPPINS -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<div class="p-6" style="font-family: 'Poppins', sans-serif;">

    <!-- Breadcrumb -->
    <div class="bg-white shadow rounded px-4 py-3 text-sm text-gray-500 mb-6">
        <a href="/koran" class="text-gray-700 hover:underline">
            Koran
        </a>
        <span class="mx-2">></span>
        <span class="text-gray-700 font-medium">Tambah Koran</span>
    </div>

    <!-- Card -->
    <div class="bg-white shadow rounded-xl p-8">

        <!-- Title -->
        <h2 class="text-2xl font-bold text-[#064469] mb-6 border-b pb-2">
            Tambah Koran
        </h2>

        <!-- FORM -->
        <form action="/koran/store" method="POST">
            @csrf

            <!-- MEDIA -->
            <div class="mb-6">
                <label class="block font-semibold text-gray-700 mb-2">
                    Media Koran <span class="text-red-500">*</span>
                </label>
                <input type="text" name="media"
                    placeholder="Silahkan Isi Media Koran"
                    class="w-full px-4 py-3 rounded-md border border-gray-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#064469]">
            </div>

            <!-- PENERBIT -->
            <div class="mb-6">
                <label class="block font-semibold text-gray-700 mb-2">
                    Penerbit Koran <span class="text-red-500">*</span>
                </label>
                <input type="text" name="penerbit"
                    placeholder="Silahkan Isi Penerbit Koran"
                    class="w-full px-4 py-3 rounded-md border border-gray-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#064469]">
            </div>

            <!-- KATEGORI -->
            <div class="mb-6">
                <label class="block font-semibold text-gray-700 mb-2">
                    Kategori Koran <span class="text-red-500">*</span>
                </label>
                <select name="kategori"
                    class="w-full px-4 py-3 rounded-md border border-gray-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#064469]">
                    <option value="">Silahkan Pilih Kategori Koran</option>
                    <option value="Regional">Regional</option>
                    <option value="Nasional">Nasional</option>
                </select>
            </div>

            <!-- STATUS -->
            <div class="mb-10">
                <label class="block font-semibold text-gray-700 mb-2">
                    Status Koran <span class="text-red-500">*</span>
                </label>
                <select name="status"
                    class="w-full px-4 py-3 rounded-md border border-gray-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#064469]">
                    <option value="">Silahkan Pilih Status Koran</option>
                    <option value="Aktif">Aktif</option>
                    <option value="Tidak Aktif">Tidak Aktif</option>
                </select>
            </div>

            <!-- BUTTON -->
            <div class="flex justify-end gap-3">
                <a href="/koran"
                   class="px-5 py-2 border border-gray-400 rounded text-gray-600 hover:bg-gray-100">
                    Batal
                </a>

                <button type="submit"
                    class="px-6 py-2 bg-[#064469] text-white rounded hover:bg-[#053656]">
                    Simpan
                </button>
            </div>

        </form>

    </div>

</div>

@endsection