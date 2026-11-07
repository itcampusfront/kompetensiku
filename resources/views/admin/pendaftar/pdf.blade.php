<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Formulir Pendaftaran - {{ $pendaftar->nama_lengkap }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body { font-size: 13px; color: #000; background: #fff; }
        .header-cetak { border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .table-data td, .table-data th { padding: 4px 8px; }
        .section-header { background: #f0f0f0; padding: 4px 8px; font-weight: bold; border-left: 4px solid #0056b3; margin-top: 15px; margin-bottom: 10px; }
        
        /* CSS Khusus Mode Print / Save to PDF */
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; margin: 0; }
            @page { size: A4; margin: 15mm; }
        }
    </style>
</head>
<body>

<div class="container my-4">
    <!-- Control Bar (Sembunyi saat di-print/save PDF) -->
    <div class="no-print alert alert-info d-flex justify-content-between align-items-center">
        <div>
            <i class="fa fa-info-circle"></i> Dialog cetak akan terbuka otomatis. Pilih Destinasi <strong>"Save as PDF" / "Simpan sebagai PDF"</strong>.
        </div>
        <div>
            <button onclick="window.print()" class="btn btn-primary btn-sm">Cetak / Simpan PDF</button>
            <button onclick="window.close()" class="btn btn-secondary btn-sm">Tutup</button>
        </div>
    </div>

    <!-- Kop / Header -->
    <div class="text-center header-cetak">
        <h3 class="font-weight-bold text-uppercase mb-0">CAMPUS DIGITAL</h3>
        <p class="mb-0">FORMULIR PERMOHONAN SERTIFIKASI KOMPETENSI (FR.APL.01)</p>
    </div>

    <!-- Section 1 -->
    <div class="section-header">1. DATA PENGAJUAN</div>
    <table class="table table-sm table-borderless table-data">
        <tr><td width="30%">Skema Sertifikasi</td><td width="2%">:</td><td><strong>{{ $pendaftar->skema_jadwal->skema_uji->nama_skema ?? '-' }}</strong></td></tr>
        <tr><td>Jadwal Uji / TUK</td><td>:</td><td>{{ $pendaftar->skema_jadwal->nama_jadwal ?? '-' }}</td></tr>
        <tr><td>Sumber / Pemberi Anggaran</td><td>:</td><td>{{ $pendaftar->sumber_anggaran ?? '-' }} ({{ $pendaftar->pemberi_anggaran ?? '-' }})</td></tr>
    </table>

    <!-- Section 2 -->
    <div class="section-header">2. RINCIAN DATA PEMOHON SERTIFIKASI</div>
    <table class="table table-sm table-borderless table-data">
        <tr><td width="30%">NIK</td><td width="2%">:</td><td>{{ $pendaftar->nik }}</td></tr>
        <tr><td>Nama Lengkap</td><td>:</td><td>{{ $pendaftar->nama_lengkap }}</td></tr>
        <tr><td>Jenis Kelamin</td><td>:</td><td>{{ $pendaftar->jenis_kelamin }}</td></tr>
        <tr><td>Tempat, Tanggal Lahir</td><td>:</td><td>{{ $pendaftar->tempat_lahir }}, {{ \Carbon\Carbon::parse($pendaftar->tgl_lahir)->format('d F Y') }}</td></tr>
        <tr><td>Alamat Domisili</td><td>:</td><td>{{ $pendaftar->alamat_domisili ?? '-' }}</td></tr>
        <tr><td>Provinsi / Kota / Kecamatan</td><td>:</td><td>{{ $pendaftar->provinsi ?? '-' }} / {{ $pendaftar->kota ?? '-' }} / {{ $pendaftar->kecamatan ?? '-' }}</td></tr>
        <tr><td>No. Telp (WA) / Email</td><td>:</td><td>{{ $pendaftar->no_telp ?? '-' }} / {{ $pendaftar->email ?? '-' }}</td></tr>
        <tr><td>Pendidikan Terakhir</td><td>:</td><td>{{ $pendaftar->pendidikan_terakhir ?? '-' }}</td></tr>
        <tr><td>Nama Sekolah / Perguruan Tinggi</td><td>:</td><td>{{ $pendaftar->nama_sekolah ?? '-' }}</td></tr>
        <tr><td>Jurusan / Program Studi</td><td>:</td><td>{{ $pendaftar->jurusan ?? '-' }}</td></tr>
    </table>

    <!-- Section 3 -->
    <div class="section-header">3. DATA PEKERJAAN SEKARANG</div>
    <table class="table table-sm table-borderless table-data">
        <tr><td width="30%">Pekerjaan / Jabatan</td><td width="2%">:</td><td>{{ $pendaftar->pekerjaan ?? '-' }} / {{ $pendaftar->jabatan ?? '-' }}</td></tr>
        <tr><td>Nama Perusahaan</td><td>:</td><td>{{ $pendaftar->nama_perusahaan ?? '-' }}</td></tr>
        <tr><td>Alamat Perusahaan</td><td>:</td><td>{{ $pendaftar->alamat_perusahaan ?? '-' }} (Kode Pos: {{ $pendaftar->kodepos ?? '-' }})</td></tr>
        <tr><td>Kontak Perusahaan</td><td>:</td><td>{{ $pendaftar->no_telp_perusahaan ?? '-' }} / {{ $pendaftar->email_perusahaan ?? '-' }}</td></tr>
    </table>

    <!-- Section 4 -->
    <div class="section-header">4. STATUS UNGGAN DOKUMEN PORTOFOLIO</div>
    <table class="table table-sm table-bordered mt-2">
        <thead class="thead-light">
            <tr>
                <th width="40">No</th>
                <th>Jenis Dokumen</th>
                <th width="120" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @php
                $dokumen = [
                    'file_ijazah' => '01. Ijazah / Transkrip',
                    'file_sertifikat_pelatihan' => '02. Sertifikat Pelatihan',
                    'file_surat_pengalaman' => '03. Surat Pengalaman Kerja',
                    'file_pas_foto' => '04. Pas Foto',
                    'file_identitas' => '05. Identitas Pribadi (KTP/Pelajar)',
                    'file_portofolio_upgrading' => '06. Portofolio Upgrading',
                    'file_portofolio_laporan' => '07. Portofolio Laporan',
                    'file_portofolio_pengalaman' => '08. Portofolio Pengalaman',
                ];
                $no = 1;
            @endphp
            @foreach($dokumen as $field => $label)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $label }}</td>
                <td class="text-center">
                    @if($pendaftar->$field)
                        <span class="badge badge-success">Terunggah</span>
                    @else
                        <span class="badge badge-secondary">Tidak Ada</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    // Otomatis buka dialog print saat halaman dimuat
    window.onload = function() {
        window.print();
    }
</script>
</body>
</html>