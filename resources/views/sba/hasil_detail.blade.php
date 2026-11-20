@extends('faturcms::template.admin.main')

@section('title', 'Detail Penilaian Ujian - ' . $hasil->uji->judul)

@section('content')
<style>
    .option-box {
        border: 1.5px solid #e9ecef;
        border-radius: 6px;
        padding: 10px 14px;
        margin-bottom: 8px;
        background-color: #fff;
    }
    .option-correct {
        border-color: #28a745 !important;
        background-color: #f0fdf4 !important;
    }
    .option-wrong {
        border-color: #dc3545 !important;
        background-color: #fff5f5 !important;
    }
    .badge-kunci {
        background-color: #28a745;
        color: #fff;
        font-size: 0.75rem;
        padding: 3px 8px;
        border-radius: 4px;
    }
    .badge-jawaban-siswa {
        background-color: #007bff;
        color: #fff;
        font-size: 0.75rem;
        padding: 3px 8px;
        border-radius: 4px;
    }
    .sticky-summary {
        position: sticky;
        top: 80px;
        z-index: 90;
    }
</style>

<div class="app-title">
    <div>
        <h1><i class="fa fa-user-check"></i> Detail & Lembar Penilaian Asesi</h1>
        <p>Asesmen: <strong>{{ $hasil->uji->judul }}</strong> ({{ strtoupper($hasil->uji->kode_uji) }})</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{ route('sba.index') }}">Daftar Ujian SBA</a></li>
        <li class="breadcrumb-item"><a href="{{ route('sba.hasil.index', $hasil->uji_id) }}">Hasil Asesmen</a></li>
        <li class="breadcrumb-item"><a href="#">Detail</a></li>
    </ul>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Sukses!</strong> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Gagal!</strong> {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

{{-- IDENTITAS & RINGKASAN HASIL --}}
<div class="tile mb-4">
    <div class="tile-title-w-btn mb-3">
        <h3 class="title mb-0">Informasi Peserta & Skor</h3>
        <div class="btn-group">
            <a href="{{ route('sba.hasil.detail.pdf', $hasil->id) }}" class="btn btn-danger btn-sm" target="_blank">
                <i class="fa fa-file-pdf-o"></i> Cetak / Export PDF
            </a>
            <a href="{{ route('sba.hasil.index', $hasil->uji_id) }}" class="btn btn-secondary btn-sm">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row align-items-center border-top pt-3">
        <div class="col-md-3 border-right mb-2 mb-md-0">
            <small class="text-muted d-block">Nama Peserta / Asesi:</small>
            <h5 class="mb-0 text-dark font-weight-bold">
                {{ $hasil->asesi ? ($hasil->asesi->nama_user ?? $hasil->asesi->name) : ($hasil->nama_peserta_publik ?? 'Guest') }}
            </h5>
            <small class="text-muted">ID: {{ $hasil->asesi_id ? 'USER #'.$hasil->asesi_id : 'Peserta Publik' }}</small>
        </div>

        <div class="col-md-3 border-right mb-2 mb-md-0">
            <small class="text-muted d-block">Waktu & Durasi Pengerjaan:</small>
            <strong class="text-dark d-block">
                {{ $hasil->waktu_mulai ? $hasil->waktu_mulai->format('d/m/Y H:i') : '-' }}
                @if($hasil->waktu_selesai)
                    - {{ $hasil->waktu_selesai->format('H:i') }}
                @endif
            </strong>
            <small class="text-info">
                <i class="fa fa-clock-o"></i> Durasi: <strong>{{ $hasil->durasi_formatted }}</strong>
            </small>
        </div>

        <div class="col-md-3 border-right text-center mb-2 mb-md-0">
            <small class="text-muted d-block mb-1">Status & Percobaan:</small>
            @if($hasil->status_pengerjaan === 'final')
                <span class="badge badge-primary">Final (Dinilai)</span>
            @elseif($hasil->status_pengerjaan === 'selesai')
                <span class="badge badge-success">Selesai</span>
            @elseif($hasil->status_pengerjaan === 'gagal_pelanggaran')
                <span class="badge badge-danger">Diskualifikasi</span>
            @else
                <span class="badge badge-info">Berlangsung</span>
            @endif
            <span class="badge badge-light border ml-1">Ke-{{ $hasil->percobaan_ke }}</span>
            <br>
            <span class="badge {{ $hasil->jumlah_pelanggaran > 0 ? 'badge-danger' : 'badge-success' }} mt-1">
                {{ $hasil->jumlah_pelanggaran }} Pelanggaran
            </span>
        </div>

        <div class="col-md-3 text-center">
            <small class="text-muted d-block">Total Skor Akhir:</small>
            <h2 class="mb-0 text-primary font-weight-bold" id="display-total-skor">
                {{ number_format($hasil->total_skor, 0) }} <small class="text-muted" style="font-size: 14px;">Poin</small>
            </h2>
        </div>
    </div>

    @if(!empty($hasil->catatan_pelanggaran))
        <div class="alert alert-light border mt-3 mb-0 py-2 px-3 small text-muted">
            <strong>Log Pelanggaran / Aktivitas:</strong> {{ ltrim($hasil->catatan_pelanggaran, ' |') }}
        </div>
    @endif
</div>

{{-- FORM PENILAIAN ESAI --}}
<form action="{{ route('sba.hasil.simpan_nilai', $hasil->id) }}" method="POST" id="formPenilaian">
    @csrf
    
    <div class="row">
        {{-- KOLOM DAFTAR SOAL --}}
        <div class="col-lg-9">
            @foreach($hasil->uji->soals as $index => $soal)
                @php
                    $jawabanSiswa = $mapJawaban->get($soal->id);
                    $jawabanRaw = $jawabanSiswa ? $jawabanSiswa->jawaban : null;
                    $skorDidapat = $jawabanSiswa ? $jawabanSiswa->skor_didapat : 0;
                    $kunciArray = $soal->kunci_jawaban ?? [];
                @endphp

                <div class="card mb-3 border shadow-sm">
                    <div class="card-header bg-light py-2 px-3 d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge badge-dark mr-1">Soal #{{ $index + 1 }}</span>
                            <span class="badge badge-info text-uppercase">{{ str_replace('_', ' ', $soal->tipe) }}</span>
                        </div>
                        <div>
                            <span class="text-muted small mr-2">Bobot Poin: <strong>{{ $soal->bobot_nilai }}</strong></span>
                            
                            @if($soal->tipe === 'esai')
                                <span class="badge badge-warning text-dark">Penilaian Uraian ({{ $skorDidapat }} / {{ $soal->bobot_nilai }})</span>
                            @else
                                @if($skorDidapat > 0)
                                    <span class="badge badge-success"><i class="fa fa-check"></i> Benar (+{{ $skorDidapat }})</span>
                                @else
                                    <span class="badge badge-danger"><i class="fa fa-times"></i> Salah (0)</span>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="card-body p-3">
                        @if(!empty($soal->media))
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $soal->media) }}" alt="Media Soal" class="img-thumbnail" style="max-height: 220px;">
                            </div>
                        @endif

                        {{-- PERTANYAAN --}}
                        <p class="text-dark font-weight-bold mb-3">{!! nl2br(e($soal->pertanyaan)) !!}</p>

                        {{-- TIPE PG & PG KOMPLEKS (TEKS &/ATAU GAMBAR OPSI) --}}
                        @if(in_array($soal->tipe, ['pg', 'pg_kompleks']))
                            @php
                                $opsiTeksList = is_array($soal->opsi_jawaban) ? $soal->opsi_jawaban : [];
                                $opsiMediaList = is_array($soal->opsi_media) ? $soal->opsi_media : [];
                                $jumlahSlotOpsi = max(count($opsiTeksList), count($opsiMediaList));
                            @endphp
                            <div class="options-wrapper">
                                @for($optIdx = 0; $optIdx < $jumlahSlotOpsi; $optIdx++)
                                    @php
                                        $opsiTeks = trim((string) ($opsiTeksList[$optIdx] ?? ''));
                                        $opsiMediaPath = $opsiMediaList[$optIdx] ?? null;
                                    @endphp
                                    @if($opsiTeks !== '' || !empty($opsiMediaPath))
                                        @php
                                            $isKunci = in_array((string)$optIdx, array_map('strval', $kunciArray));
                                            
                                            $isChosen = false;
                                            if ($soal->tipe === 'pg_kompleks') {
                                                $siswaArr = json_decode($jawabanRaw, true) ?? [];
                                                $isChosen = in_array((string)$optIdx, array_map('strval', $siswaArr));
                                            } else {
                                                $isChosen = ((string)$optIdx === (string)$jawabanRaw && $jawabanRaw !== null);
                                            }

                                            $boxClass = 'option-box';
                                            if ($isKunci) $boxClass .= ' option-correct';
                                            elseif ($isChosen && !$isKunci) $boxClass .= ' option-wrong';
                                        @endphp

                                        <div class="{{ $boxClass }} d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                                            <div class="text-dark small d-flex align-items-start flex-grow-1 mb-2 mb-md-0">
                                                <strong class="mr-2">{{ chr(65 + $optIdx) }}.</strong>
                                                <div>
                                                    @if($opsiTeks !== '')
                                                        <div>{!! nl2br(e($opsiTeks)) !!}</div>
                                                    @endif
                                                    @if(!empty($opsiMediaPath))
                                                        <div class="{{ $opsiTeks !== '' ? 'mt-2' : '' }}">
                                                            <img src="{{ asset('storage/' . $opsiMediaPath) }}" alt="Gambar Opsi {{ chr(65 + $optIdx) }}" class="img-thumbnail" style="max-height: 130px;">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="flex-shrink-0">
                                                @if($isKunci)
                                                    <span class="badge-kunci mr-1"><i class="fa fa-key"></i> Kunci</span>
                                                @endif
                                                @if($isChosen)
                                                    <span class="badge-jawaban-siswa"><i class="fa fa-user-check"></i> Pilihan Asesi</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                @endfor
                            </div>

                        {{-- TIPE ESAI / URAIAN (PANEL KOREKSI PENGUJI) --}}
                        @elseif($soal->tipe === 'esai')
                            <div class="bg-light p-3 rounded border mb-3">
                                <small class="text-muted font-weight-bold d-block mb-1">
                                    <i class="fa fa-pencil text-primary"></i> Jawaban Uraian Asesi:
                                </small>
                                <p class="text-dark mb-0" style="white-space: pre-line;">{{ $jawabanRaw ? $jawabanRaw : '- Tidak Menjawab -' }}</p>
                            </div>

                            {{-- TOOLBAR INPUT SKOR ESAI --}}
                            <div class="d-flex flex-wrap align-items-center bg-white p-2 border rounded">
                                <span class="small font-weight-bold text-dark mr-2">Beri Skor Esai:</span>
                                
                                <button type="button" class="btn btn-sm btn-outline-success mr-1 btn-quick-grade" 
                                        data-soal-id="{{ $soal->id }}" data-skor="{{ $soal->bobot_nilai }}">
                                    <i class="fa fa-check"></i> Benar Full ({{ $soal->bobot_nilai }})
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger mr-2 btn-quick-grade" 
                                        data-soal-id="{{ $soal->id }}" data-skor="0">
                                    <i class="fa fa-times"></i> Salah (0)
                                </button>

                                <div class="input-group input-group-sm ml-auto" style="width: 150px;">
                                    <input type="number" step="0.5" min="0" max="{{ $soal->bobot_nilai }}" 
                                           name="skor_esai[{{ $soal->id }}]" 
                                           id="input_skor_{{ $soal->id }}"
                                           class="form-control text-center font-weight-bold input-skor-esai" 
                                           value="{{ $skorDidapat }}" 
                                           data-bobot-max="{{ $soal->bobot_nilai }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">/ {{ $soal->bobot_nilai }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        {{-- SIDEBAR AKSI & AUTO SCORING --}}
        <div class="col-lg-3">
            <div class="tile sticky-summary">
                <h5 class="tile-title" style="font-size: 16px;"><i class="fa fa-sliders text-primary"></i> Panel Penilaian & Aksi</h5>
                
                <button type="button" id="btnAutoScoring" class="btn btn-outline-info btn-sm btn-block mb-2">
                    <i class="fa fa-magic"></i> Isi Maksimal Semua Esai
                </button>
                <small class="text-muted d-block mb-3">
                    *Mengisi skor maksimal sesuai bobot tiap soal esai.
                </small>

                <button type="submit" class="btn btn-success btn-sm btn-block py-2 font-weight-bold mb-3">
                    <i class="fa fa-save"></i> Simpan & Finalisasi Nilai
                </button>

                <hr>

                <button type="button" class="btn btn-outline-primary btn-sm btn-block mb-2" onclick="submitAksiDetail('{{ route('sba.hasil.refresh_nilai', $hasil->id) }}', 'Hitung ulang skor PG/PG Kompleks peserta ini berdasarkan kunci jawaban terbaru?')">
                    <i class="fa fa-refresh"></i> Hitung Ulang Nilai PG
                </button>

                @if($hasil->status_pengerjaan === 'gagal_pelanggaran')
                    <button type="button" class="btn btn-warning btn-sm btn-block" onclick="submitAksiDetail('{{ route('sba.hasil.unlock', $hasil->id) }}', 'Buka kunci (Unlock) sesi peserta ini agar dapat melanjutkan ujian?')">
                        <i class="fa fa-unlock"></i> Buka Kunci Sesi (Unlock)
                    </button>
                @elseif($hasil->status_pengerjaan === 'berlangsung')
                    <button type="button" class="btn btn-danger btn-sm btn-block" onclick="submitAksiDetail('{{ route('sba.hasil.finalisasi', $hasil->id) }}', 'Finalisasi paksa sesi peserta ini sekarang?')">
                        <i class="fa fa-check-square-o"></i> Finalisasi Paksa Sesi
                    </button>
                @endif
            </div>
        </div>
    </div>
</form>

<form id="formAksiDetail" action="" method="POST" class="d-none">
    @csrf
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-quick-grade').forEach(btn => {
        btn.addEventListener('click', function() {
            const soalId = this.getAttribute('data-soal-id');
            const skor = this.getAttribute('data-skor');
            const inputEl = document.getElementById(`input_skor_${soalId}`);
            if (inputEl) {
                inputEl.value = skor;
            }
        });
    });

    document.getElementById('btnAutoScoring')?.addEventListener('click', function() {
        if (!confirm('Isi skor maksimal sesuai bobot pada seluruh soal esai?')) return;

        document.querySelectorAll('.input-skor-esai').forEach(input => {
            const max = parseFloat(input.getAttribute('data-bobot-max')) || 0;
            input.value = max;
        });
    });
});

function submitAksiDetail(url, pesan) {
    if (confirm(pesan)) {
        const form = document.getElementById('formAksiDetail');
        form.action = url;
        form.submit();
    }
}
</script>
@endsection