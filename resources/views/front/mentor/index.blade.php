@extends('layout.main')

@section('title', 'Mentor | ')

@section('content')

    <div class="container p-top">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white p-3 shadow-sm rounded-1">
                <li class="breadcrumb-item"><a href="{{ route('site.home') }}"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Mentor</a></li>
            </ol>
        </nav>
    </div>
    <section>
        <div class="container">
            <div class="row">
                @foreach ($mentor as $data)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3 d-flex align-items-stretch">
                        <div class="card border-0 shadow-sm rounded-1 w-100">
                            @php
                                $fotoMentor =
                                    isset($data) &&
                                    $data->foto_mentor &&
                                    file_exists(public_path('assets/images/mentor/' . $data->foto_mentor))
                                        ? asset('assets/images/mentor/' . $data->foto_mentor)
                                        : asset('assets/images/default/mentor.jpg');
                            @endphp

                            <img class="card-img-top" src="{{ $fotoMentor }}" style="height: 300px;width:auto">
                            <div class="card-body">
                                <h5>{{ $data->nama_mentor }}</h5>
                                <p>{{ $data->profesi_mentor }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
