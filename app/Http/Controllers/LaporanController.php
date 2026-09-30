<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    // ================= LAPORAN HARIAN =================
    public function harian(Request $request)
    {
        $query = Berita::query();

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        $beritas = $query
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return view('laporan.harian', compact('beritas'));
    }

    // ================= LAPORAN MINGGUAN =================
    public function mingguan(Request $request)
    {
        $start = $request->start;

        $beritas = collect();
        $end = null;

        if ($start) {
            try {
                $startDate = Carbon::parse($start)->startOfDay();
                $endDate = $startDate->copy()->addDays(6)->endOfDay();

                $end = $endDate->toDateString();

                $beritas = Berita::whereBetween('tanggal', [$startDate, $endDate])
                    ->orderBy('tanggal', 'desc')
                    ->orderBy('id', 'desc')
                    ->get();

            } catch (\Exception $e) {
                return back()->with('error', 'Tanggal tidak valid');
            }
        }

        return view('laporan.mingguan', compact('beritas', 'start', 'end'));
    }

    // ================= LAPORAN BULANAN =================
    public function bulanan(Request $request)
    {
        $bulan = $request->input('bulan', now()->format('Y-m'));

        $beritas = collect();
        $start = null;
        $end = null;

        try {
            $startDate = Carbon::parse($bulan)->startOfMonth();
            $endDate = Carbon::parse($bulan)->endOfMonth();

            $start = $startDate->toDateString();
            $end = $endDate->toDateString();

            $beritas = Berita::whereBetween('tanggal', [$startDate, $endDate])
                ->orderBy('tanggal', 'desc')
                ->orderBy('id', 'desc')
                ->get();

        } catch (\Exception $e) {
            return back()->with('error', 'Bulan tidak valid');
        }

        return view('laporan.bulanan', compact('beritas', 'bulan', 'start', 'end'));
    }

    // ================= LAPORAN TAHUNAN =================
    public function tahunan(Request $request)
    {
        $tahun = $request->tahun;

        $beritas = collect();
        $start = null;
        $end = null;

        if ($tahun) {
            try {
                $startDate = Carbon::create($tahun, 1, 1)->startOfDay();
                $endDate = Carbon::create($tahun, 12, 31)->endOfDay();

                $start = $startDate->toDateString();
                $end = $endDate->toDateString();

                $beritas = Berita::whereBetween('tanggal', [$startDate, $endDate])
                    ->orderBy('tanggal', 'desc')
                    ->orderBy('id', 'desc')
                    ->get();

            } catch (\Exception $e) {
                return back()->with('error', 'Tahun tidak valid');
            }
        }

        return view('laporan.tahunan', compact('beritas', 'tahun', 'start', 'end'));
    }

    // ================= DOWNLOAD PDF HARIAN =================
    public function downloadHarian($tanggal)
    {
        try {
            $tanggalParsed = Carbon::parse($tanggal)->format('Y-m-d');
        } catch (\Exception $e) {
            abort(404, 'Tanggal tidak valid');
        }

        $beritas = Berita::whereDate('tanggal', $tanggalParsed)
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        if ($beritas->isEmpty()) {
            return back()->with('error', 'Tidak ada data untuk tanggal tersebut');
        }

        $pdf = Pdf::loadView('laporan.pdf_harian', [
            'beritas' => $beritas,
            'tanggal' => $tanggalParsed
        ])->setPaper('A4', 'portrait');

        return $pdf->download('laporan-harian-'.$tanggalParsed.'.pdf');
    }

    // ================= DOWNLOAD PDF MINGGUAN =================
    public function downloadMingguan(Request $request)
    {
        $start = $request->start;

        try {
            $startDate = Carbon::parse($start)->startOfDay();
            $endDate = $startDate->copy()->addDays(6)->endOfDay();

            $end = $endDate->toDateString();

        } catch (\Exception $e) {
            abort(404, 'Tanggal tidak valid');
        }

        $beritas = Berita::whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        if ($beritas->isEmpty()) {
            return back()->with('error', 'Tidak ada data');
        }

        $pdf = Pdf::loadView('laporan.pdf_mingguan', [
            'beritas' => $beritas,
            'start' => $start,
            'end' => $end
        ])->setPaper('A4', 'portrait');

        return $pdf->download('laporan-mingguan-'.$start.'-'.$end.'.pdf');
    }

    // ================= DOWNLOAD PDF BULANAN =================
    public function downloadBulanan(Request $request)
    {
        $bulan = $request->input('bulan', now()->format('Y-m'));

        try {
            $startDate = Carbon::parse($bulan)->startOfMonth();
            $endDate = Carbon::parse($bulan)->endOfMonth();

            $start = $startDate->toDateString();
            $end = $endDate->toDateString();

        } catch (\Exception $e) {
            abort(404, 'Bulan tidak valid');
        }

        $beritas = Berita::whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        if ($beritas->isEmpty()) {
            return back()->with('error', 'Tidak ada data');
        }

        $pdf = Pdf::loadView('laporan.pdf_bulanan', [
            'beritas' => $beritas,
            'bulan' => $bulan,
            'start' => $start,
            'end' => $end
        ])->setPaper('A4', 'portrait');

        return $pdf->download('laporan-bulanan-'.$bulan.'.pdf');
    }

    // ================= DOWNLOAD PDF TAHUNAN =================
    public function downloadTahunan(Request $request)
    {
        $tahun = $request->tahun;

        try {
            $startDate = Carbon::create($tahun, 1, 1)->startOfDay();
            $endDate = Carbon::create($tahun, 12, 31)->endOfDay();

            $start = $startDate->toDateString();
            $end = $endDate->toDateString();

        } catch (\Exception $e) {
            abort(404, 'Tahun tidak valid');
        }

        $beritas = Berita::whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        if ($beritas->isEmpty()) {
            return back()->with('error', 'Tidak ada data');
        }

        $pdf = Pdf::loadView('laporan.pdf_tahunan', [
            'beritas' => $beritas,
            'tahun' => $tahun,
            'start' => $start,
            'end' => $end
        ])->setPaper('A4', 'portrait');

        return $pdf->download('laporan-tahunan-'.$tahun.'.pdf');
    }
}