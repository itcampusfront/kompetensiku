@extends('faturcms::template.admin.main')

@section('title', isset($uji) ? 'Edit Asesmen & Soal SBA' : 'Buat Asesmen & Soal Baru')

@section('content')
{{-- KaTeX untuk Live Preview Rumus Matematika --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.11/dist/katex.min.css">
<script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.11/dist/katex.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.11/dist/contrib/auto-render.min.js"></script>

{{-- MathLive untuk Editor Rumus Visual seperti MS Word --}}
<script defer src="https://cdn.jsdelivr.net/npm/mathlive@0.101.0/dist/mathlive.min.js"></script>

<style>
    .btn-export-excel-ungu {
        background-color: #6f42c1 !important;
        border: 1px solid #6f42c1 !important;
        color: #ffffff !important;
    }
    .btn-export-excel-ungu:hover,
    .btn-export-excel-ungu:focus {
        background-color: #59339d !important;
        border-color: #59339d !important;
        color: #ffffff !important;
    }
    .editor-mini-toolbar {
        display: inline-flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 3px;
    }
    .btn-fmt-helper {
        background-color: #ffffff;
        border: 1px solid #ced4da;
        color: #343a40;
        font-size: 0.75rem;
        line-height: 1.2;
        padding: 2px 7px;
        border-radius: 4px;
        transition: all 0.15s ease;
    }
    .btn-fmt-helper:hover {
        background-color: #f1f3f5;
        border-color: #6f42c1;
        color: #6f42c1;
    }
    .btn-eq-helper {
        background-color: #f3ebff;
        border: 1px solid #d6c2f5;
        color: #6f42c1;
        font-weight: 700;
        font-size: 0.75rem;
        line-height: 1.2;
        padding: 2px 8px;
        border-radius: 4px;
        transition: all 0.15s ease;
    }
    .btn-eq-helper:hover {
        background-color: #6f42c1;
        border-color: #6f42c1;
        color: #ffffff;
    }
    .math-live-preview {
        background-color: #faf7ff;
        border: 1px dashed #c8b2ef;
        border-radius: 6px;
        padding: 8px 12px;
        margin-top: 6px;
        font-size: 0.9rem;
        color: #1e293b;
        line-height: 1.6;
        word-break: break-word;
    }
    .math-live-preview-label {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        color: #6f42c1;
        letter-spacing: 0.4px;
        display: block;
        margin-bottom: 2px;
    }
    math-field {
        width: 100%;
        font-size: 1.35rem;
        padding: 12px 14px;
        border: 2px solid #cbd5e1;
        border-radius: 8px;
        background-color: #ffffff;
        color: #0f172a;
        min-height: 74px;
        --keyboard-zindex: 1070;
    }
    math-field:focus-within {
        border-color: #6f42c1;
        box-shadow: 0 0 0 3px rgba(111, 66, 193, 0.16);
        outline: none;
    }
    .eq-quick-btn {
        font-size: 0.8rem;
        padding: 4px 10px;
        border-radius: 5px;
        border: 1px solid #dee2e6;
        background: #ffffff;
        color: #334155;
        font-weight: 600;
        transition: all 0.15s ease;
    }
    .eq-quick-btn:hover {
        border-color: #6f42c1;
        background: #f6f2ff;
        color: #6f42c1;
    }
    .soal-item.dragging {
        opacity: 0.5;
        border: 2px dashed #007bff !important;
        transform: scale(0.99);
    }
    .soal-item.drag-over {
        border-top: 3px solid #007bff !important;
        margin-top: 0.5rem;
    }
    .kunci-radio:checked, .kunci-checkbox:checked {
        accent-color: #28a745;
    }
</style>

<div class="app-title">
    <div>
        <h1><i class="fa fa-file-text-o"></i> {{ isset($uji) ? 'Edit Asesmen & Soal SBA' : 'Buat Asesmen & Soal Baru' }}</h1>
        <p>Pengaturan informasi dasar asesmen dan penyusunan butir soal.</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{ route('sba.index') }}">Daftar Ujian SBA</a></li>
        <li class="breadcrumb-item"><a href="#">{{ isset($uji) ? 'Edit' : 'Tambah' }}</a></li>
    </ul>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            {{-- ENCTYPE MULTIPART/FORM-DATA PENTING UNTUK UPLOAD GAMBAR --}}
            <form action="{{ isset($uji) ? route('sba.update', $uji->id) : route('sba.store') }}" 
                  method="POST" 
                  id="form-ujian-sba" 
                  enctype="multipart/form-data">
                @csrf
                @if(isset($uji))
                    @method('PUT')
                @endif

                <div class="tile-title-w-btn">
                    <h3 class="title text-primary"><i class="fa fa-cogs"></i> Bagian 1: Pengaturan Asesmen</h3>
                    <div class="btn-group">
                        <a href="{{ route('sba.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary btn-submit-sba">
                            <i class="fa fa-save"></i> {{ isset($uji) ? 'Simpan Perubahan' : 'Simpan Asesmen' }}
                        </button>
                    </div>
                </div>

                {{-- MENAMPILKAN ERROR VALIDASI (FALLBACK SERVER) --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Terjadi Kesalahan!</strong>
                        <ul class="mb-0 pl-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                {{-- ALERT ERROR VALIDASI / GAGAL SIMPAN VIA AJAX (TANPA RELOAD) --}}
                <div id="ajax-error-alert" class="alert alert-danger alert-dismissible fade show d-none shadow-sm" role="alert">
                    <div class="d-flex align-items-start">
                        <i class="fa fa-exclamation-circle fa-lg mr-2 mt-1"></i>
                        <div class="flex-grow-1">
                            <strong class="d-block mb-1" id="ajax-error-title">Gagal Menyimpan Asesmen!</strong>
                            <ul class="mb-0 pl-3" id="ajax-error-list"></ul>
                            <small class="d-block mt-2">
                                <i class="fa fa-shield mr-1"></i> Seluruh butir soal dan lampiran gambar Anda tetap aman dan tidak hilang. Silakan perbaiki data di atas lalu simpan kembali.
                            </small>
                        </div>
                        <button type="button" class="close" onclick="document.getElementById('ajax-error-alert').classList.add('d-none')" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>

                {{-- ALERT NOTIFIKASI HASIL IMPORT EXCEL / PENYESUAIAN BOBOT DI VIEW --}}
                <div id="alert-import-success" class="alert alert-success alert-dismissible fade show d-none" role="alert">
                    <span id="alert-import-success-text"></span>
                    <button type="button" class="close" onclick="this.parentElement.classList.add('d-none')" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                {{-- INFORMASI AUTHOR / PEMBUAT ASESMEN --}}
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="p-2 px-3 bg-light border rounded d-flex align-items-center">
                            <i class="fa fa-user-circle text-primary mr-2 fa-lg"></i>
                            <span class="text-muted mr-2">Pembuat Asesmen (Author):</span>
                            <strong>
                                {{ isset($uji) && $uji->author ? $uji->author->nama_user : (auth()->user()->nama_user ?? 'Administrator') }}
                            </strong>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    {{-- KOLOM KIRI: Informasi Dasar --}}
                    <div class="col-md-7 pr-md-4">
                        <div class="form-group">
                            <label for="judul">Judul Asesmen <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="judul" name="judul" 
                                   value="{{ old('judul', $uji->judul ?? '') }}" 
                                   placeholder="Contoh: Uji Kompetensi Pemrograman Web Dasar" required>
                        </div>

                        <div class="form-group">
                            <label for="kode_uji">Kode Asesmen <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control text-uppercase font-weight-bold @error('kode_uji') is-invalid @enderror" 
                                       id="kode_uji" name="kode_uji" 
                                       value="{{ old('kode_uji', $uji->kode_uji ?? strtoupper(\Illuminate\Support\Str::random(6))) }}" 
                                       placeholder="Contoh: WEB2026" required maxlength="20" pattern="[A-Za-z0-9]{1,20}"
                                       title="Hanya huruf (A-Z) dan angka (0-9), maksimal 20 karakter">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary" id="btn-generate-kode" title="Generate Kode Acak (6 Karakter)">
                                        <i class="fa fa-random"></i> Acak
                                    </button>
                                </div>
                            </div>
                            <small id="kode-uji-status" class="d-block mt-1 font-weight-bold d-none"></small>
                            <small class="form-text text-muted">Bisa diisi kode custom (hanya huruf A-Z dan angka 0-9, maksimal 20 karakter, tanpa spasi).</small>
                        </div>

                        <div class="form-group mb-0">
                            <label for="deskripsi">Deskripsi / Petunjuk Pengerjaan</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" 
                                      placeholder="Masukkan petunjuk pengerjaan (opsional, tampil di halaman persiapan jika > 10 karakter)...">{{ old('deskripsi', $uji->deskripsi ?? '') }}</textarea>
                        </div>
                    </div>

                    {{-- KOLOM KANAN: Pengaturan Waktu & Sistem --}}
                    <div class="col-md-5">
                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <label for="waktu_mulai">Waktu Mulai</label>
                                <input type="datetime-local" class="form-control" id="waktu_mulai" name="waktu_mulai" 
                                       value="{{ old('waktu_mulai', isset($uji) && $uji->waktu_mulai ? $uji->waktu_mulai->format('Y-m-d\TH:i') : '') }}">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="waktu_selesai">Waktu Selesai</label>
                                <input type="datetime-local" class="form-control" id="waktu_selesai" name="waktu_selesai" 
                                       value="{{ old('waktu_selesai', isset($uji) && $uji->waktu_selesai ? $uji->waktu_selesai->format('Y-m-d\TH:i') : '') }}">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <label for="durasi_menit">Durasi (Menit) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="durasi_menit" name="durasi_menit" 
                                       value="{{ old('durasi_menit', $uji->durasi_menit ?? 60) }}" min="0" placeholder="0 = Tanpa Batas" required>
                                <small class="form-text text-muted">0 = Tanpa batas</small>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="draft" {{ old('status', $uji->status ?? 'draft') == 'draft' ? 'selected' : '' }}>Draft (Sembunyi)</option>
                                    <option value="published" {{ old('status', $uji->status ?? '') == 'published' ? 'selected' : '' }}>Published (Aktif)</option>
                                    <option value="closed" {{ old('status', $uji->status ?? '') == 'closed' ? 'selected' : '' }}>Closed (Tutup)</option>
                                </select>
                            </div>
                        </div>

                        {{-- PENGATURAN KEAMANAN & PERCOBAAN --}}
                        <div class="form-row border-top pt-2 mt-1">
                            {{-- KOLOM KIRI: Mode Ujian (Open Book / Strict Mode) & Opsi Umum --}}
                            <div class="col-md-6 mb-2">
                                <div class="p-2 bg-light border rounded mb-2">
                                    <div class="animated-checkbox mb-1">
                                        <label class="mb-0">
                                            <input type="checkbox" id="open_book" name="open_book" value="1" {{ old('open_book', $uji->open_book ?? false) ? 'checked' : '' }}>
                                            <span class="label-text font-weight-bold text-dark">Mode Open Book</span>
                                        </label>
                                    </div>
                                    <small id="text-open-book-desc" class="d-block {{ old('open_book', $uji->open_book ?? false) ? 'text-success font-weight-bold' : 'text-muted' }}" style="font-size: 11px; line-height: 1.3;">
                                        {{ old('open_book', $uji->open_book ?? false) 
                                            ? 'Izinkan peserta berpindah tab / minimize tanpa pelanggaran' 
                                            : 'Peserta dilarang berpindah / minimize tab selama uji berlangsung' }}
                                    </small>

                                    <div id="wrapper-toleransi" class="form-group mb-0 border-top pt-2 mt-2 {{ old('open_book', $uji->open_book ?? false) ? 'd-none' : '' }}">
                                        <label for="toleransi_pelanggaran" class="small font-weight-bold mb-1">Toleransi Pelanggaran</label>
                                        <input type="number" class="form-control form-control-sm bg-white" id="toleransi_pelanggaran" name="toleransi_pelanggaran" 
                                               value="{{ old('toleransi_pelanggaran', $uji->toleransi_pelanggaran ?? 3) }}" min="0" required>
                                        <small class="form-text text-muted" style="font-size: 11px;">Batas minimize/pindah tab</small>
                                    </div>
                                </div>

                                <div class="animated-checkbox mb-2">
                                    <label><input type="checkbox" id="acak_soal" name="acak_soal" value="1" {{ old('acak_soal', $uji->acak_soal ?? true) ? 'checked' : '' }}><span class="label-text">Acak Soal</span></label>
                                </div>
                                <div class="animated-checkbox mb-2">
                                    <label><input type="checkbox" id="tampilkan_nilai" name="tampilkan_nilai" value="1" {{ old('tampilkan_nilai', $uji->tampilkan_nilai ?? false) ? 'checked' : '' }}><span class="label-text">Tampilkan Nilai</span></label>
                                </div>
                                <div class="animated-checkbox mb-0">
                                    <label><input type="checkbox" id="buka_untuk_umum" name="buka_untuk_umum" value="1" {{ old('buka_untuk_umum', $uji->buka_untuk_umum ?? true) ? 'checked' : '' }}><span class="label-text">Buka untuk Umum</span></label>
                                </div>
                            </div>

                            {{-- KOLOM KANAN: Grup Pengulangan & Maks. Percobaan --}}
                            <div class="col-md-6 mb-2">
                                <div class="p-2 bg-light border rounded h-100">
                                    <div class="animated-checkbox mb-1">
                                        <label class="mb-0">
                                            <input type="checkbox" id="ulangi_jika_gagal" name="ulangi_jika_gagal" value="1" {{ old('ulangi_jika_gagal', $uji->ulangi_jika_gagal ?? false) ? 'checked' : '' }}>
                                            <span class="label-text font-weight-bold text-dark">Ulangi Jika Gagal</span>
                                        </label>
                                    </div>
                                    <small class="text-muted d-block mb-2" style="font-size: 11px; line-height: 1.3;">
                                        Izinkan peserta mengulang ujian jika gagal/pelanggaran
                                    </small>

                                    <div id="wrapper-maks-percobaan" class="form-group mb-0 border-top pt-2 mt-2 {{ old('ulangi_jika_gagal', $uji->ulangi_jika_gagal ?? false) ? '' : 'd-none' }}">
                                        <label for="maksimal_percobaan" class="small font-weight-bold mb-1">Maks. Percobaan</label>
                                        <input type="number" class="form-control form-control-sm bg-white" id="maksimal_percobaan" name="maksimal_percobaan" 
                                               value="{{ old('maksimal_percobaan', $uji->maksimal_percobaan ?? 1) }}" min="1" required>
                                        <small class="form-text text-muted" style="font-size: 11px;">Total kuota kesempatan ujian</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ========================================================================
                    INFORMASI TOTAL, IMPORT/EXPORT SOAL EXCEL, DAN AUTO ADJUST BOBOT
                    ======================================================================== --}}
                <div class="row mb-4 mt-2" id="box-rekap-soal">
                    <div class="col-12">
                        <div class="p-3 bg-light border rounded d-flex flex-column flex-md-row justify-content-between align-items-center">
                            <div class="mb-2 mb-md-0">
                                <span class="font-weight-bold text-dark"><i class="fa fa-pie-chart text-primary"></i> Rekap Soal:</span>
                                <span class="ml-3 text-secondary">Total Soal: <strong id="summary-total-soal" class="text-primary h5">0</strong></span>
                                <span class="ml-3 text-secondary">Total Poin: <strong id="summary-total-poin" class="text-info h5">0</strong> <span id="poin-warning" class="text-danger small d-none">(Melebihi 100!)</span></span>
                            </div>
                            <div class="d-flex flex-wrap">
                                <button type="button" class="btn btn-sm btn-export-excel-ungu btn-export-soal-excel mr-2 mb-1" title="Export daftar soal saat ini ke file Excel (.xlsx) sesuai format template import">
                                    <i class="fa fa-upload"></i> Export Soal Excel
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-primary mr-2 mb-1" data-toggle="modal" data-target="#modalImportSoalExcel">
                                    <i class="fa fa-file-excel-o"></i> Import Soal Excel
                                </button>
                                <button type="button" class="btn btn-sm btn-info mb-1" id="btn-sesuaikan-poin" title="Bagikan bobot poin secara merata dengan total 100">
                                    <i class="fa fa-magic"></i> Sesuaikan Poin (Otomatis)
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                {{-- SECTION 2: PENYUSUNAN SOAL --}}
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                    <h4 class="text-info mb-0"><i class="fa fa-list-ol"></i> Bagian 2: Daftar Soal</h4>
                    <small class="text-muted"><i class="fa fa-info-circle"></i> Blok teks lalu klik <strong>B / I / U</strong> untuk format huruf, atau <strong>fx Rumus</strong> untuk persamaan matematika.</small>
                </div>
                
                <div class="bg-light rounded p-3 border mb-3" id="soal-container" style="min-height: 200px;">
                    {{-- Container untuk list soal dinamis --}}
                </div>
                
                <div class="text-center mb-4">
                    <button type="button" class="btn btn-outline-primary icon-btn px-4" onclick="addSoal(null, 'end')">
                        <i class="fa fa-plus"></i> Tambah Soal Baru di Akhir
                    </button>
                </div>

                <hr>

                {{-- TOMBOL SUBMIT UTAMA --}}
                <div class="tile-footer d-flex flex-wrap justify-content-between align-items-center">
                    <div class="mb-2 mb-md-0">
                        <button type="button" class="btn btn-sm btn-export-excel-ungu btn-export-soal-excel" title="Export daftar soal saat ini ke file Excel (.xlsx) sesuai format template import">
                            <i class="fa fa-upload"></i> Export Soal Excel
                        </button>
                    </div>
                    <div>
                        <a href="{{ route('sba.index') }}" class="btn btn-secondary mr-2">Batal</a>
                        <button type="submit" class="btn btn-primary icon-btn btn-submit-sba">
                            <i class="fa fa-save"></i> {{ isset($uji) ? 'Simpan Perubahan' : 'Simpan Asesmen' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL VISUAL EQUATION EDITOR (MATHLIVE - SEPERTI EQUATION DI MS WORD) --}}
<div class="modal fade" id="modalEquationEditor" tabindex="-1" role="dialog" aria-labelledby="modalEquationEditorLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalEquationEditorLabel">
                    <i class="fa fa-superscript mr-1"></i> Editor Rumus Matematika (Visual)
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <p class="small text-muted mb-2">
                    Ketik rumus langsung pada kotak di bawah (gunakan tombol simbol cepat atau keyboard, misal <code>/</code> untuk pecahan, <code>^</code> untuk pangkat, atau klik ikon keyboard virtual di sudut kanan kotak):
                </p>

                {{-- TOMBOL SIMBOL CEPAT --}}
                <div class="d-flex flex-wrap mb-2 p-2 bg-light rounded border" style="gap: 4px;">
                    <button type="button" class="eq-quick-btn" data-latex="\frac{#@}{#?}" title="Pecahan">a/b (Pecahan)</button>
                    <button type="button" class="eq-quick-btn" data-latex="\sqrt{#@}" title="Akar Kuadrat">√x (Akar)</button>
                    <button type="button" class="eq-quick-btn" data-latex="\sqrt[#?]{#@}" title="Akar Pangkat n">ⁿ√x</button>
                    <button type="button" class="eq-quick-btn" data-latex="{#@}^{#?}" title="Pangkat">xⁿ (Pangkat)</button>
                    <button type="button" class="eq-quick-btn" data-latex="{#@}_{#?}" title="Indeks Bawah">xₙ (Subscript)</button>
                    <button type="button" class="eq-quick-btn" data-latex="\sum_{#?}^{#?}" title="Sigma">∑ (Sigma)</button>
                    <button type="button" class="eq-quick-btn" data-latex="\int_{#?}^{#?}" title="Integral">∫ (Integral)</button>
                    <button type="button" class="eq-quick-btn" data-latex="\lim_{x \to #?}" title="Limit">lim</button>
                    <button type="button" class="eq-quick-btn" data-latex="\times" title="Kali">×</button>
                    <button type="button" class="eq-quick-btn" data-latex="\div" title="Bagi">÷</button>
                    <button type="button" class="eq-quick-btn" data-latex="\pm" title="Plus Minus">±</button>
                    <button type="button" class="eq-quick-btn" data-latex="\leq" title="Kurang dari sama dengan">≤</button>
                    <button type="button" class="eq-quick-btn" data-latex="\geq" title="Lebih dari sama dengan">≥</button>
                    <button type="button" class="eq-quick-btn" data-latex="\neq" title="Tidak sama dengan">≠</button>
                    <button type="button" class="eq-quick-btn" data-latex="\pi" title="Pi">π</button>
                    <button type="button" class="eq-quick-btn" data-latex="\theta" title="Theta">θ</button>
                    <button type="button" class="eq-quick-btn" data-latex="\alpha" title="Alpha">α</button>
                    <button type="button" class="eq-quick-btn" data-latex="\beta" title="Beta">β</button>
                    <button type="button" class="eq-quick-btn" data-latex="^{\circ}" title="Derajat">°</button>
                </div>

                {{-- KOTAK INPUT VISUAL MATHLIVE --}}
                <div class="mb-3">
                    <math-field id="mathlive-editor-field" smart-fence="true"></math-field>
                </div>

                {{-- PILIHAN PENEMPATAN RUMUS --}}
                <div class="p-2 px-3 bg-light rounded border d-flex flex-wrap align-items-center justify-content-between">
                    <span class="small font-weight-bold text-dark">Tampilan di Soal:</span>
                    <div class="d-flex flex-wrap">
                        <div class="form-check form-check-inline mb-0 mr-3">
                            <input class="form-check-input" type="radio" name="eq_display_mode" id="eqModeInline" value="inline" checked>
                            <label class="form-check-label small text-dark mb-0" for="eqModeInline">
                                Sebaris dengan kalimat (<code>$ ... $</code>)
                            </label>
                        </div>
                        <div class="form-check form-check-inline mb-0">
                            <input class="form-check-input" type="radio" name="eq_display_mode" id="eqModeBlock" value="block">
                            <label class="form-check-label small text-dark mb-0" for="eqModeBlock">
                                Baris baru rata tengah (<code>$$ ... $$</code>)
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-light d-flex justify-content-between">
                <button type="button" class="btn btn-sm btn-outline-danger" id="btn-clear-mathlive">
                    <i class="fa fa-eraser"></i> Bersihkan
                </button>
                <div>
                    <button type="button" class="btn btn-sm btn-secondary mr-1" data-dismiss="modal">Batal</button>
                    <button type="button" id="btn-insert-mathlive" class="btn btn-sm btn-primary">
                        <i class="fa fa-check"></i> Sisipkan Rumus
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL PERINGATAN TOTAL BOBOT NILAI TIDAK SAMA DENGAN 100 --}}
<div class="modal fade" id="modalPeringatanBobot" tabindex="-1" role="dialog" aria-labelledby="modalPeringatanBobotLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title font-weight-bold" id="modalPeringatanBobotLabel">
                    <i class="fa fa-exclamation-triangle mr-1"></i> Konfirmasi Total Bobot Nilai
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <p class="text-dark mb-3">
                    Total bobot nilai seluruh soal saat ini <strong class="text-danger">tidak berjumlah 100 poin</strong>. Silakan periksa ringkasan penyusunan soal berikut sebelum menyimpan:
                </p>

                <div class="row mb-3 text-center">
                    <div class="col-6">
                        <div class="p-3 bg-light rounded border h-100">
                            <span class="d-block text-muted text-uppercase small font-weight-bold">Jumlah Soal</span>
                            <strong class="h3 text-primary" id="modal-bobot-jumlah-soal">0</strong>
                            <span class="d-block small text-muted">Butir Soal</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 bg-light rounded border h-100">
                            <span class="d-block text-muted text-uppercase small font-weight-bold">Total Bobot Nilai</span>
                            <strong class="h3 text-danger" id="modal-bobot-total-poin">0</strong>
                            <span class="d-block small text-muted">Target Standar: <strong>100 Poin</strong></span>
                        </div>
                    </div>
                </div>

                <div class="p-2 px-3 mb-0 rounded border-left border-warning bg-light text-dark small" id="modal-bobot-keterangan">
                </div>
            </div>

            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" id="btn-modal-tetap-simpan" class="btn btn-sm btn-info">
                    <i class="fa fa-save"></i> Tetap Simpan
                </button>
                <button type="button" id="btn-modal-sesuaikan-bobot" class="btn btn-sm btn-primary">
                    <i class="fa fa-magic"></i> Sesuaikan Bobot dan Simpan
                </button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL IMPORT SOAL EXCEL --}}
