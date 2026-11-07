<?php

namespace App\Http\Controllers;

use App\Models\Pendaftar;
use App\Models\SkemaJadwal;
use App\Models\SkemaUji;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FrontRegisterController extends Controller
{
    public function index()
    {
        $today = date('Y-m-d');

        // Ambil Skema Uji yang aktif
        $skemaUjis = SkemaUji::where('status', 'Aktif')->with('skema_uks')->get();

        // Filter Jadwal: Status 'Buka' DAN hari ini di antara tgl_mulai sampai tgl_selesai
        $jadwals = SkemaJadwal::where('status', 'Buka')
            ->whereDate('tgl_mulai', '<=', $today)
            ->whereDate('tgl_selesai', '>=', $today)
            ->get();

        return view('front.register.index', compact('skemaUjis', 'jadwals'));
    }

    public function store(Request $request)
    {
        // Custom message agar error yang tampil di layar client sangat jelas
        $messages = [
            'required' => ':attribute wajib diisi.',
            'max'      => ':attribute tidak boleh lebih dari :max KB (2 MB).',
            'mimes'    => ':attribute harus berupa file dengan format: :values.',
            'image'    => ':attribute harus berupa file foto/gambar (JPG/PNG).',
            'email'    => 'Format :attribute tidak valid.',
        ];

        $attributes = [
            'skema_jadwal_id'           => 'Jadwal Uji Kompetensi',
            'nik'                       => 'NIK',
            'nama_lengkap'              => 'Nama Lengkap',
            'jenis_kelamin'             => 'Jenis Kelamin',
            'tempat_lahir'              => 'Tempat Lahir',
            'tgl_lahir'                 => 'Tanggal Lahir',
            'alamat_domisili'           => 'Alamat Domisili',
            'no_telp'                   => 'No. Telephone/WhatsApp',
            'file_pas_foto'             => 'File Pasfoto',
            'file_identitas'            => 'File KTP/Identitas',
            'file_ijazah'               => 'File Ijazah/Transkrip',
            'file_sertifikat_pelatihan' => 'File Sertifikat Pelatihan',
            'file_surat_pengalaman'     => 'File Surat Pengalaman',
            'file_portofolio_upgrading' => 'File Portofolio Upgrading',
            'file_portofolio_laporan'   => 'File Portofolio Laporan',
            'file_portofolio_pengalaman' => 'File Portofolio Pengalaman',
        ];

        // Validasi data (mencakup biodata dan file wajib/opsional)
        $request->validate([
            'skema_jadwal_id'           => 'required|exists:skema_jadwals,id',
            'nik'                       => 'required|string|max:255',
            'nama_lengkap'              => 'required|string|max:255',
            'jenis_kelamin'             => 'required|string',
            'tempat_lahir'              => 'required|string|max:255',
            'tgl_lahir'                 => 'required|date',
            'alamat_domisili'           => 'required|string',
            'no_telp'                   => 'required|string|max:50',
            'email'                     => 'nullable|email|max:255',
            // Validasi file wajib (2MB = 2048 KB)
            'file_pas_foto'             => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'file_identitas'            => 'required|file|mimes:jpg,jpeg,png|max:2048',
            // Validasi file opsional pendukung & portofolio
            'file_ijazah'               => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_sertifikat_pelatihan' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_surat_pengalaman'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_portofolio_upgrading' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_portofolio_laporan'   => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_portofolio_pengalaman'=> 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], $messages,$attributes);

        try {
            // Ambil data jadwal & skema untuk struktur folder penyimpanan
            $jadwal = SkemaJadwal::with('skema_uji')->findOrFail($request->skema_jadwal_id);
            $idSkema =$jadwal->skema_uji_id;
            $idJadwal =$jadwal->id;

            // Format penamaan file: Nama_Lengkap_01, dst
            $namaBersih = str_replace(' ', '_', trim($request->nama_lengkap));$folderPath = "register/{$idSkema}/{$idJadwal}";

            $fileData = [];$filesMap = [
                'file_ijazah'                => '01',
                'file_sertifikat_pelatihan'  => '02',
                'file_surat_pengalaman'      => '03',
                'file_pas_foto'              => '04',
                'file_identitas'             => '05',
                'file_portofolio_upgrading'  => '06',
                'file_portofolio_laporan'    => '07',
                'file_portofolio_pengalaman' => '08',
            ];

            // Proses upload file manual ke storage public
            foreach ($filesMap as $inputName =>$code) {
                if ($request->hasFile($inputName)) {$file = $request->file($inputName);
                    
                    // Cek jika ada error upload dari php runtime
                    if (!$file->isValid()) {
                        throw new \Exception("File {$inputName} tidak valid atau gagal terunggah ke server.");
                    }

                    $ext =$file->getClientOriginalExtension();
                    $fileName = "{$namaBersih}_{$code}.{$ext}";
                    
                    // Simpan ke storage/app/public/register/{id_skema}/{id_jadwal}/nama_file
                    $path = $file->storeAs($folderPath, $fileName, 'public');$fileData[$inputName] =$path;
                }
            }

            // Simpan data pendaftar ke database
            $pendaftarData = array_merge($request->except(array_keys($filesMap)),$fileData);
            Pendaftar::create($pendaftarData);

            return redirect()->route('front.register.index')->with('success', 'Pendaftaran berhasil dikirim! Data dan dokumen Anda sedang diproses.');

        } catch (\Exception $e) {
            // Catat log server
            Log::error('Gagal Simpan Pendaftaran: ' . $e->getMessage(), [
                'nama' => $request->nama_lengkap,
                'nik'  => $request->nik
            ]);

            // Kembalikan ke form dengan pesan error yang terbaca jelas
            return redirect()->back()
                ->withInput()
                ->withErrors(['system_error' => 'Terjadi kesalahan sistem saat menyimpan berkas: ' . $e->getMessage()]);
        }
    }
}