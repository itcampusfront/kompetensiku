  <nav class="navbar navbar-expand-lg shadow-sm py-3">
      <div class="container-lg">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
              <span class="navbar-toggler-icon"></span>
          </button>
          <a class="navbar-brand fw-bold text-primary" href="/">
              <img src="{{ asset('assets/images/logo/' . setting('site.logo')) }}" alt="Logo Kompetensiku"
                  width="150" />
          </a>
          @if (Auth::guest())
              <div class="nav-item d-lg-none">
                  <a class="nav-link text-muted fs-5 ps-0"
                      href="{{ route('auth.login', ['ref' => isset($_GET) && isset($_GET['ref']) ? $_GET['ref'] : null]) }}"><i
                          class="fas fa-sign-in-alt"></i></a>
              </div>
          @else
              <div class="nav-item dropdown dropdown-mobile d-block d-lg-none megamenu-li">
                  <a class="nav-link dropdown-toggle" href="#" style="text-decoration: none;color:black"
                      id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      {{ Auth::user()->nama_user }}
                      <img src="{{ image('assets/images/users/' . Auth::user()->foto, 'user') }}" alt="user"
                          class="rounded-circle" width="30">
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end megamenu" aria-labelledby="navbarDropdown">
                      <li><a class="dropdown-item"
                              href="{{ Auth::user()->is_admin == 1 ? route('admin.dashboard') : route('member.dashboard') }}"
                              target="_blank">Dashboard</a></li>
                      <li><a class="dropdown-item"
                              href="{{ Auth::user()->is_admin == 1 ? route('admin.profile') : route('member.profile') }}">Profil</a>
                      </li>
                      <li>
                          <hr class="dropdown-divider">
                      </li>
                      <li><a class="dropdown-item" href="javascript:void(0)"
                              onclick="event.preventDefault(); document.getElementById('form-logout').submit();">Keluar</a>
                      </li>
                      <form id="form-logout" method="post"
                          action="{{ Auth::user()->is_admin == 1 ? route('admin.logout') : route('member.logout') }}">
                          {{ csrf_field() }}
                      </form>
                  </ul>
              </div>
          @endif
          <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
              <ul class="navbar-nav">
                  <li class="nav-item"><a class="nav-link {{ Request::path() == '/' ? 'active-link' : '' }}"
                          href="/">Beranda</a></li>
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle {{ is_int(strpos(Request::url(), route('site.halaman.detail', ['permalink' => 'tentang-kami']))) ||
                      is_int(strpos(Request::url(), route('site.halaman.gallery')))
                          ? 'active-link'
                          : '' }}"
                          href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                          aria-expanded="false">
                          Tentang Kami
                      </a>
                      <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                          <li>
                              <a class="dropdown-item {{ is_int(strpos(Request::url(), route('site.halaman.detail', ['permalink' => 'tentang-kami']))) ? 'active' : '' }}"
                                  href="{{ route('site.halaman.detail', ['permalink' => 'tentang-kami']) }}">
                                  Tentang Kami
                              </a>
                          </li>
                          <li>
                              <a class="dropdown-item {{ is_int(strpos(Request::url(), route('site.halaman.gallery'))) ? 'active' : '' }}"
                                  href="{{ route('site.halaman.gallery') }}">
                                  Galeri
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item"><a
                          class="nav-link {{ is_int(strpos(Request::url(), route('site.program.index'))) ? 'active-link' : '' }}"
                          href="{{ route('site.program.index') }}">Program</a></li>
                  <li class="nav-item"><a
                          class="nav-link {{ is_int(strpos(Request::url(), route('site.artikel.index'))) ? 'active-link' : '' }}"
                          href="{{ route('site.artikel.index') }}">Artikel</a></li>
                  <li class="nav-item"><a
                          class="nav-link {{ is_int(strpos(Request::url(), route('site.mentor.index'))) ? 'active-link' : '' }}"
                          href="{{ route('site.mentor.index') }}">Mentor</a></li>
                  <li class="nav-item"><a
                          class="nav-link {{ is_int(strpos(Request::url(), route('site.acara.index'))) ? 'active-link' : '' }}"
                          href="{{ route('site.acara.index') }}">Acara</a></li>
              </ul>
              <div class="d-flex gap-2 mt-3 mt-lg-0">
                  @if (Auth::guest())
                      <a href="{{ route('auth.login', ['ref' => isset($_GET) && isset($_GET['ref']) ? $_GET['ref'] : null]) }}"
                          class="fw-bold btn btn-custom-120 btn-main-1">MASUK</a>
                      <a href="{{ route('auth.register', ['ref' => isset($_GET) && isset($_GET['ref']) ? $_GET['ref'] : null]) }}"
                          class="fw-bold btn btn-custom-120 btn-main-2">DAFTAR</a>
                  @else
                      <div class="nav-item dropdown d-none dropdown-mobile d-lg-block" style="margin-left:10px">
                          <a class="nav-link dropdown-toggle p-2 no-decoration text-orange bg-white rounded-3"
                              href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                              aria-expanded="false">
                              {{ Auth::user()->nama_user }}
                              <img src="{{ image('assets/images/users/' . Auth::user()->foto, 'user') }}"
                                  alt="user" class="rounded-circle" width="25">
                          </a>
                          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                              <li><a class="dropdown-item"
                                      href="{{ Auth::user()->is_admin == 1 ? route('admin.dashboard') : route('member.dashboard') }}"
                                      target="_blank">Dashboard</a></li>
                              <li><a class="dropdown-item"
                                      href="{{ Auth::user()->is_admin == 1 ? route('admin.profile') : route('member.profile') }}">Profil</a>
                              </li>
                              <li>
                                  <hr class="dropdown-divider">
                              </li>
                              <li><a class="dropdown-item" href="javascript:void(0)"
                                      onclick="event.preventDefault(); document.getElementById('form-logout').submit();">Keluar</a>
                              </li>
                              <form id="form-logout" method="post"
                                  action="{{ Auth::user()->is_admin == 1 ? route('admin.logout') : route('member.logout') }}">
                                  {{ csrf_field() }}
                              </form>
                          </ul>
                      </div>
                  @endif
              </div>
          </div>
      </div>
  </nav>
