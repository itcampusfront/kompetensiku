<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran Uji Kompetensi</title>
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Flatpickr CSS untuk kalender -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .wizard-container {
            max-width: 900px;
            margin: 40px auto;
        }
        /* Navigasi Tab Wizard Atas */
        .wizard-steps {
            display: flex;
            background: #fff;
            border-radius: 8px 8px 0 0;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .wizard-step {
            flex: 1;
            padding: 15px 10px;
            text-align: center;
            background: #0056b3;
            color: #fff;
            font-weight: 600;
            font-size: 14px;
            border-right: 1px solid rgba(255,255,255,0.1);
            transition: all 0.3s ease;
        }
        .wizard-step:last-child {
            border-right: none;
        }
        .wizard-step.active {
            background: #004085;
            box-shadow: inset 0 -4px 0 #ffc107;
        }
        .wizard-step.disabled {
            background: #6c757d;
            opacity: 0.7;
        }
        .wizard-card {
            background: #fff;
            padding: 30px;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .step-content {
            display: none;
        }
        .step-content.active {
            display: block;
        }
        .required-label::after {
            content: " *";
            color: red;
        }
    </style>
</head>
<body>

<div class="container wizard-container">
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check-circle mr-1"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Alert Tampilan Error Server / Validasi -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
            <h5 class="font-weight-bold mb-2"><i class="fa fa-exclamation-triangle"></i> Gagal Mengirim Pendaftaran!</h5>
            <p class="mb-1">Silakan periksa dan perbaiki isian form berikut:</p>
            <ul class="mb-0 pl-3">
                @foreach ($errors->all() as $error)
                    <li><strong>{{ $error }}</strong></li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Wizard Nav Tabs -->
    <div class="wizard-steps">
        <div class="wizard-step active" id="tab-nav-1">
            <i class="fa fa-folder-open d-block mb-1" style="font-size: 1.2rem;"></i> Data Pengajuan
        </div>
        <div class="wizard-step disabled" id="tab-nav-2">
            <i class="fa fa-user d-block mb-1" style="font-size: 1.2rem;"></i> Profil Peserta
        </div>
        <div class="wizard-step disabled" id="tab-nav-3">
            <i class="fa fa-upload d-block mb-1" style="font-size: 1.2rem;"></i> Dokumen Portofolio
        </div>
        <div class="wizard-step disabled" id="tab-nav-4">
            <i class="fa fa-check-circle d-block mb-1" style="font-size: 1.2rem;"></i> Asesmen Mandiri
        </div>
    </div>

    <!-- Wizard Form Body -->
    <div class="wizard-card">
        <form action="{{ route('front.register.store') }}" method="POST" enctype="multipart/form-data" id="form-pendaftaran">
            @csrf

            <!-- ================= PAGE 1: DATA PENGAJUAN ================= -->
            <div class="step-content active" id="step-1">
                <h4 class="font-weight-bold text-dark">DATA PENGAJUAN</h4>
                <p class="text-muted">Pada bagian ini, Pilih Skema Sertifikasi yang akan di ambil, Pilih jadwal sesuai Tempat Uji Kompetensi.</p>
                <hr>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label required-label">Skema</label>
                    <div class="col-md-9">
                        <select name="skema_uji_id_dummy" id="select-skema" class="form-control" required>
                            <option value="" disabled selected>Pilih Skema</option>
                            @foreach($skemaUjis as $skema)
                                <option value="{{ $skema->id }}">{{ $skema->nama_skema }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label required-label">Jadwal Uji Kompetensi</label>
                    <div class="col-md-9">
                        <select name="skema_jadwal_id" id="select-jadwal" class="form-control" required>
                            <option value="" disabled selected>-- Pilih Jadwal & TUK --</option>
                            @foreach($jadwals as $jadwal)
                                <option value="{{ $jadwal->id }}" data-skema="{{ $jadwal->skema_uji_id }}">
                                    {{ $jadwal->nama_jadwal }} ({{ $jadwal->skema_uji->nama_skema ?? '' }})
                                </option>
                            @endforeach
                        </select>
                        <small class="text-success font-weight-bold">Perhatikan nama jadwal, Pilih jadwal berdasarkan Skema dan Tempat Uji Kompetensi</small>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label required-label">Sumber Anggaran</label>
                    <div class="col-md-9">
                        <input type="text" name="sumber_anggaran" class="form-control" value="Lainnya" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label required-label">Pemberi Anggaran</label>
                    <div class="col-md-9">
                        <input type="text" name="pemberi_anggaran" class="form-control" value="Lainnya" required>
                    </div>
                </div>

                <div class="text-right mt-4">
                    <button type="button" class="btn btn-success px-4" onclick="nextStep(2)">Selanjutnya <i class="fa fa-arrow-right"></i></button>
                </div>
            </div>

            <!-- ================= PAGE 2: PROFIL PESERTA ================= -->
            <div class="step-content" id="step-2">
                <h4 class="font-weight-bold text-dark">FR.APL.01 FORMULIR PERMOHONAN SERTIFIKASI KOMPETENSI</h4>
                <p class="text-muted">Bagian 1: Rincian Data Pemohon Sertifikasi<br>Pada bagian ini, cantumkan data pribadi, data pendidikan formal anda pada saat ini.</p>
                <hr>
                <h5 class="text-primary font-weight-bold mb-3">a. Data Pribadi</h5>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label required-label">NIK</label>
                    <div class="col-md-9">
                        <input type="text" name="nik" class="form-control" placeholder="Masukkan Nomor Induk Kependudukan" value="{{ old('nik') }}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label required-label">Nama Lengkap</label>
                    <div class="col-md-9">
                        <input type="text" name="nama_lengkap" class="form-control" placeholder="Masukkan Nama Lengkap" value="{{ old('nama_lengkap') }}" required>
                        <small class="text-success">Nama yang diinput akan tertera di sertifikat (Jika Kompeten)</small>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label required-label">Jenis Kelamin</label>
                    <div class="col-md-9 d-flex align-items-center">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="jk_laki" name="jenis_kelamin" value="Laki-Laki" class="custom-control-input" {{ old('jenis_kelamin') == 'Laki-Laki' ? 'checked' : '' }} required>
                            <label class="custom-control-label" for="jk_laki">Laki-Laki</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="jk_perempuan" name="jenis_kelamin" value="Perempuan" class="custom-control-input" {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }} required>
                            <label class="custom-control-label" for="jk_perempuan">Perempuan</label>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label required-label">Tempat & Tanggal Lahir</label>
                    <div class="col-md-6">
                        <input type="text" name="tempat_lahir" class="form-control" placeholder="Masukkan Tempat Lahir" value="{{ old('tempat_lahir') }}" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="tgl_lahir" class="form-control datepicker" placeholder="YYYY-MM-DD" value="{{ old('tgl_lahir') }}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label required-label">Alamat Domisili / Sesuai KTP</label>
                    <div class="col-md-9">
                        <textarea name="alamat_domisili" class="form-control" rows="2" placeholder="Alamat Lengkap Domisili atau Sesuai dengan KTP" required>{{ old('alamat_domisili') }}</textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Provinsi / Kota / Kecamatan</label>
                    <div class="col-md-3">
                        <input type="text" name="provinsi" class="form-control" placeholder="Provinsi" value="{{ old('provinsi') }}">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="kota" class="form-control" placeholder="Kota / Kabupaten" value="{{ old('kota') }}">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="kecamatan" class="form-control" placeholder="Kecamatan" value="{{ old('kecamatan') }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label required-label">No. Telp / Email Aktif</label>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-6 mb-2 mb-md-0">
                                <input type="text" name="no_telp" class="form-control" placeholder="Masukkan No WhatsApp Aktif" value="{{ old('no_telp') }}" required>
                            </div>
                            <div class="col-md-6">
                                <input type="email" name="email" class="form-control" placeholder="Masukkan Email" value="{{ old('email') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label required-label">Pendidikan Terakhir</label>
                    <div class="col-md-9">
                        <select name="pendidikan_terakhir" class="form-control" required>
                            <option value="" disabled selected>-- Pilih Pendidikan --</option>
                            <option value="SMA/SMK Sederajat" {{ old('pendidikan_terakhir') == 'SMA/SMK Sederajat' ? 'selected' : '' }}>SMA / SMK Sederajat</option>
                            <option value="D3" {{ old('pendidikan_terakhir') == 'D3' ? 'selected' : '' }}>D3</option>
                            <option value="D4/S1" {{ old('pendidikan_terakhir') == 'D4/S1' ? 'selected' : '' }}>D4 / S1</option>
                            <option value="S2" {{ old('pendidikan_terakhir') == 'S2' ? 'selected' : '' }}>S2</option>
                            <option value="S3" {{ old('pendidikan_terakhir') == 'S3' ? 'selected' : '' }}>S3</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label required-label">Nama Sekolah / Perguruan Tinggi</label>
                    <div class="col-md-9">
                        <input type="text" name="nama_sekolah" class="form-control" placeholder="Masukkan Nama Sekolah atau Perguruan Tinggi" value="{{ old('nama_sekolah') }}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label required-label">Jurusan / Program Studi</label>
                    <div class="col-md-9">
                        <input type="text" name="jurusan" class="form-control" placeholder="Masukkan Nama Jurusan atau Program Studi" value="{{ old('jurusan') }}" required>
                    </div>
                </div>

                <hr class="my-4">
                <h5 class="text-primary font-weight-bold mb-3">b. Data Pekerjaan Sekarang</h5>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Pekerjaan</label>
                    <div class="col-md-9">
                        <input type="text" name="pekerjaan" class="form-control" placeholder="Pekerjaan / Profesi Saat Ini" value="{{ old('pekerjaan') }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Nama Perusahaan</label>
                    <div class="col-md-9">
                        <input type="text" name="nama_perusahaan" class="form-control" placeholder="Organisasi / Tempat Bekerja / Institusi terkait / Freelance" value="{{ old('nama_perusahaan') }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Jabatan</label>
                    <div class="col-md-9">
                        <input type="text" name="jabatan" class="form-control" placeholder="Jabatan di Perusahaan" value="{{ old('jabatan') }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Alamat Lembaga / Perusahaan</label>
                    <div class="col-md-6">
                        <textarea name="alamat_perusahaan" class="form-control" rows="2" placeholder="Alamat Perusahaan">{{ old('alamat_perusahaan') }}</textarea>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="kodepos" class="form-control" placeholder="Kode Pos" value="{{ old('kodepos') }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Kontak Perusahaan</label>
                    <div class="col-md-6">
                        <input type="text" name="no_telp_perusahaan" class="form-control" placeholder="No Telp Perusahaan" value="{{ old('no_telp_perusahaan') }}">
                    </div>
                    <div class="col-md-3">
                        <input type="email" name="email_perusahaan" class="form-control" placeholder="Email Perusahaan" value="{{ old('email_perusahaan') }}">
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-secondary px-4" onclick="prevStep(1)"><i class="fa fa-arrow-left"></i> Kembali</button>
                    <button type="button" class="btn btn-success px-4" onclick="nextStep(3)">Selanjutnya <i class="fa fa-arrow-right"></i></button>
                </div>
            </div>

            <!-- ================= PAGE 3: DOKUMEN PORTOFOLIO ================= -->
            <div class="step-content" id="step-3">
                <h4 class="font-weight-bold text-dark">DOKUMEN PERSYARATAN & PORTOFOLIO</h4>
                <div class="alert alert-info py-2">
                    <small>
                        <i class="fa fa-info-circle mr-1"></i>
                        1. Upload dapat berupa file gambar (JPG/PNG) atau PDF.<br>
                        2. <strong>Maksimal Ukuran File adalah 2 MB</strong> per dokumen.
                    </small>
                </div>
                <hr>

                <h5 class="text-primary font-weight-bold">PERSYARATAN DASAR</h5>
                <table class="table table-bordered bg-white">
                    <thead class="thead-light">
                        <tr>
                            <th width="50">No</th>
                            <th>Persyaratan</th>
                            <th width="35%">Upload Dokumen</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Foto Copy Transkrip nilai kelas 12 atau Ijazah Pendidikan SMA/Sederajat</td>
                            <td>
                                <input type="file" name="file_ijazah" class="form-control-file file-check" data-name="Ijazah" accept=".jpg,.jpeg,.png,.pdf">
                                <small class="text-muted">*Format: jpg/jpeg/png/pdf (Max 2MB)</small>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Foto Copy sertifikat pelatihan berbasis kompetensi sesuai bidang</td>
                            <td>
                                <input type="file" name="file_sertifikat_pelatihan" class="form-control-file file-check" data-name="Sertifikat Pelatihan" accept=".jpg,.jpeg,.png,.pdf">
                                <small class="text-muted">*Format: jpg/jpeg/png/pdf (Max 2MB)</small>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Surat Keterangan Pengalaman Kerja minimal 1 tahun</td>
                            <td>
                                <input type="file" name="file_surat_pengalaman" class="form-control-file file-check" data-name="Surat Pengalaman" accept=".jpg,.jpeg,.png,.pdf">
                                <small class="text-muted">*Format: jpg/jpeg/png/pdf (Max 2MB)</small>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <h5 class="text-primary font-weight-bold mt-4">PERSYARATAN ADMINISTRATIF</h5>
                <table class="table table-bordered bg-white">
                    <thead class="thead-light">
                        <tr>
                            <th width="50">No</th>
                            <th>Persyaratan</th>
                            <th width="35%">Upload Dokumen</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Pasfoto <span class="text-danger">*</span></td>
                            <td>
                                <input type="file" name="file_pas_foto" class="form-control-file file-check" data-name="Pasfoto" accept=".jpg,.jpeg,.png" required>
                                <small class="text-danger">*Wajib diisi (jpg/jpeg/png, Max 2MB)</small>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Identitas Pribadi (KTP / Kartu Pelajar) <span class="text-danger">*</span></td>
                            <td>
                                <input type="file" name="file_identitas" class="form-control-file file-check" data-name="KTP/Identitas" accept=".jpg,.jpeg,.png" required>
                                <small class="text-danger">*Wajib diisi (jpg/jpeg/png, Max 2MB)</small>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-secondary px-4" onclick="prevStep(2)"><i class="fa fa-arrow-left"></i> Kembali</button>
                    <button type="button" class="btn btn-success px-4" onclick="nextStep(4)">Selanjutnya <i class="fa fa-arrow-right"></i></button>
                </div>
            </div>

            <!-- ================= PAGE 4: ASESMEN MANDIRI ================= -->
            <div class="step-content" id="step-4">
                <h4 class="font-weight-bold text-dark">FR-APL.02 ASESMEN MANDIRI & BUKTI PENDUKUNG</h4>
                <p class="text-muted">Jika anda memiliki portofolio atau bukti relevan tambahan, silakan unggah pada kolom di bawah ini.</p>
                <hr>

                <table class="table table-bordered bg-white">
                    <thead class="thead-light">
                        <tr>
                            <th width="50">No</th>
                            <th>Jenis Portofolio / Deskripsi</th>
                            <th width="35%">Upload Dokumen</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>
                                <strong>Sertifikat Upgrading Kompetensi</strong><br>
                                <small class="text-muted">Sertifikat pendukung bidang terkait</small>
                            </td>
                            <td>
                                <input type="file" name="file_portofolio_upgrading" class="form-control-file file-check" data-name="Portofolio Upgrading" accept=".jpg,.jpeg,.png,.pdf">
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>
                                <strong>Hasil / Laporan Pekerjaan</strong><br>
                                <small class="text-muted">Dokumentasi konfigurasi / laporan proyek</small>
                            </td>
                            <td>
                                <input type="file" name="file_portofolio_laporan" class="form-control-file file-check" data-name="Portofolio Laporan" accept=".jpg,.jpeg,.png,.pdf">
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>
                                <strong>Surat Pengalaman Bekerja Tambahan</strong><br>
                                <small class="text-muted">Surat referensi kerja / kontrak</small>
                            </td>
                            <td>
                                <input type="file" name="file_portofolio_pengalaman" class="form-control-file file-check" data-name="Portofolio Pengalaman" accept=".jpg,.jpeg,.png,.pdf">
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="alert alert-warning">
                    <i class="fa fa-info-circle mr-1"></i> Pastikan seluruh data dan dokumen yang Anda unggah sudah benar sebelum menekan tombol Kirim Pendaftaran.
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-secondary px-4" onclick="prevStep(3)"><i class="fa fa-arrow-left"></i> Kembali</button>
                    <button type="submit" id="btn-submit" class="btn btn-primary px-5 font-weight-bold"><i class="fa fa-paper-plane"></i> Kirim Pendaftaran</button>
                </div>
            </div>

        </form>
    </div>

</div>

<!-- JS Dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    // Inisialisasi Flatpickr Tanggal Lahir
    flatpickr(".datepicker", {
        dateFormat: "Y-m-d",
        allowInput: true
    });

    // Validasi Sisi Client: Cek Ukuran dan Ekstensi File secara Real-Time
    $('.file-check').on('change', function() {
        let file = this.files[0];
        let fieldName = $(this).attr('data-name') || 'Dokumen';
        
        if (file) {
            let maxSize = 2 * 1024 * 1024; // 2MB dalam bytes
            let allowedExts = ['jpg', 'jpeg', 'png', 'pdf'];
            let ext = file.name.split('.').pop().toLowerCase();

            // 1. Cek Ukuran
            if (file.size > maxSize) {
                alert('Ukuran file "' + fieldName + '" terlalu besar (' + (file.size / 1024 / 1024).toFixed(2) + ' MB).\nMaksimal ukuran file yang diperbolehkan adalah 2 MB!');
                $(this).val(''); // Reset input
                return false;
            }

            // 2. Cek Ekstensi
            if (!allowedExts.includes(ext)) {
                alert('Format file "' + fieldName + '" tidak didukung (.' + ext + ').\nGunakan format: JPG, JPEG, PNG, atau PDF.');
                $(this).val(''); // Reset input
                return false;
            }
        }
    });

    // Indikator Loading saat Form Disubmit
    $('#form-pendaftaran').on('submit', function() {
        let $btn = $('#btn-submit');
        $btn.prop('disabled', true);
        $btn.html('<i class="fa fa-spinner fa-spin mr-1"></i> Sedang Mengunggah & Memproses Data...');
    });

    // Filter Dropdown Jadwal berdasarkan Skema yang dipilih
    $('#select-skema').on('change', function() {
        let skemaId = $(this).val();
        
        // Reset pilihan jadwal
        $('#select-jadwal').val('');
        
        // Sembunyikan semua opsi jadwal terlebih dahulu
        $('#select-jadwal option').each(function() {
            let optionSkema = $(this).attr('data-skema');
            
            if (!optionSkema) {
                $(this).show();
            } else if (optionSkema == skemaId) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    // Fungsi Navigasi Virtual Page (Wizard) dengan Cek Validasi Penuh
    function nextStep(targetStep) {
        let currentStep = targetStep - 1;
        let currentContainer = document.getElementById('step-' + currentStep);
        let form = document.getElementById('form-pendaftaran');

        let inputs = currentContainer.querySelectorAll('input, select, textarea');
        let isValid = true;

        inputs.forEach(function(input) {
            if (!input.checkValidity()) {
                isValid = false;
            }
        });

        if (!isValid) {
            form.reportValidity();
            return false;
        }

        $('.step-content').removeClass('active');
        $('#step-' + targetStep).addClass('active');

        $('.wizard-step').removeClass('active').addClass('disabled');
        for(let i = 1; i <= targetStep; i++) {
            $('#tab-nav-' + i).removeClass('disabled').addClass(i === targetStep ? 'active' : '');
        }
        window.scrollTo(0, 0);
    }

    function prevStep(step) {
        $('.step-content').removeClass('active');
        $('#step-' + step).addClass('active');

        $('.wizard-step').removeClass('active').addClass('disabled');
        for(let i = 1; i <= step; i++) {
            $('#tab-nav-' + i).removeClass('disabled').addClass(i === step ? 'active' : '');
        }
        window.scrollTo(0, 0);
    }
</script>
</body>
</html>