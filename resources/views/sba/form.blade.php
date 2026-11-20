@extends('faturcms::template.admin.main')

@section('title', isset($uji) ? 'Edit Asesmen & Soal SBA' : 'Buat Asesmen & Soal Baru')

@section('content')
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

                {{-- MENAMPILKAN ERROR VALIDASI --}}
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

                {{-- SECTION 1: PENGATURAN ASESMEN --}}
                <h4 class="text-primary mb-3"><i class="fa fa-cogs"></i> Bagian 1: Pengaturan Asesmen</h4>
                
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
                    <div class="col-md-7">
                        <div class="form-group">
                            <label for="judul">Judul Asesmen <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="judul" name="judul" 
                                   value="{{ old('judul', $uji->judul ?? '') }}" 
                                   placeholder="Contoh: Penilaian Tengah Semester - Matematika" required>
                        </div>

                        <div class="form-group">
                            <label for="kode_uji">Kode Asesmen <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control text-uppercase font-weight-bold" id="kode_uji" name="kode_uji" 
                                       value="{{ old('kode_uji', $uji->kode_uji ?? strtoupper(Str::random(6))) }}" 
                                       placeholder="Contoh: MAT01" required maxlength="20">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary" id="btn-generate-kode" title="Generate Kode Acak">
                                        <i class="fa fa-random"></i> Acak
                                    </button>
                                </div>
                            </div>
                            <small class="form-text text-muted">Maksimal 20 karakter huruf/angka tanpa spasi (unik per ujian).</small>
                        </div>

                        <div class="form-group">
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
                                <label for="durasi_menit">Durasi (Menit)</label>
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

                        {{-- PENGATURAN KEAMANAN --}}
                        <div class="form-row border-top pt-2 mt-2">
                            <div class="col-md-6 form-group">
                                <label for="toleransi_pelanggaran">Toleransi Pelanggaran</label>
                                <input type="number" class="form-control" id="toleransi_pelanggaran" name="toleransi_pelanggaran" 
                                       value="{{ old('toleransi_pelanggaran', $uji->toleransi_pelanggaran ?? 3) }}" min="1" required>
                                <small class="form-text text-muted">Batas pindah tab</small>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="maksimal_percobaan">Maks. Percobaan</label>
                                <input type="number" class="form-control" id="maksimal_percobaan" name="maksimal_percobaan" 
                                       value="{{ old('maksimal_percobaan', $uji->maksimal_percobaan ?? 1) }}" min="1" required>
                                <small class="form-text text-muted">Batas partisipasi</small>
                            </div>
                        </div>

                        {{-- OPTION SWITCHES (TOGGLE) --}}
                        <div class="form-row mt-2">
                            <div class="col-12">
                                <div class="animated-checkbox mb-2">
                                    <label><input type="checkbox" id="acak_soal" name="acak_soal" value="1" {{ old('acak_soal', $uji->acak_soal ?? true) ? 'checked' : '' }}><span class="label-text">Acak Soal</span></label>
                                </div>
                                <div class="animated-checkbox mb-2">
                                    <label><input type="checkbox" id="tampilkan_nilai" name="tampilkan_nilai" value="1" {{ old('tampilkan_nilai', $uji->tampilkan_nilai ?? false) ? 'checked' : '' }}><span class="label-text">Tampilkan Nilai Setelah Selesai</span></label>
                                </div>
                                <div class="animated-checkbox mb-2">
                                    <label><input type="checkbox" id="open_book" name="open_book" value="1" {{ old('open_book', $uji->open_book ?? false) ? 'checked' : '' }}><span class="label-text">Mode Open Book (Bebas Pindah Tab / Referensi)</span></label>
                                </div>
                                <div class="animated-checkbox mb-2">
                                    <label><input type="checkbox" id="buka_untuk_umum" name="buka_untuk_umum" value="1" {{ old('buka_untuk_umum', $uji->buka_untuk_umum ?? true) ? 'checked' : '' }}><span class="label-text">Buka untuk Umum</span></label>
                                </div>
                                <div class="animated-checkbox mb-2">
                                    <label><input type="checkbox" id="ulangi_jika_gagal" name="ulangi_jika_gagal" value="1" {{ old('ulangi_jika_gagal', $uji->ulangi_jika_gagal ?? false) ? 'checked' : '' }}><span class="label-text">Ulangi Jika Gagal Pelanggaran</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- INFORMASI TOTAL DAN AUTO ADJUST --}}
                <div class="row mb-4 mt-2">
                    <div class="col-12">
                        <div class="p-3 bg-light border rounded d-flex flex-column flex-md-row justify-content-between align-items-center">
                            <div class="mb-2 mb-md-0">
                                <span class="font-weight-bold text-dark"><i class="fa fa-pie-chart"></i> Rekap Soal:</span>
                                <span class="ml-3 text-secondary">Total Soal: <strong id="summary-total-soal" class="text-primary h5">0</strong></span>
                                <span class="ml-3 text-secondary">Total Poin: <strong id="summary-total-poin" class="text-info h5">0</strong> <span id="poin-warning" class="text-danger small d-none">(Melebihi 100!)</span></span>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modalImportSoal">
                                    <i class="fa fa-file-excel-o"></i> Import Soal (Excel/CSV)
                                </button>
                                <button type="button" class="btn btn-sm btn-info" id="btn-sesuaikan-poin" title="Bagikan bobot poin secara merata dengan total 100">
                                    <i class="fa fa-magic"></i> Sesuaikan Poin (100)
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                {{-- SECTION 2: PENYUSUNAN SOAL --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-info mb-0"><i class="fa fa-list-ol"></i> Bagian 2: Daftar Soal</h4>
                    <small class="text-muted"><i class="fa fa-info-circle"></i> Gunakan tombol panah untuk memindahkan posisi soal.</small>
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
                <div class="tile-footer text-right">
                    <a href="{{ route('sba.index') }}" class="btn btn-secondary mr-2">Batal</a>
                    <button type="submit" class="btn btn-primary icon-btn">
                        <i class="fa fa-save"></i> {{ isset($uji) ? 'Simpan Perubahan' : 'Simpan Asesmen' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL IMPORT SOAL DARI EXCEL / CSV --}}
<div class="modal fade" id="modalImportSoal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fa fa-file-excel-o"></i> Import Soal dari Excel / CSV</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="small text-muted">
                    Unduh template terlebih dahulu, isi daftar soal pada file tersebut, lalu unggah kembali di bawah ini. Soal akan langsung ditambahkan ke daftar butir soal di form.
                </p>
                <div class="mb-3">
                    <a href="{{ route('sba.soal.template') }}" class="btn btn-outline-success btn-sm">
                        <i class="fa fa-download"></i> Unduh Template Excel (.xls)
                    </a>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Pilih File Soal (.xls / .xlsx / .csv)</label>
                    <input type="file" id="inputFileImportSoal" class="form-control-file border p-2 rounded" accept=".xls,.xlsx,.csv">
                </div>
                <div id="importSoalFeedback" class="small mt-2"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success" id="btnProsesImportSoal">
                    <i class="fa fa-upload"></i> Proses & Muat ke Form
                </button>
            </div>
        </div>
    </div>
</div>

{{-- TEMPLATE SOAL (Hidden) --}}
<template id="soal-template">
    <div class="soal-item card mb-3 border">
        <input type="hidden" class="soal-id" value="">
        
        <div class="card-header bg-white py-2 px-3 d-flex justify-content-between align-items-center">
            <span class="font-weight-bold text-dark mb-0">Soal #<span class="soal-number">1</span></span>
            <div class="btn-group">
                <button type="button" class="btn btn-outline-secondary btn-sm btn-move-up" title="Geser ke Atas">
                    <i class="fa fa-chevron-up"></i>
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm btn-move-down" title="Geser ke Bawah">
                    <i class="fa fa-chevron-down"></i>
                </button>
                <button type="button" class="btn btn-outline-danger btn-sm btn-remove-soal" title="Hapus Soal">
                    <i class="fa fa-trash"></i> Hapus
                </button>
            </div>
        </div>
        
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tipe Soal</label>
                        <select class="form-control soal-tipe" required>
                            <option value="pg">Pilihan Ganda</option>
                            <option value="pg_kompleks">PG Kompleks</option>
                            <option value="esai">Uraian / Isian</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Bobot (Poin)</label>
                        <input type="number" class="form-control soal-bobot" value="10" min="1" required>
                    </div>
                </div>
                
                <div class="col-md-9">
                    <div class="form-group">
                        <label>Pertanyaan <span class="text-danger">*</span></label>
                        <textarea class="form-control soal-pertanyaan" rows="4" placeholder="Ketikkan teks pertanyaan di sini..." required style="resize: vertical;"></textarea>
                    </div>

                    {{-- SLOT INPUT GAMBAR SOAL & PREVIEW --}}
                    <div class="form-group border-top pt-2 mt-2">
                        <label class="text-dark font-weight-bold">
                            <i class="fa fa-image text-primary"></i> Lampiran Gambar Soal (Opsional)
                        </label>
                        <div class="d-flex align-items-center">
                            <input type="file" class="form-control-file soal-media" accept="image/*">
                            <input type="hidden" class="soal-remove-media" value="0">
                        </div>
                        <small class="form-text text-muted">*Format: JPG, PNG, WEBP (Maksimal 2MB)</small>

                        {{-- PREVIEW CONTAINER --}}
                        <div class="media-preview-container mt-2 position-relative d-none" style="max-width: 250px;">
                            <img src="" class="img-thumbnail media-preview-img" style="max-height: 140px; width: auto;" alt="Preview Soal">
                            <button type="button" class="btn btn-danger btn-sm position-absolute btn-delete-media" style="top: 5px; right: 5px;" title="Hapus Gambar">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Container Opsi Jawaban --}}
            <div class="opsi-wrapper border-top pt-3 mt-3">
                <label class="font-weight-bold text-primary d-block mb-2">
                    <i class="fa fa-check-circle"></i> Pilihan Jawaban & Kunci 
                    <small class="text-muted font-weight-normal">(Centang / pilih kunci jawaban yang benar. Opsi dapat berupa teks, gambar, atau keduanya.)</small>
                </label>
                
                <div class="opsi-container">
                    @foreach(['A', 'B', 'C', 'D', 'E'] as $index => $huruf)
                    <div class="opsi-item border rounded p-2 mb-2 bg-light" data-opt-index="{{ $index }}">
                        <div class="row align-items-start">
                            {{-- KOLOM KIRI: BADGE HURUF, RADIO/CHECKBOX KUNCI & TEKS OPSI --}}
                            <div class="col-12 col-md-7 mb-2 mb-md-0">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text font-weight-bold bg-secondary text-white">{{ $huruf }}</span>
                                        <div class="input-group-text bg-white">
                                            <input type="radio" class="kunci-radio" value="{{ $index }}" title="Kunci PG" style="cursor: pointer;">
                                            <input type="checkbox" class="kunci-checkbox d-none" value="{{ $index }}" title="Kunci PG Kompleks" style="cursor: pointer;">
                                        </div>
                                    </div>
                                    <textarea class="form-control opsi-teks" rows="2" placeholder="Masukkan teks untuk opsi {{ $huruf }}..." style="resize:vertical;"></textarea>
                                </div>
                            </div>

                            {{-- KOLOM KANAN: INSERT GAMBAR OPSI & PREVIEW (TANPA LABEL GAMBAR A, B, DST.) --}}
                            <div class="col-12 col-md-5">
                                <input type="file" class="form-control-file border bg-white p-1 rounded opsi-media-input" accept="image/*">
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
                    @endforeach
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('soal-container');
    const template = document.getElementById('soal-template');

    // Tombol Acak Kode Asesmen
    document.getElementById('btn-generate-kode')?.addEventListener('click', function() {
        const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        let code = '';
        for (let i = 0; i < 6; i++) {
            code += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        document.getElementById('kode_uji').value = code;
    });

    const existingSoals = @json(isset($uji) ? $uji->soals : []);
    
    if (existingSoals.length > 0) {
        existingSoals.forEach(soal => addSoal(null, 'end', soal));
    } else {
        addSoal(); 
    }

    function addSoal(referenceElement = null, position = 'after', data = null) {
        const clone = template.content.cloneNode(true);
        const soalItem = clone.querySelector('.soal-item');
        
        setupSoalEvents(soalItem);

        if (data) {
            if(data.id) {
                soalItem.querySelector('.soal-id').value = data.id;
            }
            soalItem.querySelector('.soal-tipe').value = data.tipe || 'pg';
            soalItem.querySelector('.soal-bobot').value = data.bobot_nilai || 10;
            soalItem.querySelector('.soal-pertanyaan').value = data.pertanyaan || '';
            
            if (data.media) {
                const previewContainer = soalItem.querySelector('.media-preview-container');
                const previewImg = soalItem.querySelector('.media-preview-img');
                previewImg.src = `{{ asset('storage') }}/${data.media}`;
                previewContainer.classList.remove('d-none');
            }

            if (['pg', 'pg_kompleks'].includes(data.tipe)) {
                const opsiItems = soalItem.querySelectorAll('.opsi-item');
                const kunciRadios = soalItem.querySelectorAll('.kunci-radio');
                const kunciCheckboxes = soalItem.querySelectorAll('.kunci-checkbox');
                
                let opsiData = data.opsi_jawaban || [];
                let opsiMediaData = data.opsi_media || [];
                let kunciData = (data.kunci_jawaban || []).map(String);
                
                opsiItems.forEach((optEl, i) => {
                    const ta = optEl.querySelector('.opsi-teks');
                    if (ta && opsiData[i]) ta.value = opsiData[i];

                    if (opsiMediaData[i]) {
                        const optPrevContainer = optEl.querySelector('.opsi-media-preview-container');
                        const optPrevImg = optEl.querySelector('.opsi-media-preview-img');
                        optPrevImg.src = `{{ asset('storage') }}/${opsiMediaData[i]}`;
                        optPrevContainer.classList.remove('d-none');
                        optEl.dataset.hasExistingMedia = '1';
                    }
                });
                
                if (data.tipe === 'pg') {
                    kunciRadios.forEach((r, i) => {
                        if (kunciData.includes(String(i))) r.checked = true;
                    });
                } else {
                    kunciCheckboxes.forEach((c, i) => {
                        if (kunciData.includes(String(i))) c.checked = true;
                    });
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
        
        updateSoalNames();
        updateSummary();
    }

    window.addSoal = addSoal;

    function syncOpsiRequiredState(soalItem) {
        const tipe = soalItem.querySelector('.soal-tipe').value;
        const opsiItems = soalItem.querySelectorAll('.opsi-item');

        opsiItems.forEach((optEl, index) => {
            const ta = optEl.querySelector('.opsi-teks');
            const fileInput = optEl.querySelector('.opsi-media-input');
            const removeInput = optEl.querySelector('.opsi-remove-media');
            const hasNewFile = fileInput && fileInput.files && fileInput.files.length > 0;
            const hasExisting = optEl.dataset.hasExistingMedia === '1' && removeInput.value !== '1';

            if (tipe === 'esai') {
                ta.removeAttribute('required');
            } else if (index < 2) {
                if (hasNewFile || hasExisting) {
                    ta.removeAttribute('required');
                } else {
                    ta.setAttribute('required', 'true');
                }
            } else {
                ta.removeAttribute('required');
            }
        });
    }

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

        // Gambar Utama Soal
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

        // Gambar per Opsi Jawaban (A-E)
        item.querySelectorAll('.opsi-item').forEach(optEl => {
            const optFile = optEl.querySelector('.opsi-media-input');
            const optPreviewBox = optEl.querySelector('.opsi-media-preview-container');
            const optPreviewImg = optEl.querySelector('.opsi-media-preview-img');
            const optRemoveInput = optEl.querySelector('.opsi-remove-media');
            const btnDeleteOptMedia = optEl.querySelector('.btn-delete-opsi-media');

            optFile.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        optPreviewImg.src = e.target.result;
                        optPreviewBox.classList.remove('d-none');
                        optRemoveInput.value = "0";
                        syncOpsiRequiredState(item);
                    };
                    reader.readAsDataURL(file);
                } else {
                    syncOpsiRequiredState(item);
                }
            });

            btnDeleteOptMedia.addEventListener('click', function() {
                optFile.value = "";
                optPreviewImg.src = "";
                optPreviewBox.classList.add('d-none');
                optRemoveInput.value = "1";
                optEl.dataset.hasExistingMedia = '0';
                syncOpsiRequiredState(item);
            });
        });

        item.querySelector('.btn-move-up').addEventListener('click', function() {
            const prev = item.previousElementSibling;
            if (prev && prev.classList.contains('soal-item')) {
                container.insertBefore(item, prev);
                updateSoalNames();
            }
        });

        item.querySelector('.btn-move-down').addEventListener('click', function() {
            const next = item.nextElementSibling;
            if (next && next.classList.contains('soal-item')) {
                container.insertBefore(next, item);
                updateSoalNames();
            }
        });

        item.querySelector('.btn-insert-soal').addEventListener('click', function() {
            addSoal(item, 'after');
        });

        item.querySelector('.soal-tipe').addEventListener('change', function() {
            toggleOpsiVisibility(item);
        });

        item.querySelector('.soal-bobot').addEventListener('input', updateSummary);
    }

    function toggleOpsiVisibility(item) {
        const tipe = item.querySelector('.soal-tipe').value;
        const opsiWrapper = item.querySelector('.opsi-wrapper');
        const radios = item.querySelectorAll('.kunci-radio');
        const checkboxes = item.querySelectorAll('.kunci-checkbox');
        const opsiTexts = item.querySelectorAll('.opsi-teks');

        if (tipe === 'esai') {
            opsiWrapper.classList.add('d-none');
            opsiTexts.forEach(el => el.removeAttribute('required'));
            radios.forEach(el => el.removeAttribute('required'));
            checkboxes.forEach(el => el.removeAttribute('required'));
        } else {
            opsiWrapper.classList.remove('d-none');
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
            
            item.querySelector('.soal-media').name = `soals[${index}][media]`;
            item.querySelector('.soal-remove-media').name = `soals[${index}][remove_media]`;
            
            item.querySelectorAll('.opsi-item').forEach((optEl, optIdx) => {
                optEl.querySelector('.opsi-teks').name = `soals[${index}][opsi_jawaban][${optIdx}]`;
                optEl.querySelector('.opsi-media-input').name = `soals[${index}][opsi_media][${optIdx}]`;
                optEl.querySelector('.opsi-remove-media').name = `soals[${index}][remove_opsi_media][${optIdx}]`;
            });

            item.querySelectorAll('.kunci-radio').forEach(el => el.name = `soals[${index}][kunci_jawaban][]`);
            item.querySelectorAll('.kunci-checkbox').forEach(el => el.name = `soals[${index}][kunci_jawaban][]`);
        });
    }

    function updateSummary() {
        const bobotInputs = document.querySelectorAll('.soal-bobot');
        let totalPoin = 0;
        bobotInputs.forEach(input => {
            totalPoin += parseInt(input.value) || 0;
        });
        document.getElementById('summary-total-soal').innerText = bobotInputs.length;
        
        const poinEl = document.getElementById('summary-total-poin');
        const warningEl = document.getElementById('poin-warning');
        
        poinEl.innerText = totalPoin;
        
        if (totalPoin > 100) {
            poinEl.className = 'text-danger h5';
            warningEl.classList.remove('d-none');
        } else if (totalPoin === 100) {
            poinEl.className = 'text-success h5';
            warningEl.classList.add('d-none');
        } else {
            poinEl.className = 'text-info h5';
            warningEl.classList.add('d-none');
        }
    }

    document.getElementById('btn-sesuaikan-poin').addEventListener('click', function() {
        const bobotInputs = document.querySelectorAll('.soal-bobot');
        const n = bobotInputs.length;
        if (n === 0) return;
        
        const basePoin = Math.floor(100 / n);
        const remainder = 100 % n;
        
        bobotInputs.forEach((input, index) => {
            if (index === n - 1) {
                input.value = basePoin + remainder;
            } else {
                input.value = basePoin;
            }
        });
        
        updateSummary();
        
        const originalText = this.innerHTML;
        this.innerHTML = '<i class="fa fa-check"></i> Berhasil Disesuaikan';
        setTimeout(() => {
            this.innerHTML = originalText;
        }, 2000);
    });

    // Proses Import Soal Excel / CSV ke Form
    document.getElementById('btnProsesImportSoal')?.addEventListener('click', function() {
        const fileInput = document.getElementById('inputFileImportSoal');
        const feedback = document.getElementById('importSoalFeedback');
        if (!fileInput.files || !fileInput.files[0]) {
            feedback.innerHTML = '<span class="text-danger">Silakan pilih file terlebih dahulu.</span>';
            return;
        }

        const formData = new FormData();
        formData.append('file_soal', fileInput.files[0]);
        formData.append('_token', '{{ csrf_token() }}');

        this.disabled = true;
        feedback.innerHTML = '<span class="text-info"><i class="fa fa-spinner fa-spin"></i> Membaca file soal...</span>';

        fetch("{{ route('sba.soal.import_preview') }}", {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            this.disabled = false;
            if (data.status === 'success' && Array.isArray(data.soals)) {
                const items = document.querySelectorAll('.soal-item');
                if (items.length === 1 && !items[0].querySelector('.soal-id').value && items[0].querySelector('.soal-pertanyaan').value.trim() === '') {
                    items[0].remove();
                }

                data.soals.forEach(s => addSoal(null, 'end', s));
                feedback.innerHTML = `<span class="text-success font-weight-bold">${data.message}</span>`;
                fileInput.value = '';
                setTimeout(() => {
                    $('#modalImportSoal').modal('hide');
                    feedback.innerHTML = '';
                }, 800);
            } else {
                feedback.innerHTML = `<span class="text-danger">${data.message || 'Gagal mengimpor file soal.'}</span>`;
            }
        })
        .catch(() => {
            this.disabled = false;
            feedback.innerHTML = '<span class="text-danger">Terjadi kesalahan saat mengunggah file.</span>';
        });
    });

    updateSummary();
});
</script>
@endsection