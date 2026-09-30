<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $fillable = [
        'koran_id', 
        'tanggal',
        'judul',
        'media',
        'kategori',
        'sentimen',
        'ringkasan',
        'gambar',
        'file_pdf'
    ];

    // 🔥 RELASI KE KORAN
    public function koran()
    {
        return $this->belongsTo(Koran::class);
    }
}