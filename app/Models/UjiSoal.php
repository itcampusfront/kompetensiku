<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class UjiSoal extends Model
{
    protected $table = 'uji_soals';

    protected $fillable = [
        'uji_id',
        'tipe',
        'pertanyaan',
        'media', // Menggunakan kolom media existing untuk path file gambar
        'opsi_jawaban',
        'opsi_media',
        'kunci_jawaban',
        'bobot_nilai',
    ];

    protected $casts = [
        'opsi_jawaban' => 'array',
        'opsi_media' => 'array',
        'kunci_jawaban' => 'array',
    ];

    public function uji()
    {
        return $this->belongsTo(Uji::class, 'uji_id');
    }

    /**
     * Accessor untuk mendapatkan URL Gambar/Media Soal secara langsung
     */
    public function getMediaUrlAttribute()
    {
        if ($this->media && Storage::disk('public')->exists($this->media)) {
            return asset('storage/' . $this->media);
        }
        return null;
    }

    /**
     * Accessor untuk mendapatkan daftar URL Gambar per Opsi Jawaban (A-E)
     */
    public function getOpsiMediaUrlsAttribute(): array
    {
        $mediaList = is_array($this->opsi_media) ? $this->opsi_media : [];
        $urls = [];

        foreach ($mediaList as $idx => $path) {
            if (!empty($path) && Storage::disk('public')->exists($path)) {
                $urls[$idx] = asset('storage/' . $path);
            } else {
                $urls[$idx] = null;
            }
        }

        return $urls;
    }

    /**
     * Lifecycle Management Pembersihan File Sampah (Anti-Junk File)
     */
    protected static function booted()
    {
        // 1. Otomatis hapus file media fisik (soal & opsi jawaban) dari storage server saat soal dihapus
        static::deleting(function ($soal) {
            if ($soal->media && Storage::disk('public')->exists($soal->media)) {
                Storage::disk('public')->delete($soal->media);
            }

            $opsiMedia = is_array($soal->opsi_media) ? $soal->opsi_media : [];
            foreach ($opsiMedia as $path) {
                if (!empty($path) && Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }
        });

        // 2. Otomatis hapus file media lama dari storage server jika gambar soal atau gambar opsi di-edit / diganti / dihapus
        static::updating(function ($soal) {
            if ($soal->isDirty('media')) {
                $mediaLama = $soal->getOriginal('media');
                if ($mediaLama && Storage::disk('public')->exists($mediaLama)) {
                    Storage::disk('public')->delete($mediaLama);
                }
            }

            if ($soal->isDirty('opsi_media')) {
                $lamaRaw = $soal->getOriginal('opsi_media');
                $mediaOpsiLama = is_array($lamaRaw) ? $lamaRaw : (json_decode((string) $lamaRaw, true) ?? []);
                $mediaOpsiBaru = is_array($soal->opsi_media) ? $soal->opsi_media : [];

                foreach ($mediaOpsiLama as $idx => $pathLama) {
                    $pathBaru = $mediaOpsiBaru[$idx] ?? null;
                    if (!empty($pathLama) && $pathLama !== $pathBaru && Storage::disk('public')->exists($pathLama)) {
                        Storage::disk('public')->delete($pathLama);
                    }
                }
            }
        });
    }
}