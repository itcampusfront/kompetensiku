@extends('layout.main')

@section('title', 'Kategori: '.$kategori->kategori.' | ')

@section('content')

<div class="container p-top">
	<nav aria-label="breadcrumb">
	  <ol class="breadcrumb bg-white p-3 shadow-sm rounded-1">
        <li class="breadcrumb-item"><a href="{{ route('site.home') }}"><i class="fas fa-home"></i></a></li>
	    <li class="breadcrumb-item"><a href="{{ route('site.artikel.index') }}">Artikel</a></li>
        <li class="breadcrumb-item active" aria-current="page">Kategori</a></li>
	    <li class="breadcrumb-item active" aria-current="page">{{ $kategori->kategori }}</a></li>
	  </ol>
	</nav>
</div>
<section>
	<div class="container mb-2">
        <div class="row">
            @foreach($artikel as $data)
             @include('layout.komponen.card_artikel', ['data' => $data])
            @endforeach
        </div>
        
        <nav class="blog-pagination justify-content-center d-flex">
            {!! $artikel->links() !!}
        </nav>
	</div>
</section>

@endsection

@section('css-extra')

@endsection