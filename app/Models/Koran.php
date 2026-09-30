<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Koran extends Model
{
    protected $fillable = [
        'media',
        'penerbit',
        'kategori',
        'status'
    ];

    // 🔥 RELASI KE BERITA
    public function berita()
    {
        return $this->hasMany(Berita::class);
    }
}