<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Berita</title>

    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }

        .header {
            text-align: center;
            position: relative;
            margin-bottom: 30px;
        }

        .logo-left { position: absolute; left: 0; top: 0; width: 70px; }
        .logo-right { position: absolute; right: 0; top: 0; width: 70px; }

        .title { font-size: 18px; font-weight: bold; }
        .subtitle { font-size: 12px; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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
            max-width: 90%;
            max-height: 500px;
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

    $gambarPath = $berita->gambar 
        ? public_path('storage/' . $berita->gambar) 
        : null;

    $gambarFix = ($gambarPath && file_exists($gambarPath)) 
        ? $gambarPath 
        : null;
@endphp

<div class="header">

    @if(file_exists($logoKiri))
        <img src="{{ $logoKiri }}" class="logo-left">
    @endif

    @if(file_exists($logoKanan))
        <img src="{{ $logoKanan }}" class="logo-right">
    @endif

    <div class="title">E-KLIPING</div>
    <div class="subtitle">Pemerintah Provinsi Jambi</div>
    <div class="subtitle">Dinas Komunikasi dan Informatika</div>

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

</body>
</html>