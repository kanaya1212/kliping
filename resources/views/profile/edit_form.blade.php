@extends('layouts.app')

@section('content')

<!-- FONT POPPINS -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<div class="p-6 bg-gray-100 min-h-screen" style="font-family: 'Poppins', sans-serif;">

    <!-- BREADCRUMB -->
    <div class="bg-white shadow rounded px-4 py-3 text-sm text-gray-500 mb-6">
        <a href="{{ route('profile.edit') }}" class="text-gray-700 hover:underline">
            Profil Pengguna
        </a>
        <span class="mx-2">></span>
        <span class="text-gray-700 font-medium">Edit Profil</span>
    </div>

    <!-- CARD -->
    <div class="bg-white rounded-xl shadow p-6 w-full">

        <!-- TITLE -->
        <h2 class="text-2xl font-bold text-[#064469] mb-6 border-b pb-2">
            Edit Profil
        </h2>

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="space-y-4">

                <!-- NAMA -->
                <div>
                    <label class="text-xs text-gray-500">
                        Nama <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name"
                        value="{{ old('name', $user->name) }}"
                        placeholder="Silahkan Isi Nama"
                        class="w-full border p-2 rounded-lg bg-gray-50 
                        @error('name') border-red-500 @enderror
                        focus:ring-2 focus:ring-[#064469] focus:outline-none">

                    @error('name')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>

                <!-- NO HP -->
                <div>
                    <label class="text-xs text-gray-500">
                        No HP <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="phone"
                        value="{{ old('phone', $user->phone) }}"
                        placeholder="Silahkan Isi Nomor HP"
                        class="w-full border p-2 rounded-lg bg-gray-50 
                        @error('phone') border-red-500 @enderror
                        focus:ring-2 focus:ring-[#064469] focus:outline-none">

                    @error('phone')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>

                <!-- ALAMAT -->
                <div>
                    <label class="text-xs text-gray-500">
                        Alamat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="address"
                        value="{{ old('address', $user->address) }}"
                        placeholder="Silahkan Isi Alamat"
                        class="w-full border p-2 rounded-lg bg-gray-50 
                        @error('address') border-red-500 @enderror
                        focus:ring-2 focus:ring-[#064469] focus:outline-none">

                    @error('address')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>

                <!-- NIP -->
                <div>
                    <label class="text-xs text-gray-500">NIP</label>
                    <input type="text" name="nip"
                        value="{{ old('nip', $user->nip) }}"
                        placeholder="Silahkan Isi NIP"
                        class="w-full border p-2 rounded-lg bg-gray-50 focus:ring-2 focus:ring-[#064469] focus:outline-none">
                </div>

                <!-- GOLONGAN -->
                <div>
                    <label class="text-xs text-gray-500">Golongan</label>
                    <input type="text" name="golongan"
                        value="{{ old('golongan', $user->golongan) }}"
                        placeholder="Silahkan Isi Golongan"
                        class="w-full border p-2 rounded-lg bg-gray-50 focus:ring-2 focus:ring-[#064469] focus:outline-none">
                </div>

                <!-- EMAIL -->
                <div>
                    <label class="text-xs text-gray-500">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email"
                        value="{{ old('email', $user->email) }}"
                        placeholder="Silahkan Isi Email"
                        class="w-full border p-2 rounded-lg bg-gray-50 
                        @error('email') border-red-500 @enderror
                        focus:ring-2 focus:ring-[#064469] focus:outline-none">

                    @error('email')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>

                <!-- FOTO -->
                <div>
                    <label class="text-xs text-gray-500">Foto Profil</label>

                    <div class="flex items-center gap-4 mt-2">

                        @if($user->photo)
                            <img src="{{ asset('storage/' . $user->photo) }}"
                                 class="w-20 h-20 rounded-full object-cover border">
                        @else
                            <img src="{{ asset('icons/icon_profil.png') }}"
                                 class="w-20 h-20 rounded-full object-cover border">
                        @endif

                        <div class="flex flex-col gap-2 w-full">

                            
                        <input type="file" name="photo"
                                class="border p-2 rounded-lg bg-gray-50 w-full
                                @error('photo') border-red-500 @enderror">

                            @error('photo')
                                <small class="text-red-500">{{ $message }}</small>
                            @enderror
                            
                            @if($user->photo)
                            <button type="submit" name="hapus_foto" value="1"
                                class="text-red-500 text-sm hover:underline w-fit">
                                Hapus Foto
                            </button>
                            @endif

                        </div>

                    </div>
                </div>

            </div>

            <!-- BUTTON -->
            <div class="flex justify-end mt-6 gap-2">
                <a href="{{ route('profile.edit') }}"
                   class="px-4 py-2 border rounded-lg hover:bg-gray-100 transition">
                    Batal
                </a>

                <button
                    class="px-4 py-2 bg-[#064469] text-white rounded-lg hover:opacity-90 transition">
                    Simpan
                </button>
            </div>

        </form>

    </div>

</div>

@endsection