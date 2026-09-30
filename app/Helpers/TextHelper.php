<?php

namespace App\Helpers;

class TextHelper
{
    // ================= PDF to TEXT =================
    public static function pdfToText($pdfPath)
    {
        $tempDir = storage_path('app/public/temp/');

        // buat folder jika belum ada
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        $imagePath = $tempDir . 'page';

        // ================= CONVERT PDF KE GAMBAR =================
        $cmd1 = "\"C:\\Program Files\\ImageMagick-7.1.2-Q16-HDRI\\magick.exe\" -density 300 \"$pdfPath\" \"$imagePath-%d.png\"";

        shell_exec($cmd1);

        $text = '';

        // ================= OCR PER HALAMAN =================
        foreach (glob($tempDir . "page-*.png") as $img) {

            $cmd2 = "\"C:\\Program Files\\Tesseract-OCR\\tesseract.exe\" \"$img\" stdout -l ind+eng";

            $hasil = shell_exec($cmd2);

            if ($hasil) {
                $text .= $hasil . " ";
            }

            // ================= HAPUS FILE TEMP =================
            if (file_exists($img)) {
                unlink($img);
            }
        }

        return trim($text);
    }

    // ================= CLEAN TEXT =================
    public static function cleanText($text)
    {
        if (!$text) {
            return '';
        }

        // hapus karakter aneh
        $text = preg_replace('/[^\p{L}\p{N}\s\.\,\?\!]/u', ' ', $text);

        // rapikan spasi
        $text = preg_replace('/\s+/u', ' ', $text);

        // rapikan tanda baca
        $text = preg_replace('/\s*([.,?!])\s*/u', '$1 ', $text);

        // hilangkan spasi berlebih lagi
        $text = preg_replace('/\s+/u', ' ', $text);

        return trim($text);
    }

    // ================= SENTIMEN =================
    public static function analisisSentimen($text)
    {
        if (!$text) {
            return 'Netral';
        }

        // lowercase hanya untuk analisis
        $text = mb_strtolower(self::cleanText($text));

        // ================= KATA POSITIF =================
        $positif = [

            'baik',
            'bagus',
            'hebat',
            'meningkat',
            'sukses',
            'maju',
            'positif',
            'unggul',
            'berhasil',
            'bantuan',
            'bantu',
            'menyalurkan',
            'memberikan',
            'kepedulian',
            'peduli',
            'dukungan',
            'melayani',
            'kesejahteraan',
            'program',
            'kegiatan',
            'kerja sama',
            'kolaborasi',
            'penghargaan',
            'apresiasi',
            'membantu',
            'pembangunan',
            'pelayanan',
            'donasi',
            'sosial',
            'amal',
            'zakat'

        ];

        // ================= KATA NEGATIF =================
        $negatif = [

            'buruk',
            'jelek',
            'turun',
            'gagal',
            'negatif',
            'krisis',
            'masalah',
            'konflik',
            'kerugian',
            'rugi',
            'defisit',
            'lambat',
            'macet',
            'kacau',
            'rusak',
            'parah',
            'menurun',
            'anjlok',
            'korupsi',
            'pelanggaran',
            'ilegal',
            'kelalaian',
            'kecelakaan',
            'kekurangan',
            'keterlambatan',
            'kegagalan',
            'penurunan',
            'melemah',
            'pengangguran',
            'kemiskinan',
            'ketimpangan',
            'keluhan',
            'protes',
            'demo',
            'kerusuhan',
            'ketidakpuasan',
            'gangguan',
            'error',
            'overload',
            'pemborosan'

        ];

        $score = 0;

        // ================= HITUNG POSITIF =================
        foreach ($positif as $kata) {

            $jumlah = preg_match_all(
                '/\b' . preg_quote($kata, '/') . '\b/u',
                $text
            );

            $score += $jumlah;
        }

        // ================= HITUNG NEGATIF =================
        foreach ($negatif as $kata) {

            $jumlah = preg_match_all(
                '/\b' . preg_quote($kata, '/') . '\b/u',
                $text
            );

            $score -= $jumlah;
        }

        // ================= HASIL =================
        if ($score >= 2) {
            return 'Positif';
        }

        if ($score <= -2) {
            return 'Negatif';
        }

        return 'Netral';
    }

    // ================= RINGKASAN =================
    public static function ringkasan($text)
    {
        if (!$text) {
            return '-';
        }

        // ================= CLEANING =================
        $text = self::cleanText($text);

        // ================= PECAH KALIMAT =================
        $kalimat = preg_split('/(?<=[.?!])\s+/u', $text);

        if (!$kalimat || count($kalimat) === 0) {
            return mb_substr($text, 0, 250) . '...';
        }

        $kalimat_bersih = [];

        foreach ($kalimat as $k) {

            $k = trim($k);

            // kosong
            if (!$k) {
                continue;
            }

            // terlalu pendek
            if (mb_strlen($k) < 40) {
                continue;
            }

            // OCR rusak
            if (preg_match('/(.)\\1{6,}/u', $k)) {
                continue;
            }

            // terlalu banyak simbol
            if (preg_match('/[^A-Za-zÀ-ÿ0-9\s\.\,\?\!]/u', $k)) {
                continue;
            }

            // kata pertama terlalu panjang
            $firstWord = explode(' ', $k)[0] ?? '';

            if (mb_strlen($firstWord) > 20) {
                continue;
            }

            // kapitalisasi awal kalimat
            $k = mb_strtoupper(mb_substr($k, 0, 1)) .
                 mb_substr($k, 1);

            $kalimat_bersih[] = $k;
        }

        // ================= FALLBACK =================
        if (empty($kalimat_bersih)) {

            $fallback = mb_substr($text, 0, 250);

            return ucfirst($fallback) . '...';
        }

        // ================= AMBIL 3 KALIMAT PERTAMA =================
        $hasil = array_slice($kalimat_bersih, 0, 100);

        return implode(' ', $hasil);
    }

    // ================= JUDUL MANUAL =================
    public static function generateJudul($judul)
    {
        // wajib isi manual
        if (!$judul || trim($judul) === '') {

            return 'Judul Harus Diisi';
        }

        // rapikan spasi
        $judul = preg_replace('/\s+/u', ' ', trim($judul));

        // format title case
        $judul = mb_convert_case(

            $judul,

            MB_CASE_TITLE,

            "UTF-8"
        );

        return $judul;
    }
}