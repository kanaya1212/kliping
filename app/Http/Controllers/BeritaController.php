<?php

namespace App\Http\Controllers;

use App\Models\Koran;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Illuminate\Http\Request;
use App\Models\Berita;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Helpers\TextHelper;

class BeritaController extends Controller
{
    // ================= INDEX =================
    public function index(Request $request)
    {
        $query = Berita::query();

        // ================= FILTER TANGGAL =================
        if ($request->tanggal) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        // ================= FILTER SENTIMEN =================
        if ($request->sentimen) {
            $query->where('sentimen', $request->sentimen);
        }

        // ================= SEARCH =================
        if ($request->search) {

            $query->where(function ($q) use ($request) {

                $q->where('judul', 'like', '%' . $request->search . '%')
                    ->orWhere('media', 'like', '%' . $request->search . '%')
                    ->orWhere('ringkasan', 'like', '%' . $request->search . '%')
                    ->orWhere('kategori', 'like', '%' . $request->search . '%');

            });
        }

        // ================= DATA =================
        $beritas = $query->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('berita.index', compact('beritas'));
    }

    // ================= CREATE =================
    public function create()
    {
        $korans = Koran::latest()->get();

        return view('berita.create', compact('korans'));
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        // ================= VALIDASI =================
        $request->validate([

            'tanggal' => 'required',

            // WAJIB MANUAL
            'judul' => 'required|string|max:255',

            'media' => 'required|array',

            'media.*' => 'string',

            'kategori' => 'required',

            // sentimen optional
            'sentimen' => 'nullable|in:Positif,Netral,Negatif',

            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'

        ], [

            'tanggal.required' => 'Tanggal wajib diisi',

            'judul.required' => 'Judul wajib diisi',

            'media.required' => 'Media wajib dipilih',

            'kategori.required' => 'Kategori wajib dipilih',

            'gambar.image' => 'File harus berupa gambar',

            'gambar.mimes' => 'Format gambar harus JPG, JPEG, atau PNG',

            'gambar.max' => 'Ukuran gambar maksimal 2 MB',

        ]);

        $namaGambar = null;

        $ringkasan = '-';

        $fullText = null;

        // ================= OCR GAMBAR =================
        if ($request->hasFile('gambar')) {

            // simpan gambar
            $namaGambar = $request->file('gambar')->store('gambar', 'public');

            $path = public_path('storage/' . $namaGambar);

            // cek file
            if (file_exists($path)) {

                try {

                    // ================= OCR =================
                    $text = (new TesseractOCR($path))
                        ->lang('ind')
                        ->run();

                    // batasi text
                    $text = substr($text, 0, 5000);

                    // ================= CLEAN TEXT =================
                    $fullText = TextHelper::cleanText($text);

                    // ================= RINGKASAN =================
                    $ringkasan = TextHelper::ringkasan($fullText);

                } catch (\Exception $e) {

                    $fullText = null;

                    $ringkasan = '-';
                }
            }
        }

        // ================= SENTIMEN =================
        $sentimen = 'Netral';

        // prioritas manual
        if ($request->filled('sentimen')) {

            $sentimen = $request->sentimen;

        } else {

            // otomatis dari OCR
            if ($fullText) {

                $sentimen = TextHelper::analisisSentimen($fullText);
            }
        }

        // ================= SIMPAN =================
        Berita::create([

            'tanggal' => $request->tanggal,

            // FULL MANUAL TANPA OCR
            'judul' => $request->judul,

            'media' => implode(', ', $request->media),

            'kategori' => $request->kategori,

            'sentimen' => $sentimen,

            'ringkasan' => $ringkasan,

            'gambar' => $namaGambar

        ]);

        return redirect()
            ->route('berita.index')
            ->with('success', 'Berita berhasil ditambahkan ✅');
    }

    // ================= EDIT =================
    public function edit($id)
    {
        $berita = Berita::findOrFail($id);

        $korans = Koran::all();

        return view('berita.edit', compact('berita', 'korans'));
    }

    // ================= UPDATE =================
    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);

        // ================= VALIDASI =================
        $request->validate([

            'tanggal' => 'required',

            // WAJIB MANUAL
            'judul' => 'required|string|max:255',

            'media' => 'required',

            'kategori' => 'required',

            // optional

            'ringkasan' => 'nullable|string',

            'sentimen' => 'nullable|in:Positif,Netral,Negatif',

            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'

        ], [

            'tanggal.required' => 'Tanggal wajib diisi',

            'judul.required' => 'Judul wajib diisi',

            'media.required' => 'Media wajib dipilih',

            'kategori.required' => 'Kategori wajib dipilih',

            'gambar.image' => 'File harus berupa gambar',

            'gambar.mimes' => 'Format gambar harus JPG, JPEG, atau PNG',

            'gambar.max' => 'Ukuran gambar maksimal 2 MB',

        ]);

        $namaGambar = $berita->gambar;

        $ringkasan = $request->ringkasan;

        $fullText = null;

        // ================= UPDATE GAMBAR =================
        if ($request->hasFile('gambar')) {

            // hapus gambar lama
            if ($berita->gambar) {

                Storage::disk('public')->delete($berita->gambar);
            }

            // upload baru
            $namaGambar = $request->file('gambar')->store('gambar', 'public');

            $path = public_path('storage/' . $namaGambar);

            if (file_exists($path)) {

                try {

                    // ================= OCR =================
                    $text = (new TesseractOCR($path))
                        ->lang('ind')
                        ->run();

                    // batasi text
                    $text = substr($text, 0, 5000);

                    // ================= CLEAN TEXT =================
                    $fullText = TextHelper::cleanText($text);

                } catch (\Exception $e) {

                    $fullText = null;
                }
            }
        }

        // ================= SENTIMEN =================
        $sentimen = 'Netral';

        // prioritas manual
        if ($request->filled('sentimen')) {

            $sentimen = $request->sentimen;

        } else {

            // otomatis dari OCR
            if ($fullText) {

                $sentimen = TextHelper::analisisSentimen($fullText);

            } else {

                // fallback dari ringkasan
                $sentimen = TextHelper::analisisSentimen($ringkasan);
            }
        }

        // ================= UPDATE DATA =================
        $berita->update([

            'tanggal' => $request->tanggal,

            // FULL MANUAL TANPA OCR
            'judul' => $request->judul,

            'media' => is_array($request->media)
                ? implode(', ', $request->media)
                : $request->media,

            'kategori' => $request->kategori,

            'sentimen' => $sentimen,

            'ringkasan' => $ringkasan,

            'gambar' => $namaGambar

        ]);

        return redirect()
            ->route('berita.index')
            ->with('success', 'Berita berhasil diedit ✅');
    }

    // ================= DELETE =================
    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);

        // hapus gambar
        if ($berita->gambar) {

            Storage::disk('public')->delete($berita->gambar);
        }

        // hapus data
        $berita->delete();

        return redirect()
            ->route('berita.index')
            ->with('success', 'Berita berhasil dihapus ✅');
    }

    // ================= DETAIL =================
    public function show($id)
    {
        $berita = Berita::findOrFail($id);

        return view('berita.lihat', compact('berita'));
    }

    // ================= EXPORT PDF =================
    public function exportPdf($id)
    {
        $berita = Berita::findOrFail($id);

        $pdf = Pdf::loadView('berita.laporan_pdf', compact('berita'))
            ->setPaper('A4', 'portrait');

        return $pdf->download('laporan-berita-' . $berita->id . '.pdf');
    }
}