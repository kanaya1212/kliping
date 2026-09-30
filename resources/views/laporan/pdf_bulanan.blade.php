<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Bulanan</title>

    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }

        .page {
            page-break-after: always;
        }

        .header {
            text-align: center;
            position: relative;
            margin-bottom: 25px;
            padding-top: 15px;
        }

        .logo-left { position: absolute; left: 0; top: 0; width: 70px; }
        .logo-right { position: absolute; right: 0; top: 0; width: 70px; }

        .title {
            font-size: 18px;
            font-weight: bold;
            color: #2563EB;
            margin-top: 10px;
        }

        .subtitle {
            font-size: 12px;
            margin-top: 3px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        td {
            border: 1px solid black;
            padding: 8px;
            vertical-align: top;
        }

        .label {
            width: 25%;
            font-weight: bold;
            background: #f2f2f2;
        }

        .image {
            margin-top: 20px;
            text-align: center;
        }

        .image img {
            width: 100%;
            max-width: 500px;
            max-height: 450px;
            object-fit: contain;
            border: 1px solid #ccc;
        }

        .no-image {
            margin-top: 20px;
            text-align: center;
            color: #888;
        }
    </style>
</head>

<body>

@php
    $logoKiri = public_path('images/logo_kiri.jpeg');
    $logoKanan = public_path('images/logo_kanan.jpeg');
@endphp

@foreach($beritas as $berita)

@php
    $gambarPath = $berita->gambar 
        ? public_path('storage/' . $berita->gambar) 
        : null;

    $gambarFix = ($gambarPath && file_exists($gambarPath)) 
        ? $gambarPath 
        : null;
@endphp

<div class="{{ !$loop->last ? 'page' : '' }}">

    <div class="header">

        @if(file_exists($logoKiri))
            <img src="{{ $logoKiri }}" class="logo-left">
        @endif

        @if(file_exists($logoKanan))
            <img src="{{ $logoKanan }}" class="logo-right">
        @endif

        <div class="title">DIGITAL KLIPING</div>
        <div class="subtitle">Pemerintah Provinsi Jambi</div>
        <div class="subtitle">Dinas Komunikasi dan Informatika</div>

        {{--<div class="subtitle" style="margin-top: 10px;">
            Laporan Bulanan<br>
            Periode {{ \Carbon\Carbon::parse($start)->format('d F Y') }} 
            - 
            {{ \Carbon\Carbon::parse($end)->format('d F Y') }}
        </div>--}}

    </div>

    <table>
        <tr>
            <td class="label">Tanggal</td>
            <td>{{ \Carbon\Carbon::parse($berita->tanggal)->format('d F Y') }}</td>
        </tr>
        <tr>
            <td class="label">Judul</td>
            <td>{{ $berita->judul }}</td>
        </tr>
        <tr>
            <td class="label">Media</td>
            <td>{{ $berita->media }}</td>
        </tr>
        <tr>
            <td class="label">Sentimen</td>
            <td>{{ $berita->sentimen ?? 'Netral' }}</td>
        </tr>
        <tr>
            <td class="label">Ringkasan</td>
            <td>{{ $berita->ringkasan ?? '-' }}</td>
        </tr>
    </table>

    @if($gambarFix)
        <div class="image">
            <img src="{{ $gambarFix }}">
        </div>
    @else
        <div class="no-image">
            (Gambar tidak tersedia)
        </div>
    @endif

</div>

@endforeach

</body>
</html>