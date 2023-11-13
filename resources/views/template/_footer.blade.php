<footer class="footer bg-theme-1 text-light py-5">
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12 col-lg-4">
                <a href="#">
                    <img class="mb-3" src="{{ asset('assets/images/logo/'.setting('site.logo')) }}" width="200" alt="logo" style="filter: brightness(0) invert(1);">
                </a>
                <p class="text-justify">{{ setting('site.name') }} adalah platform pembelajaran untuk pengembangan SDM, teknologi, bisnis, keuangan dan spiritual.</p>
            </div>
            <div class="col-md-6 col-lg-2">
                <h5>Menu</h5>
                <ul class="list-unstyled">
                    <li><a class="link-secondary text-decoration-none" href="{{ route('site.halaman.detail', ['permalink' => 'tentang-kami']) }}">Tentang Kami</a></li>
                    <li><a class="link-secondary text-decoration-none" href="{{ route('site.artikel.index') }}">Artikel</a></li>
                    <li><a class="link-secondary text-decoration-none" href="{{ route('site.acara.index') }}">Acara</a></li>
                </ul>
            </div>
            <div class="col-md-6 col-lg-2">
                <h5>Kategori</h5>
                <ul class="list-unstyled">
				    @foreach(array_kategori_artikel() as $kategori_artikel)
                        <li><a class="link-secondary text-decoration-none" href="{{ route('site.artikel.category', ['category' => $kategori_artikel->slug]) }}">{{ $kategori_artikel->kategori }}</a></li>
				    @endforeach
                </ul>
            </div>
            <div class="col-md-6 col-lg-4">
                <h5>Hubungi Kami</h5>
                <ul class="list-unstyled">
                    <li><i class="fa fa-map-marker position-absolute pt-1"></i><span class="ms-4">{{ setting('site.address') }}</span></li>
                    <li><i class="fab fa-whatsapp position-absolute pt-1"></i><span class="ms-4">{{ setting('site.whatsapp') }}</span></li>
                    <li><i class="fab fa-instagram position-absolute pt-1"></i><span class="ms-4">{{ setting('site.medsos.instagram') }}</span></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container pt-5">
        <hr>
        <p class="m-0">Copyright &copy;<script>document.write(new Date().getFullYear());</script> {{ setting('site.name') }}. All rights reserved</p>
    </div>
</footer>