<div class="modal fade" id="modalImportSoalExcel" tabindex="-1" role="dialog" aria-labelledby="modalImportSoalExcelLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalImportSoalExcelLabel">
                    <i class="fa fa-file-excel-o mr-1"></i> Import Soal dari Excel
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body">
                <div id="import-excel-error-box" class="alert alert-danger small py-2 px-3 mb-3 d-none">
                    <strong class="d-block mb-1" id="import-excel-error-title"></strong>
                    <ul class="mb-0 pl-3" id="import-excel-error-list"></ul>
                </div>

                {{-- 1. BAGIAN PERTAMA: UNDUH FORMAT TEMPLATE --}}
                <div class="mb-3 p-3 bg-light rounded border">
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge badge-primary mr-2">1</span>
                        <h6 class="font-weight-bold text-dark mb-0">Unduh Format Template</h6>
                    </div>
                    <p class="text-muted small mb-2" style="line-height: 1.5;">
                        Gunakan file template resmi dengan header kolom wajib:<br>
                        <code class="text-primary font-weight-bold">no, tipe_soal, pertanyaan, opsi_a..e, kunci_jawaban, bobot_nilai</code><br>
                        <span class="d-block mt-1" style="font-size: 11px;">
                            • Untuk <strong>benar_salah</strong>: isi pernyataan pada kolom berawalan <code>opsi_</code> (bisa menambah kolom baru seperti <code>opsi_f</code>, <code>opsi_g</code>, dst. sesuai jumlah pernyataan), kunci dipisah koma (misal <code>B,S,B</code>), dan bobot dipisah koma (misal <code>10,10,20</code>) atau total (misal <code>40</code>).<br>
                            • Untuk <strong>esai</strong>: isi <code>kunci_jawaban</code> jika berupa isian singkat (gunakan pemisah <code>|</code> untuk beberapa variasi jawaban benar, misal <code>Soekarno | Ir. Soekarno</code>), atau kosongkan jika uraian manual.
                        </span>
                    </p>
                    <a href="{{ route('sba.soal.template') }}" class="btn btn-sm btn-info btn-block">
                        <i class="fa fa-download"></i> Download Template Excel (.xlsx)
                    </a>
                </div>

                {{-- 2. BAGIAN KEDUA: UNGGAH FILE TEMPLATE (AJAX TO VIEW) --}}
                <div>
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge badge-primary mr-2">2</span>
                        <h6 class="font-weight-bold text-dark mb-0">Unggah File Template</h6>
                    </div>

                    <div class="p-2 px-3 mb-3 rounded border-left border-info bg-light text-dark small">
                        <i class="fa fa-info-circle text-info mr-1"></i>
                        Hasil import akan dimuat ke form terlebih dahulu (bersifat sementara) agar dapat Anda tinjau sebelum menekan tombol <strong>Simpan Asesmen</strong>.
                    </div>

                    <div class="form-group mb-3">
                        <label class="small font-weight-bold text-uppercase text-muted">Mode Penempatan Soal di Form</label>
                        <div class="p-2 px-3 bg-light rounded border">
                            <div class="form-check mb-1">
                                <input class="form-check-input" type="radio" name="import_mode" id="modeReplace" value="replace" checked>
                                <label class="form-check-label small font-weight-bold text-dark" for="modeReplace">
                                    Ganti / Timpa semua soal yang ada di form saat ini
                                </label>
                            </div>
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" name="import_mode" id="modeAppend" value="append">
                                <label class="form-check-label small font-weight-bold text-dark" for="modeAppend">
                                    Tambahkan di urutan bawah soal yang sudah ada
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <label for="input_excel_soal" class="small font-weight-bold text-uppercase text-muted">Pilih File Excel (.xlsx / .xls / .csv)</label>
                        <input type="file" id="input_excel_soal" class="form-control-file border p-2 rounded" accept=".xlsx, .xls, .csv">
                    </div>
                </div>
            </div>
            
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" id="btn-proses-import-excel" class="btn btn-sm btn-primary">
                    <i class="fa fa-cloud-upload"></i> Muat Soal ke Form
                </button>
            </div>
        </div>
    </div>
