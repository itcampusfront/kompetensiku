@extends('template.main')

@section('title', $program->program_title.' - Program | ')

@section('content')
<div>
  <div class="container mt-3">
  	<nav aria-label="breadcrumb">
  	  <ol class="breadcrumb bg-white p-3 shadow-sm rounded-1">
  	    <li class="breadcrumb-item"><a href="{{ route('site.home') }}"><i class="fas fa-home"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ route('site.program.index') }}">Program</a></li>
        <li class="breadcrumb-item active" aria-current="page">
          <span>{{$program->program_title}}</span>
        </li>
  	  </ol>
  	</nav>
  </div>
  <section>
      <div class="bg-theme-2">
          <div class="container pt-0 pt-md-4 pb-4 mb-4 mb-lg-0">
            <div class="row">
              <div class="col-lg-8 order-2 order-lg-1 text-white">
                <span class="badge bg-theme-1 mb-3 p-2">{{$program->kategori}}</span>
                <h2 class="mb-3">{{$program->program_title}}</h2>
                <p>Oleh : {{$program->nama_user}}<br> Terakhir diperbarui {{date('d/m/Y', strtotime($program->program_at))}}</p>
                <a href="{{ route('auth.login') }}" class="btn btn-light">Ambil Pelatihan</a>
              </div>
              <div class="col-lg-4 order-1 order-lg-2 px-0 px-md-3">
                  <img class="img-fluid rounded mb-3 mb-lg-0" src="{{ image('assets/images/program/'.$program->program_gambar, 'program') }}">
              </div>
            </div>
          </div>
      </div>
  </section>
  <section class="my-3">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 mb-3 mb-lg-0">
          <div class="heading">
            <h5 class="font-weight-bold">Ringkasan</h5>
          </div>
          <div class="card rounded-2 border-0 shadow-sm">
            <div class="card-body">
              <div class="ql-snow">
                <div class="ql-editor">{!! html_entity_decode($program->konten) !!}</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <h5 class="widget_title">Pelatihan Lainnya</h5>
          <div class="card mb-3">
              <div class="card-body">
                  @foreach($program_lainnya as $data)
                  <a class="text-body" href="{{ route('site.program.detail', ['permalink' => $data->program_permalink]) }}">
                      <div class="d-flex mb-3">
                          <img class="rounded flex-shrink-0 me-3" width="70" src="{{ image('assets/images/program/'.$data->program_gambar, 'program') }}" alt="post">
                          <span>{{$data->program_title}}</span>
                      </div>
                  </a>
                  @endforeach
              </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
@section('css-extra')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection