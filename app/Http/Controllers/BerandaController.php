<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BerandaController extends Controller
{
    public function index(Request $request)
    {
        // ================= TANGGAL =================
        $now        = Carbon::now();
        $hariIni    = $now->copy()->startOfDay();
        $mingguIni  = $now->copy()->startOfWeek();
        $bulanIni   = $now->copy()->startOfMonth();
        $tahunIni   = $now->copy()->startOfYear();

        // ================= STATISTIK =================
        $hari_ini = Berita::whereDate('tanggal', $hariIni)->count();

        $minggu_ini = Berita::whereBetween('tanggal', [
            $mingguIni,
            $now
        ])->count();

        $bulan_ini = Berita::whereBetween('tanggal', [
            $bulanIni,
            $now
        ])->count();

        $tahun_ini = Berita::whereBetween('tanggal', [
            $tahunIni,
            $now
        ])->count();

        // ================= DATA BERITA =================
       $beritas = Berita::orderBy('tanggal', 'desc')
        ->orderBy('created_at', 'desc')
        ->paginate(10)
        ->withQueryString();

        // ================= DETAIL BERITA =================
        $id = $request->query('id'); // ambil dari URL (?id=...)

        $detail = $id ? Berita::find($id) : null;

        // ================= RETURN =================
        return view('beranda.index', [
            'hari_ini'   => $hari_ini,
            'minggu_ini' => $minggu_ini,
            'bulan_ini'  => $bulan_ini,
            'tahun_ini'  => $tahun_ini,
            'beritas'    => $beritas,
            'detail'     => $detail,
        ]);
    }
}