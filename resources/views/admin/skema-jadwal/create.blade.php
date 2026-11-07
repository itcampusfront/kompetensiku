@extends('faturcms::template.admin.main')

@section('title', 'Tambah Jadwal Uji')

@section('css-extra')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection

@section('content')
<div class="app-title">
    <div>
        <h1><i class="fa fa-plus"></i> Tambah Jadwal Uji</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <form action="{{ route('admin.skema-jadwal.store') }}" method="POST">
                @csrf
                <div class="tile-body">
                    <div class="form-group row">
                        <label class="control-label col-md-3">Skema Uji <span class="text-danger">*</span></label>
                        <div class="col-md-9">
                            <select name="skema_uji_id" class="form-control @error('skema_uji_id') is-invalid @enderror" required>
                                <option value="" disabled selected>-- Pilih Skema Uji --</option>
                                @foreach($skemaUjis as $skema)
                                    <option value="{{ $skema->id }}" {{ old('skema_uji_id') == $skema->id ? 'selected' : '' }}>{{ $skema->nama_skema }}</option>
                                @endforeach
                            </select>
                            @error('skema_uji_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-3">Nama Jadwal <span class="text-danger">*</span></label>
                        <div class="col-md-9">
                            <input type="text" name="nama_jadwal" class="form-control @error('nama_jadwal') is-invalid @enderror" value="{{ old('nama_jadwal') }}" placeholder="Contoh: Batch 1 - 2026" required>
                            @error('nama_jadwal') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-3">Deskripsi</label>
                        <div class="col-md-9">
                            <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-3">Tanggal Mulai <span class="text-danger">*</span></label>
                        <div class="col-md-9">
                            <input type="text" name="tgl_mulai" class="form-control datepicker @error('tgl_mulai') is-invalid @enderror" value="{{ old('tgl_mulai') }}" placeholder="Pilih Tanggal" required>
                            @error('tgl_mulai') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-3">Tanggal Selesai <span class="text-danger">*</span></label>
                        <div class="col-md-9">
                            <input type="text" name="tgl_selesai" class="form-control datepicker @error('tgl_selesai') is-invalid @enderror" value="{{ old('tgl_selesai') }}" placeholder="Pilih Tanggal" required>
                            @error('tgl_selesai') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-3">Status <span class="text-danger">*</span></label>
                        <div class="col-md-9">
                            <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                <option value="Buka" {{ old('status') == 'Buka' ? 'selected' : '' }}>Buka</option>
                                <option value="Tutup" {{ old('status') == 'Tutup' ? 'selected' : '' }}>Tutup</option>
                            </select>
                            @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="tile-footer text-right">
                    <a href="{{ route('admin.skema-jadwal.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js-extra')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr(".datepicker", {
        dateFormat: "Y-m-d",
        allowInput: true
    });
</script>
@endsection