</div>

{{-- TEMPLATE SOAL (Hidden) --}}
<template id="soal-template">
    <div class="soal-item card mb-3 border" draggable="false" style="transition: transform 0.2s, border-color 0.2s;">
        <input type="hidden" class="soal-id" value="">
        
        <div class="card-header bg-white py-2 px-3 d-flex justify-content-between align-items-center">
            <div class="drag-handle px-1 text-secondary d-flex align-items-center" title="Tahan dan geser untuk memindahkan urutan" style="cursor: grab;">
                <i class="fa fa-bars mr-2"></i>
                <span class="font-weight-bold text-dark mb-0">Soal #<span class="soal-number">1</span></span>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-outline-secondary btn-sm btn-move-up" title="Geser ke Atas">
                    <i class="fa fa-chevron-up"></i>
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm btn-move-down" title="Geser ke Bawah">
                    <i class="fa fa-chevron-down"></i>
                </button>
                <button type="button" class="btn btn-outline-danger btn-sm btn-remove-soal" title="Hapus Soal Ini">
                    <i class="fa fa-trash"></i> Hapus
                </button>
            </div>
        </div>
        
        <div class="card-body">
            <div class="row align-items-start">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tipe Soal</label>
                        <select class="form-control soal-tipe" required>
                            <option value="pg">Pilihan Ganda</option>
                            <option value="pg_kompleks">PG Kompleks (Banyak Jawaban)</option>
                            <option value="benar_salah">Pernyataan Benar Salah</option>
                            <option value="esai">Uraian / Isian</option>
                        </select>
                    </div>
                    <div class="form-group mb-0">
                        <label class="label-bobot-utama">Bobot (Poin)</label>
                        <input type="number" class="form-control soal-bobot" value="10" min="0" required>
                        <small class="form-text text-info d-none info-bobot-bs">
                            *Otomatis dijumlahkan dari bobot tiap pernyataan di bawah.
                        </small>
                    </div>
                </div>
                
                <div class="col-md-9">
                    <div class="form-group">
                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-1">
                            <label class="mb-0 label-pertanyaan-utama">Pertanyaan <span class="text-danger">*</span></label>
                            <div class="editor-mini-toolbar">
                                <button type="button" class="btn btn-fmt-helper btn-format-text" data-tag="b" title="Tebal (Ctrl+B)"><strong>B</strong></button>
                                <button type="button" class="btn btn-fmt-helper btn-format-text" data-tag="i" title="Miring (Ctrl+I)"><em>I</em></button>
                                <button type="button" class="btn btn-fmt-helper btn-format-text" data-tag="u" title="Garis Bawah (Ctrl+U)"><u>U</u></button>
                                <button type="button" class="btn btn-fmt-helper btn-format-text" data-tag="sub" title="Subscript (Contoh: H₂O)">x<sub>2</sub></button>
                                <button type="button" class="btn btn-fmt-helper btn-format-text" data-tag="sup" title="Superscript (Contoh: m²)">x<sup>2</sup></button>
                                <button type="button" class="btn btn-eq-helper btn-open-equation" data-target="pertanyaan" title="Buka Editor Rumus Matematika">
                                    <i class="fa fa-superscript"></i> fx Rumus
                                </button>
                            </div>
                        </div>
                        <textarea class="form-control soal-pertanyaan math-watch-input" rows="4" placeholder="Ketikkan teks pertanyaan di sini..." required style="resize: vertical; min-height: 90px;"></textarea>
                        <div class="math-live-preview d-none">
                            <span class="math-live-preview-label"><i class="fa fa-eye"></i> Pratinjau Tampilan:</span>
                            <div class="math-preview-content"></div>
                        </div>
                    </div>

                    {{-- SLOT INPUT GAMBAR SOAL & PREVIEW --}}
                    <div class="form-group mb-0 border-top pt-2 mt-2">
                        <label class="text-dark font-weight-bold">
                            <i class="fa fa-image text-primary"></i> Lampiran Gambar Soal (Opsional)
                        </label>
                        <div class="d-flex align-items-center">
                            <input type="file" class="form-control-file soal-media" accept="image/*">
                            <input type="hidden" class="soal-remove-media" value="0">
                        </div>
                        <small class="form-text text-muted">*Format: JPG, JPEG, PNG, WEBP (Maksimal 2MB)</small>

                        <div class="media-preview-container mt-2 position-relative d-none" style="max-width: 250px;">
                            <img src="" class="img-thumbnail media-preview-img" style="max-height: 140px; width: auto;" alt="Preview Soal">
                            <button type="button" class="btn btn-danger btn-sm position-absolute btn-delete-media" style="top: 5px; right: 5px;" title="Hapus Gambar Ini">
                                <i class="fa fa-times"></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CONTAINER OPSI JAWABAN (PG & PG KOMPLEKS + GAMBAR PER OPSI) --}}
            <div class="opsi-wrapper border-top pt-3 mt-3">
                <label class="font-weight-bold text-primary d-block mb-2">
                    <i class="fa fa-check-circle"></i> Pilihan Jawaban, Lampiran Gambar Opsi & Kunci 
                    <small class="text-muted font-weight-normal">(Klik bulatan/kotak "KUNCI" untuk menandai jawaban yang benar)</small>
                </label>
                
                <div class="opsi-container">
                    @foreach(['A', 'B', 'C', 'D', 'E'] as $index => $huruf)
                    <div class="opsi-item border rounded mb-2 bg-white" data-opsi-index="{{ $index }}">
                        <div class="d-flex align-items-stretch">
                            <div class="bg-light border-right d-flex flex-column align-items-center justify-content-center px-2 py-1" style="min-width: 58px;">
                                <small class="font-weight-bold text-muted mb-1" style="font-size: 10px; line-height: 1;">KUNCI</small>
                                <input type="radio" class="kunci-radio" value="{{ $index }}" style="width: 18px; height: 18px; cursor:pointer;" title="Jadikan Jawaban Benar">
                                <input type="checkbox" class="kunci-checkbox d-none" value="{{ $index }}" style="width: 18px; height: 18px; cursor:pointer;" title="Jadikan Jawaban Benar">
                            </div>
                            
                            <div class="bg-secondary text-white d-flex align-items-center px-3 font-weight-bold">
                                {{ $huruf }}
                            </div>

                            <div class="flex-grow-1 p-2">
                                <div class="row align-items-start">
                                    {{-- KOLOM KIRI: ISIAN KETIKAN OPSI --}}
                                    <div class="col-12 col-md-7 mb-2 mb-md-0">
                                        <div class="d-flex justify-content-end mb-1">
                                            <div class="editor-mini-toolbar">
                                                <button type="button" class="btn btn-fmt-helper btn-format-text" data-tag="b" title="Tebal (Ctrl+B)"><strong>B</strong></button>
                                                <button type="button" class="btn btn-fmt-helper btn-format-text" data-tag="i" title="Miring (Ctrl+I)"><em>I</em></button>
                                                <button type="button" class="btn btn-fmt-helper btn-format-text" data-tag="u" title="Garis Bawah (Ctrl+U)"><u>U</u></button>
                                                <button type="button" class="btn btn-fmt-helper btn-format-text" data-tag="sub" title="Subscript">x<sub>2</sub></button>
                                                <button type="button" class="btn btn-fmt-helper btn-format-text" data-tag="sup" title="Superscript">x<sup>2</sup></button>
                                                <button type="button" class="btn btn-eq-helper btn-open-equation" data-target="opsi" title="Sisipkan Rumus Matematika ke Opsi {{ $huruf }}">
                                                    <i class="fa fa-superscript"></i> fx Rumus
                                                </button>
                                            </div>
                                        </div>
                                        <textarea class="form-control form-control-sm opsi-teks math-watch-input" rows="2" placeholder="Masukkan teks untuk opsi {{ $huruf }} (atau kosongkan jika hanya memakai gambar)..." style="resize: vertical; min-height: 58px;"></textarea>
                                        <div class="math-live-preview d-none">
                                            <span class="math-live-preview-label"><i class="fa fa-eye"></i> Pratinjau Opsi {{ $huruf }}:</span>
                                            <div class="math-preview-content"></div>
                                        </div>
                                    </div>

                                    {{-- KOLOM KANAN: INSERT GAMBAR OPSI & PREVIEW --}}
                                    <div class="col-12 col-md-5">
                                        <input type="file" class="form-control-file border bg-light p-1 rounded opsi-media-input" accept="image/*">
                                        <input type="hidden" class="opsi-remove-media" value="0">
                                        <small class="form-text text-muted mt-1" style="font-size: 11px;">Gambar opsi (Opsional: JPG, PNG, WEBP maks. 2MB)</small>

                                        <div class="opsi-media-preview-container mt-2 position-relative d-inline-block d-none">
                                            <img src="" class="img-thumbnail opsi-media-preview-img" style="max-height: 95px; width: auto;" alt="Preview Opsi {{ $huruf }}">
                                            <button type="button" class="btn btn-danger btn-sm position-absolute btn-delete-opsi-media" style="top: 4px; right: 4px; padding: 1px 6px;" title="Hapus Gambar Opsi {{ $huruf }}">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- CONTAINER PERNYATAAN BENAR / SALAH (DINAMIS) --}}
            <div class="bs-wrapper border-top pt-3 mt-3 d-none">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2">
                    <div>
                        <label class="font-weight-bold text-primary d-block mb-0">
                            <i class="fa fa-check-square-o"></i> Daftar Pernyataan, Kunci & Bobot per Pernyataan
                        </label>
                        <small class="text-muted">Pilih kunci <strong>Benar</strong> atau <strong>Salah</strong> dan tentukan bobot poin pada masing-masing pernyataan.</small>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary btn-add-bs-row">
                        <i class="fa fa-plus"></i> Tambah Pernyataan
                    </button>
                </div>

                <div class="bs-rows-container">
                    {{-- Baris pernyataan Benar/Salah dirender dinamis di sini --}}
                </div>
            </div>

            {{-- CONTAINER KUNCI JAWABAN OPSIONAL UNTUK URAIAN / ISIAN SINGKAT --}}
            <div class="esai-wrapper border-top pt-3 mt-3 d-none">
                <div class="p-3 bg-light border rounded">
                    <label class="font-weight-bold text-primary d-block mb-1">
                        <i class="fa fa-key"></i> Kunci Jawaban Isian Singkat (Opsional — Kosongkan jika Uraian Manual)
                    </label>
                    <input type="text" class="form-control form-control-sm bg-white soal-kunci-isian"
                           placeholder="Contoh teks: Soekarno | Ir. Soekarno  atau  Contoh angka: 0,5 | 0.5">
                    <small class="form-text text-muted mt-1" style="line-height: 1.45;">
                        • <strong>Jika diisi:</strong> Sistem mengoreksi otomatis (tidak peka huruf besar/kecil, koma/titik desimal pada angka disamakan). Gunakan tanda garis tegak <code>|</code> untuk memisahkan beberapa variasi jawaban benar.<br>
                        • <strong>Jika dikosongkan:</strong> Dianggap sebagai soal uraian panjang dan dinilai manual oleh penguji.
                    </small>
                </div>
            </div>
        </div>

        <div class="card-footer bg-light py-1 text-center">
            <button type="button" class="btn btn-link text-primary btn-sm btn-insert-soal">
                <i class="fa fa-plus-circle"></i> Sisipkan Soal Baru di Bawah Ini
            </button>
        </div>
    </div>
