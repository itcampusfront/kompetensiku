@extends('layout.main')
@section('title','Pelatihan dan Sertifikasi SDM Terpercaya di Semarang')
@section('meta_description', 'Pelatihan dan Sertifikasi SDM Terpercaya Semarang, Praktisi SDM, Kompetensi SDM semarang')

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-overlay"></div>
        <div class="container-lg hero-content">
            <div class="row">
                <div class="col-12 col-md-6" style="padding-right: 10px;">
                    <h1 class=" main-tag text-orange">Tingkatkan Kompetensi Dengan <br>Pelatihan dan Sertifikasi SDM
                        Terpercaya di
                        Semarang</h1>
                    <p class="mt-3 sub-tag">Program Pelatihan dan Sertifikasi SDM terpercaya bersama fasilitator profesional
                        dan
                        Praktisi SDM lokal siap mendukung pengembangan kinerja organisasi Anda.</p>
                    <div class="button">
                        @php $wa = "https://api.whatsapp.com/send/?phone=".setting('site.whatsapp')."&text&type=phone_number&app_absent=0"  @endphp                       
                        <a href="{{ $wa }}" target="__blank" class="btn btn-dark">Hubungi Kami</a>
                        <a href="{{ setting('site.medsos.facebook') }}"><img src="{{ asset('assets/new_assets/devicon_facebook.png') }}" /></a>
                        <a href="{{ setting('site.medsos.instagram') }}"><img src="{{ asset('assets/new_assets/skill-icons_instagram.png') }}" /></a>
                    </div>
                    <div class="row text-center p-2 stats-group">
                        <div class="col-6 stats-item">
                            <p class="fw-bold stats-item-number text-orange">{{ $count_program }}</p>
                            <p class="fw-bold stats-item-ket">Program</p>
                        </div>
                        <div class="col-6  stats-item">
                            <p class="fw-bold stats-item-number text-orange">5000+</p>
                            <p class="fw-bold stats-item-ket">Alumni</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- about us -->
    <section class="about-content">
        <div class="container-lg hero-about">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ asset('assets/new_assets/about-us.png') }}" alt="about us" class="img-fluid img-about">
                </div>
                <div class="col-md-6">
                    <h2 class="text-orange">Tentang <span class="text-main fw-bold">Kompetensiku</span></h2>
                    <div class="paragrap">
                        <p class="text-submain">Kompetensiku adalah platform pelatihan dan sertifikasi SDM berstandar BNSP
                            yang
                            hadir di Semarang. Kami fokus membantu individu dan organisasi meningkatkan kompetensi melalui
                            pelatihan
                            yang relevan dan mudah diakses.</p>
                        <p class="text-submain">Program kami dipandu oleh praktisi SDM Terpercaya di Semarang yang
                            berpengalaman,
                            dengan metode pembelajaran online dan tatap muka. Materi pelatihan disusun sesuai kebutuhan
                            industri dan
                            mengikuti standar resmi BNSP.</p>
                        <p class="text-submain">Kami menyediakan pelatihan untuk semua jenjang—dari staf, supervisor,
                            manajer,
                            hingga instruktur. Peserta berkesempatan mendapatkan Sertifikat Kompetensi resmi dari BNSP
                            sebagai
                            pengakuan atas keahliannya.</p>
                    </div>
                    <a href="{{ route('site.halaman.detail', ['permalink' => 'tentang-kami']) }}" target="__blank" class="fw-bold fs-6 text-orange">Selengkapnya...</a>
                </div>
            </div>
        </div>
    </section>
    <!-- layanan -->
    <section class="layanan-content">
        <div class="container-lg hero-layanan">
            <div class="row">
                <div class="col-12 text-center">
                    <h2 class="text-orange">Layanan <span class="text-main fw-bold">Kompetensiku</span></h2>
                    <div class="text-submain">
                        <p class="sub-layanan">Kami membantu Anda mencapai standar kompetensi terbaik melalui pelatihan,
                            asesmen,
                            dan pendampingan profesional dirancang untuk mendukung pengembangan SDM.</p>
                    </div>
                </div>
            </div>
            <div class="row  mt-5">
                <div class="col-12 col-sm-6 col-md-3 p-1 ">
                    <div class="card h-100 shadow-sm text-center p-1 border-0 rounded-4">
                        <div class="card-body">
                            <img src="{{ asset('assets/new_assets/layanan.png') }}" alt="Fasilitator Icon" width="50"
                                class="mb-3">
                            <h5 class="card-title text-dark">Materi Standar BNSP</h5>
                            <p class="card-text text-submain">
                                Pelatihan menggunakan kurikulum resmi sesuai standar BNSP dan SKKNI.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3 p-1 ">
                    <div class="card h-100 shadow-sm text-center p-1 border-0 rounded-4">
                        <div class="card-body">
                            <img src="{{ asset('assets/new_assets/layanan.png') }}" alt="Fasilitator Icon" width="50"
                                class="mb-3">
                            <h5 class="card-title text-dark">Pelaksanaan Fleksibel</h5>
                            <p class="card-text text-submain">
                                Pelatihan secara online atau langsung di lokasi Anda di Semarang.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3 p-1 ">
                    <div class="card h-100 shadow-sm text-center p-1 border-0 rounded-4">
                        <div class="card-body">
                            <img src="{{ asset('assets/new_assets/layanan.png') }}" alt="Fasilitator Icon" width="50"
                                class="mb-3">
                            <h5 class="card-title text-dark">Harga Terjangkau</h5>
                            <p class="card-text text-submain">
                                Harga terjangkau untuk UMKM, lembaga, hingga instansi pemerintahan.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3 p-1 ">
                    <div class="card h-100 shadow-sm text-center p-1 border-0 rounded-4">
                        <div class="card-body">
                            <img src="{{ asset('assets/new_assets/layanan.png') }}" alt="Fasilitator Icon" width="50"
                                class="mb-3">
                            <h5 class="card-title text-dark">Fasilitator Berpengalaman</h5>
                            <p class="card-text text-submain">
                                Dipandu oleh praktisi SDM yang ahli dan paham kebutuhan industri lokal.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- why us -->
    <section class="whyus-content">
        <div class="container-lg hero-whyus">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ asset('assets/new_assets/why-us-image.png') }}" alt="why us" class="img-fluid img-whyus">
                </div>
                <div class="col-md-6 d-flex align-items-center justify-content-start">
                    <div>
                        <h2 class="text-orange">Kenapa Memilih <span class="text-main fw-bold">Kompetensiku ?</span></h2>
                        <div class="list-whyus">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td><img src="{{ asset('assets/new_assets/bulletlist.png') }}" alt="why us"
                                                class="img-fluid img-whyus-icon"></td>
                                        <td>
                                            <h5 class="text-orange">Pelatihan Bersertifikat BNSP</h5>
                                            <p>Sertifikasi resmi yang diakui secara nasional untuk meningkatkan daya saing
                                                tenaga kerja.</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><img src="{{ asset('assets/new_assets/bulletlist.png') }}" alt="why us"
                                                class="img-fluid img-whyus-icon"></td>
                                        <td>
                                            <h5 class="text-orange">Biaya Terjangkau, Pelaksanaan Fleksibel</h5>
                                            <p>Pelatihan berkualitas tanpa membebani anggaran pengeluaran dengan waktu
                                                pelaksanaan yang fleksibel.</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><img src="{{ asset('assets/new_assets/bulletlist.png') }}" alt="why us"
                                                class="img-fluid img-whyus-icon"></td>
                                        <td>
                                            <h5 class="text-orange">Dukungan Konsultan SDM Berpengalaman</h5>
                                            <p>Dikerjakan oleh tim ahli yang memahami dinamika ketenagakerjaan dan
                                                pengembangan SDM di
                                                berbagai sektor industri.</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><img src="{{ asset('assets/new_assets/bulletlist.png') }}" alt="why us"
                                                class="img-fluid img-whyus-icon"></td>
                                        <td>
                                            <h5 class="text-orange">Mendukung Transformasi Digital HR</h5>
                                            <p>Mendorong efisiensi kerja HR melalui solusi digital, mulai dari pemetaan
                                                kompetensi hingga
                                                pelaporan berbasis data.</p>
                                        </td>
                                    </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="program-content">
        <div class="container-lg hero-program">
            <div class="program-title row mb-3">
                <div class="col-12 col-md-6 program-text ">
                    <h2 class="text-orange">Program <span class="text-main fw-bold">Kompetensiku</span></h2>
                    <p class="text-submain">Program kami membantu meningkatkan kompetensi SDM melalui pelatihan, asesmen,
                        dan
                        pendampingan yang sesuai kebutuhan industri.</p>
                </div>
                <div class="col-12 col-md-6 button-program">
                    <a href="{{ route('site.program.index') }}" target="__blank" class="btn btn-dark">Selengkapnya</a>
                </div>
            </div>
            <div class="row">
                @foreach ($program as $data)
                    <div class="col-12 col-custom-6 col-sm-6 col-md-3 p-1">
                        <div class="card shadow text-center p-2 border-0 rounded-1">
                            <div class="card-body p-0">
                                <a target="__blank" class="no-decoration" href="{{ route('site.program.detail', ['permalink' => $data->program_permalink]) }}">
                                    <img src="{{ image('assets/images/program/' . $data->program_gambar, 'program') }}"
                                        alt="Fasilitator Icon" class="card-img-top rounded-1 w-100">
                                    <p class="card-text text-main fw-bold my-3">
                                        {{ $data->program_title }}
                                    </p>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="layanan-content">
        <div class="container-lg hero-layanan">
            <div class="row">
                <div class="col-12 text-center">
                    <h2 class="text-orange">Mitra <span class="text-main fw-bold">Kompetensiku</span></h2>
                    <div class="text-submain">
                        <p class="sub-layanan">Kami bangga menjadi pilihan mitra terpercaya bagi berbagai institusi dan
                            profesional
                            dalam pelatihan dan sertifikasi SDM.</p>
                    </div>
                </div>
            </div>
            <div class="row mt-5 text-center">
                @foreach($mitra as $data)
                <div class="col-6 col-sm-2 p-1">
                    <div class="card shadow-sm text-center p-0 border-0 rounded-1">
                        <div class="card-body p-0">
                            <img src="{{ asset('assets/images/mitra/'.$data->logo_mitra) }}" alt="Fasilitator Icon" class="img-fluid">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="cta-section">
        <div class="container-lg hero-cta">
            <div class="row text-center">
                <div class="col-12 text-white">
                    <h3>Siap Tingkatkan Kompetensi Tim Anda?</h3>
                    <p>Optimalkan potensi SDM Anda dengan layanan pelatihan, asesmen, dan pendampingan berbasis data dari
                        Kompetensiku.
                        Bangun tim yang kompeten, adaptif, dan siap hadapi tantangan masa depan.</p>
                    <a href="https://api.whatsapp.com/send/?phone=62816343741&text&type=phone_number&app_absent=0" target="__blank" class="btn btn-custom-180 btn-main-1 fw-bold">HUBUNGI KAMI</a>
                </div>
            </div>
        </div>
    </section>

    <section class="artikel-content">
        <div class="container-lg hero-program">
            <div class="program-title row mb-3">
                <div class="col-12 col-md-6 program-text ">
                    <h2 class="text-orange fw-bold">Artikel Kompetensiku</h2>
                    <p class="text-submain">Temukan insight terbaru seputar pengembangan kompetensi, tren SDM, dan strategi
                        peningkatan kinerja di artikel-artikel pilihan kami.</p>
                </div>
                <div class="col-12 col-md-6 button-program">
                    <a href="{{ route('site.artikel.index') }}" target="__blank" class="btn btn-dark">Selengkapnya</a>
                </div>
            </div>
            <div class="row">
                @foreach ($artikel as $data)
                    <div class="col-12 col-custom-6 col-sm-6 col-md-3 p-1">
                        <div class="card shadow text-center p-2 border-0 rounded-1 h-100">
                            <div class="card-body p-0">
                                <a class="no-decoration" href="/artikel/{{ $data->blog_permalink }}" target="__blank">
                                    <img src="{{ image('assets/images/blog/' . $data->blog_gambar, 'blog') }}"
                                        alt="{{ $data->blog_title }}" class="img-fluid rounded-1 w-100 card-image">
                                    <p class="card-text text-main fw-bold my-2">
                                        {{ $data->blog_title }}
                                    </p>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
