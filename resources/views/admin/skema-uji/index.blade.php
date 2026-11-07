@extends('faturcms::template.admin.main')

@section('title', 'Data Skema Uji')

@section('content')
<div class="app-title">
    <div>
        <h1><i class="fa fa-list"></i> Data Skema Uji</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-title-w-btn">
                <h3 class="title">Daftar Skema Uji</h3>
                <p><a class="btn btn-primary icon-btn" href="{{ route('admin.skema-uji.create') }}"><i class="fa fa-plus"></i>Tambah Data</a></p>
            </div>
            
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="dataTable">
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th>Nama Skema</th>
                                <th>Jumlah Unit Kompetensi</th>
                                <th>Status</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($skemaUjis as $key => $skema)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $skema->nama_skema }}</td>
                                <td>{{ $skema->skema_uks->count() }} Unit</td>
                                <td>
                                    <span class="badge {{ $skema->status == 'Aktif' ? 'badge-success' : 'badge-danger' }}">{{ $skema->status }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.skema-uji.edit', $skema->id) }}" class="btn btn-sm btn-warning" title="Edit"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('admin.skema-uji.destroy', $skema->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js-extra')
<script>
    // Inisialisasi DataTables jika template Anda menggunakannya
    if(typeof $('#dataTable').DataTable === 'function') {
        $('#dataTable').DataTable();
    }
</script>
@endsection