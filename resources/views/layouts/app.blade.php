<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!--  GANTI FONT KE POPPINS -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script src="//unpkg.com/alpinejs" defer></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-gray-100" style="font-family: 'Poppins', sans-serif;">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <div class="w-64 bg-white shadow">

        <div class="p-4 border-b flex justify-center">
            <img src="{{ asset('images/logo_ekliping.png') }}" 
                alt="Logo E-Kliping"
                class="h-16 object-contain">
        </div>

        <ul class="mt-4 text-gray-600">

            <li>
                <a href="/dashboard"
                   class="flex items-center gap-3 px-4 py-3
                   {{ request()->is('dashboard') ? 'bg-[#064469] text-white' : 'hover:bg-[#064469] hover:text-white' }}">
                    <img src="{{ asset('icons/icon_beranda.png') }}" class="w-6 h-6 object-contain">
                    <span>Beranda</span>
                </a>
            </li>

            @if(auth()->user()->role == 'pegawai')

            <li>
                <a href="/koran"
                   class="flex items-center gap-3 px-4 py-3
                   {{ request()->is('koran*') ? 'bg-[#064469] text-white' : 'hover:bg-[#064469] hover:text-white' }}">
                    <img src="{{ asset('icons/icon_koran.png') }}" class="w-6 h-6 object-contain">
                    <span>Koran</span>
                </a>
            </li>

            <li>
                <a href="/berita"
                   class="flex items-center gap-3 px-4 py-3
                   {{ request()->is('berita*') ? 'bg-[#064469] text-white' : 'hover:bg-[#064469] hover:text-white' }}">
                    <img src="{{ asset('icons/icon_berita.png') }}" class="w-6 h-6 object-contain">
                    <span>Berita</span>
                </a>
            </li>

            @endif

            <li x-data="{ open: false }">

                <button @click="open = !open"
                    class="w-full relative flex items-center px-4 py-3
                    hover:bg-[#064469] hover:text-white
                    {{ request()->is('laporan*') ? 'bg-[#064469] text-white' : '' }}">

                    <div class="flex items-center gap-3">
                        <img src="{{ asset('icons/icon_laporan.png') }}" class="w-6 h-6 object-contain">
                        <span>Laporan</span>
                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-5 h-5 absolute right-6 transition-transform duration-300"
                         :class="open ? 'rotate-180' : ''"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2">
                        <path d="M6 9l6 6 6-6"/>
                    </svg>

                </button>

                <div x-show="open" x-transition
                     class="ml-10 mt-1 space-y-1 text-sm text-gray-600">

                    <a href="/laporan/harian" class="block py-2 px-3 rounded-md hover:bg-[#064469] hover:text-white hover:translate-x-1 transition-all duration-300">Laporan Harian</a>
                    <a href="/laporan/mingguan" class="block py-2 px-3 rounded-md hover:bg-[#064469] hover:text-white hover:translate-x-1 transition-all duration-300">Laporan Mingguan</a>
                    <a href="/laporan/bulanan" class="block py-2 px-3 rounded-md hover:bg-[#064469] hover:text-white hover:translate-x-1 transition-all duration-300">Laporan Bulanan</a>
                    <a href="/laporan/tahunan" class="block py-2 px-3 rounded-md hover:bg-[#064469] hover:text-white hover:translate-x-1 transition-all duration-300">Laporan Tahunan</a>

                </div>

            </li>

        </ul>
    </div>

    <!-- CONTENT -->
    <div class="flex-1 flex flex-col">

        <div class="bg-[#064469] text-white flex justify-end items-center px-6 py-3 relative">

            <div class="relative">

                <button onclick="toggleDropdown()"
                    class="flex items-center gap-2 bg-white text-black px-3 py-1 rounded-lg shadow">

                    <div class="w-8 h-8 rounded-full overflow-hidden border">
                        @if(auth()->user()->photo)
                            <img src="{{ asset('storage/' . auth()->user()->photo) }}"
                                class="w-full h-full object-cover">
                        @else
                            <img src="{{ asset('icons/icon_profil.png') }}"
                                class="w-full h-full object-cover">
                        @endif
                    </div>

                    <div class="flex flex-col leading-tight text-left">
                        <span class="text-sm font-semibold">
                            {{ auth()->user()->name }}
                        </span>

                        <span class="text-xs text-gray-500">
                            {{ ucfirst(auth()->user()->role) }}
                        </span>
                    </div>

                </button>

                <div id="dropdownMenu"
                     class="hidden absolute right-0 mt-2 w-44 bg-white text-black rounded shadow">

                    <a href="/profile" class="block px-4 py-2 hover:bg-gray-100">
                        Profil
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full text-left px-4 py-2 hover:bg-gray-100">
                            Keluar
                        </button>
                    </form>

                </div>

            </div>

        </div>

        <!-- CONTENT -->
        <main class="p-6 flex-1">
            @yield('content')
        </main>

        <!-- FOOTER -->
        <div class="bg-white px-6 py-3 border-t text-right text-sm font-semibold text-gray-600">
            Copyright © 2026 - Dinas Komunikasi dan Informatika Provinsi Jambi
        </div>

    </div>

</div>

<script>
    function toggleDropdown() {
        document.getElementById('dropdownMenu').classList.toggle('hidden');
    }

    window.onclick = function(event) {
        if (!event.target.closest('.relative')) {
            document.getElementById('dropdownMenu').classList.add('hidden');
        }
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Tidak Ada Data',
        text: "{{ session('error') }}",
        timer: 3000,
        showConfirmButton: false,
        timerProgressBar: true
    });
</script>
@endif

</body>
</html>