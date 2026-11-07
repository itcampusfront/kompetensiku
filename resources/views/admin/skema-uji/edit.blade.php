@extends('faturcms::template.admin.main')

@section('title', 'Edit Skema Uji')

@section('content')
<div class="app-title">
    <div>
        <h1><i class="fa fa-edit"></i> Edit Skema Uji</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <form action="{{ route('admin.skema-uji.update', $skemaUji->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="tile-body">
                    <div class="form-group row">
                        <label class="control-label col-md-3">Nama Skema Uji <span class="text-danger">*</span></label>
                        <div class="col-md-9">
                            <input type="text" name="nama_skema" class="form-control @error('nama_skema') is-invalid @enderror" value="{{ old('nama_skema', $skemaUji->nama_skema) }}" required>
                            @error('nama_skema') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3">Status <span class="text-danger">*</span></label>
                        <div class="col-md-9">
                            <select name="status" class="form-control" required>
                                <option value="Aktif" {{ $skemaUji->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Tidak Aktif" {{ $skemaUji->status == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                        </div>
                    </div>

                    <hr>
                    <h4>Unit Kompetensi</h4>
                    <p class="text-muted">Perbarui daftar unit kompetensi untuk skema ini.</p>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="30%">Kode UK</th>
                                    <th>Judul UK</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="uk-container">
                                @if($skemaUji->skema_uks->count() > 0)
                                    @foreach($skemaUji->skema_uks as $uk)
                                    <tr>
                                        <td><input type="text" name="kode_uk[]" class="form-control" value="{{ $uk->kode }}"></td>
                                        <td><input type="text" name="judul_uk[]" class="form-control" value="{{ $uk->judul }}"></td>
                                        <td><button type="button" class="btn btn-sm btn-danger btn-remove-uk"><i class="fa fa-times"></i></button></td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td><input type="text" name="kode_uk[]" class="form-control" placeholder="Kode UK"></td>
                                        <td><input type="text" name="judul_uk[]" class="form-control" placeholder="Judul UK"></td>
                                        <td><button type="button" class="btn btn-sm btn-danger btn-remove-uk"><i class="fa fa-times"></i></button></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-sm btn-info" id="btn-add-uk"><i class="fa fa-plus"></i> Tambah Unit Kompetensi</button>
                    </div>
                </div>
                <div class="tile-footer text-right">
                    <a href="{{ route('admin.skema-uji.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js-extra')
<script>
    document.getElementById('btn-add-uk').addEventListener('click', function() {
        let html = `<tr>
            <td><input type="text" name="kode_uk[]" class="form-control" placeholder="Kode UK"></td>
            <td><input type="text" name="judul_uk[]" class="form-control" placeholder="Judul UK"></td>
            <td><button type="button" class="btn btn-sm btn-danger btn-remove-uk"><i class="fa fa-times"></i></button></td>
        </tr>`;
        document.getElementById('uk-container').insertAdjacentHTML('beforeend', html);
    });

    document.getElementById('uk-container').addEventListener('click', function(e) {
        if(e.target.classList.contains('btn-remove-uk') || e.target.closest('.btn-remove-uk')) {
            e.target.closest('tr').remove();
        }
    });
</script>
@endsection