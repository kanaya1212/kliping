@extends('layouts.app')

@section('content')

<!-- FONT POPPINS -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<div class="p-6 bg-gray-100 min-h-screen" style="font-family: 'Poppins', sans-serif;">

    <!-- BREADCRUMB -->
    <div class="bg-white px-4 py-2 rounded-lg mb-4 text-sm text-gray-500 shadow-sm">
        <a href="{{ route('profile.edit') }}" class="text-gray-700 hover:underline">
            Profil Pengguna
        </a>
        <span class="mx-2">></span>
        <span class="text-gray-700 font-medium">Edit Kata Sandi</span>
    </div>

    <!-- SUCCESS -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 mb-4 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- CARD -->
    <div class="bg-white rounded-xl shadow p-6 w-full">

        <h2 class="text-2xl font-bold text-[#064469] mb-6 border-b pb-2">
            Edit Kata Sandi
        </h2>

        <form method="POST" action="{{ route('profile.password.update') }}">
            @csrf
            @method('PUT')

            <div class="space-y-4">

                <!-- PASSWORD LAMA -->
                <div>
                    <label class="text-xs text-gray-500">
                        Password Lama <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="current_password"
                        placeholder="Silahkan Isi Kata Sandi Lama"
                        class="w-full border p-2 rounded-lg bg-gray-50 
                        @error('current_password') border-red-500 @enderror
                        focus:ring-2 focus:ring-[#064469] focus:outline-none">

                    @error('current_password')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>

                <!-- PASSWORD BARU -->
                <div>
                    <label class="text-xs text-gray-500">
                        Password Baru <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password"
                        placeholder="Silahkan Isi Kata Sandi Baru"
                        class="w-full border p-2 rounded-lg bg-gray-50 
                        @error('password') border-red-500 @enderror
                        focus:ring-2 focus:ring-[#064469] focus:outline-none">

                    @error('password')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>

                <!-- KONFIRMASI -->
                <div>
                    <label class="text-xs text-gray-500">
                        Konfirmasi Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password_confirmation"
                        placeholder="Silahkan Isi Konfirmasi Kata Sandi"
                        class="w-full border p-2 rounded-lg bg-gray-50 
                        @error('password_confirmation') border-red-500 @enderror
                        focus:ring-2 focus:ring-[#064469] focus:outline-none">

                    @error('password_confirmation')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>

            </div>

            <!-- BUTTON -->
            <div class="flex justify-end gap-2 mt-6">
                <a href="{{ route('profile.edit') }}"
                   class="px-4 py-2 border rounded-lg hover:bg-gray-100 transition">
                    Batal
                </a>

                <button type="submit"
                        class="px-4 py-2 bg-[#064469] text-white rounded-lg hover:opacity-90 transition">
                    Simpan
                </button>
            </div>

        </form>

    </div>

</div>

@endsection