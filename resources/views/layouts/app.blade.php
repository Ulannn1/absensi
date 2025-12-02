<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','Absensi PKL')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/theme.css">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg app-navbar shadow-sm py-2">
      <div class="container">
          <a class="navbar-brand d-flex align-items-center gap-2" href="/">
          <span class="rounded-3 bg-gradient p-2 d-inline-flex align-items-center justify-content-center" style="width:38px;height:38px">
            <i class="bi bi-journal-check text-white fs-5"></i>
          </span>
          <span class="brand ms-2">Absensi PKL</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav"
          aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="nav">
          <ul class="navbar-nav me-auto align-items-center">
            @auth
              @if(auth()->user()->role === 'admin')
                <li class="nav-item"><a class="nav-link text-muted" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-1"></i> Dashboard</a></li>
              @else
                <li class="nav-item"><a class="nav-link text-muted" href="{{ route('attendances.today') }}"><i class="bi bi-clock-history me-1"></i> Absensi</a></li>
                <li class="nav-item"><a class="nav-link text-muted" href="{{ route('attendances.index') }}"><i class="bi bi-clipboard-check me-1"></i> Riwayat</a></li>
              @endif
              <li class="nav-item"><a class="nav-link" href="{{ route('leave_requests.index') }}">Izin</a></li>
            @endauth
          </ul>

          <ul class="navbar-nav ms-auto align-items-center">
            @guest
              <li class="nav-item"><a class="btn btn-sm btn-outline-primary" href="{{ route('login') }}">Login</a></li>
            @else
              <li class="nav-item dropdown">
                <a class="nav-link d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <img src="{{ auth()->user()->photo ? asset('storage/'.auth()->user()->photo) : 'https://i.pravatar.cc/40' }}" class="profile-avatar">
                  <div class="d-none d-md-block text-end me-2">
                    <div class="fw-bold small mb-0">{{ auth()->user()->name }}</div>
                  </div>
                </a>
                {{-- Keep actions inside dropdown only (no always-visible buttons) --}}
                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                  <li><a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('profile.show') }}"><i class="bi bi-person-fill text-primary"></i> <span>Profil</span></a></li>
                  <li><hr class="dropdown-divider"/></li>
                  <li>
                    <form method="POST" action="{{ route('logout') }}">
                      @csrf
                      <button class="dropdown-item d-flex align-items-center gap-2 text-danger"><i class="bi bi-box-arrow-right"></i> <span>Keluar</span></button>
                    </form>
                  </li>
                </ul>
              </li>
            @endguest
          </ul>
        </div>
      </div>
    </nav>

    <main class="py-5">
      <div class="container">
        <div class="flash mb-3">
          @if(session('success'))
            <div class="alert alert-success rounded-pill">{{ session('success') }}</div>
          @endif
          @if(session('info'))
            <div class="alert alert-info rounded-pill">{{ session('info') }}</div>
          @endif
          @if($errors->any())
            <div class="alert alert-danger rounded-pill">Terdapat beberapa kesalahan. Silakan periksa kembali.</div>
          @endif
        </div>

        @hasSection('sidebar')
          <div class="row gy-3">
            <div class="col-md-3">
              <div class="sticky-top" style="top:90px">
                @yield('sidebar')
              </div>
            </div>
            <div class="col-md-9">
              @yield('content')
            </div>
          </div>
        @else
          @yield('content')
        @endif
      </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      function confirmAction(message){ return confirm(message || 'Apakah Anda yakin?'); }
    </script>
  </body>
 </html>
