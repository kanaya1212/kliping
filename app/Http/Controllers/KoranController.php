<?php

namespace App\Http\Controllers;

use App\Models\Koran;
use Illuminate\Http\Request;

class KoranController extends Controller
{
    // ================= LIST DATA =================
    public function index(Request $request)
    {
        $query = Koran::query();

        // ================= SEARCH =================
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('media', 'like', '%' . $request->search . '%')
                  ->orWhere('penerbit', 'like', '%' . $request->search . '%');
            });
        }

        // ================= FILTER STATUS =================
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // ================= DATA =================
        $korans = $query->latest()->paginate(10)->withQueryString();

        return view('koran.index', [
            'korans'   => $korans,
            'total'    => Koran::count(),
            'aktif'    => Koran::where('status', 'Aktif')->count(),
            'nasional' => Koran::where('kategori', 'Nasional')->count(),
            'regional' => Koran::where('kategori', 'Regional')->count(),
        ]);
    }

    // ================= FORM TAMBAH =================
    public function create()
    {
        return view('koran.create');
    }

    // ================= SIMPAN DATA =================
    public function store(Request $request)
    {
        $request->validate([
            'media'     => 'required|string|max:255',
            'penerbit'  => 'required|string|max:255',
            'kategori'  => 'required|in:Regional,Nasional',
            'status'    => 'required|in:Aktif,Tidak Aktif',
        ]);

        Koran::create([
            'media'     => $request->media,
            'penerbit'  => $request->penerbit,
            'kategori'  => $request->kategori,
            'status'    => $request->status,
        ]);

        return redirect('/koran')->with('success', 'Koran berhasil ditambahkan');
    }

    // ================= FORM EDIT =================
    public function edit($id)
    {
        $koran = Koran::findOrFail($id);
        return view('koran.edit', compact('koran'));
    }

    // ================= UPDATE DATA =================
    public function update(Request $request, $id)
    {
        $request->validate([
            'media'     => 'required|string|max:255',
            'penerbit'  => 'required|string|max:255',
            'kategori'  => 'required|in:Regional,Nasional',
            'status'    => 'required|in:Aktif,Tidak Aktif',
        ]);

        $koran = Koran::findOrFail($id);

        $koran->update([
            'media'     => $request->media,
            'penerbit'  => $request->penerbit,
            'kategori'  => $request->kategori,
            'status'    => $request->status,
        ]);

        return redirect('/koran')->with('success', 'Koran berhasil diedit');
    }

    // ================= HAPUS DATA =================
    public function destroy($id)
    {
        $koran = Koran::findOrFail($id);
        $koran->delete();

        return back()->with('success', 'Koran berhasil dihapus');
    }
}