  <footer class="bg-main text-white pt-5 pb-3">
      <div class="container-lg">
          <div class="row">
              <!-- Kolom 1: Deskripsi -->
              <div class="col-md-4 mb-4 paragrap">
                  <h5 class="fw-bold">KOMPETENSIKU</h5>
                  <p>
                      Kompetensiku hadir sebagai platform unggulan pembelajaran dan sertifikasi yang berfokus pada
                      pengembangan
                      SDM, teknologi, bisnis, keuangan, dan spiritual. Kami meyakini bahwa business is built on
                      competent human
                      resources—ketika SDM berkembang, bisnis pun tumbuh.
                  </p>
                  <div class="d-flex gap-3">
                      @php $wa = "https://api.whatsapp.com/send/?phone=".setting('site.whatsapp')."&text&type=phone_number&app_absent=0"  @endphp
                      <a target="__blank" href="{{ $wa }}"><img
                              src="{{ asset('assets/new_assets/logos_whatsapp-icon.png') }}" alt="WhatsApp"
                              width="24"></a>
                      <a href="#"><img src="{{ asset('assets/new_assets/skill-icons_instagram.png') }}"
                              alt="Instagram" width="24"></a>
                      <a href="#"><img src="{{ asset('assets/new_assets/devicon_facebook.png') }}" alt="Facebook"
                              width="24"></a>
                  </div>
              </div>

              <!-- Kolom 2: Kategori Artikel -->
              <div class="col-md-2 mb-4">
                  <h6 class="fw-bold">KATEGORI ARTIKEL</h6>
                  <ul class="list-unstyled">
                      @foreach (array_kategori_artikel() as $category)
                          <li><a target="__blank"
                                  href="{{ route('site.artikel.category', ['category' => $category->slug]) }}"
                                  class="text-white text-decoration-none">{{ $category->kategori }}</a>
                          </li>
                      @endforeach
                  </ul>
              </div>

              <!-- Kolom 3: Temukan Kami -->
              <div class="col-md-6 mb-4">
                  <h6 class="fw-bold">TEMUKAN KAMI</h6>
                  <p><i class="fa fa-map-marker" aria-hidden="true"></i> {{ setting('site.address') }}</p>

                  <iframe
                      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.7511531449627!2d110.45863817574087!3d-7.038505268964127!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e70894e88615ef1%3A0x40991ad781fce8e9!2sCampus%20World!5e0!3m2!1sid!2sid!4v1750736272560!5m2!1sid!2sid"
                      allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
              </div>
          </div>

          <!-- Garis Horizontal -->
          <hr class="border-light">

          <!-- Copyright -->
          <div class="text-center small">
              Copyright ©2025 Kompetensiku. All rights reserved
          </div>
      </div>
  </footer>
