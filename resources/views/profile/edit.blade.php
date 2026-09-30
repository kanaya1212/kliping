@extends('layouts.app')

@section('content')

<!-- FONT POPPINS -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<div class="p-6 bg-gray-100 min-h-screen" style="font-family: 'Poppins', sans-serif;">

    <!-- TITLE -->
    <h2 class="text-2xl font-bold text-[#064469] mb-6">
        Profil Pengguna
    </h2>

    <!-- CARD -->
    <div class="bg-white rounded-xl shadow p-6">

        <!-- HEADER -->
        <div class="flex items-center justify-between mb-6 border-b pb-4">

            <div class="flex items-center gap-4">

                <!-- FOTO -->
                <div class="w-20 h-20 rounded-full overflow-hidden border">
                    @if($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}"
                            class="w-20 h-20 rounded-full object-cover border">
                    @else
                        <img src="{{ asset('icons/icon_profil.png') }}"
                            class="w-20 h-20 rounded-full object-cover border">
                    @endif
                </div>

                <!-- NAMA -->
                <div>
                    <h3 class="text-lg font-semibold text-[#064469]">
                        {{ $user->name }}
                    </h3>
                    <p class="text-gray-500 text-sm">
                        {{ ucfirst($user->role ?? 'User') }}
                    </p>
                </div>

            </div>

            <!-- BUTTON -->
            <div class="flex gap-2">
                <a href="{{ route('profile.form') }}"
                   class="px-4 py-2 border rounded-lg text-sm hover:bg-gray-100 transition">
                    Edit Profil
                </a>

                <a href="{{ route('profile.password') }}"
                   class="px-4 py-2 bg-[#064469] text-white rounded-lg text-sm hover:opacity-90 transition">
                    Edit Kata Sandi
                </a>
            </div>

        </div>

        <!-- DATA USER -->
        <div class="space-y-4">

            <div>
                <label class="text-xs text-gray-500">Nama</label>
                <input type="text"
                       value="{{ $user->name }}"
                       class="w-full border p-2 rounded-lg bg-gray-50 focus:outline-none" readonly>
            </div>

            <div>
                <label class="text-xs text-gray-500">No HP</label>
                <input type="text"
                       value="{{ $user->phone ?? 'Belum diisi' }}"
                       class="w-full border p-2 rounded-lg bg-gray-50 focus:outline-none" readonly>
            </div>

            <div>
                <label class="text-xs text-gray-500">Alamat</label>
                <input type="text"
                       value="{{ $user->address ?? 'Belum diisi' }}"
                       class="w-full border p-2 rounded-lg bg-gray-50 focus:outline-none" readonly>
            </div>

            <!-- NIP (GANTI DARI PANGKAT) -->
            <div>
                <label class="text-xs text-gray-500">NIP</label>
                <input type="text"
                       value="{{ $user->nip ?? 'Belum diisi' }}"
                       class="w-full border p-2 rounded-lg bg-gray-50 focus:outline-none" readonly>
            </div>

            <div>
                <label class="text-xs text-gray-500">Golongan</label>
                <input type="text"
                       value="{{ $user->golongan ?? 'Belum diisi' }}"
                       class="w-full border p-2 rounded-lg bg-gray-50 focus:outline-none" readonly>
            </div>

            <div>
                <label class="text-xs text-gray-500">Email</label>
                <input type="text"
                       value="{{ $user->email }}"
                       class="w-full border p-2 rounded-lg bg-gray-50 focus:outline-none" readonly>
            </div>

        </div>

    </div>

</div>

<!-- SWEETALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: @json(session('success')),
        confirmButtonColor: '#064469',
        timer: 2000,
        showConfirmButton: false
    });
});
</script>
@endif

@endsection