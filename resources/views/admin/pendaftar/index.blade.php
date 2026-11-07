@extends('faturcms::template.admin.main')

@section('title', 'Data Pendaftar')

@section('content')
<div class="app-title">
    <div>
        <h1><i class="fa fa-users"></i> Data Pendaftar</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">Filter & Pencarian</h3>
            
            <!-- Form Filter & Search -->
            <form action="{{ route('admin.pendaftar.index') }}" method="GET" class="mb-4">
                <!-- Keep sorting parameters during filtering -->
                <input type="hidden" name="sort_by" value="{{ $sortBy }}">
                <input type="hidden" name="sort_dir" value="{{ $sortDir }}">

                <div class="form-row">
                    <!-- Search Field -->
                    <div class="form-group col-md-3">
                        <label>Cari (Nama, NIK, Skema, Jadwal)</label>
                        <input type="text" name="search" class="form-control" placeholder="Kata kunci..." value="{{ $search }}">
                    </div>

                    <!-- Filter Skema -->
                    <div class="form-group col-md-3">
                        <label>Filter Skema Uji</label>
                        <select name="skema_uji_id" class="form-control" id="filter-skema">
                            <option value="">-- Semua Skema --</option>
                            @foreach($skemaUjis as $skema)
                                <option value="{{ $skema->id }}" {{ $skemaId == $skema->id ? 'selected' : '' }}>
                                    {{ $skema->nama_skema }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Jadwal -->
                    <div class="form-group col-md-2">
                        <label>Filter Jadwal Uji</label>
                        <select name="skema_jadwal_id" class="form-control" id="filter-jadwal">
                            <option value="">-- Semua Jadwal --</option>
                            @foreach($jadwals as $jadwal)
                                <option value="{{ $jadwal->id }}" data-skema="{{ $jadwal->skema_uji_id }}" {{ $jadwalId == $jadwal->id ? 'selected' : '' }}>
                                    {{ $jadwal->nama_jadwal }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Status (BARU) -->
                    <div class="form-group col-md-2">
                        <label>Filter Status</label>
                        <select name="status" class="form-control">
                            <option value="">-- Semua Status --</option>
                            <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                            <option value="Diterima" {{ $status === 'Diterima' ? 'selected' : '' }}>Diterima</option>
                            <option value="Ditolak" {{ $status === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>

                    <!-- Option Tampilkan Per Page -->
                    <div class="form-group col-md-1">
                        <label>Tampil</label>
                        <select name="per_page" class="form-control" onchange="this.form.submit()">
                            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="form-group col-md-1 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary mr-1" title="Cari"><i class="fa fa-search"></i></button>
                        <a href="{{ route('admin.pendaftar.index') }}" class="btn btn-secondary" title="Reset"><i class="fa fa-refresh"></i></a>
                    </div>
                </div>
            </form>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        @php
                            // Helper function untuk generate URL sorting
                            function sortUrl($column, $currentBy, $currentDir) {
                                $nextDir = ($currentBy === $column && $currentDir === 'asc') ? 'desc' : 'asc';
                                return request()->fullUrlWithQuery(['sort_by' => $column, 'sort_dir' => $nextDir]);
                            }
                            // Helper function untuk menampilkan Icon sorting
                            function sortIcon($column, $currentBy, $currentDir) {
                                if ($currentBy !== $column) return '<i class="fa fa-sort text-muted float-right mt-1"></i>';
                                return $currentDir === 'asc' ? '<i class="fa fa-sort-asc float-right mt-1"></i>' : '<i class="fa fa-sort-desc float-right mt-1"></i>';
                            }
                        @endphp
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th>
                                    <a href="{{ sortUrl('nik', $sortBy, $sortDir) }}" class="text-dark d-block">
                                        NIK {!! sortIcon('nik', $sortBy, $sortDir) !!}
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ sortUrl('nama_lengkap', $sortBy, $sortDir) }}" class="text-dark d-block">
                                        Nama Lengkap {!! sortIcon('nama_lengkap', $sortBy, $sortDir) !!}
                                    </a>
                                </th>
                                <th>Skema & Jadwal</th>
                                <th>No. Telp (WA)</th>
                                <th>
                                    <a href="{{ sortUrl('created_at', $sortBy, $sortDir) }}" class="text-dark d-block">
                                        Tgl Daftar {!! sortIcon('created_at', $sortBy, $sortDir) !!}
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ sortUrl('status', $sortBy, $sortDir) }}" class="text-dark d-block">
                                        Status {!! sortIcon('status', $sortBy, $sortDir) !!}
                                    </a>
                                </th>
                                <th width="100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendaftars as $key => $pendaftar)
                            <tr>
                                <td>{{ $pendaftars->firstItem() + $key }}</td>
                                <td>{{ $pendaftar->nik }}</td>
                                <td>{{ $pendaftar->nama_lengkap }}</td>
                                <td>
                                    <strong>{{ $pendaftar->skema_jadwal->skema_uji->nama_skema ?? 'Skema Dihapus' }}</strong><br>
                                    <small class="text-muted">{{ $pendaftar->skema_jadwal->nama_jadwal ?? 'Jadwal Dihapus' }}</small>
                                </td>
                                <td>{{ $pendaftar->no_telp }}</td>
                                <td>{{ $pendaftar->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    @if($pendaftar->status === 'Diterima')
                                        <span class="badge badge-success"><i class="fa fa-check"></i> Diterima</span>
                                    @elseif($pendaftar->status === 'Ditolak')
                                        <span class="badge badge-danger"><i class="fa fa-times"></i> Ditolak</span>
                                    @else
                                        <span class="badge badge-warning text-dark"><i class="fa fa-clock-o"></i> Pending</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.pendaftar.show', $pendaftar->id) }}" class="btn btn-sm btn-info" title="Detail"><i class="fa fa-eye"></i></a>
                                    <form action="{{ route('admin.pendaftar.destroy', $pendaftar->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data beserta file pendaftar ini secara permanen?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Data pendaftar tidak ditemukan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination & Info -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        Menampilkan {{ $pendaftars->firstItem() ?? 0 }} sampai {{ $pendaftars->lastItem() ?? 0 }} dari total {{ $pendaftars->total() }} data
                    </div>
                    <div>
                        {{ $pendaftars->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js-extra')
<script>
    // Filter dropdown Jadwal secara otomatis saat Skema dipilih
    $('#filter-skema').on('change', function() {
        let skemaId = $(this).val();
        $('#filter-jadwal').val('');
        
        $('#filter-jadwal option').each(function() {
            let optionSkema = $(this).attr('data-skema');
            if(!optionSkema || !skemaId || optionSkema == skemaId) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
</script>
@endsection