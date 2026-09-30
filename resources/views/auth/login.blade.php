<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="h-screen w-screen flex overflow-hidden">

    <!-- ================= KIRI ================= -->
    <div class="w-3/5 h-full bg-cover"
         style="background-image: url('{{ asset('images/login.jpeg') }}'); background-position: 70% center;">
    </div>

    <!-- ================= KANAN ================= -->
    <div class="w-2/5 h-full bg-gray-100 flex items-center justify-center">

        <!-- CARD FORM -->
        <div class="w-[510px] h-[660px] bg-white p-8 rounded-xl shadow-xl border flex flex-col justify-center">

            <!-- TITLE (NAIK TANPA NGARUHIN YANG LAIN) -->
            <h2 class="text-2xl font-bold text-center text-[#264B6D] relative -top-6">
                Selamat Datang !
            </h2>

            <p class="text-center text-gray-500 mt-3 mb-8 text-sm leading-relaxed">
                Sistem Monitoring Berita <br>
                Dinas Komunikasi dan Informatika Provinsi Jambi
            </p>

            <!-- FORM -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- EMAIL -->
                <div class="mb-4">
                    <label class="block text-[#264B6D] font-medium mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>

                    <input type="email" name="email"
                        value="{{ old('email') }}"
                        placeholder="Silahkan Masukkan Email"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 
                        bg-white shadow-sm focus:outline-none 
                        focus:ring-2 focus:ring-[#264B6D]">

                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- PASSWORD -->
                <div class="mb-5">
                    <label class="block text-[#264B6D] font-medium mb-2">
                        Kata Sandi <span class="text-red-500">*</span>
                    </label>

                    <input type="password" name="password"
                        placeholder="Silahkan Masukkan Kata Sandi"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 
                        bg-white shadow-sm focus:outline-none 
                        focus:ring-2 focus:ring-[#264B6D]">

                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- BUTTON -->
                <button class="w-full bg-[#264B6D] text-white py-3 rounded-lg text-lg font-semibold 
                               hover:bg-[#1f3e5a] transition duration-300 shadow-md mt-4">
                    Masuk
                </button>

            </form>

        </div>

    </div>

</body>
</html>