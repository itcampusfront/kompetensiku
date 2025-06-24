@extends('layout.main')

@section('title', 'Pencarian | ')

@section('content')

<section class="section-search mt-3">
    <div class="container">
        <div class="card">
            <div class="card-body text-center">
                Menampilkan pencarian dengan kata kunci <strong>{{ isset($_GET) && isset($_GET['q']) ? $_GET['q'] : '' }}</strong>.
            </div>
        </div>
    </div>
</section>
<section class="container mt-3" id="section-kategori">
<!--     <div class="heading mb-3">
        <h5>Program</h5>
    </div> -->
    <div class="row">
        @if(count($program)>0)
        @foreach($program as $data)
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
        <div class="d-flex justify-content-center">{!! $program->appends(['q' => $_GET['q'], 'k' => 'kategori'])->links() !!}</div>
    </div>
</section>

@endsection
