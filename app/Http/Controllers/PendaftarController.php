<?php

namespace App\Http\Controllers;

use App\Models\Pendaftar;
use App\Models\SkemaJadwal;
use App\Models\SkemaUji;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class PendaftarController extends Controller
{
    public function index(Request $request)
    {
        // Tangkap parameter filter, search, & pagination
        $search   = $request->get('search');
        $skemaId  = $request->get('skema_uji_id');
        $jadwalId = $request->get('skema_jadwal_id');
        $status   = $request->get('status');
        $perPage  = $request->get('per_page', 10);

        // Sorting params (default: created_at desc)
        $sortBy  = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');

        // Whitelist kolom sorting untuk keamanan SQL Injection
        $allowedSorts = ['id', 'nama_lengkap', 'nik', 'created_at', 'status'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }
        if (!in_array(strtolower($sortDir), ['asc', 'desc'])) {
            $sortDir = 'desc';
        }

        // Query Pendaftar dengan eager loading relasi
        $query = Pendaftar::with('skema_jadwal.skema_uji');

        // Filter berdasarkan Search (Nama, NIK, Nama Skema, Nama Jadwal)
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhereHas('skema_jadwal.skema_uji', function ($qSkema) use ($search) {
                      $qSkema->where('nama_skema', 'like', "%{$search}%");
                  })
                  ->orWhereHas('skema_jadwal', function ($qJadwal) use ($search) {
                      $qJadwal->where('nama_jadwal', 'like', "%{$search}%");
                  });
            });
        }

        // Filter berdasarkan Skema Uji
        if ($skemaId) {
            $query->whereHas('skema_jadwal', function ($q) use ($skemaId) {
                $q->where('skema_uji_id', $skemaId);
            });
        }

        // Filter berdasarkan Jadwal Uji
        if ($jadwalId) {
            $query->where('skema_jadwal_id', $jadwalId);
        }

        // Filter berdasarkan Status (pending / Diterima / Ditolak)
        if ($status !== null && $status !== '') {
            if ($status === 'pending') {
                $query->whereNull('status');
            } else {
                $query->where('status', $status);
            }
        }

        // Dapatkan data hasil sorting & pagination
        $pendaftars = $query->orderBy($sortBy, $sortDir)
                            ->paginate($perPage)
                            ->appends($request->all());

        // Ambil data Skema & Jadwal untuk isi dropdown filter
        $skemaUjis = SkemaUji::all();
        $jadwals   = SkemaJadwal::with('skema_uji')->get();

        return view('admin.pendaftar.index', compact(
            'pendaftars', 'skemaUjis', 'jadwals', 
            'search', 'skemaId', 'jadwalId', 'status', 
            'perPage', 'sortBy', 'sortDir'
        ));
    }

    public function show($id)
    {
        $pendaftar = Pendaftar::with('skema_jadwal.skema_uji')->findOrFail($id);
        return view('admin.pendaftar.show', compact('pendaftar'));
    }

    // Method baru untuk Update Status (Diterima / Ditolak / Reset)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'nullable|in:Diterima,Ditolak',
        ]);

        $pendaftar = Pendaftar::findOrFail($id);
        $pendaftar->status = $request->status;
        $pendaftar->save();

        $pesan = $request->status 
            ? "Status pendaftar berhasil diperbarui menjadi: {$request->status}." 
            : "Status pendaftar dikembalikan ke Pending (Menunggu).";

        return redirect()->back()->with('success', $pesan);
    }

    public function destroy($id)
    {
        $pendaftar = Pendaftar::findOrFail($id);
        
        // List 8 kolom file yang harus dihapus dari storage fisik
        $fileColumns = [
            'file_ijazah', 
            'file_sertifikat_pelatihan', 
            'file_surat_pengalaman', 
            'file_pas_foto', 
            'file_identitas', 
            'file_portofolio_upgrading', 
            'file_portofolio_laporan', 
            'file_portofolio_pengalaman'
        ];

        // Hapus file fisik jika file ada di storage
        foreach ($fileColumns as $column) {
            if ($pendaftar->$column && Storage::disk('public')->exists($pendaftar->$column)) {
                Storage::disk('public')->delete($pendaftar->$column);
            }
        }

        // Hapus record dari database
        $pendaftar->delete();

        return redirect()->route('admin.pendaftar.index')->with('success', 'Data pendaftar beserta seluruh file fisiknya berhasil dihapus secara permanen.');
    }

    // Halaman khusus Tampilan Cetak PDF (menggunakan browser print)
    public function cetakPdf($id)
    {
        $pendaftar = Pendaftar::with('skema_jadwal.skema_uji')->findOrFail($id);
        return view('admin.pendaftar.pdf', compact('pendaftar'));
    }

    // Export ZIP khusus Berkas Lampiran tanpa DomPDF
    public function exportZip($id)
    {
        $pendaftar = Pendaftar::with('skema_jadwal.skema_uji')->findOrFail($id);
        
        $namaClean = str_replace(' ', '_', preg_replace('/[^A-Za-z0-9\-]/', '', $pendaftar->nama_lengkap));
        $zipFileName = "Lampiran_Pendaftar_{$pendaftar->nik}_{$namaClean}.zip";
        $zipPath = storage_path("app/public/{$zipFileName}");

        $zip = new ZipArchive;

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            
            $fileColumns = [
                'file_ijazah'                => '01_Ijazah_Transkrip',
                'file_sertifikat_pelatihan'  => '02_Sertifikat_Pelatihan',
                'file_surat_pengalaman'      => '03_Surat_Pengalaman',
                'file_pas_foto'              => '04_Pas_Foto',
                'file_identitas'             => '05_Identitas_KTP_Pelajar',
                'file_portofolio_upgrading'  => '06_Portofolio_Upgrading',
                'file_portofolio_laporan'    => '07_Portofolio_Laporan',
                'file_portofolio_pengalaman' => '08_Portofolio_Pengalaman',
            ];

            foreach ($fileColumns as $column => $aliasName) {
                $filePath = $pendaftar->$column;
                
                if ($filePath && Storage::disk('public')->exists($filePath)) {
                    $absolutePath = Storage::disk('public')->path($filePath);
                    $ext = pathinfo($filePath, PATHINFO_EXTENSION);
                    
                    $zipInternalPath = "{$aliasName}.{$ext}";
                    $zip->addFile($absolutePath, $zipInternalPath);
                }
            }

            $zip->close();
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}