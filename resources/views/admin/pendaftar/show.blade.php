@extends('faturcms::template.admin.main')

@section('title', 'Detail Pendaftar')

@section('content')
<div class="app-title">
    <div>
        <h1><i class="fa fa-user"></i> Detail Pendaftar</h1>
    </div>
    <div>
        <a href="{{ route('admin.pendaftar.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Kembali</a>
        <a href="{{ route('admin.pendaftar.cetak-pdf', $pendaftar->id) }}" target="_blank" class="btn btn-info"><i class="fa fa-print"></i> Cetak PDF</a>
        <a href="{{ route('admin.pendaftar.export-zip', $pendaftar->id) }}" class="btn btn-success"><i class="fa fa-file-archive-o"></i> Download Lampiran (ZIP)</a>
        <form action="{{ route('admin.pendaftar.destroy', $pendaftar->id) }}" method="POST" class="d-inline" onsubmit="return confirm('PERHATIAN: Hapus data ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</button>
        </form>
    </div>
</div>

<!-- Card Status & Control Verifikasi Admin (BARU) -->
<div class="row">
    <div class="col-md-12">
        <div class="tile py-3 mb-3 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">Status Verifikasi Pendaftaran: 
                    @if($pendaftar->status === 'Diterima')
                        <span class="badge badge-success p-2"><i class="fa fa-check-circle"></i> DITERIMA</span>
                    @elseif($pendaftar->status === 'Ditolak')
                        <span class="badge badge-danger p-2"><i class="fa fa-times-circle"></i> DITOLAK</span>
                    @else
                        <span class="badge badge-warning p-2 text-dark"><i class="fa fa-clock-o"></i> PENDING (Menunggu Verifikasi)</span>
                    @endif
                </h5>
            </div>
            <div class="d-flex align-items-center">
                <span class="mr-2 font-weight-bold">Ubah Status:</span>
                
                <!-- Tombol Terima -->
                <form action="{{ route('admin.pendaftar.update-status', $pendaftar->id) }}" method="POST" class="d-inline mr-1">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="Diterima">
                    <button type="submit" class="btn btn-success {{ $pendaftar->status === 'Diterima' ? 'disabled' : '' }}" {{ $pendaftar->status === 'Diterima' ? 'disabled' : '' }}>
                        <i class="fa fa-check"></i> Terima
                    </button>
                </form>
                
                <!-- Tombol Tolak -->
                <form action="{{ route('admin.pendaftar.update-status', $pendaftar->id) }}" method="POST" class="d-inline mr-1">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="Ditolak">
                    <button type="submit" class="btn btn-danger {{ $pendaftar->status === 'Ditolak' ? 'disabled' : '' }}" {{ $pendaftar->status === 'Ditolak' ? 'disabled' : '' }}>
                        <i class="fa fa-times"></i> Tolak
                    </button>
                </form>
                
                <!-- Tombol Reset Ke Pending -->
                @if($pendaftar->status !== null)
                <form action="{{ route('admin.pendaftar.update-status', $pendaftar->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="">
                    <button type="submit" class="btn btn-outline-secondary" title="Reset ke Status Pending">
                        <i class="fa fa-undo"></i> Reset
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="row">
    <!-- Kolom Kiri: Biodata Peserta -->
    <div class="col-md-6">
        <div class="tile">
            <h3 class="tile-title">Biodata Peserta</h3>
            <table class="table table-striped table-sm">
                <tbody>
                    <tr><th width="35%">Skema Uji</th><td>{{ $pendaftar->skema_jadwal->skema_uji->nama_skema ?? '-' }}</td></tr>
                    <tr><th>Jadwal Uji</th><td>{{ $pendaftar->skema_jadwal->nama_jadwal ?? '-' }}</td></tr>
                    <tr><th>Sumber Anggaran</th><td>{{ $pendaftar->sumber_anggaran ?? '-' }} ({{ $pendaftar->pemberi_anggaran ?? '-' }})</td></tr>
                    <tr><th>NIK</th><td>{{ $pendaftar->nik }}</td></tr>
                    <tr><th>Nama Lengkap</th><td>{{ $pendaftar->nama_lengkap }}</td></tr>
                    <tr><th>Jenis Kelamin</th><td>{{ $pendaftar->jenis_kelamin }}</td></tr>
                    <tr><th>Tempat, Tgl Lahir</th><td>{{ $pendaftar->tempat_lahir }}, {{ \Carbon\Carbon::parse($pendaftar->tgl_lahir)->format('d M Y') }}</td></tr>
                    <tr><th>No. Telepon / WA</th><td>{{ $pendaftar->no_telp ?? '-' }}</td></tr>
                    <tr><th>Email</th><td>{{ $pendaftar->email ?? '-' }}</td></tr>
                    <tr><th>Alamat Domisili</th><td>{{ $pendaftar->alamat_domisili ?? '-' }}</td></tr>
                    <tr><th>Prov/Kota/Kec</th><td>{{ $pendaftar->provinsi ?? '-' }} / {{ $pendaftar->kota ?? '-' }} / {{ $pendaftar->kecamatan ?? '-' }}</td></tr>
                </tbody>
            </table>
        </div>

        <div class="tile">
            <h3 class="tile-title">Data Pendidikan & Pekerjaan</h3>
            <table class="table table-striped table-sm">
                <tbody>
                    <tr><th width="35%">Pend. Terakhir</th><td>{{ $pendaftar->pendidikan_terakhir ?? '-' }}</td></tr>
                    <tr><th>Nama Sekolah/PT</th><td>{{ $pendaftar->nama_sekolah ?? '-' }}</td></tr>
                    <tr><th>Jurusan/Prodi</th><td>{{ $pendaftar->jurusan ?? '-' }}</td></tr>
                    <tr><th>Pekerjaan</th><td>{{ $pendaftar->pekerjaan ?? '-' }}</td></tr>
                    <tr><th>Nama Perusahaan</th><td>{{ $pendaftar->nama_perusahaan ?? '-' }}</td></tr>
                    <tr><th>Jabatan</th><td>{{ $pendaftar->jabatan ?? '-' }}</td></tr>
                    <tr><th>Alamat Perusahaan</th><td>{{ $pendaftar->alamat_perusahaan ?? '-' }} (Kode Pos: {{ $pendaftar->kodepos ?? '-' }})</td></tr>
                    <tr><th>Kontak Perusahaan</th><td>{{ $pendaftar->no_telp_perusahaan ?? '-' }} / {{ $pendaftar->email_perusahaan ?? '-' }}</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Kolom Kanan: List Dokumen Pendukung & Preview -->
    <div class="col-md-6">
        <div class="tile">
            <h3 class="tile-title">Dokumen Pendukung & Lampiran</h3>
            <p class="text-muted">Klik thumbnail/preview gambar untuk memperbesar mode Popup, atau klik tombol PDF untuk membuka di Tab Baru.</p>
            
            <div class="list-group">
                @php
                    $dokumen = [
                        '01' => ['label' => 'Ijazah / Transkrip', 'field' => 'file_ijazah'],
                        '02' => ['label' => 'Sertifikat Pelatihan', 'field' => 'file_sertifikat_pelatihan'],
                        '03' => ['label' => 'Surat Pengalaman Kerja', 'field' => 'file_surat_pengalaman'],
                        '04' => ['label' => 'Pas Foto', 'field' => 'file_pas_foto'],
                        '05' => ['label' => 'Identitas Pribadi (KTP/Pelajar)', 'field' => 'file_identitas'],
                        '06' => ['label' => 'Portofolio Upgrading', 'field' => 'file_portofolio_upgrading'],
                        '07' => ['label' => 'Portofolio Laporan', 'field' => 'file_portofolio_laporan'],
                        '08' => ['label' => 'Portofolio Pengalaman', 'field' => 'file_portofolio_pengalaman'],
                    ];
                @endphp

                @foreach($dokumen as $key => $doc)
                    @php
                        $filePath = $pendaftar->{$doc['field']};
                        $fileUrl = $filePath ? asset('storage/' . $filePath) : null;
                        $ext = $filePath ? strtolower(pathinfo($filePath, PATHINFO_EXTENSION)) : '';
                        $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                        $isPdf = ($ext === 'pdf');
                    @endphp

                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <!-- Icon / Thumbnail Preview -->
                            @if($fileUrl && $isImage)
                                <img src="{{ $fileUrl }}" 
                                     alt="Preview" 
                                     class="img-thumbnail mr-3 img-preview-trigger" 
                                     style="width: 50px; height: 50px; object-fit: cover; cursor: pointer;"
                                     data-src="{{ $fileUrl }}"
                                     data-title="{{ $doc['label'] }} - {{ $pendaftar->nama_lengkap }}">
                            @elseif($fileUrl && $isPdf)
                                <a href="{{ $fileUrl }}" target="_blank" title="Buka PDF di Tab Baru">
                                    <div class="bg-light text-center mr-3 d-flex align-items-center justify-content-center border rounded" style="width: 50px; height: 50px; cursor: pointer;">
                                        <i class="fa fa-file-pdf-o text-danger" style="font-size: 24px;"></i>
                                    </div>
                                </a>
                            @else
                                <div class="bg-light text-center mr-3 d-flex align-items-center justify-content-center border rounded" style="width: 50px; height: 50px;">
                                    <i class="fa fa-times text-muted" style="font-size: 20px;"></i>
                                </div>
                            @endif

                            <div>
                                <strong>{{ $key }} - {{ $doc['label'] }}</strong>
                                @if($doc['field'] == 'file_pas_foto' || $doc['field'] == 'file_identitas')
                                    <span class="badge badge-danger ml-1">Wajib</span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Action Control Unduh / View -->
                        @if($fileUrl)
                            <div>
                                @if($isImage)
                                    <button type="button" 
                                            class="btn btn-sm btn-info img-preview-trigger" 
                                            data-src="{{ $fileUrl }}" 
                                            data-title="{{ $doc['label'] }} - {{ $pendaftar->nama_lengkap }}" 
                                            title="Lihat Gambar">
                                        <i class="fa fa-search-plus"></i> Preview
                                    </button>
                                @elseif($isPdf)
                                    <a href="{{ $fileUrl }}" target="_blank" class="btn btn-sm btn-warning" title="Buka PDF di Tab Baru">
                                        <i class="fa fa-external-link"></i> Buka PDF
                                    </a>
                                @endif
                                <a href="{{ $fileUrl }}" target="_blank" class="btn btn-sm btn-primary" title="Unduh File">
                                    <i class="fa fa-download"></i> Unduh
                                </a>
                            </div>
                        @else
                            <span class="text-muted italic"><i class="fa fa-times"></i> Belum Diunggah</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Modal Popup Image Preview -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalTitle">Preview Gambar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center bg-dark p-3" style="min-height: 200px;">
                <!-- Container Loading / Spinner -->
                <div id="imageLoadingSpinner" class="py-5 text-white">
                    <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                    <p class="mt-2">Memuat gambar...</p>
                </div>
                <!-- Target Gambar -->
                <img src="" id="modalImageTarget" class="img-fluid d-none" style="max-height: 75vh; margin: 0 auto;" alt="Gambar Besar">
            </div>
            <div class="modal-footer">
                <a href="#" id="modalDownloadBtn" target="_blank" class="btn btn-primary"><i class="fa fa-external-link"></i> Buka Ukuran Asli</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js-extra')
