@extends('template.main')

@section('title', 'Acara | ')

@section('content')

<div class="container mt-5">
	<nav aria-label="breadcrumb">
	  <ol class="breadcrumb bg-white p-3 shadow-sm rounded-1">
	    <li class="breadcrumb-item"><a href="{{ route('site.home') }}"><i class="fas fa-home"></i></a></li>
	    <li class="breadcrumb-item active" aria-current="page">Acara</a></li>
	  </ol>
	</nav>
</div>
<section>
	<div class="container mt-5 mb-5">
        <div class="row">
            @foreach($gallery as $gs)
            <div class="col-6 col-md-4 mb-3 g-2">
				<div class="card border-0 shadow-sm rounded-1">
                    <img class="img-fluid rounded" src="{{ file_exists(public_path('assets/images/dokumentasi/' . $gs->gambar)) ? asset('assets/images/dokumentasi/' . $gs->gambar) : asset('assets/images/default/program.png') }}" alt="{{ $gs->judul_gambar }}">
           		</div>
           	</div>
            @endforeach
        </div>
        
        <nav class="acara-pagination justify-content-center d-flex">
            {!! $gallery->links() !!}
        </nav>
	</div>
</section>

@endsection

@section('css-extra')

@endsection