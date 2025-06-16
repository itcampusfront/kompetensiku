@extends('template.main')

@section('meta_description', 'Kompetensiku – Platform pelatihan & sertifikasi SDM, teknologi, bisnis, keuangan, dan spiritual. Dapatkan materi berkualitas, fasilitator berpengalaman, dan program BNSP—online maupun tatap muka—dengan harga terjangkau. Hubungi WhatsApp 0816343741')

@section('content')
<section class="section-carousel">
	<div class="container pb-3 pt-0 pt-md-3 px-0 px-lg-auto">
		<div id="carouselExampleDark" class="carousel slide" data-bs-ride="carousel">
		  <div class="carousel-indicators">
		  	@foreach($slider as $key => $data)
		    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="{{$key}}" class="{{$key == 0 ? 'active' : '' }}" aria-current="{{$key == 0 ? 'true' : '' }}" aria-label="Slide {{$key}}"></button>
		    @endforeach
		  </div>
		  <div class="carousel-inner rounded-0 rounded-md-1 shadow-sm">
		  	@foreach($slider as $key => $data)
		    <div class="carousel-item {{$key == 0 ? 'active' : '' }}" data-bs-interval="10000">
		    <!-- <a href="{{$data->slider_url}}"> -->
		      <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" class="d-block" alt="carousel"
		      	style="background-image: url({{ asset('assets/images/slider/'.$data->slider) }}); background-size: cover; background-repeat: no-repeat; width: 100%; height: 400px">
		      <div class="carousel-caption d-flex align-items-center justify-content-center">
		      	@if($key == 0)
		      	<div class="content mx-md-5 px-md-5">
		      		<div class="mb-3 w-100 text-center d-flex justify-content-center">
		      			<div class="w-fit">
			      			<h2 class="text-capitalize">bisnis adalah tentang membangun SDM</h2>
			      			<p class="text-capitalize">mengapa kita perlu mengembangkan SDM untuk menumbuhkan bisnis?</p>
			      			<hr>
			      			<p class="text-capitalize">daftar sekarang untuk mengetahui jawabanya</p>
			      			<a href="{{ route('auth.register') }}" class="btn btn-light">Daftar Sekarang</a>
			      		</div>
		      		</div>
			    </div>
		      	@endif
		      	@if($key == 1)
		      	<div class="content mx-md-5 px-md-5">
		      		<div class="mb-3 w-100 text-center d-flex justify-content-center">
		      			<div class="w-fit">
			      			<h2>Kompetensiku</h2>
			      			<hr>
			      		</div>
		      		</div>
			        <div class="row text-center">
			        	<div class="col-md-6"><i class="fas fa-check"></i> Materi Berkualitas</div>
			        	<div class="col-md-6"><i class="fas fa-check"></i> Berbasis Kompetensi</div>
			        	<div class="col-md-6"><i class="fas fa-check"></i> Bersertifikat BNSP</div>
			        	<div class="col-md-6"><i class="fas fa-check"></i> Distance Learning</div>
			        	<div class="col-md-6"><i class="fas fa-check"></i> E-Learning Program</div>
			        	<div class="col-md-6"><i class="fas fa-check"></i> Pelatihan Tatap Muka</div>
			        	<div class="col-md-6"><i class="fas fa-check"></i> Paket Uji Kompetensi</div>
			        	<div class="col-md-6"><i class="fas fa-check"></i> Harga Terjangkau</div>
			        </div>
			    </div>
		      	@endif
		      </div>
		  	<!-- </a> -->
		    </div>
		    @endforeach
		  </div>
		  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
		    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
		    <span class="visually-hidden">Previous</span>
		  </button>
		  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
		    <span class="carousel-control-next-icon" aria-hidden="true"></span>
		    <span class="visually-hidden">Next</span>
		  </button>
		</div>
	</div>
</section>
<section class="section-intro">
	<div class="container my-5">
		<div class="row">
			<div class="content-intro col-6 col-md-4 col-lg-3 mb-3">
				<div class="wrap-img bg-white rounded-1 shadow-sm p-3 mb-3 mx-auto w-fit">
					<img width="50" src="{{asset('assets/images/others/role-model.svg')}}">
				</div>
				<div class="caption text-center">
					<h5>Fasilitator Handal</h5>
					<p>Fasilitator merupakan praktisi yang telah berpengalaman dibidangnya</p>
				</div>
			</div>
			<div class="content-intro col-6 col-md-4 col-lg-3 mb-3">
				<div class="wrap-img bg-white rounded-1 shadow-sm p-3 mb-3 mx-auto w-fit">
					<img width="50" src="{{asset('assets/images/others/homework.svg')}}">
				</div>
				<div class="caption text-center">
					<h5>Materi Relevan</h5>
					<p>Materi terstandarisasi oleh Badan Nasional Sertifikasi Profesi (BNSP)</p>
				</div>
			</div>
			<div class="content-intro col-6 col-md-4 col-lg-3 mb-3">
				<div class="wrap-img bg-white rounded-1 shadow-sm p-3 mb-3 mx-auto w-fit">
					<img width="50" src="{{asset('assets/images/others/tutorial.svg')}}">
				</div>
				<div class="caption text-center">
					<h5>Mudah Diakses</h5>
					<p>Pelatihan yang mudah diakses kapan saja dan dimana saja</p>
				</div>
			</div>
			<div class="content-intro col-6 col-md-4 col-lg-3 mb-3">
				<div class="wrap-img bg-white rounded-1 shadow-sm p-3 mb-3 mx-auto w-fit">
					<img width="50" src="{{asset('assets/images/others/struggle.svg')}}">
				</div>
				<div class="caption text-center">
					<h5>Investasi Terjangkau</h5>
					<p>Materi lengkap dengan harga yang terjangkau</p>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="section-program">
	<div class="container my-5">
		<div class="heading mb-3">
			<h2>Program</h2>
			<div id="typed-strings">
				<p>Program Pelatihan dan Sertifikasi <span class="fw-bold">Profesi Kepelatihan</span></p>
				<p>Program Pelatihan dan Sertifikasi <span class="fw-bold">Praktisi Sumber Daya Manusia</span></p>
				<p>Program Pelatihan dan Sertifikasi <span class="fw-bold">Profesi UMKM</span></p>
				<p>Program Pelatihan dan Sertifikasi <span class="fw-bold">Profesi Profesi Teknologi Digital</span></p>
			</div>
			<span id="typed"></span>
		</div>
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
                        <small class="card-title bg-theme-1 text-white py-1 px-2 w-fit rounded">{{$data->kategori}}</small>
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
		<div class="text-center mt-3">
			<a href="{{ route('site.program.index') }}" class="btn btn-theme-1 px-4">Lihat Lainnya</a>
		</div>
	</div>