<script>
    $(document).ready(function() {
        // Handle trigger click
        $('.img-preview-trigger').on('click', function(e) {
            e.preventDefault();
            
            let imageSrc = $(this).attr('data-src');
            let imageTitle = $(this).attr('data-title');

            // Reset modal state
            $('#imageModalTitle').text(imageTitle);
            $('#modalDownloadBtn').attr('href', imageSrc);
            
            let $imgTarget = $('#modalImageTarget');
            let $spinner = $('#imageLoadingSpinner');

            // Sembunyikan gambar lama & tampilkan loading spinner
            $imgTarget.addClass('d-none').attr('src', '');
            $spinner.removeClass('d-none');

            // Tampilkan modal terlebih dahulu
            $('#imagePreviewModal').modal('show');

            // Bikin objek Image baru di memory untuk force pre-loading
            let tempImg = new Image();
            tempImg.onload = function() {
                // Ketika gambar selesai di-load browser, masukkan ke modal
                $imgTarget.attr('src', imageSrc).removeClass('d-none');
                $spinner.addClass('d-none');
            };
            tempImg.onerror = function() {
                $spinner.html('<p class="text-danger mb-0"><i class="fa fa-exclamation-triangle"></i> Gagal memuat gambar.</p>');
            };
            
            // Bypass browser cache dengan penambahan timestamp unik jika diperlukan
            tempImg.src = imageSrc;
        });

        // Cleanup total saat modal tertutup
        $('#imagePreviewModal').on('hidden.bs.modal', function () {
            $('#modalImageTarget').addClass('d-none').attr('src', '');
            $('#imageLoadingSpinner').removeClass('d-none').html('<i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i><p class="mt-2">Memuat gambar...</p>');
        });
    });
</script>
@endsection