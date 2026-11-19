@extends('faturcms::template.admin.main')

@section('title', 'Hasil Ujian - ' . $uji->judul)

@section('content')
<div class="app-title">
    <div>
        <h1><i class="fa fa-bar-chart"></i> Hasil Asesmen: {{ $uji->judul }}</h1>
        <p>Kode Uji: <strong>{{ strtoupper($uji->kode_uji) }}</strong> | Total Data: <strong>{{ $hasils->total() }} Peserta</strong></p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{ route('sba.index') }}">Daftar Ujian SBA</a></li>
        <li class="breadcrumb-item"><a href="#">Hasil Asesmen</a></li>
    </ul>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            
            {{-- Tombol Kembali dan Export --}}
            <div class="tile-title-w-btn mb-4">
                <h3 class="title">Rekapitulasi Hasil</h3>
                <div class="btn-group">
                    <a href="{{ route('sba.index') }}" class="btn btn-secondary icon-btn">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                    
                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-file-excel-o"></i> Export Data
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('sba.hasil.export', array_merge(['uji_id' => $uji->id, 'format' => 'excel'], request()->query())) }}">
                            <i class="fa fa-file-excel-o text-success"></i> Export Excel
                        </a>
                        <a class="dropdown-item" href="{{ route('sba.hasil.export', array_merge(['uji_id' => $uji->id, 'format' => 'pdf'], request()->query())) }}" target="_blank">
                            <i class="fa fa-file-pdf-o text-danger"></i> Export PDF
                        </a>
                    </div>
                </div>
            </div>

            {{-- ALERT NOTIFICATION --}}
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

            <div class="tile-body">
                
                {{-- FILTER PANEL --}}
                <form id="filterForm" action="{{ route('sba.hasil.index', $uji->id) }}" method="GET" class="row mb-3">
                    <input type="hidden" name="sort_by" value="{{ request('sort_by', 'total_skor') }}">
                    <input type="hidden" name="sort_order" value="{{ request('sort_order', 'desc') }}">

                    <div class="col-md-2 mb-2">
                        <select name="status_pengerjaan" class="form-control" onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="final" {{ request('status_pengerjaan') == 'final' ? 'selected' : '' }}>Final (Dinilai)</option>
                            <option value="selesai" {{ request('status_pengerjaan') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="berlangsung" {{ request('status_pengerjaan') == 'berlangsung' ? 'selected' : '' }}>Berlangsung</option>
                            <option value="gagal_pelanggaran" {{ request('status_pengerjaan') == 'gagal_pelanggaran' ? 'selected' : '' }}>Diskualifikasi</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-2">
                        <input type="text" name="search" class="form-control" placeholder="Cari ID / Nama Peserta..." value="{{ request('search') }}" onkeypress="if(event.key === 'Enter') this.form.submit()">
                    </div>

                    <div class="col-md-3 mb-2 d-flex align-items-center">
                        <input type="date" name="tgl_mulai" class="form-control px-2 py-1 text-sm" value="{{ request('tgl_mulai') }}" title="Mulai" onchange="this.form.submit()">
                        <span class="mx-2 text-muted">s/d</span>
                        <input type="date" name="tgl_selesai" class="form-control px-2 py-1 text-sm" value="{{ request('tgl_selesai') }}" title="Selesai" onchange="this.form.submit()">
                    </div>
                    
                    <div class="col-md-2 mb-2 pt-2">
                        <div class="animated-checkbox">
                            <label>
                                <input type="checkbox" name="hide_duplicates" value="1" {{ request('hide_duplicates') == '1' ? 'checked' : '' }} onchange="this.form.submit()"><span class="label-text text-dark font-weight-bold">Sembunyikan Duplikat</span>
                            </label>
                        </div>
                    </div>

                    <div class="col-md-2 mb-2 text-right">
                        <a href="{{ route('sba.hasil.index', $uji->id) }}" class="btn btn-secondary mr-2" title="Reset Filter"><i class="fa fa-refresh"></i></a>
                        <select name="per_page" class="form-control d-inline-block w-auto" onchange="this.form.submit()">
                            @foreach([10, 25, 50, 100] as $pageOption)
                                <option value="{{ $pageOption }}" {{ request('per_page', 10) == $pageOption ? 'selected' : '' }}>{{ $pageOption }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>

                {{-- HELPER SORTING --}}
                @php
                    function getSortUrlHasil($column) {
                        $currentSort = request('sort_by', 'total_skor');
                        $currentOrder = request('sort_order', 'desc');
                        $nextOrder = ($currentSort === $column && $currentOrder === 'asc') ? 'desc' : 'asc';
                        return request()->fullUrlWithQuery(['sort_by' => $column, 'sort_order' => $nextOrder]);
                    }

                    function getSortIconHasil($column) {
                        if (request('sort_by', 'total_skor') !== $column) {
                            return '<i class="fa fa-sort text-muted ml-1"></i>';
                        }
                        return request('sort_order', 'desc') === 'asc' 
                            ? '<i class="fa fa-sort-up text-primary ml-1"></i>' 
                            : '<i class="fa fa-sort-down text-primary ml-1"></i>';
                    }
                @endphp

                <form id="formBulkDelete" action="{{ route('sba.hasil.bulk_delete', $uji->id) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center" width="3%">
                                        <input type="checkbox" id="checkAllHasil" style="cursor: pointer;">
                                    </th>
                                    <th width="5%">No</th>
                                    <th width="10%"><a href="{{ getSortUrlHasil('asesi_id') }}" class="text-dark">Asesi ID {!! getSortIconHasil('asesi_id') !!}</a></th>
                                    <th width="23%">Nama Peserta</th>
                                    <th width="20%" class="text-center">Waktu & Durasi</th>
                                    <th width="12%" class="text-center"><a href="{{ getSortUrlHasil('total_skor') }}" class="text-dark">Skor Akhir {!! getSortIconHasil('total_skor') !!}</a></th>
                                    <th width="15%" class="text-center"><a href="{{ getSortUrlHasil('status_pengerjaan') }}" class="text-dark">Status / Ke {!! getSortIconHasil('status_pengerjaan') !!}</a></th>
                                    <th width="12%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($hasils as $index => $hasil)
                                <tr>
                                    <td class="text-center">
                                        <input class="check-item-hasil" type="checkbox" name="ids[]" value="{{ $hasil->id }}" style="cursor: pointer;">
                                    </td>
                                    <td>{{ ($hasils instanceof \Illuminate\Pagination\LengthAwarePaginator) ? $hasils->firstItem() + $index : $loop->iteration }}</td>
                                    
                                    <td>
                                        @if($hasil->asesi_id)
                                            <span class="badge badge-dark">USER #{{ $hasil->asesi_id }}</span>
                                        @else
                                            <span class="badge badge-secondary">GUEST</span>
                                        @endif
                                    </td>

                                    <td>
                                        <i class="fa fa-user-circle text-primary mr-1"></i>
                                        <strong>{{ $hasil->asesi ? ($hasil->asesi->nama_user ?? $hasil->asesi->name) : ($hasil->nama_peserta_publik ?? 'Peserta Tanpa Nama') }}</strong>
                                    </td>

                                    <td class="text-center">
                                        {{ $hasil->waktu_mulai ? $hasil->waktu_mulai->format('d/m/Y H:i') : '-' }}<br>
                                        <small class="text-info"><i class="fa fa-clock-o"></i> Durasi: <strong>{{ $hasil->durasi_formatted }}</strong></small>
                                    </td>

                                    <td class="text-center">
                                        @if(in_array($hasil->status_pengerjaan, ['selesai', 'final']))
                                            <span class="badge badge-success p-2" style="font-size:13px">{{ number_format($hasil->total_skor, 0) }} Poin</span>
                                        @elseif($hasil->status_pengerjaan === 'gagal_pelanggaran')
                                            <span class="badge badge-danger p-2" style="font-size:13px">{{ number_format($hasil->total_skor, 0) }} (Gagal)</span>
                                        @else
                                            <span class="badge badge-light border p-2" style="font-size:13px">--</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        @if($hasil->status_pengerjaan === 'final')
                                            <span class="badge badge-primary mb-1"><i class="fa fa-check-circle"></i> Final</span>
                                        @elseif($hasil->status_pengerjaan === 'selesai')
                                            <span class="badge badge-success mb-1">Selesai</span>
                                        @elseif($hasil->status_pengerjaan === 'gagal_pelanggaran')
                                            <span class="badge badge-danger mb-1">Diskualifikasi</span>
                                        @else
                                            <span class="badge badge-info mb-1">Berlangsung</span>
                                        @endif
                                        <br>
                                        <small class="text-muted">Percobaan ke-{{ $hasil->percobaan_ke }}</small>
                                    </td>

                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('sba.hasil.detail', $hasil->id) }}" class="btn btn-info btn-sm" title="Detail & Penilaian">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            @if($hasil->status_pengerjaan === 'gagal_pelanggaran')
                                                <button type="button" class="btn btn-warning btn-sm" title="Buka Kunci (Unlock) Sesi" onclick="aksiPostHasil('{{ route('sba.hasil.unlock', $hasil->id) }}', 'Buka kunci sesi peserta ini agar dapat melanjutkan ujian?')">
                                                    <i class="fa fa-unlock"></i>
                                                </button>
                                            @elseif($hasil->status_pengerjaan === 'berlangsung')
                                                <button type="button" class="btn btn-success btn-sm" title="Finalisasi Paksa Sesi" onclick="aksiPostHasil('{{ route('sba.hasil.finalisasi', $hasil->id) }}', 'Finalisasi paksa sesi peserta ini sekarang?')">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                            @endif
                                            <button type="button" class="btn btn-danger btn-sm" title="Hapus" onclick="hapusSingleHasil({{ $hasil->id }})">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <i class="fa fa-users fa-3x text-muted mb-3 d-block"></i>
                                        <h5 class="text-muted">Belum ada data hasil ujian.</h5>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <button type="button" id="btnBulkDelete" class="btn btn-danger btn-sm" disabled onclick="konfirmasiBulkDelete()">
                            <i class="fa fa-trash"></i> Hapus Terpilih (<span id="selectedCount">0</span>)
                        </button>
                        
                        @if($hasils instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            <small class="text-muted">Menampilkan {{ $hasils->firstItem() ?? 0 }} - {{ $hasils->lastItem() ?? 0 }} dari {{ $hasils->total() }} data</small>
                        @endif
                    </div>
                </form>

                <form id="formSingleDelete" action="" method="POST" class="d-none">
                    @csrf
                    @method('DELETE')
                </form>

                <form id="formPostAksiHasil" action="" method="POST" class="d-none">
                    @csrf
                </form>

                @if($hasils instanceof \Illuminate\Pagination\LengthAwarePaginator && $hasils->hasPages())
                    <div class="d-flex justify-content-end mt-3">
                        {{ $hasils->links('pagination::bootstrap-4') }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection

@section('js-extra')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkAll = document.getElementById('checkAllHasil');
        const checkItems = document.querySelectorAll('.check-item-hasil');
        const btnBulkDelete = document.getElementById('btnBulkDelete');
        const selectedCountEl = document.getElementById('selectedCount');

        function updateBulkDeleteState() {
            const checkedCount = document.querySelectorAll('.check-item-hasil:checked').length;
            selectedCountEl.innerText = checkedCount;

            if (checkedCount > 0) {
                btnBulkDelete.removeAttribute('disabled');
            } else {
                btnBulkDelete.setAttribute('disabled', 'true');
            }

            if (checkItems.length > 0 && checkedCount === checkItems.length) {
                checkAll.checked = true;
                checkAll.indeterminate = false;
            } else if (checkedCount > 0) {
                checkAll.checked = false;
                checkAll.indeterminate = true;
            } else {
                checkAll.checked = false;
                checkAll.indeterminate = false;
            }
        }

        if (checkAll) {
            checkAll.addEventListener('change', function() {
                checkItems.forEach(item => {
                    item.checked = this.checked;
                });
                updateBulkDeleteState();
            });
        }

        checkItems.forEach(item => {
            item.addEventListener('change', updateBulkDeleteState);
        });
    });

    function konfirmasiBulkDelete() {
        const checkedCount = document.querySelectorAll('.check-item-hasil:checked').length;
        if (checkedCount === 0) return;

        if (confirm(`Apakah Anda yakin ingin menghapus ${checkedCount} data hasil ujian yang dipilih secara permanen?`)) {
            document.getElementById('formBulkDelete').submit();
        }
    }

    function hapusSingleHasil(id) {
        if (confirm('Apakah Anda yakin ingin menghapus hasil pengerjaan peserta ini?')) {
            const form = document.getElementById('formSingleDelete');
            form.action = `/admin/sba/hasil/${id}`;
            form.submit();
        }
    }

    function aksiPostHasil(url, pesan) {
        if (confirm(pesan)) {
            const form = document.getElementById('formPostAksiHasil');
            form.action = url;
            form.submit();
        }
    }
</script>
@endsection