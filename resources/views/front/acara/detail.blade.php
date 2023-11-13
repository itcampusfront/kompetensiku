@extends('template.main')

@section('title', $acara->nama_acara.' - Acara | ')

@section('content')
<div>
  <div class="container mt-3">
  	<nav aria-label="breadcrumb">
  	  <ol class="breadcrumb bg-white p-3 shadow-sm rounded-1">
  	    <li class="breadcrumb-item"><a href="{{ route('site.home') }}"><i class="fas fa-home"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ route('site.acara.index') }}">Acara</a></li>
        <li class="breadcrumb-item active" aria-current="page">
          <span>{{$acara->nama_acara}}</span>
        </li>
  	  </ol>
  	</nav>
  </div>
  <section>
      <div class="bg-theme-2">
          <div class="container pt-0 pt-md-4 pb-4 mb-4 mb-lg-0">
            <div class="row">
              <div class="col-lg-8 order-2 order-lg-1 text-white">
                <span class="badge bg-theme-1 mb-3 p-2">{{$acara->kategori}}</span>
                <h2 class="mb-3">{{$acara->nama_acara}}</h2>
                <p>
                  Tempat : {{$acara->tempat_acara}}<br>
                  Dimulai pada {{ generate_date_time($acara->tanggal_acara_from) }} WIB<br>
                  Sampai {{ generate_date_time($acara->tanggal_acara_to) }} WIB
                </p>
                <!-- <a href="{{ route('auth.login') }}" class="btn btn-light">Ambil Pelatihan</a> -->
              </div>
              <div class="col-lg-4 order-1 order-lg-2 px-0 px-md-3">
                  <img class="img-fluid rounded mb-3 mb-lg-0" src="{{ image('assets/images/acara/'.$acara->gambar_acara, 'acara') }}">
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
                <div class="ql-editor">{!! html_entity_decode($acara->deskripsi_acara) !!}</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <h5 class="widget_title">Acara Lainnya</h5>
          <div class="card mb-3">
              <div class="card-body">
                  @foreach($acara_lainnya as $data)
                  <a class="text-body" href="{{ route('site.acara.detail', ['permalink' => $data->id_acara]) }}">
                      <div class="d-flex mb-3">
                          <img class="rounded flex-shrink-0 me-3" width="70" src="{{ image('assets/images/acara/'.$data->gambar_acara, 'acara') }}" alt="post">
                          <span>{{$data->nama_acara}}</span>
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