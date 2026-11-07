@extends('faturcms::template.admin.main')

@section('title', 'Data Gallery')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Data Gallery',
        'items' => [
            ['text' => 'Gallery', 'url' => route('admin.gallery.index')],
            ['text' => 'Data Gallery', 'url' => '#'],
        ]
    ]])
    <!-- /Breadcrumb -->

    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-md-12">
            <!-- Tile -->
            <div class="tile">
                <!-- Tile Title -->
                <div class="tile-title-w-btn">
                    <div class="btn-group">
                        <a href="{{ route('admin.gallery.create') }}" class="btn btn-sm btn-theme-1"><i class="fa fa-plus mr-2"></i> Tambah Data</a>
                    </div>
                </div>
                <!-- /Tile Title -->
                <!-- Tile Body -->
                <div class="tile-body">
                    @if(Session::get('message') != null)
                        <div class="alert alert-success alert-dismissible mb-4 fade show" role="alert">
                            {{ Session::get('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if(count($gallery)>0)
                        <div class="row sortable">
                            @foreach($gallery as $data)
                                <div class="col-md-4 col-sm-6 mb-3">
                                    <div data-id="{{ $data->id }}">
                                        <div class="card-body text-center">
                                            <a class="btn-magnify-popup" href="{{ image('assets/images/dokumentasi/'.$data->gambar, 'gallery') }}" title="{{ $data->gambar }}">
                                                <img src="{{ image('assets/images/dokumentasi/'.$data->gambar, 'gallery') }}" height="150" style="max-width: 100%;">
                                            </a>
                                            <p class="h5 mt-2 mb-1">{{ $data->judul_gambar }}</p>
                                        </div>
                                        <div class="card-footer d-flex justify-content-between">
                                            <a href="{{ route('admin.gallery.edit', ['id' => $data->id]) }}" class="btn btn-sm btn-info" title="Edit" data-toggle="tooltip"><i class="fa fa-edit"></i></a>
                                            <a href="#" class="btn btn-sm btn-danger btn-delete" title="Hapus" data-id="{{ $data->id }}" data-toggle="tooltip"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <form id="form-delete" class="d-none" method="post" action="{{ route('admin.gallery.delete') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="id">
                        </form>
                    @else
                        <div class="alert alert-danger text-center">Tidak ada data tersedia.</div>
                    @endif
                </div>
                <!-- /Tile Body -->
            </div>
            <!-- /Tile -->
        </div>
        <!-- /Column -->
    </div>
    <!-- /Row -->
</main>
<!-- /Main -->

@endsection
