<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
  <div class="container py-lg-2">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand me-0 me-lg-3" href="{{ route('site.home') }}">
      <img src="{{ asset('assets/images/logo/'.setting('site.logo')) }}" width="170" alt="logo">
    </a>
    @if(Auth::guest())
    <div class="nav-item d-lg-none">
        <a class="nav-link text-muted fs-5 ps-0" href="{{ route('auth.login', ['ref' => isset($_GET) && isset($_GET['ref']) ? $_GET['ref'] : null]) }}"><i class="fas fa-sign-in-alt"></i></a>
    </div>
    @else
    <div class="nav-item dropdown dropdown-mobile d-block d-lg-none megamenu-li">
      <a class="nav-link dropdown-toggle" href="#" style="text-decoration: none;color:black" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        {{ Auth::user()->nama_user }} 
        <img src="{{ image('assets/images/users/'.Auth::user()->foto, 'user') }}" alt="user" class="rounded-circle" width="30">
      </a>
      <ul class="dropdown-menu dropdown-menu-end megamenu" aria-labelledby="navbarDropdown">
        <li><a class="dropdown-item" href="{{Auth::user()->is_admin==1? route('admin.dashboard') : route('member.dashboard')}}" target="_blank">Dashboard</a></li>
        <li><a class="dropdown-item" href="{{Auth::user()->is_admin==1? route('admin.profile') : route('member.profile')}}">Profil</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('form-logout').submit();">Keluar</a></li>
        <form id="form-logout" method="post" action="{{Auth::user()->is_admin==1? route('admin.logout') : route('member.logout')}}">
              {{ csrf_field() }}
        </form>
      </ul>
    </div>
    @endif
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    {{-- <form class="w-100 me-2 mt-3 mt-lg-0" method="get" action="{{ route('site.search') }}">
      <div class="input-group search-bar">
        <input type="text" class="form-control border-end-0" placeholder="Pencarian" name="q" value="{{ isset($_GET) && isset($_GET['q']) ? $_GET['q'] : '' }}" required>
        <button class="input-group-text bg-transparent border-start-0" type="submit"><i class="fas fa-search color-theme-1"></i></button>
      </div>
    </form> --}}
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 ">
        <li class="nav-item align-items-center">
          <a class="nav-link fw-bold {{ Request::path()=='/' ? 'active' : '' }}" href="/">Beranda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fw-bold {{ is_int(strpos(Request::url(), route('site.program.index'))) ? 'active' : '' }}" href="{{ route('site.program.index') }}">Program</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fw-bold {{ is_int(strpos(Request::url(), route('site.acara.index'))) ? 'active' : '' }}" href="{{ route('site.acara.index') }}">Acara</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fw-bold {{ is_int(strpos(Request::url(), route('site.mentor.index'))) ? 'active' : '' }}" href="{{ route('site.mentor.index') }}">Mentor</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fw-bold {{ is_int(strpos(Request::url(), route('site.halaman.detail', ['permalink' => 'tentang-kami']))) ? 'active' : '' }}" href="{{ route('site.halaman.detail', ['permalink' => 'tentang-kami']) }}">Tentang&nbsp;Kami</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fw-bold {{ is_int(strpos(Request::url(), route('site.artikel.index'))) ? 'active' : '' }}" href="{{ route('site.artikel.index') }}">Artikel</a>
        </li>
      </ul>
        @if(Auth::guest())
        <div class="nav-item mt-2" style="margin-left:20px">
            <a style="border: #000E38 1px solid;color:#000E38" class="btn btn-light px-3 rounded-3" href="{{ route('auth.login', ['ref' => isset($_GET) && isset($_GET['ref']) ? $_GET['ref'] : null]) }}">LOGIN</a>
			            <a class="btn btn-theme-1 px-3 rounded-3" href="{{ route('auth.register', ['ref' => isset($_GET) && isset($_GET['ref']) ? $_GET['ref'] : null]) }}">DAFTAR SEKARANG</a>
        </div>
        @else
        <div class="nav-item dropdown d-none dropdown-mobile d-lg-block" style="margin-left:10px">
          <a class="nav-link dropdown-toggle" href="#" style="text-decoration: none;color:black" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{ Auth::user()->nama_user }} 
            <img src="{{ image('assets/images/users/'.Auth::user()->foto, 'user') }}" alt="user" class="rounded-circle" width="25">
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="{{Auth::user()->is_admin==1? route('admin.dashboard') : route('member.dashboard')}}" target="_blank">Dashboard</a></li>
            <li><a class="dropdown-item" href="{{Auth::user()->is_admin==1? route('admin.profile') : route('member.profile')}}">Profil</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('form-logout').submit();">Keluar</a></li>
            <form id="form-logout" method="post" action="{{Auth::user()->is_admin==1? route('admin.logout') : route('member.logout')}}">
                  {{ csrf_field() }}
            </form>
          </ul>
        </div>
        @endif
      
    </div>
  </div>
</nav>