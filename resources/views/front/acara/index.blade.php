@extends('layout.main')

@section('title', 'Acara | ')

@section('content')

    <div class="container p-top">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white p-3 shadow-sm rounded-1">
                <li class="breadcrumb-item"><a href="{{ route('site.home') }}"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Acara</a></li>
            </ol>
        </nav>
    </div>
    <section>
        <div class="container mb-2">
            <div class="row">
                @foreach ($acara as $data)
                    <div class="col-12 custom-col-430 col-sm-6 col-md-4 col-lg-3 mb-3 d-flex align-items-stretch p-0">
                        <div class="card p-1 border-0 shadow-sm rounded-1 w-100">
                            <a href="{{ route('site.acara.detail', ['permalink' => $data->id_acara]) }}">
                                <img class="card-img-top rounded-1" style="height: 200px; width: 100%; object-fit: cover;"
                                    src="{{ image('assets/images/acara/' . $data->gambar_acara, 'acara') }}" alt="thumbnail">
                            </a>
                            <div class="card-body">
                                <a class="text-decoration-none text-body"
                                    href="{{ route('site.acara.detail', ['permalink' => $data->id_acara]) }}">
                                    <span>{{ $data->nama_acara }}</span>
                                </a>
                            </div>
                            <div
                                class="card-footer bg-transparent mx-3 px-0 text-muted d-flex justify-content-between align-items-center">
                                <span><i class="fa fa-calendar"></i>
                                    {{ date('d/m/Y', strtotime($data->tanggal_acara_from)) }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <nav class="acara-pagination justify-content-center d-flex">
                {!! $acara->links() !!}
            </nav>
        </div>
    </section>

@endsection

@section('css-extra')

@endsection