</template>

{{-- TEMPLATE SATU BARIS PERNYATAAN BENAR / SALAH --}}
<template id="bs-row-template">
    <div class="bs-row p-2 bg-light border rounded mb-2">
        <div class="row align-items-start">
            <div class="col-auto pt-1">
                <span class="badge badge-secondary bs-row-num">1</span>
            </div>
            <div class="col">
                <div class="d-flex justify-content-end mb-1">
                    <div class="editor-mini-toolbar">
                        <button type="button" class="btn btn-fmt-helper btn-format-text" data-tag="b" title="Tebal (Ctrl+B)"><strong>B</strong></button>
                        <button type="button" class="btn btn-fmt-helper btn-format-text" data-tag="i" title="Miring (Ctrl+I)"><em>I</em></button>
                        <button type="button" class="btn btn-fmt-helper btn-format-text" data-tag="u" title="Garis Bawah (Ctrl+U)"><u>U</u></button>
                        <button type="button" class="btn btn-fmt-helper btn-format-text" data-tag="sub" title="Subscript">x<sub>2</sub></button>
                        <button type="button" class="btn btn-fmt-helper btn-format-text" data-tag="sup" title="Superscript">x<sup>2</sup></button>
                        <button type="button" class="btn btn-eq-helper btn-open-equation" data-target="bs" title="Sisipkan Rumus Matematika">
                            <i class="fa fa-superscript"></i> fx
                        </button>
                    </div>
                </div>
                <textarea class="form-control form-control-sm bg-white bs-teks math-watch-input" rows="1" placeholder="Tuliskan teks pernyataan..." style="resize: vertical;"></textarea>
                <div class="math-live-preview d-none">
                    <span class="math-live-preview-label"><i class="fa fa-eye"></i> Pratinjau:</span>
                    <div class="math-preview-content"></div>
                </div>
            </div>
            <div class="col-md-auto mt-2 mt-md-0">
                <div class="d-flex align-items-center bg-white border rounded px-2 py-1">
                    <small class="font-weight-bold text-muted mr-2">KUNCI:</small>
                    <div class="form-check form-check-inline mb-0 mr-2">
                        <input class="form-check-input bs-kunci-benar" type="radio" value="benar" style="cursor: pointer;">
                        <label class="form-check-label small font-weight-bold text-success mb-0" style="cursor: pointer;">Benar</label>
                    </div>
                    <div class="form-check form-check-inline mb-0 mr-0">
                        <input class="form-check-input bs-kunci-salah" type="radio" value="salah" style="cursor: pointer;">
                        <label class="form-check-label small font-weight-bold text-danger mb-0" style="cursor: pointer;">Salah</label>
                    </div>
                </div>
            </div>
            <div class="col-md-auto mt-2 mt-md-0" style="width: 125px;">
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white">Poin</span>
                    </div>
                    <input type="number" class="form-control bg-white text-center font-weight-bold bs-bobot" value="10" min="0">
                </div>
            </div>
            <div class="col-auto mt-2 mt-md-0">
                <button type="button" class="btn btn-outline-danger btn-sm btn-remove-bs-row" title="Hapus Pernyataan Ini">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