</section>
@if(isset($g))
<section>
	<div class="container">
		<div class="heading d-flex align-items-center justify-content-between">
			<h2>Cek Kegiatan Kami</h2>
			<a href="{{ route('site.halaman.gallery') }}" class="btn btn-theme-1"> Semua Kegiatan</a>
		</div>
		<div class="row align-items-center justify-content-center">
			@foreach ($g as $gs)
				<div class="col-12 col-sm-6 col-md-4 g-1">
					<div class="card">
						<div class="card-body">
							<img class="img-fluid rounded" src="{{ file_exists(public_path('assets/images/dokumentasi/' . $gs->gambar)) ? asset('assets/images/dokumentasi/' . $gs->gambar) : asset('assets/images/default/program.png') }}" alt="{{ $gs->judul_gambar }}">
							<h5 class="text-center mt-2">{{ $gs->judul_gambar }}</h5>
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>
</section>
@endif
<section class="section-partner">
	<div class="container my-5">
		<div class="heading">
			<h2>Mitra</h3>
			<p>Mitra Kami</p>
		</div>
		<div class="card border-0 shadow-sm rounded-1">
			<div class="card-body">
				<div class="row align-items-center justify-content-center">
					@foreach($mitra as $data)
					<div class="col-4 col-md-3 col-lg-2 mb-3 mb-lg-0 mt-3 mt-lg-0">
		                <div class="text-center">
		                    <img src="{{ asset('assets/images/mitra/'.$data->logo_mitra) }}" width="100" alt="mitra">
		                </div>
					</div>
		            @endforeach
	        	</div>
	        </div>
		</div>
	</div>
</section>
<section class="section-artikel">
	<div class="container my-5">
		<div class="heading">
			<h2>Artikel</h2>
		</div>
        <div class="row">
        	@if(count($artikel)>0)
			@foreach($artikel as $data)
            <div class="col-6 col-md-4 col-lg-3 mb-3 d-flex align-items-stretch">
				<div class="card border-0 shadow-sm rounded-1">
                    <a href="/artikel/{{ $data->blog_permalink }}">
                        <img class="card-img-top rounded-1" src="{{ image('assets/images/blog/'.$data->blog_gambar, 'blog') }}" alt="thumbnail">
                    </a>
                	<div class="card-body">
                        <div class="row mb-2">
                            <div class="col-12 text-truncate">
			                    <a class="text-decoration-none text-body" href="/artikel/{{ $data->blog_permalink }}">
			                        <span>{{ $data->blog_title }}</span>
			                    </a>
                            </div>
                        </div>
	                </div>
                    <div class="card-footer bg-transparent mx-3 px-0 text-muted d-flex justify-content-between align-items-center">
                        <span><i class="fa fa-calendar"></i> {{ date('d/m/Y', strtotime($data->blog_at)) }}</span>
                        <span><i class="fa fa-comments"></i> {{ count_komentar($data->id_blog) }}</span>
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
</section>
<section class="bg-white">
    <div class="container py-5 rounded-1">
        <div class="row align-items-center">
        	<!-- <div class="col-6 col-md-auto col-lg-auto mb-3 mb-lg-0 text-center text-lg-start order-2 order-md-1">
        		<img src="{{asset('assets/images/icons/987628.svg')}}" width="100">
        	</div> -->
            <div class="col-12 col-md col-lg mb-3 mb-lg-0 text-center text-lg-center order-3 order-md-2">
                <h3 class="mb-3">Siap menjadi kompeten bersama Kami?</h3>
                <a href="https://wa.me/{{ setting('site.whatsapp') }}" class="btn btn-theme-1 btn-lg" target="_blank">Hubungi Kami</a>
            </div>
            <!-- <div class="col-6 col-md-auto col-lg-auto mb-3 mb-lg-0 text-center text-lg-end order-1 order-md-3">
            	<img src="{{asset('assets/images/icons/987611.svg')}}" width="100">
            </div> -->
        </div>
    </div>
</section>
@endsection
@section('js-extra')
<script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
<script type="text/javascript" src="{{asset('assets/js/app.js')}}"></script>
<script>
  var typed = new Typed('#typed', {
    stringsElement: '#typed-strings',
    loop: true,
    typeSpeed: 10,
    smartBackspace: true,
  });
</script>
@endsection