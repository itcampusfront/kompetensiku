@extends('faturcms::template.admin.main')

@section('title', 'Data Jadwal Uji')

@section('content')
<div class="app-title">
    <div>
        <h1><i class="fa fa-calendar"></i> Data Jadwal Uji</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-title-w-btn">
                <h3 class="title">Daftar Jadwal Uji</h3>
                <p><a class="btn btn-primary icon-btn" href="{{ route('admin.skema-jadwal.create') }}"><i class="fa fa-plus"></i>Tambah Jadwal</a></p>
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
                                <th>Nama Jadwal</th>
                                <th>Skema Uji</th>
                                <th>Periode Pendaftaran</th>
                                <th>Status</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jadwals as $key => $jadwal)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $jadwal->nama_jadwal }}</td>
                                <td>{{ $jadwal->skema_uji->nama_skema ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($jadwal->tgl_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($jadwal->tgl_selesai)->format('d M Y') }}</td>
                                <td>
                                    <span class="badge {{ $jadwal->status == 'Buka' ? 'badge-success' : 'badge-danger' }}">{{ $jadwal->status }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.skema-jadwal.edit', $jadwal->id) }}" class="btn btn-sm btn-warning" title="Edit"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('admin.skema-jadwal.destroy', $jadwal->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
    if(typeof $('#dataTable').DataTable === 'function') {
        $('#dataTable').DataTable();
    }
</script>
@endsection