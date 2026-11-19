@extends('faturcms::template.admin.main')

@section('title', 'Daftar Ujian SBA')

@section('content')
<div class="app-title">
    <div>
        <h1><i class="fas fa-laptop-code"></i> Daftar Ujian SBA</h1>
        <p>Kelola daftar ujian, pencarian data, pengaturan waktu, dan soal untuk peserta.</p>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-title-w-btn">
                <h3 class="title">Daftar Ujian</h3>
                <p><a class="btn btn-primary icon-btn" href="{{ route('sba.create') }}"><i class="fa fa-plus"></i>Buat Ujian Baru</a></p>
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

            <div class="tile-body">
                
                {{-- PANEL FILTER & SEARCH --}}
                <form action="{{ route('sba.index') }}" method="GET" class="row mb-3">
                    <input type="hidden" name="sort_by" value="{{ request('sort_by', 'id') }}">
                    <input type="hidden" name="sort_order" value="{{ request('sort_order', 'desc') }}">

                    <div class="col-md-3 mb-2">
                        <select name="user_id" class="form-control">
                            <option value="">-- Semua Author Pembuat --</option>
                            @foreach($authors as $author)
                                <option value="{{ $author->id_user }}" {{ request('user_id') == $author->id_user ? 'selected' : '' }}>
                                    {{ $author->nama_user }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-5 mb-2">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari Kode Uji, Judul, atau Deskripsi..." value="{{ request('search') }}">
                        </div>
                    </div>

                    <div class="col-md-2 mb-2 d-flex">
                        <button type="submit" class="btn btn-primary w-100 mr-1"><i class="fa fa-search"></i> Cari</button>
                        @if(request()->hasAny(['search', 'user_id', 'per_page', 'sort_by']))
                            <a href="{{ route('sba.index') }}" class="btn btn-secondary" title="Reset Filter"><i class="fa fa-refresh"></i></a>
                        @endif
                    </div>

                    <div class="col-md-2 mb-2 text-right">
                        <select name="per_page" class="form-control d-inline-block w-auto" onchange="this.form.submit()">
                            @foreach([10, 25, 50, 100] as $pageOption)
                                <option value="{{ $pageOption }}" {{ request('per_page', 10) == $pageOption ? 'selected' : '' }}>
                                    Tampil {{ $pageOption }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>

                {{-- HELPER UNTUK URL SORTING --}}
                @php
                    function getSortUrl($column) {
                        $currentSort = request('sort_by', 'id');
                        $currentOrder = request('sort_order', 'desc');
                        $nextOrder = ($currentSort === $column && $currentOrder === 'asc') ? 'desc' : 'asc';
                        return request()->fullUrlWithQuery(['sort_by' => $column, 'sort_order' => $nextOrder]);
                    }

                    function getSortIcon($column) {
                        if (request('sort_by', 'id') !== $column) {
                            return '<i class="fa fa-sort text-muted ml-1"></i>';
                        }
                        return request('sort_order', 'desc') === 'asc' 
                            ? '<i class="fa fa-sort-up text-primary ml-1"></i>' 
                            : '<i class="fa fa-sort-down text-primary ml-1"></i>';
                    }
                @endphp

                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%"><a href="{{ getSortUrl('kode_uji') }}" class="text-dark">Kode Uji {!! getSortIcon('kode_uji') !!}</a></th>
                                <th width="30%"><a href="{{ getSortUrl('judul') }}" class="text-dark">Judul / Deskripsi {!! getSortIcon('judul') !!}</a></th>
                                <th width="15%"><a href="{{ getSortUrl('user_id') }}" class="text-dark">Author {!! getSortIcon('user_id') !!}</a></th>
                                <th width="15%"><a href="{{ getSortUrl('waktu_mulai') }}" class="text-dark">Waktu / Durasi {!! getSortIcon('waktu_mulai') !!}</a></th>
                                <th width="10%" class="text-center"><a href="{{ getSortUrl('status') }}" class="text-dark">Status {!! getSortIcon('status') !!}</a></th>
                                <th width="10%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ujis as $index => $uji)
                            <tr>
                                <td>{{ ($ujis instanceof \Illuminate\Pagination\LengthAwarePaginator) ? $ujis->firstItem() + $index : $loop->iteration }}</td>
                                
                                <td>
                                    <strong>{{ strtoupper($uji->kode_uji) }}</strong>
                                </td>
                                
                                <td>
                                    <strong>{{ $uji->judul }}</strong><br>
                                    <small class="text-muted">
                                        @if($uji->deskripsi)
                                            {{ Str::limit(strip_tags($uji->deskripsi), 30, '...') }}
                                        @else
                                            <em>Tidak ada deskripsi</em>
                                        @endif
                                    </small>
                                </td>
                                
                                <td>
                                    <i class="fa fa-user-circle-o mr-1"></i> {{ $uji->author->nama_user ?? 'Administrator' }}
                                </td>
                                
                                <td>
                                    @if($uji->waktu_mulai && $uji->waktu_selesai)
                                        <small>{{ $uji->waktu_mulai->format('d/m/Y H:i') }} - {{ $uji->waktu_selesai->format('H:i') }}</small>
                                    @elseif($uji->waktu_mulai)
                                        <small>Mulai: {{ $uji->waktu_mulai->format('d/m/Y H:i') }}</small>
                                    @else
                                        <small class="text-muted">Fleksibel</small>
                                    @endif
                                    <br>
                                    <small class="text-info"><i class="fa fa-clock-o"></i> {{ $uji->durasi_menit > 0 ? $uji->durasi_menit . ' Menit' : 'Tanpa Batas' }}</small>
                                </td>
                                
                                <td class="text-center">
                                    @if($uji->status == 'published')
                                        <span class="badge badge-success mb-1">Published</span>
                                    @elseif($uji->status == 'closed')
                                        <span class="badge badge-danger mb-1">Closed</span>
                                    @else
                                        <span class="badge badge-secondary mb-1">Draft</span>
                                    @endif
                                    <br>
                                    <a href="{{ route('sba.hasil.index', $uji->id) }}" class="badge badge-light border" title="Lihat Hasil">
                                        <i class="fa fa-users text-primary"></i> {{ $uji->hasils_count ?? $uji->hasils()->count() }} Hasil
                                    </a>
                                </td>
                                
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-info btn-sm btn-copy-link" data-url="{{ route('sba.uji.halaman', $uji->kode_uji) }}" title="Salin Link">
                                            <i class="fa fa-link"></i>
                                        </button>
                                        <a href="{{ route('sba.edit', $uji->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('sba.destroy', $uji->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin menghapus ujian ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="fa fa-search fa-3x text-muted mb-3 d-block"></i>
                                    <h5 class="text-muted">Data ujian tidak ditemukan.</h5>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION INTERAKTIF --}}
                @if($ujis instanceof \Illuminate\Pagination\LengthAwarePaginator && $ujis->hasPages())
                    <div class="d-flex justify-content-between mt-3">
                        <div>
                            <small class="text-muted">Menampilkan {{ $ujis->firstItem() }} - {{ $ujis->lastItem() }} dari {{ $ujis->total() }} data</small>
                        </div>
                        <div>
                            {{ $ujis->links('pagination::bootstrap-4') }}
                        </div>
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
    document.querySelectorAll('.btn-copy-link').forEach(btn => {
        btn.addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            navigator.clipboard.writeText(url).then(() => {
                const originalHtml = this.innerHTML;
                this.innerHTML = '<i class="fa fa-check"></i>';
                this.classList.remove('btn-info');
                this.classList.add('btn-success');
                setTimeout(() => {
                    this.innerHTML = originalHtml;
                    this.classList.remove('btn-success');
                    this.classList.add('btn-info');
                }, 2000);
            }).catch(err => {
                console.error('Gagal menyalin link:', err);
            });
        });
    });
});
</script>
@endsection