<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Uji;
use App\Models\UjiSoal;
use App\Models\UjiHasil;
use App\Models\UjiJawaban;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SbaController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil daftar ID user yang memiliki asesmen dari tabel ujis
        $authorIds = Uji::select('user_id')->distinct()->pluck('user_id');
        
        // SESUAIKAN KOLOM DENGAN STRUKTUR TABEL USERS KOMPETENSIKU (id_user, nama_user)
        $authors = \App\Models\User::whereIn('id_user', $authorIds)->get(['id_user', 'nama_user']);

        // 2. Query Utama Uji
        $query = Uji::with('author')->withCount(['hasils', 'soals']);

        // Filter Search (Kode Uji, Judul, Deskripsi)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_uji', 'like', "%{$search}%")
                  ->orWhere('judul', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // Filter Author
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sorting Kolom (Default: id DESC / Latest)
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'desc');
        $allowedSorts = ['id', 'kode_uji', 'judul', 'user_id', 'waktu_mulai', 'status'];

        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder === 'asc' ? 'asc' : 'desc');
        } else {
            $query->latest('id');
        }

        // Per Page Pagination (Default: 10)
        $perPage = (int) $request->get('per_page', 10);
        $ujis = $query->paginate($perPage)->withQueryString();

        return view('sba.index', compact('ujis', 'authors'));
    }

    public function create()
    {
        return view('sba.form');
    }

    public function edit(Uji $uji)
    {
        $uji->load('soals');
        return view('sba.form', compact('uji'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'kode_uji' => strtoupper(trim((string) $request->kode_uji)),
        ]);

        $request->validate([
            'judul'                 => 'required|string|max:255',
            'kode_uji'              => 'required|string|max:20|alpha_num|unique:ujis,kode_uji',
            'durasi_menit'          => 'required|integer|min:0',
            'toleransi_pelanggaran' => 'required|integer|min:1',
            'waktu_mulai'           => 'nullable|date',
            'waktu_selesai'         => 'nullable|date|after_or_equal:waktu_mulai',
            'maksimal_percobaan'    => 'nullable|integer|min:1',
            'soals'                 => 'required|array|min:1',
            'soals.*.pertanyaan'    => 'required|string',
            'soals.*.tipe'          => 'required|in:pg,pg_kompleks,esai',
            'soals.*.media'         => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'kode_uji.unique'    => 'Kode Asesmen sudah digunakan oleh ujian lain. Silakan gunakan kode berbeda.',
            'kode_uji.alpha_num' => 'Kode Asesmen hanya boleh berisi huruf dan angka tanpa spasi.',
        ]);

        // 1. Buat Ujian Utama
        $uji = Uji::create([
            'user_id'               => auth()->id(),
            'kode_uji'              => $request->kode_uji,
            'judul'                 => $request->judul,
            'deskripsi'             => $request->deskripsi,
            'waktu_mulai'           => $request->waktu_mulai,
            'waktu_selesai'         => $request->waktu_selesai,
            'durasi_menit'          => $request->durasi_menit,
            'acak_soal'             => $request->boolean('acak_soal'),
            'tampilkan_nilai'       => $request->boolean('tampilkan_nilai'),
            'buka_untuk_umum'       => $request->boolean('buka_untuk_umum'),
            'open_book'             => $request->boolean('open_book'),
            'toleransi_pelanggaran' => $request->toleransi_pelanggaran,
            'maksimal_percobaan'    => $request->maksimal_percobaan ?? 1,
            'ulangi_jika_gagal'     => $request->boolean('ulangi_jika_gagal'),
            'status'                => $request->status ?? 'draft',
        ]);

        // 2. Simpan Setiap Soal & File Media (Jika Ada)
        foreach ($request->soals as $index => $soalData) {
            $pathMedia = null;

            if ($request->hasFile("soals.{$index}.media")) {
                $pathMedia = $request->file("soals.{$index}.media")->store('soal-images', 'public');
            }

            UjiSoal::create([
                'uji_id'        => $uji->id,
                'tipe'          => $soalData['tipe'],
                'pertanyaan'    => $soalData['pertanyaan'],
                'media'         => $pathMedia,
                'opsi_jawaban'  => isset($soalData['opsi_jawaban']) ? array_values($soalData['opsi_jawaban']) : null,
                'kunci_jawaban' => isset($soalData['kunci_jawaban']) ? (array) $soalData['kunci_jawaban'] : null,
                'bobot_nilai'   => $soalData['bobot_nilai'] ?? 10,
            ]);
        }

        return redirect()->route('sba.index')->with('success', 'Ujian dan soal berhasil dibuat!');
    }

    public function update(Request $request, $id)
    {
        $uji = Uji::with('soals')->findOrFail($id);

        $request->merge([
            'kode_uji' => strtoupper(trim((string) $request->kode_uji)),
        ]);

        $request->validate([
            'judul'                 => 'required|string|max:255',
            'kode_uji'              => 'required|string|max:20|alpha_num|unique:ujis,kode_uji,' . $uji->id,
            'durasi_menit'          => 'required|integer|min:0',
            'toleransi_pelanggaran' => 'required|integer|min:1',
            'waktu_mulai'           => 'nullable|date',
            'waktu_selesai'         => 'nullable|date|after_or_equal:waktu_mulai',
            'maksimal_percobaan'    => 'nullable|integer|min:1',
            'soals'                 => 'required|array|min:1',
            'soals.*.pertanyaan'    => 'required|string',
            'soals.*.tipe'          => 'required|in:pg,pg_kompleks,esai',
            'soals.*.media'         => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'kode_uji.unique'    => 'Kode Asesmen sudah digunakan oleh ujian lain. Silakan gunakan kode berbeda.',
            'kode_uji.alpha_num' => 'Kode Asesmen hanya boleh berisi huruf dan angka tanpa spasi.',
        ]);

        // 1. Update Data Utama Ujian
        $uji->update([
            'kode_uji'              => $request->kode_uji,
            'judul'                 => $request->judul,
            'deskripsi'             => $request->deskripsi,
            'waktu_mulai'           => $request->waktu_mulai,
            'waktu_selesai'         => $request->waktu_selesai,
            'durasi_menit'          => $request->durasi_menit,
            'acak_soal'             => $request->boolean('acak_soal'),
            'tampilkan_nilai'       => $request->boolean('tampilkan_nilai'),
            'buka_untuk_umum'       => $request->boolean('buka_untuk_umum'),
            'open_book'             => $request->boolean('open_book'),
            'toleransi_pelanggaran' => $request->toleransi_pelanggaran,
            'maksimal_percobaan'    => $request->maksimal_percobaan ?? 1,
            'ulangi_jika_gagal'     => $request->boolean('ulangi_jika_gagal'),
            'status'                => $request->status,
        ]);

        // 2. Hapus Soal di Database yang Dihapus oleh User di Form
        $inputSoalIds = array_filter(array_column($request->soals, 'id'));
        $uji->soals()->whereNotIn('id', $inputSoalIds)->get()->each->delete();

        // 3. Simpan / Update Soals
        foreach ($request->soals as $index => $soalData) {
            $soalId = $soalData['id'] ?? null;
            $soalEksis = $soalId ? UjiSoal::find($soalId) : new UjiSoal();

            $pathMedia = $soalEksis->media;

            // Cek jika ada request hapus gambar eksisting
            if (isset($soalData['remove_media']) && $soalData['remove_media'] == '1') {
                if ($pathMedia && Storage::disk('public')->exists($pathMedia)) {
                    Storage::disk('public')->delete($pathMedia);
                }
                $pathMedia = null;
            }

            // Cek jika ada file gambar baru yang diunggah
            if ($request->hasFile("soals.{$index}.media")) {
                if ($pathMedia && Storage::disk('public')->exists($pathMedia)) {
                    Storage::disk('public')->delete($pathMedia);
                }
                $pathMedia = $request->file("soals.{$index}.media")->store('soal-images', 'public');
            }

            $soalEksis->fill([
                'uji_id'        => $uji->id,
                'tipe'          => $soalData['tipe'],
                'pertanyaan'    => $soalData['pertanyaan'],
                'media'         => $pathMedia,
                'opsi_jawaban'  => isset($soalData['opsi_jawaban']) ? array_values($soalData['opsi_jawaban']) : null,
                'kunci_jawaban' => isset($soalData['kunci_jawaban']) ? (array) $soalData['kunci_jawaban'] : null,
                'bobot_nilai'   => $soalData['bobot_nilai'] ?? 10,
            ]);

            $soalEksis->save();
        }

        return redirect()->route('sba.index')->with('success', 'Perubahan ujian dan soal berhasil disimpan!');
    }

    /**
     * Duplikat Ujian Beserta Seluruh Butir Soal & Gambar Media
     */
    public function duplicate($id)
    {
        $ujiAsli = Uji::with('soals')->findOrFail($id);

        do {
            $kodeBaru = strtoupper(Str::random(6));
        } while (Uji::where('kode_uji', $kodeBaru)->exists());

        $ujiBaru = Uji::create([
            'user_id'               => auth()->id(),
            'kode_uji'              => $kodeBaru,
            'judul'                 => $ujiAsli->judul . ' (Salinan)',
            'deskripsi'             => $ujiAsli->deskripsi,
            'waktu_mulai'           => $ujiAsli->waktu_mulai,
            'waktu_selesai'         => $ujiAsli->waktu_selesai,
            'durasi_menit'          => $ujiAsli->durasi_menit,
            'acak_soal'             => $ujiAsli->acak_soal,
            'tampilkan_nilai'       => $ujiAsli->tampilkan_nilai,
            'buka_untuk_umum'       => $ujiAsli->buka_untuk_umum,
            'open_book'             => $ujiAsli->open_book,
            'toleransi_pelanggaran' => $ujiAsli->toleransi_pelanggaran,
            'maksimal_percobaan'    => $ujiAsli->maksimal_percobaan,
            'ulangi_jika_gagal'     => $ujiAsli->ulangi_jika_gagal,
            'status'                => 'draft',
        ]);

        foreach ($ujiAsli->soals as $soal) {
            $mediaBaru = null;
            if ($soal->media && Storage::disk('public')->exists($soal->media)) {
                $ext = pathinfo($soal->media, PATHINFO_EXTENSION);
                $mediaBaru = 'soal-images/' . Str::random(40) . ($ext ? '.' . $ext : '');
                Storage::disk('public')->copy($soal->media, $mediaBaru);
            }

            UjiSoal::create([
                'uji_id'        => $ujiBaru->id,
                'tipe'          => $soal->tipe,
                'pertanyaan'    => $soal->pertanyaan,
                'media'         => $mediaBaru,
                'opsi_jawaban'  => $soal->opsi_jawaban,
                'kunci_jawaban' => $soal->kunci_jawaban,
                'bobot_nilai'   => $soal->bobot_nilai,
            ]);
        }

        return redirect()->route('sba.index')->with('success', "Asesmen berhasil diduplikasi dengan kode baru: {$kodeBaru} (Status: Draft).");
    }

    /**
     * Download Template Excel (.xls) untuk Import Soal
     */
    public function downloadTemplateSoal()
    {
        $fileName = 'Template_Import_Soal_SBA.xls';

        $headers = [
            "Content-Type"        => "application/vnd.ms-excel; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"$fileName\"",
            "Cache-Control"       => "max-age=0, no-cache, must-revalidate",
            "Pragma"              => "no-cache",
        ];

        $callback = function () {
            echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
            echo '<head><meta charset="utf-8"></head><body>';
            echo '<table border="1">';
            echo '<tr style="background-color:#5e72e4; color:#ffffff; font-weight:bold;">';
            echo '<th>tipe</th>';
            echo '<th>pertanyaan</th>';
            echo '<th>opsi_a</th>';
            echo '<th>opsi_b</th>';
            echo '<th>opsi_c</th>';
            echo '<th>opsi_d</th>';
            echo '<th>opsi_e</th>';
            echo '<th>kunci</th>';
            echo '<th>bobot</th>';
            echo '</tr>';

            // Contoh 1: PG
            echo '<tr>';
            echo '<td>pg</td>';
            echo '<td>Ibu kota Provinsi Jawa Tengah adalah...</td>';
            echo '<td>Surakarta</td>';
            echo '<td>Semarang</td>';
            echo '<td>Salatiga</td>';
            echo '<td>Magelang</td>';
            echo '<td>Tegal</td>';
            echo '<td>B</td>';
            echo '<td>10</td>';
            echo '</tr>';

            // Contoh 2: PG Kompleks
            echo '<tr>';
            echo '<td>pg_kompleks</td>';
            echo '<td>Manakah yang termasuk bahasa pemrograman web server-side?</td>';
            echo '<td>PHP</td>';
            echo '<td>HTML</td>';
            echo '<td>Python</td>';
            echo '<td>CSS</td>';
            echo '<td>Node.js</td>';
            echo '<td>A,C,E</td>';
            echo '<td>20</td>';
            echo '</tr>';

            // Contoh 3: Esai
            echo '<tr>';
            echo '<td>esai</td>';
            echo '<td>Jelaskan perbedaan antara HTTP dan HTTPS!</td>';
            echo '<td></td><td></td><td></td><td></td><td></td><td></td>';
            echo '<td>30</td>';
            echo '</tr>';

            echo '</table></body></html>';
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Parse File Upload Soal (CSV / Excel HTML / XLSX) & Kembalikan JSON Preview ke Form
     */
    public function importSoalPreview(Request $request)
    {
        $request->validate([
            'file_soal' => 'required|file|mimes:csv,txt,xls,xlsx|max:5120',
        ]);

        $file = $request->file('file_soal');
        $ext = strtolower($file->getClientOriginalExtension());
        $path = $file->getRealPath();
        $rows = [];

        try {
            $rawContent = file_get_contents($path);

            // Deteksi apakah file .xls sebenarnya berbasis HTML table (hasil export template)
            if (stripos($rawContent, '<table') !== false) {
                $dom = new \DOMDocument();
                @$dom->loadHTML('<?xml encoding="utf-8" ?>' . $rawContent);
                foreach ($dom->getElementsByTagName('tr') as $tr) {
                    $row = [];
                    foreach ($tr->childNodes as $cell) {
                        if (in_array(strtolower($cell->nodeName), ['td', 'th'])) {
                            $row[] = trim($cell->textContent);
                        }
                    }
                    if (!empty($row)) {
                        $rows[] = $row;
                    }
                }
            } elseif (class_exists(\PhpOffice\PhpSpreadsheet\IOFactory::class)) {
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
                $rows = $spreadsheet->getActiveSheet()->toArray(null, true, true, false);
            } elseif (in_array($ext, ['csv', 'txt'])) {
                $firstLine = strtok($rawContent, "\r\n");
                $delimiter = substr_count($firstLine, ';') > substr_count($firstLine, ',') ? ';' : ',';
                if (($handle = fopen($path, 'r')) !== false) {
                    while (($data = fgetcsv($handle, 0, $delimiter)) !== false) {
                        $rows[] = $data;
                    }
                    fclose($handle);
                }
            } else {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Format .xlsx membutuhkan library PhpSpreadsheet. Silakan simpan file sebagai .xls (dari Template) atau .csv.',
                ], 422);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal membaca file soal: ' . $e->getMessage(),
            ], 422);
        }

        if (count($rows) < 2) {
            return response()->json([
                'status'  => 'error',
                'message' => 'File tidak memiliki baris data soal (minimal 1 header + 1 baris soal).',
            ], 422);
        }

        $hurufMap = ['A' => '0', 'B' => '1', 'C' => '2', 'D' => '3', 'E' => '4'];
        $parsedSoals = [];

        foreach ($rows as $idx => $row) {
            if ($idx === 0) continue; // Lewati baris header

            $tipeRaw = strtolower(trim((string) ($row[0] ?? 'pg')));
            $pertanyaan = trim((string) ($row[1] ?? ''));
            if ($pertanyaan === '') continue;

            if (in_array($tipeRaw, ['pg_kompleks', 'pg kompleks', 'pgk', 'kompleks'])) {
                $tipe = 'pg_kompleks';
            } elseif (in_array($tipeRaw, ['esai', 'essay', 'uraian', 'isian'])) {
                $tipe = 'esai';
            } else {
                $tipe = 'pg';
            }

            $opsiJawaban = [
                trim((string) ($row[2] ?? '')),
                trim((string) ($row[3] ?? '')),
                trim((string) ($row[4] ?? '')),
                trim((string) ($row[5] ?? '')),
                trim((string) ($row[6] ?? '')),
            ];

            $kunciRaw = strtoupper(trim((string) ($row[7] ?? '')));
            $kunciJawaban = [];
            if ($kunciRaw !== '' && in_array($tipe, ['pg', 'pg_kompleks'])) {
                $parts = preg_split('/[\s,;]+/', $kunciRaw);
                foreach ($parts as $part) {
                    if (isset($hurufMap[$part])) {
                        $kunciJawaban[] = $hurufMap[$part];
                    } elseif (in_array($part, ['0', '1', '2', '3', '4'])) {
                        $kunciJawaban[] = $part;
                    }
                }
                $kunciJawaban = array_values(array_unique($kunciJawaban));
            }

            $bobot = (int) ($row[8] ?? 10);
            if ($bobot < 1) $bobot = 10;

            $parsedSoals[] = [
                'tipe'          => $tipe,
                'pertanyaan'    => $pertanyaan,
                'opsi_jawaban'  => $opsiJawaban,
                'kunci_jawaban' => $kunciJawaban,
                'bobot_nilai'   => $bobot,
            ];
        }

        if (empty($parsedSoals)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Tidak ada butir soal valid yang dapat diimpor dari file tersebut.',
            ], 422);
        }

        return response()->json([
            'status'  => 'success',
            'message' => count($parsedSoals) . ' soal berhasil dibaca.',
            'soals'   => $parsedSoals,
        ]);
    }

    /**
     * Hapus 1 Butir Soal Spesifik (Otomatis hapus file media via Model Event UjiSoal)
     */
    public function destroySoal($soal_id)
    {
        $soal = UjiSoal::findOrFail($soal_id);
        $soal->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Soal dan file media berhasil dihapus dari server.',
        ]);
    }

    /**
     * Hapus Seluruh Ujian (Otomatis hapus seluruh file media soal-soalnya)
     */
    public function destroy($id)
    {
        $uji = Uji::findOrFail($id);
        $uji->delete();

        return redirect()->route('sba.index')->with('success', 'Ujian beserta seluruh gambar soal berhasil dihapus!');
    }

    /**
     * Halaman Index Daftar Hasil Peserta / Asesi per Ujian
     */
    public function hasilIndex(Request $request, $uji_id)
    {
        $uji = Uji::findOrFail($uji_id);

        // Pemanggilan Query Utama
        $hasils = $this->getFilteredHasilQuery($request, $uji->id)
            ->paginate((int) $request->get('per_page', 10))
            ->withQueryString();

        return view('sba.hasil', compact('uji', 'hasils'));
    }

    /**
     * Helper Private Query Filter Hasil Ujian
     */
    private function getFilteredHasilQuery(Request $request, $uji_id)
    {
        $query = UjiHasil::where('uji_id', $uji_id)->with('asesi');

        // Filter Search (Asesi ID, Nama Peserta Publik, Nama User)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('asesi_id', 'like', "%{$search}%")
                  ->orWhere('nama_peserta_publik', 'like', "%{$search}%")
                  ->orWhereHas('asesi', function($userQuery) use ($search) {
                      $userQuery->where('nama_user', 'like', "%{$search}%");
                  });
            });
        }

        // Filter Status Pengerjaan
        if ($request->filled('status_pengerjaan')) {
            $query->where('status_pengerjaan', $request->status_pengerjaan);
        }

        // Filter Tanggal Mulai Pengerjaan
        if ($request->filled('tgl_mulai')) {
            $query->whereDate('waktu_mulai', '>=', $request->tgl_mulai);
        }
        if ($request->filled('tgl_selesai')) {
            $query->whereDate('waktu_mulai', '<=', $request->tgl_selesai);
        }

        // Checkbox: Sembunyikan Identitas Ganda (Ambil Percobaan Terbaru)
        if ($request->has('hide_duplicates') && $request->hide_duplicates == '1') {
            $subLatestIds = UjiHasil::where('uji_id', $uji_id)
                ->selectRaw('MAX(id) as max_id')
                ->groupByRaw("COALESCE(CAST(asesi_id AS CHAR), nama_peserta_publik)")
                ->pluck('max_id');

            $query->whereIn('id', $subLatestIds);
        }

        // Sorting Kolom (Default: total_skor DESC)
        $sortBy = $request->get('sort_by', 'total_skor');
        $sortOrder = $request->get('sort_order', 'desc');
        $allowedSorts = ['id', 'asesi_id', 'total_skor', 'waktu_mulai', 'status_pengerjaan'];

        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder === 'asc' ? 'asc' : 'desc');
        } else {
            $query->orderBy('total_skor', 'desc');
        }

        return $query;
    }

    /**
     * Ekspor Rekap Hasil (Excel .xls / PDF)
     */
    public function exportHasil(Request $request, $uji_id)
    {
        $uji = Uji::findOrFail($uji_id);
        $format = $request->get('format', 'excel');
        
        $dataHasils = $this->getFilteredHasilQuery($request, $uji->id)->get();

        if ($format === 'pdf') {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('sba.exports.hasil_pdf', compact('uji', 'dataHasils'))
                ->setPaper('a4', 'landscape');
                
            return $pdf->download("Rekap_Hasil_{$uji->kode_uji}.pdf");
        }

        // Export format Microsoft Excel (.xls) via HTML Spreadsheet Stream
        $fileName = "Rekap_Hasil_{$uji->kode_uji}.xls";
        
        $headers = [
            "Content-Type"        => "application/vnd.ms-excel; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"$fileName\"",
            "Cache-Control"       => "max-age=0, no-cache, must-revalidate",
            "Pragma"              => "no-cache",
        ];

        $callback = function() use ($uji, $dataHasils) {
            echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
            echo '<head><meta charset="utf-8"><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>Hasil Ujian</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head>';
            echo '<body>';
            echo '<table border="1">';
            echo '<tr style="background-color: #5e72e4; color: #ffffff; font-weight: bold;">';
            echo '<th>No</th>';
            echo '<th>ID Asesi</th>';
            echo '<th>Nama Peserta</th>';
            echo '<th>Percobaan Ke</th>';
            echo '<th>Waktu Mulai</th>';
            echo '<th>Waktu Selesai</th>';
            echo '<th>Durasi</th>';
            echo '<th>Status</th>';
            echo '<th>Skor Akhir</th>';
            echo '</tr>';

            foreach ($dataHasils as $idx => $row) {
                $nama = $row->asesi ? ($row->asesi->nama_user ?? $row->asesi->name) : ($row->nama_peserta_publik ?? 'Guest');
                
                $durasiText = '-';
                if ($row->waktu_mulai && $row->waktu_selesai) {
                    $totalDetik = $row->waktu_mulai->diffInSeconds($row->waktu_selesai);
                    $jam = floor($totalDetik / 3600);
                    $menit = floor(($totalDetik % 3600) / 60);
                    $detik = $totalDetik % 60;
                    $durasiText = sprintf('%02d:%02d:%02d', $jam, $menit, $detik);
                } elseif ($row->status_pengerjaan === 'berlangsung') {
                    $durasiText = 'Sedang Berjalan';
                }

                echo '<tr>';
                echo '<td>' . ($idx + 1) . '</td>';
                echo '<td>' . ($row->asesi_id ?? 'Publik') . '</td>';
                echo '<td>' . htmlspecialchars($nama) . '</td>';
                echo '<td>' . $row->percobaan_ke . '</td>';
                echo '<td>' . ($row->waktu_mulai ? $row->waktu_mulai->format('d/m/Y H:i:s') : '-') . '</td>';
                echo '<td>' . ($row->waktu_selesai ? $row->waktu_selesai->format('d/m/Y H:i:s') : '-') . '</td>';
                echo '<td>' . $durasiText . '</td>';
                echo '<td>' . strtoupper($row->status_pengerjaan) . '</td>';
                echo '<td>' . $row->total_skor . '</td>';
                echo '</tr>';
            }

            echo '</table>';
            echo '</html>';
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Hapus Data Hasil Ujian Peserta
     */
    public function hasilDestroy($hasil_id)
    {
        $hasil = UjiHasil::findOrFail($hasil_id);
        $ujiId = $hasil->uji_id;
        
        $hasil->jawabans()->delete();
        $hasil->delete();

        return redirect()->route('sba.hasil.index', $ujiId)->with('success', 'Data hasil ujian peserta berhasil dihapus.');
    }

    /**
     * Halaman Detail & Penilaian Jawaban Asesi
     */
    public function hasilDetail($hasil_id)
    {
        $hasil = UjiHasil::with(['uji.soals', 'jawabans', 'asesi'])->findOrFail($hasil_id);
        $mapJawaban = $hasil->jawabans->keyBy('uji_soal_id');

        return view('sba.hasil_detail', compact('hasil', 'mapJawaban'));
    }

    /**
     * Simpan Penilaian Esai & Finalisasi Skor (Ubah status menjadi 'final')
     */
    public function simpanPenilaianEsai(Request $request, $hasil_id)
    {
        $hasil = UjiHasil::with('uji.soals')->findOrFail($hasil_id);

        $skorEsaiTotal = 0;
        $skorOtomatisPg = 0;

        $skorInputs = $request->input('skor_esai', []);

        foreach ($hasil->uji->soals as $soal) {
            $jawaban = UjiJawaban::where('uji_hasil_id', $hasil->id)
                ->where('uji_soal_id', $soal->id)
                ->first();

            if ($soal->tipe === 'esai') {
                $skorDidapat = isset($skorInputs[$soal->id]) ? (float) $skorInputs[$soal->id] : 0;
                
                if ($skorDidapat > $soal->bobot_nilai) {
                    $skorDidapat = $soal->bobot_nilai;
                } elseif ($skorDidapat < 0) {
                    $skorDidapat = 0;
                }

                if ($jawaban) {
                    $jawaban->update(['skor_didapat' => $skorDidapat]);
                } else {
                    UjiJawaban::create([
                        'uji_hasil_id' => $hasil->id,
                        'uji_soal_id'  => $soal->id,
                        'jawaban'      => null,
                        'skor_didapat' => $skorDidapat,
                    ]);
                }
                $skorEsaiTotal += $skorDidapat;
            } else {
                if ($jawaban) {
                    $skorOtomatisPg += (float) $jawaban->skor_didapat;
                }
            }
        }

        $totalSkorAkhir = $skorOtomatisPg + $skorEsaiTotal;

        $hasil->update([
            'skor_otomatis'     => $skorOtomatisPg,
            'total_skor'        => $totalSkorAkhir,
            'status_pengerjaan' => 'final',
        ]);

        return redirect()->back()->with('success', 'Penilaian esai berhasil disimpan dan status hasil difinalisasi!');
    }

    /**
     * Hitung Ulang (Refresh) Nilai PG & PG Kompleks Berdasarkan Kunci & Bobot Terbaru
     */
    public function refreshNilaiHasil($hasil_id)
    {
        $hasil = UjiHasil::with(['uji.soals', 'jawabans'])->findOrFail($hasil_id);
        $mapJawaban = $hasil->jawabans->keyBy('uji_soal_id');

        $skorOtomatisPg = 0;
        $skorEsaiTotal = 0;

        foreach ($hasil->uji->soals as $soal) {
            $jawaban = $mapJawaban->get($soal->id);

            if (in_array($soal->tipe, ['pg', 'pg_kompleks'])) {
                $skorItem = 0;
                if ($jawaban && $jawaban->jawaban !== null && $jawaban->jawaban !== '') {
                    $kunciArray = $soal->kunci_jawaban ?? [];
                    if ($soal->tipe === 'pg_kompleks') {
                        $jawabanArr = json_decode($jawaban->jawaban, true) ?? [];
                        sort($kunciArray);
                        sort($jawabanArr);
                        if ($kunciArray == $jawabanArr && !empty($kunciArray)) {
                            $skorItem = $soal->bobot_nilai;
                        }
                    } else {
                        if (in_array($jawaban->jawaban, $kunciArray)) {
                            $skorItem = $soal->bobot_nilai;
                        }
                    }
                    $jawaban->update(['skor_didapat' => $skorItem]);
                }
                $skorOtomatisPg += $skorItem;
            } else {
                if ($jawaban) {
                    $skorEsaiTotal += (float) $jawaban->skor_didapat;
                }
            }
        }

        $hasil->update([
            'skor_otomatis' => $skorOtomatisPg,
            'total_skor'    => $skorOtomatisPg + $skorEsaiTotal,
        ]);

        return redirect()->back()->with('success', 'Nilai PG/PG Kompleks berhasil dihitung ulang sesuai kunci jawaban & bobot soal terbaru!');
    }

    /**
     * Buka Kunci (Unlock) Sesi Peserta yang Gagal Pelanggaran agar Bisa Melanjutkan Ujian
     */
    public function unlockSesi($hasil_id)
    {
        $hasil = UjiHasil::findOrFail($hasil_id);

        if ($hasil->status_pengerjaan !== 'gagal_pelanggaran') {
            return redirect()->back()->with('error', 'Hanya sesi berstatus Diskualifikasi (gagal pelanggaran) yang dapat dibuka kuncinya.');
        }

        $catatanBaru = trim(($hasil->catatan_pelanggaran ?? '') . " | [UNLOCK ADMIN pada " . now()->format('d/m/Y H:i:s') . "]");

        $hasil->update([
            'status_pengerjaan'   => 'berlangsung',
            'waktu_selesai'       => null,
            'jumlah_pelanggaran'  => 0,
            'catatan_pelanggaran' => $catatanBaru,
        ]);

        return redirect()->back()->with('success', 'Sesi peserta berhasil dibuka kuncinya (Unlock). Peserta dapat masuk kembali melalui portal untuk melanjutkan.');
    }

    /**
     * Finalisasi Paksa Sesi yang Masih Berlangsung
     */
    public function finalisasiPaksa($hasil_id)
    {
        $hasil = UjiHasil::with(['uji.soals', 'jawabans'])->findOrFail($hasil_id);

        if ($hasil->status_pengerjaan !== 'berlangsung') {
            return redirect()->back()->with('error', 'Sesi ini sudah tidak dalam status berlangsung.');
        }

        $totalSkorOtomatis = 0;
        $mapSoal = $hasil->uji->soals->keyBy('id');

        foreach ($hasil->jawabans as $jawabanSiswa) {
            $soal = $mapSoal->get($jawabanSiswa->uji_soal_id);
            if (!$soal) continue;

            if (in_array($soal->tipe, ['pg', 'pg_kompleks'])) {
                $kunciArray = $soal->kunci_jawaban ?? [];
                $skorItem = 0;

                if ($soal->tipe === 'pg_kompleks') {
                    $jawabanArr = json_decode($jawabanSiswa->jawaban, true) ?? [];
                    sort($kunciArray);
                    sort($jawabanArr);
                    if ($kunciArray == $jawabanArr && !empty($kunciArray)) {
                        $skorItem = $soal->bobot_nilai;
                    }
                } else {
                    if (in_array($jawabanSiswa->jawaban, $kunciArray)) {
                        $skorItem = $soal->bobot_nilai;
                    }
                }

                $totalSkorOtomatis += $skorItem;
                $jawabanSiswa->update(['skor_didapat' => $skorItem]);
            }
        }

        $hasil->update([
            'waktu_selesai'     => now(),
            'skor_otomatis'     => $totalSkorOtomatis,
            'total_skor'        => $totalSkorOtomatis,
            'status_pengerjaan' => 'selesai',
        ]);

        return redirect()->back()->with('success', 'Sesi ujian peserta berhasil difinalisasi secara paksa dan skor otomatis telah dihitung.');
    }

    /**
     * Export Detail Jawaban Peserta ke PDF
     */
    public function exportHasilDetailPdf($hasil_id)
    {
        $hasil = UjiHasil::with(['uji.soals', 'jawabans', 'asesi'])->findOrFail($hasil_id);
        $mapJawaban = $hasil->jawabans->keyBy('uji_soal_id');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('sba.exports.hasil_detail_pdf', compact('hasil', 'mapJawaban'))
            ->setPaper('a4', 'portrait');

        $namaPeserta = $hasil->asesi ? ($hasil->asesi->nama_user ?? $hasil->asesi->name) : ($hasil->nama_peserta_publik ?? 'Peserta');
        $fileName = 'Detail_Hasil_' . Str::slug($namaPeserta) . '_' . $hasil->uji->kode_uji . '.pdf';

        return $pdf->download($fileName);
    }

    public function bulkDelete(Request $request, $uji_id)
    {
        $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'exists:uji_hasils,id',
        ]);

        try {
            UjiHasil::where('uji_id', $uji_id)
                ->whereIn('id', $request->ids)
                ->delete();

            return redirect()->back()->with('success', count($request->ids) . ' data hasil ujian berhasil dihapus secara massal.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data hasil ujian: ' . $e->getMessage());
        }
    }
}