document.addEventListener('DOMContentLoaded', function() {

    /* ========================================================================
     * TOOLBAR FORMAT TEKS (B/I/U/SUB/SUP), EDITOR RUMUS (MATHLIVE) & PREVIEW KATEX
     * ======================================================================== */
    const modalEqEl = document.getElementById('modalEquationEditor');
    const mathFieldEl = document.getElementById('mathlive-editor-field');
    const btnInsertMath = document.getElementById('btn-insert-mathlive');
    const btnClearMath = document.getElementById('btn-clear-mathlive');
    let activeEquationTextarea = null;

    const RICH_TAG_REGEX = /<\/?(b|i|u|sub|sup|strong|em)\s*>/i;

    function applyFormatTagToTextarea(textareaEl, tag) {
        if (!textareaEl || !tag) return;
        const start = textareaEl.selectionStart ?? textareaEl.value.length;
        const end = textareaEl.selectionEnd ?? textareaEl.value.length;
        const currentVal = textareaEl.value;
        const selectedText = currentVal.substring(start, end);
        const openTag = `<${tag}>`;
        const closeTag = `</${tag}>`;

        if (selectedText.length > 0) {
            if (selectedText.startsWith(openTag) && selectedText.endsWith(closeTag)) {
                const unwrapped = selectedText.slice(openTag.length, selectedText.length - closeTag.length);
                textareaEl.value = currentVal.substring(0, start) + unwrapped + currentVal.substring(end);
                textareaEl.focus();
                textareaEl.setSelectionRange(start, start + unwrapped.length);
            } else {
                const wrapped = `${openTag}${selectedText}${closeTag}`;
                textareaEl.value = currentVal.substring(0, start) + wrapped + currentVal.substring(end);
                textareaEl.focus();
                textareaEl.setSelectionRange(start + openTag.length, start + openTag.length + selectedText.length);
            }
        } else {
            const placeholderText = 'teks';
            const inserted = `${openTag}${placeholderText}${closeTag}`;
            textareaEl.value = currentVal.substring(0, start) + inserted + currentVal.substring(end);
            textareaEl.focus();
            textareaEl.setSelectionRange(start + openTag.length, start + openTag.length + placeholderText.length);
        }

        renderMathPreviewForTextarea(textareaEl);
    }

    function buildSafeRichHtmlWithMathTokens(rawText) {
        const mathTokens = [];
        const protectedText = rawText.replace(/(\$\$[\s\S]+?\$\$|\$[^$\n]+?\$)/g, function(match) {
            const token = `@@MATH_TOKEN_${mathTokens.length}@@`;
            mathTokens.push(match);
            return token;
        });

        let safeHtml = protectedText
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');

        safeHtml = safeHtml.replace(/&lt;(\/?(b|i|u|sub|sup|strong|em))&gt;/gi, '<$1>');
        safeHtml = safeHtml.replace(/\n/g, '<br>');

        safeHtml = safeHtml.replace(/@@MATH_TOKEN_(\d+)@@/g, function(_, idx) {
            return mathTokens[Number(idx)] ?? '';
        });

        return safeHtml;
    }

    function renderMathPreviewForTextarea(textareaEl) {
        if (!textareaEl) return;
        const wrapper = textareaEl.closest('.form-group, .col-12, .col');
        if (!wrapper) return;

        const previewBox = wrapper.querySelector('.math-live-preview');
        const previewContent = previewBox?.querySelector('.math-preview-content');
        if (!previewBox || !previewContent) return;

        const rawText = textareaEl.value || '';
        const hasMath = rawText.includes('$');
        const hasRichTag = RICH_TAG_REGEX.test(rawText);

        if (!hasMath && !hasRichTag) {
            previewBox.classList.add('d-none');
            previewContent.innerHTML = '';
            return;
        }

        previewBox.classList.remove('d-none');
        previewContent.innerHTML = buildSafeRichHtmlWithMathTokens(rawText);

        if (hasMath && typeof renderMathInElement === 'function') {
            renderMathInElement(previewContent, {
                delimiters: [
                    { left: '$$', right: '$$', display: true },
                    { left: '$', right: '$', display: false }
                ],
                throwOnError: false
            });
        }
    }

    function refreshAllMathPreviews(scopeEl = document) {
        scopeEl.querySelectorAll('.math-watch-input').forEach(ta => {
            renderMathPreviewForTextarea(ta);
        });
    }

    document.addEventListener('input', function(e) {
        if (e.target && e.target.classList.contains('math-watch-input')) {
            renderMathPreviewForTextarea(e.target);
        }
    });

    document.addEventListener('keydown', function(e) {
        if (!e.target || !e.target.classList.contains('math-watch-input')) return;
        if (!(e.ctrlKey || e.metaKey) || e.altKey) return;

        const key = e.key.toLowerCase();
        if (key === 'b' || key === 'i' || key === 'u') {
            e.preventDefault();
            applyFormatTagToTextarea(e.target, key);
        }
    });

    document.addEventListener('click', function(e) {
        const btnFmt = e.target.closest('.btn-format-text');
        if (!btnFmt) return;

        const wrapper = btnFmt.closest('.form-group, .col-12, .col');
        const targetTa = wrapper ? wrapper.querySelector('.math-watch-input') : null;
        if (!targetTa) return;

        applyFormatTagToTextarea(targetTa, btnFmt.dataset.tag);
    });

    document.addEventListener('click', function(e) {
        const btnEq = e.target.closest('.btn-open-equation');
        if (!btnEq) return;

        const wrapper = btnEq.closest('.form-group, .col-12, .col');
        const targetTa = wrapper ? wrapper.querySelector('.math-watch-input') : null;
        if (!targetTa) return;

        activeEquationTextarea = targetTa;
        if (mathFieldEl) {
            mathFieldEl.value = '';
        }

        $('#modalEquationEditor').modal('show');
    });

    if (modalEqEl && mathFieldEl) {
        $('#modalEquationEditor').on('shown.bs.modal', function() {
            mathFieldEl.focus();
        });
    }

    document.querySelectorAll('.eq-quick-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            if (!mathFieldEl) return;
            const latexTpl = this.dataset.latex || '';
            mathFieldEl.executeCommand(['insert', latexTpl]);
            mathFieldEl.focus();
        });
    });

    if (btnClearMath && mathFieldEl) {
        btnClearMath.addEventListener('click', function() {
            mathFieldEl.value = '';
            mathFieldEl.focus();
        });
    }

    if (btnInsertMath && mathFieldEl) {
        btnInsertMath.addEventListener('click', function() {
            const latex = (mathFieldEl.value || '').trim();
            if (!latex) {
                mathFieldEl.focus();
                return;
            }

            const displayMode = document.querySelector('input[name="eq_display_mode"]:checked')?.value || 'inline';
            const formattedFormula = displayMode === 'block'
                ? `\n$$${latex}$$\n`
                : `$${latex}$`;

            if (activeEquationTextarea) {
                const start = activeEquationTextarea.selectionStart ?? activeEquationTextarea.value.length;
                const end = activeEquationTextarea.selectionEnd ?? activeEquationTextarea.value.length;
                const currentVal = activeEquationTextarea.value;

                activeEquationTextarea.value =
                    currentVal.substring(0, start) +
                    formattedFormula +
                    currentVal.substring(end);

                const newCursorPos = start + formattedFormula.length;
                activeEquationTextarea.focus();
                activeEquationTextarea.setSelectionRange(newCursorPos, newCursorPos);
                renderMathPreviewForTextarea(activeEquationTextarea);
            }

            $('#modalEquationEditor').modal('hide');
        });
    }

    /* ========================================================================
     * VALIDASI, GENERATOR & CEK REAL-TIME KODE ASESMEN (A-Z, 0-9, MAX 20)
     * ======================================================================== */
    const inputKodeUji = document.getElementById('kode_uji');
    const btnGenerateKode = document.getElementById('btn-generate-kode');
    const kodeStatusEl = document.getElementById('kode-uji-status');
    const ignoreUjiId = @json(isset($uji) ? $uji->id : null);
    let checkKodeTimer = null;

    function cekKetersediaanKode(kode) {
        if (!kodeStatusEl || !inputKodeUji) return;

        if (!kode) {
            kodeStatusEl.classList.add('d-none');
            inputKodeUji.classList.remove('is-invalid', 'is-valid');
            return;
        }

        const params = new URLSearchParams({ kode: kode });
        if (ignoreUjiId) {
            params.append('ignore_id', ignoreUjiId);
        }

        fetch(`{{ route('sba.check_kode') }}?${params.toString()}`, {
            headers: { 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(data => {
            kodeStatusEl.classList.remove('d-none', 'text-success', 'text-danger');
            if (data.available) {
                kodeStatusEl.classList.add('text-success');
                kodeStatusEl.innerHTML = `<i class="fa fa-check-circle mr-1"></i> ${data.message}`;
                inputKodeUji.classList.remove('is-invalid');
            } else {
                kodeStatusEl.classList.add('text-danger');
                kodeStatusEl.innerHTML = `<i class="fa fa-times-circle mr-1"></i> ${data.message}`;
                inputKodeUji.classList.add('is-invalid');
            }
        })
        .catch(() => {});
    }

    if (inputKodeUji) {
        inputKodeUji.addEventListener('input', function() {
            this.value = this.value
                .toUpperCase()
                .replace(/[^A-Z0-9]/g, '')
                .slice(0, 20);

            clearTimeout(checkKodeTimer);
            const val = this.value;
            checkKodeTimer = setTimeout(() => cekKetersediaanKode(val), 350);
        });
    }

    if (btnGenerateKode && inputKodeUji) {
        btnGenerateKode.addEventListener('click', function() {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            let randomCode = '';
            for (let i = 0; i < 6; i++) {
                randomCode += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            inputKodeUji.value = randomCode;
            cekKetersediaanKode(randomCode);
        });
    }

    /* ========================================================================
     * MANAJEMEN SOAL DINAMIS, PERNYATAAN BENAR/SALAH, DRAG-AND-DROP & MEDIA
     * ======================================================================== */
    const container = document.getElementById('soal-container');
    const template = document.getElementById('soal-template');
    const bsRowTemplate = document.getElementById('bs-row-template');
    let draggedItem = null;

    function syncOpsiRequiredState(soalItem) {
        const tipe = soalItem.querySelector('.soal-tipe').value;
        const opsiItems = soalItem.querySelectorAll('.opsi-item');

        if (!['pg', 'pg_kompleks'].includes(tipe)) {
            opsiItems.forEach(optEl => {
                optEl.querySelector('.opsi-teks')?.removeAttribute('required');
            });
            return;
        }

        opsiItems.forEach((optEl, idx) => {
            const ta = optEl.querySelector('.opsi-teks');
            const previewContainer = optEl.querySelector('.opsi-media-preview-container');
            const hasImage = previewContainer && !previewContainer.classList.contains('d-none');

            if (idx < 2 && !hasImage) {
                ta.setAttribute('required', 'true');
            } else {
                ta.removeAttribute('required');
            }
        });
    }

    function recalcBobotBenarSalah(soalItem) {
        if (!soalItem || soalItem.querySelector('.soal-tipe').value !== 'benar_salah') return;
        let total = 0;
        soalItem.querySelectorAll('.bs-bobot').forEach(inp => {
            total += parseInt(inp.value, 10) || 0;
        });
        soalItem.querySelector('.soal-bobot').value = total;
        updateSummary();
    }

    function addBsRow(soalItem, rowData = null) {
        const rowsContainer = soalItem.querySelector('.bs-rows-container');
        const clone = bsRowTemplate.content.cloneNode(true);
        const rowEl = clone.querySelector('.bs-row');

        const teksInput = rowEl.querySelector('.bs-teks');
        const radioBenar = rowEl.querySelector('.bs-kunci-benar');
        const radioSalah = rowEl.querySelector('.bs-kunci-salah');
        const bobotInput = rowEl.querySelector('.bs-bobot');
        const btnRemove = rowEl.querySelector('.btn-remove-bs-row');

        if (rowData) {
            teksInput.value = rowData.teks || '';
            bobotInput.value = (rowData.bobot !== undefined && rowData.bobot !== null) ? rowData.bobot : 10;
            if (rowData.kunci === 'benar') {
                radioBenar.checked = true;
            } else if (rowData.kunci === 'salah') {
                radioSalah.checked = true;
            }
        }

        bobotInput.addEventListener('input', () => recalcBobotBenarSalah(soalItem));

        btnRemove.addEventListener('click', function() {
            if (rowsContainer.querySelectorAll('.bs-row').length > 1) {
                rowEl.remove();
                updateSoalNames();
                recalcBobotBenarSalah(soalItem);
            }
        });

        rowsContainer.appendChild(rowEl);
        renderMathPreviewForTextarea(teksInput);
        updateSoalNames();
        recalcBobotBenarSalah(soalItem);
    }

    const existingSoals = @json(isset($uji) ? $uji->soals : []);
    
    if (existingSoals.length > 0) {
        existingSoals.forEach(soal => addSoal(null, 'end', soal));
    } else {
        addSoal(); 
    }

    window.addEventListener('load', function() {
        refreshAllMathPreviews();
    });

    function addSoal(referenceElement = null, position = 'after', data = null) {
        const clone = template.content.cloneNode(true);
        const soalItem = clone.querySelector('.soal-item');
        
        setupSoalEvents(soalItem);

        if (data) {
            if(data.id) {
                soalItem.querySelector('.soal-id').value = data.id;
            }
            soalItem.querySelector('.soal-tipe').value = data.tipe;
            soalItem.querySelector('.soal-bobot').value = data.bobot_nilai || 10;
            soalItem.querySelector('.soal-pertanyaan').value = data.pertanyaan;
            
            if (data.media) {
                const previewContainer = soalItem.querySelector('.media-preview-container');
                const previewImg = soalItem.querySelector('.media-preview-img');
                previewImg.src = `{{ asset('storage') }}/${data.media}`;
                previewContainer.classList.remove('d-none');
            }

            if (data.tipe === 'benar_salah') {
                const opsiList = Array.isArray(data.opsi_jawaban) ? data.opsi_jawaban : [];
                const kunciList = Array.isArray(data.kunci_jawaban) ? data.kunci_jawaban : [];

                if (opsiList.length > 0) {
                    opsiList.forEach((item, idx) => {
                        addBsRow(soalItem, {
                            teks: item.teks ?? '',
                            bobot: item.bobot ?? 10,
                            kunci: kunciList[idx] ?? ''
                        });
                    });
                } else {
                    addBsRow(soalItem);
                    addBsRow(soalItem);
                }
            } else if (['pg', 'pg_kompleks'].includes(data.tipe)) {
                const opsiItems = soalItem.querySelectorAll('.opsi-item');
                const kunciRadios = soalItem.querySelectorAll('.kunci-radio');
                const kunciCheckboxes = soalItem.querySelectorAll('.kunci-checkbox');
                
                let opsiData = Array.isArray(data.opsi_jawaban) ? data.opsi_jawaban : [];
                let opsiMediaData = Array.isArray(data.opsi_media) ? data.opsi_media : [];
                let kunciData = Array.isArray(data.kunci_jawaban) ? data.kunci_jawaban : [];
                
                opsiItems.forEach((optEl, i) => {
                    const ta = optEl.querySelector('.opsi-teks');
                    if (opsiData[i]) ta.value = opsiData[i];

                    if (opsiMediaData[i]) {
                        const prevContainer = optEl.querySelector('.opsi-media-preview-container');
                        const prevImg = optEl.querySelector('.opsi-media-preview-img');
                        prevImg.src = `{{ asset('storage') }}/${opsiMediaData[i]}`;
                        prevContainer.classList.remove('d-none');
                    }
                });
                
                if (data.tipe === 'pg') {
                    kunciRadios.forEach((r, i) => {
                        if (kunciData.includes(String(i)) || kunciData.includes(i)) r.checked = true;
                    });
                } else {
                    kunciCheckboxes.forEach((c, i) => {
                        if (kunciData.includes(String(i)) || kunciData.includes(i)) c.checked = true;
                    });
                }
            } else if (data.tipe === 'esai') {
                const kunciIsianInput = soalItem.querySelector('.soal-kunci-isian');
                if (kunciIsianInput) {
                    const kunciList = Array.isArray(data.kunci_jawaban)
                        ? data.kunci_jawaban.filter(v => String(v ?? '').trim() !== '')
                        : (data.kunci_jawaban ? [String(data.kunci_jawaban)] : []);
                    kunciIsianInput.value = kunciList.join(' | ');
                }
            }
        }

        toggleOpsiVisibility(soalItem);

        if (referenceElement) {
            if (position === 'after') referenceElement.after(soalItem);
            else referenceElement.before(soalItem);
        } else {
            container.appendChild(soalItem);
        }
        
        refreshAllMathPreviews(soalItem);
        updateSoalNames();
        
        if(!data && referenceElement) {
            soalItem.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        
        updateSummary();
    }

    window.addSoal = addSoal;

    function setupSoalEvents(item) {
        item.querySelector('.btn-remove-soal').addEventListener('click', function() {
            if (document.querySelectorAll('.soal-item').length > 1) {
                const soalId = item.querySelector('.soal-id').value;
                if(soalId) {
                    fetch(`{{ url('admin/sba/soal') }}/${soalId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    });
                }
                item.remove();
                updateSoalNames();
                updateSummary();
            } else {
                alert('Minimal harus ada 1 soal dalam asesmen.');
            }
        });

        item.querySelector('.btn-add-bs-row').addEventListener('click', function() {
            addBsRow(item);
        });

        // Media Gambar Utama Soal
        const fileInput = item.querySelector('.soal-media');
        const previewContainer = item.querySelector('.media-preview-container');
        const previewImg = item.querySelector('.media-preview-img');
        const removeMediaInput = item.querySelector('.soal-remove-media');
        const btnDeleteMedia = item.querySelector('.btn-delete-media');

        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewContainer.classList.remove('d-none');
                    removeMediaInput.value = "0";
                }
                reader.readAsDataURL(file);
            }
        });

        btnDeleteMedia.addEventListener('click', function() {
            fileInput.value = "";
            previewImg.src = "";
            previewContainer.classList.add('d-none');
            removeMediaInput.value = "1";
        });

        // Media Gambar Per Pilihan Jawaban (Opsi A - E)
        item.querySelectorAll('.opsi-item').forEach(optEl => {
            const optFileInput = optEl.querySelector('.opsi-media-input');
            const optPreviewContainer = optEl.querySelector('.opsi-media-preview-container');
            const optPreviewImg = optEl.querySelector('.opsi-media-preview-img');
            const optRemoveInput = optEl.querySelector('.opsi-remove-media');
            const btnDeleteOptMedia = optEl.querySelector('.btn-delete-opsi-media');

            optFileInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        optPreviewImg.src = e.target.result;
                        optPreviewContainer.classList.remove('d-none');
                        optRemoveInput.value = "0";
                        syncOpsiRequiredState(item);
                    };
                    reader.readAsDataURL(file);
                }
            });

            btnDeleteOptMedia.addEventListener('click', function() {
                optFileInput.value = "";
                optPreviewImg.src = "";
                optPreviewContainer.classList.add('d-none');
                optRemoveInput.value = "1";
                syncOpsiRequiredState(item);
            });
        });

        item.querySelector('.btn-move-up').addEventListener('click', function() {
            const prev = item.previousElementSibling;
            if (prev && prev.classList.contains('soal-item')) {
                container.insertBefore(item, prev);
                updateSoalNames();
                item.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        });

        item.querySelector('.btn-move-down').addEventListener('click', function() {
            const next = item.nextElementSibling;
            if (next && next.classList.contains('soal-item')) {
                container.insertBefore(next, item);
                updateSoalNames();
                item.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        });

        item.querySelector('.btn-insert-soal').addEventListener('click', function() {
            addSoal(item, 'after');
        });

        item.querySelector('.soal-tipe').addEventListener('change', function() {
            toggleOpsiVisibility(item);
            updateSummary();
        });

        item.querySelector('.soal-bobot').addEventListener('input', updateSummary);

        // DRAG & DROP EVENTS
        const handle = item.querySelector('.drag-handle');
        handle.addEventListener('mousedown', () => item.setAttribute('draggable', 'true'));
        handle.addEventListener('mouseup', () => item.setAttribute('draggable', 'false'));
        handle.addEventListener('mouseleave', () => item.setAttribute('draggable', 'false'));

        item.addEventListener('dragstart', function(e) {
            draggedItem = item;
            e.dataTransfer.effectAllowed = 'move';
            setTimeout(() => item.classList.add('dragging'), 0);
        });

        item.addEventListener('dragend', function() {
            draggedItem.classList.remove('dragging');
            draggedItem = null;
            item.setAttribute('draggable', 'false');
            document.querySelectorAll('.soal-item').forEach(el => el.classList.remove('drag-over'));
            updateSoalNames(); 
        });

        item.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
            if(draggedItem !== item) {
                item.classList.add('drag-over');
            }
            const afterElement = getDragAfterElement(container, e.clientY);
            if (afterElement == null) {
                container.appendChild(draggedItem);
            } else {
                container.insertBefore(draggedItem, afterElement);
            }
        });

        item.addEventListener('dragleave', function() {
            item.classList.remove('drag-over');
        });
    }

    function getDragAfterElement(container, y) {
        const draggableElements = [...container.querySelectorAll('.soal-item:not(.dragging)')];
        return draggableElements.reduce((closest, child) => {
            const box = child.getBoundingClientRect();
            const offset = y - box.top - box.height / 2;
            if (offset < 0 && offset > closest.offset) {
                return { offset: offset, element: child };
            } else {
                return closest;
            }
        }, { offset: Number.NEGATIVE_INFINITY }).element;
    }

    function toggleOpsiVisibility(item) {
        const tipe = item.querySelector('.soal-tipe').value;
        const opsiWrapper = item.querySelector('.opsi-wrapper');
        const bsWrapper = item.querySelector('.bs-wrapper');
        const esaiWrapper = item.querySelector('.esai-wrapper');
        const radios = item.querySelectorAll('.kunci-radio');
        const checkboxes = item.querySelectorAll('.kunci-checkbox');
        const opsiTexts = item.querySelectorAll('.opsi-teks');
        const bobotUtamaInput = item.querySelector('.soal-bobot');
        const labelBobotUtama = item.querySelector('.label-bobot-utama');
        const infoBobotBs = item.querySelector('.info-bobot-bs');
        const labelPertanyaan = item.querySelector('.label-pertanyaan-utama');
        const textareaPertanyaan = item.querySelector('.soal-pertanyaan');

        // Reset atribut BS terlebih dahulu
        item.querySelectorAll('.bs-teks').forEach(el => el.removeAttribute('required'));
        item.querySelectorAll('.bs-kunci-benar').forEach(el => el.removeAttribute('required'));

        if (tipe === 'benar_salah') {
            opsiWrapper.classList.add('d-none');
            bsWrapper.classList.remove('d-none');
            if (esaiWrapper) esaiWrapper.classList.add('d-none');

            opsiTexts.forEach(el => el.removeAttribute('required'));
            radios.forEach(el => el.removeAttribute('required'));
            checkboxes.forEach(el => el.removeAttribute('required'));

            bobotUtamaInput.readOnly = true;
            bobotUtamaInput.classList.add('bg-light');
            labelBobotUtama.innerText = 'Total Bobot Soal';
            infoBobotBs.classList.remove('d-none');
            labelPertanyaan.innerHTML = 'Penjelasan / Paragraf / Cerita Stimulus <span class="text-danger">*</span>';
            textareaPertanyaan.placeholder = 'Ketikkan penjelasan, cerita, atau paragraf bacaan sebelum daftar pernyataan...';

            if (item.querySelectorAll('.bs-row').length === 0) {
                addBsRow(item);
                addBsRow(item);
            }

            item.querySelectorAll('.bs-teks').forEach(el => el.setAttribute('required', 'true'));
            item.querySelectorAll('.bs-kunci-benar').forEach(el => el.setAttribute('required', 'true'));

            recalcBobotBenarSalah(item);
        } else if (tipe === 'esai') {
            opsiWrapper.classList.add('d-none');
            bsWrapper.classList.add('d-none');
            if (esaiWrapper) esaiWrapper.classList.remove('d-none');

            opsiTexts.forEach(el => el.removeAttribute('required'));
            radios.forEach(el => el.removeAttribute('required'));
            checkboxes.forEach(el => el.removeAttribute('required'));

            bobotUtamaInput.readOnly = false;
            bobotUtamaInput.classList.remove('bg-light');
            labelBobotUtama.innerText = 'Bobot (Poin)';
            infoBobotBs.classList.add('d-none');
            labelPertanyaan.innerHTML = 'Pertanyaan <span class="text-danger">*</span>';
            textareaPertanyaan.placeholder = 'Ketikkan teks pertanyaan di sini...';
        } else {
            opsiWrapper.classList.remove('d-none');
            bsWrapper.classList.add('d-none');
            if (esaiWrapper) esaiWrapper.classList.add('d-none');

            bobotUtamaInput.readOnly = false;
            bobotUtamaInput.classList.remove('bg-light');
            labelBobotUtama.innerText = 'Bobot (Poin)';
            infoBobotBs.classList.add('d-none');
            labelPertanyaan.innerHTML = 'Pertanyaan <span class="text-danger">*</span>';
            textareaPertanyaan.placeholder = 'Ketikkan teks pertanyaan di sini...';

            syncOpsiRequiredState(item);

            if (tipe === 'pg') {
                radios.forEach(el => { el.classList.remove('d-none'); el.setAttribute('required', 'true'); });
                checkboxes.forEach(el => { el.classList.add('d-none'); el.removeAttribute('required'); });
                checkboxes.forEach(el => el.checked = false); 
            } else if (tipe === 'pg_kompleks') {
                checkboxes.forEach(el => { el.classList.remove('d-none'); }); 
                radios.forEach(el => { el.classList.add('d-none'); el.removeAttribute('required'); });
                radios.forEach(el => el.checked = false);
            }
        }
        updateSoalNames();
    }

    function updateSoalNames() {
        document.querySelectorAll('.soal-item').forEach((item, index) => {
            item.querySelector('.soal-number').innerText = index + 1;
            
            const soalIdEl = item.querySelector('.soal-id');
            if(soalIdEl) soalIdEl.name = `soals[${index}][id]`;

            item.querySelector('.soal-tipe').name = `soals[${index}][tipe]`;
            item.querySelector('.soal-bobot').name = `soals[${index}][bobot_nilai]`;
            item.querySelector('.soal-pertanyaan').name = `soals[${index}][pertanyaan]`;

            const kunciIsianEl = item.querySelector('.soal-kunci-isian');
            if (kunciIsianEl) kunciIsianEl.name = `soals[${index}][kunci_isian]`;
            
            item.querySelector('.soal-media').name = `soals[${index}][media]`;
            item.querySelector('.soal-remove-media').name = `soals[${index}][remove_media]`;
            
            item.querySelectorAll('.opsi-item').forEach((optEl, optIdx) => {
                optEl.querySelector('.opsi-teks').name = `soals[${index}][opsi_jawaban][${optIdx}]`;
                optEl.querySelector('.opsi-media-input').name = `soals[${index}][opsi_media][${optIdx}]`;
                optEl.querySelector('.opsi-remove-media').name = `soals[${index}][remove_opsi_media][${optIdx}]`;
            });
            item.querySelectorAll('.kunci-radio').forEach(el => el.name = `soals[${index}][kunci_jawaban][]`);
            item.querySelectorAll('.kunci-checkbox').forEach(el => el.name = `soals[${index}][kunci_jawaban][]`);

            // Penamaan atribut pernyataan Benar/Salah
            item.querySelectorAll('.bs-row').forEach((row, pIdx) => {
                row.querySelector('.bs-row-num').innerText = pIdx + 1;
                row.querySelector('.bs-teks').name = `soals[${index}][pernyataan_bs][${pIdx}][teks]`;
                row.querySelector('.bs-bobot').name = `soals[${index}][pernyataan_bs][${pIdx}][bobot]`;

                const radioBenar = row.querySelector('.bs-kunci-benar');
                const radioSalah = row.querySelector('.bs-kunci-salah');
                const labelBenar = radioBenar.nextElementSibling;
                const labelSalah = radioSalah.nextElementSibling;

                const radioName = `soals[${index}][pernyataan_bs][${pIdx}][kunci]`;
                const idBenar = `bs_benar_${index}_${pIdx}`;
                const idSalah = `bs_salah_${index}_${pIdx}`;

                radioBenar.name = radioName;
                radioBenar.id = idBenar;
                labelBenar.setAttribute('for', idBenar);

                radioSalah.name = radioName;
                radioSalah.id = idSalah;
                labelSalah.setAttribute('for', idSalah);
            });
        });
    }

    function hitungStatistikSoal() {
        const bobotInputs = document.querySelectorAll('.soal-bobot');
        let totalPoin = 0;
        bobotInputs.forEach(input => {
            totalPoin += parseInt(input.value) || 0;
        });
        return {
            jumlahSoal: bobotInputs.length,
            totalPoin: totalPoin
        };
    }

    function updateSummary() {
        const { jumlahSoal, totalPoin } = hitungStatistikSoal();
        document.getElementById('summary-total-soal').innerText = jumlahSoal;
        
        const poinEl = document.getElementById('summary-total-poin');
        const warningEl = document.getElementById('poin-warning');
        
        poinEl.innerText = totalPoin;
        
        if (totalPoin > 100) {
            poinEl.classList.remove('text-info', 'text-success');
            poinEl.classList.add('text-danger');
            warningEl.classList.remove('d-none');
        } else if (totalPoin === 100) {
            poinEl.classList.remove('text-info', 'text-danger');
            poinEl.classList.add('text-success');
            warningEl.classList.add('d-none');
        } else {
            poinEl.classList.remove('text-success', 'text-danger');
            poinEl.classList.add('text-info');
            warningEl.classList.add('d-none');
        }
    }

    function sesuaikanBobotOtomatis() {
        const soalItems = document.querySelectorAll('.soal-item');
        const n = soalItems.length;
        if (n === 0) return;

        let totalUnits = 0;
        soalItems.forEach(item => {
            const tipe = item.querySelector('.soal-tipe').value;
            if (tipe === 'benar_salah') {
                totalUnits += Math.max(1, item.querySelectorAll('.bs-bobot').length);
            } else {
                totalUnits += 1;
            }
        });

        const basePoin = Math.floor(100 / totalUnits);
        const remainder = 100 % totalUnits;
        let currentUnit = 0;

        soalItems.forEach(item => {
            const tipe = item.querySelector('.soal-tipe').value;
            if (tipe === 'benar_salah') {
                const bsBobots = item.querySelectorAll('.bs-bobot');
                bsBobots.forEach(inp => {
                    currentUnit++;
                    inp.value = (currentUnit === totalUnits) ? (basePoin + remainder) : basePoin;
                });
                recalcBobotBenarSalah(item);
            } else {
                currentUnit++;
                item.querySelector('.soal-bobot').value = (currentUnit === totalUnits) ? (basePoin + remainder) : basePoin;
            }
        });
        
        updateSummary();
    }

    // ========================================================================
    // EXPORT SOAL SAAT INI KE EXCEL (.XLSX) SESUAI FORMAT TEMPLATE IMPORT
    // ========================================================================
    const exportSoalButtons = document.querySelectorAll('.btn-export-soal-excel');
    if (exportSoalButtons.length > 0) {
        exportSoalButtons.forEach(btnExport => {
            btnExport.addEventListener('click', async function() {
                const soalItems = document.querySelectorAll('.soal-item');
                if (soalItems.length === 0) {
                    alert('Belum ada butir soal untuk di-export.');
                    return;
                }

                const payloadSoals = [];
                soalItems.forEach(item => {
                    const tipe = item.querySelector('.soal-tipe').value;
                    const pertanyaan = item.querySelector('.soal-pertanyaan').value;
                    const bobotNilai = item.querySelector('.soal-bobot').value;
                    const mediaPreview = item.querySelector('.media-preview-container');
                    const hasMedia = (mediaPreview && !mediaPreview.classList.contains('d-none')) ? '1' : '0';

                    const soalObj = {
                        tipe: tipe,
                        pertanyaan: pertanyaan,
                        bobot_nilai: bobotNilai,
                        has_media: hasMedia,
                        opsi_jawaban: [],
                        has_opsi_media: [],
                        kunci_jawaban: [],
                        kunci_isian: '',
                        pernyataan_bs: []
                    };

                    if (tipe === 'benar_salah') {
                        item.querySelectorAll('.bs-row').forEach(row => {
                            const teks = row.querySelector('.bs-teks').value;
                            const bobot = row.querySelector('.bs-bobot').value;
                            const radioBenar = row.querySelector('.bs-kunci-benar');
                            const radioSalah = row.querySelector('.bs-kunci-salah');
                            let kunci = '';
                            if (radioBenar && radioBenar.checked) kunci = 'benar';
                            else if (radioSalah && radioSalah.checked) kunci = 'salah';

                            soalObj.pernyataan_bs.push({
                                teks: teks,
                                kunci: kunci,
                                bobot: bobot
                            });
                        });
                    } else if (['pg', 'pg_kompleks'].includes(tipe)) {
                        item.querySelectorAll('.opsi-item').forEach((optEl, optIdx) => {
                            const teksOpsi = optEl.querySelector('.opsi-teks').value;
                            const optPrev = optEl.querySelector('.opsi-media-preview-container');
                            const hasOptMedia = (optPrev && !optPrev.classList.contains('d-none')) ? '1' : '0';

                            soalObj.opsi_jawaban.push(teksOpsi);
                            soalObj.has_opsi_media.push(hasOptMedia);

                            if (tipe === 'pg') {
                                const r = optEl.querySelector('.kunci-radio');
                                if (r && r.checked) {
                                    soalObj.kunci_jawaban.push(String(optIdx));
                                }
                            } else {
                                const c = optEl.querySelector('.kunci-checkbox');
                                if (c && c.checked) {
                                    soalObj.kunci_jawaban.push(String(optIdx));
                                }
                            }
                        });
                    } else {
                        soalObj.kunci_isian = item.querySelector('.soal-kunci-isian')?.value?.trim() || '';
                    }

                    payloadSoals.push(soalObj);
                });

                const originalHtmls = [];
                exportSoalButtons.forEach((btn, idx) => {
                    originalHtmls[idx] = btn.innerHTML;
                    btn.disabled = true;
                    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Mengekspor...';
                });

                try {
                    const kodeUjiVal = inputKodeUji ? inputKodeUji.value.trim() : '';
                    const response = await fetch("{{ route('sba.soal.export') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/json'
                        },
                        body: JSON.stringify({
                            kode_uji: kodeUjiVal,
                            soals: payloadSoals
                        })
                    });

                    if (!response.ok) {
                        let errMsg = 'Gagal mengekspor soal ke Excel.';
                        try {
                            const errData = await response.json();
                            if (errData && errData.message) errMsg = errData.message;
                        } catch (_) {}
                        throw new Error(errMsg);
                    }

                    const blob = await response.blob();
                    const downloadUrl = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = downloadUrl;
                    a.download = kodeUjiVal !== ''
                        ? `Export_Soal_SBA_${kodeUjiVal}.xlsx`
                        : 'Export_Soal_SBA.xlsx';
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                    window.URL.revokeObjectURL(downloadUrl);
                } catch (err) {
                    alert(err.message || 'Terjadi kesalahan saat mengekspor soal.');
                } finally {
                    exportSoalButtons.forEach((btn, idx) => {
                        btn.disabled = false;
                        btn.innerHTML = originalHtmls[idx];
                    });
                }
            });
        });
    }

    // ========================================================================
    // AJAX IMPORT EXCEL TO VIEW (TEMPORARY DI FORM)
    // ========================================================================
    const btnProsesImport = document.getElementById('btn-proses-import-excel');
    const inputExcelSoal = document.getElementById('input_excel_soal');
    const errorBox = document.getElementById('import-excel-error-box');
    const errorTitle = document.getElementById('import-excel-error-title');
    const errorList = document.getElementById('import-excel-error-list');
    const alertImportSuccess = document.getElementById('alert-import-success');
    const alertImportSuccessText = document.getElementById('alert-import-success-text');

    if (btnProsesImport) {
        btnProsesImport.addEventListener('click', function() {
            errorBox.classList.add('d-none');
            errorList.innerHTML = '';

            if (!inputExcelSoal.files || inputExcelSoal.files.length === 0) {
                errorTitle.innerText = 'File belum dipilih!';
                errorList.innerHTML = '<li>Silakan pilih file Excel (.xlsx, .xls, atau .csv) terlebih dahulu.</li>';
                errorBox.classList.remove('d-none');
                return;
            }

            const formData = new FormData();
            formData.append('excel_file', inputExcelSoal.files[0]);

            const originalBtnHtml = btnProsesImport.innerHTML;
            btnProsesImport.disabled = true;
            btnProsesImport.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Memproses...';

            fetch("{{ route('sba.soal.import_preview') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(async response => {
                const data = await response.json();
                if (!response.ok) {
                    throw data;
                }
                return data;
            })
            .then(data => {
                const mode = document.querySelector('input[name="import_mode"]:checked').value;

                if (mode === 'replace') {
                    container.innerHTML = '';
                }

                data.soals.forEach(soalData => {
                    addSoal(null, 'end', soalData);
                });

                updateSoalNames();
                updateSummary();

                inputExcelSoal.value = '';
                $('#modalImportSoalExcel').modal('hide');

                alertImportSuccessText.innerHTML = `<strong>Berhasil Dimuat!</strong> ${data.message}`;
                alertImportSuccess.classList.remove('d-none');
                container.scrollIntoView({ behavior: 'smooth', block: 'start' });
            })
            .catch(err => {
                errorTitle.innerText = err.message || 'Terjadi kesalahan saat memproses file Excel.';
                if (err.errors && Array.isArray(err.errors)) {
                    err.errors.forEach(msg => {
                        const li = document.createElement('li');
                        li.innerText = msg;
                        errorList.appendChild(li);
                    });
                } else if (err.errors && typeof err.errors === 'object') {
                    Object.values(err.errors).flat().forEach(msg => {
                        const li = document.createElement('li');
                        li.innerText = msg;
                        errorList.appendChild(li);
                    });
                }
                errorBox.classList.remove('d-none');
            })
            .finally(() => {
                btnProsesImport.disabled = false;
                btnProsesImport.innerHTML = originalBtnHtml;
            });
        });
    }

    // ========================================================================
    // TOGGLE OTOMATIS ULANGI JIKA GAGAL & MODE OPEN BOOK
    // ========================================================================
    const switchUlangi = document.getElementById('ulangi_jika_gagal');
    const wrapperPercobaan = document.getElementById('wrapper-maks-percobaan');
    const inputPercobaan = document.getElementById('maksimal_percobaan');
    const switchOpenBook = document.getElementById('open_book');
    const wrapperToleransi = document.getElementById('wrapper-toleransi');
    const descOpenBook = document.getElementById('text-open-book-desc');

    if (switchUlangi && wrapperPercobaan && inputPercobaan) {
        switchUlangi.addEventListener('change', function() {
            if (this.checked) {
                wrapperPercobaan.classList.remove('d-none');
                if (parseInt(inputPercobaan.value) <= 1 || !inputPercobaan.value) {
                    inputPercobaan.value = 2;
                }
                inputPercobaan.min = 2;
            } else {
                wrapperPercobaan.classList.add('d-none');
                inputPercobaan.min = 1;
                inputPercobaan.value = 1;
            }
        });
    }

    if (switchOpenBook && wrapperToleransi && descOpenBook) {
        switchOpenBook.addEventListener('change', function() {
            if (this.checked) {
                wrapperToleransi.classList.add('d-none');
                descOpenBook.innerText = 'Izinkan peserta berpindah tab / minimize tanpa pelanggaran';
                descOpenBook.classList.remove('text-muted');
                descOpenBook.classList.add('text-success', 'font-weight-bold');
            } else {
                wrapperToleransi.classList.remove('d-none');
                descOpenBook.innerText = 'Peserta dilarang berpindah / minimize tab selama uji berlangsung';
                descOpenBook.classList.remove('text-success', 'font-weight-bold');
                descOpenBook.classList.add('text-muted');
            }
        });
    }

    const btnSesuaikanPoin = document.getElementById('btn-sesuaikan-poin');
    btnSesuaikanPoin.addEventListener('click', function() {
        sesuaikanBobotOtomatis();
        
        const originalText = this.innerHTML;
        this.innerHTML = '<i class="fa fa-check"></i> Berhasil Disesuaikan';
        this.classList.replace('btn-info', 'btn-success');
        setTimeout(() => {
            this.innerHTML = originalText;
            this.classList.replace('btn-success', 'btn-info');
        }, 2000);
    });

    // ========================================================================
    // INTERCEPT SUBMIT FORM: MODAL BOBOT & SIMPAN VIA AJAX (ZERO PAGE RELOAD)
    // ========================================================================
    const formUjianSba = document.getElementById('form-ujian-sba');
    const modalBobotEl = document.getElementById('modalPeringatanBobot');
    const btnModalSesuaikanBobot = document.getElementById('btn-modal-sesuaikan-bobot');
    const btnModalTetapSimpan = document.getElementById('btn-modal-tetap-simpan');
    const ajaxErrorAlert = document.getElementById('ajax-error-alert');
    const ajaxErrorTitle = document.getElementById('ajax-error-title');
    const ajaxErrorList = document.getElementById('ajax-error-list');
    const submitButtons = document.querySelectorAll('.btn-submit-sba');
    let isSubmitting = false;

    function formatErrorKeyLabel(key) {
        const matchSoal = key.match(/^soals\.(\d+)\.(.+)$/);
        if (matchSoal) {
            const nomorSoal = parseInt(matchSoal[1], 10) + 1;
            return `Soal #${nomorSoal}`;
        }
        return null;
    }

    function tampilkanErrorAjax(title, messages = []) {
        ajaxErrorTitle.textContent = title;
        ajaxErrorList.innerHTML = '';

        if (messages.length > 0) {
            messages.forEach(msg => {
                const li = document.createElement('li');
                li.textContent = msg;
                ajaxErrorList.appendChild(li);
            });
        } else {
            const li = document.createElement('li');
            li.textContent = 'Periksa kembali isian formulir Anda.';
            ajaxErrorList.appendChild(li);
        }

        ajaxErrorAlert.classList.remove('d-none');
        ajaxErrorAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    async function kirimFormViaAjax() {
        if (isSubmitting) return;
        isSubmitting = true;

        ajaxErrorAlert.classList.add('d-none');
        updateSoalNames();

        const originalButtonHtmls = [];
        submitButtons.forEach((btn, idx) => {
            originalButtonHtmls[idx] = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Menyimpan...';
        });

        try {
            const formData = new FormData(formUjianSba);

            const response = await fetch(formUjianSba.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            });

            let data = null;
            try {
                data = await response.json();
            } catch (_) {
                data = null;
            }

            if (response.ok && data && data.status === 'success') {
                window.location.href = data.redirect || "{{ route('sba.index') }}";
                return;
            }

            if (response.status === 422 && data && data.errors) {
                const formattedMessages = [];
                Object.entries(data.errors).forEach(([field, msgs]) => {
                    if (field === 'kode_uji' && inputKodeUji) {
                        inputKodeUji.classList.add('is-invalid');
                    }
                    const prefix = formatErrorKeyLabel(field);
                    (Array.isArray(msgs) ? msgs : [msgs]).forEach(m => {
                        formattedMessages.push(prefix ? `${prefix}: ${m}` : m);
                    });
                });

                tampilkanErrorAjax(
                    'Gagal Menyimpan! Terdapat data yang belum sesuai:',
                    formattedMessages
                );
            } else if (response.status === 419) {
                tampilkanErrorAjax(
                    'Sesi Keamanan (CSRF) Berakhir',
                    ['Silakan buka tab baru untuk login ulang jika diperlukan, lalu tekan kembali tombol Simpan Asesmen tanpa me-refresh halaman ini agar soal tidak hilang.']
                );
            } else if (response.status === 413) {
                tampilkanErrorAjax(
                    'Ukuran File Terlalu Besar',
                    ['Total ukuran gambar soal dan pilihan jawaban yang diunggah melebihi batas server. Silakan perkecil ukuran gambar (maksimal 2MB per gambar) lalu coba simpan kembali.']
                );
            } else {
                tampilkanErrorAjax(
                    'Gagal Menyimpan Asesmen!',
                    [(data && data.message) ? data.message : `Terjadi kesalahan pada server (Kode HTTP ${response.status}).`]
                );
            }
        } catch (networkErr) {
            tampilkanErrorAjax(
                'Koneksi Terputus!',
                ['Gagal terhubung ke server. Periksa koneksi internet Anda lalu klik tombol Simpan kembali.']
            );
        } finally {
            isSubmitting = false;
            submitButtons.forEach((btn, idx) => {
                btn.disabled = false;
                btn.innerHTML = originalButtonHtmls[idx];
            });
        }
    }

    function submitFormSetelahKonfirmasi() {
        $('#modalPeringatanBobot').modal('hide');
        kirimFormViaAjax();
    }

    if (formUjianSba && modalBobotEl) {
        formUjianSba.addEventListener('submit', function(e) {
            e.preventDefault();

            if (!formUjianSba.checkValidity()) {
                formUjianSba.reportValidity();
                return;
            }

            const { jumlahSoal, totalPoin } = hitungStatistikSoal();

            if (totalPoin !== 100) {
                document.getElementById('modal-bobot-jumlah-soal').innerText = jumlahSoal;
                document.getElementById('modal-bobot-total-poin').innerText = totalPoin + ' Poin';

                const ketEl = document.getElementById('modal-bobot-keterangan');
                if (totalPoin < 100) {
                    const kurang = 100 - totalPoin;
                    ketEl.innerHTML = `<i class="fa fa-info-circle text-warning mr-1"></i> Total bobot nilai dari <strong>${jumlahSoal} soal</strong> saat ini masih <strong>kurang ${kurang} poin</strong> dari standar nilai maksimal 100.`;
                } else {
                    const lebih = totalPoin - 100;
                    ketEl.innerHTML = `<i class="fa fa-info-circle text-warning mr-1"></i> Total bobot nilai dari <strong>${jumlahSoal} soal</strong> saat ini <strong>melebihi ${lebih} poin</strong> dari standar nilai maksimal 100.`;
                }

                $('#modalPeringatanBobot').modal('show');
                return;
            }

            kirimFormViaAjax();
        });

        btnModalTetapSimpan?.addEventListener('click', function() {
            submitFormSetelahKonfirmasi();
        });

        btnModalSesuaikanBobot?.addEventListener('click', function() {
            sesuaikanBobotOtomatis();
            submitFormSetelahKonfirmasi();
        });
    }

    updateSummary();
});
</script>
@endsection