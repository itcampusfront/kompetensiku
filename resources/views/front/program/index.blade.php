@extends('layout.main')

@section('title', 'Program | ')

@section('content')

<div class="container p-top">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-white p-3 shadow-sm rounded-1">
        <li class="breadcrumb-item"><a href="{{ route('site.home') }}"><i class="fas fa-home"></i></a></li>
        <li class="breadcrumb-item active" aria-current="page">Program</a></li>
      </ol>
    </nav>
</div>
<section>
    <div class="container">
        <ul class="nav nav-pills nav-justified mb-3 bg-white shadow-sm rounded-1 p-2" id="pills-tab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">BNSP</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Non BNSP</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false"><span class="d-none d-md-inline">Program</span>&nbsp;Prakerja</button>
          </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="row">
                    @if(count($program_bnsp)>0)
                    @foreach($program_bnsp as $data)
                    <div class="col-6 col-md-4 col-lg-3 mb-3">
                        <div class="card border-0 shadow-sm rounded-1" 
                            data-bs-toggle="tooltip"
                            data-bs-placement="bottom"
                            title="{{$data->program_title}}">
                            <a href="{{ route('site.program.detail', ['permalink' => $data->program_permalink]) }}" class="card-link">
                                <img src="{{ image('assets/images/program/'.$data->program_gambar, 'program') }}" class="card-img-top rounded-1" alt="thumbnail">
                            </a>
                            <div class="card-img-overlay h-fit w-fit">
                                <p class="card-title bg-theme-1 text-white py-1 px-2 w-fit rounded">{{$data->kategori}}</p>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-12 text-truncate">
                                        {{$data->program_title}}
                                    </div>
                                </div>
                                <a href="{{ route('site.program.detail', ['permalink' => $data->program_permalink]) }}" class="btn btn-theme-1 w-100">Detail</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="text-center my-5">
                        <img src="{{asset('assets/images/others/cloud-network.svg')}}" width="150">
                        <h3>Oh tidak! Data Belum Tersedia</h3>
                        <p>Data ini akan kami sediakan secepat kilat</p>
                    </div>
                    @endif
                </div>
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <div class="row">
                    @if(count($program_nonbnsp)>0)
                    @foreach($program_nonbnsp as $data)
                    <div class="col-6 col-md-4 col-lg-3 mb-3">
                        <div class="card border-0 shadow-sm rounded-1" 
                            data-bs-toggle="tooltip"
                            data-bs-placement="bottom"
                            title="{{$data->program_title}}">
                            <a href="{{ route('site.program.detail', ['permalink' => $data->program_permalink]) }}" class="card-link">
                                <img src="{{ image('assets/images/program/'.$data->program_gambar, 'program') }}" class="card-img-top rounded-1" alt="thumbnail">
                            </a>
                            <div class="card-img-overlay h-fit w-fit">
                                <p class="card-title bg-theme-1 text-white py-1 px-2 w-fit rounded">{{$data->kategori}}</p>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-12 text-truncate">
                                        {{$data->program_title}}
                                    </div>
                                </div>
                                <a href="{{ route('site.program.detail', ['permalink' => $data->program_permalink]) }}" class="btn btn-theme-1 w-100">Detail</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="text-center my-5">
                        <img src="{{asset('assets/images/others/cloud-network.svg')}}" width="150">
                        <h3>Oh tidak! Data Belum Tersedia</h3>
                        <p>Data ini akan kami sediakan secepat kilat</p>
                    </div>
                    @endif
                </div>
            </div>
            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                <div class="row">
                    <div class="col-6 col-md-4 col-lg-3 mb-3">
                    </div>
                    <div class="text-center my-5">
                        <img src="{{asset('assets/images/others/coming-soon.svg')}}" width="150">
                        <h3>Segera Hadir</h3>
                        <p>Program ini akan segera hadir</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection