<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','Admin - Absensi PKL')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/theme.css">
    <link rel="stylesheet" href="/css/admin.css">
  </head>
  <body class="bg-light admin-layout">

    <div class="d-flex" id="wrapper">
      <!-- Sidebar -->
      <aside id="sidebar" class="bg-white border-end shadow-sm">
        <div class="sidebar-header d-flex align-items-center justify-content-between p-3 border-bottom">
          <div class="d-flex align-items-center gap-2">
            <span class="rounded-3 bg-gradient d-inline-flex align-items-center justify-content-center" style="width:42px;height:42px">
              <i class="bi bi-journal-check text-white fs-5"></i>
            </span>
            <div>
              <div class="fw-bold">Absensi PKL</div>
              <div class="small muted">Admin</div>
            </div>
          </div>
          <button class="btn btn-sm btn-outline-secondary d-md-none" id="sidebarCollapse"><i class="bi bi-list"></i></button>
        </div>

        <nav class="nav flex-column p-3 small">
          <a class="nav-link d-flex align-items-center gap-2 active" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
          <a class="nav-link d-flex align-items-center gap-2" href="{{ route('admin.export') }}"><i class="bi bi-file-earmark-arrow-down"></i> Export</a>
          <a class="nav-link d-flex align-items-center gap-2" href="{{ route('leave_requests.index') }}"><i class="bi bi-calendar-x"></i> Izin</a>
          <a class="nav-link d-flex align-items-center gap-2" href="{{ route('admin.user.activity', auth()->id() ?? 1) }}"><i class="bi bi-people"></i> Pengguna</a>
        </nav>

        {{-- place for page-specific sidebar content --}}
        <div class="p-3 mt-2 sidebar-content">
          @yield('sidebar')
        </div>

        <div class="sidebar-footer p-3 small muted">
          © {{ date('Y') }} Absensi PKL
        </div>
      </aside>

      <!-- Page content -->
      <div id="page-content" class="flex-fill">
        <nav class="navbar navbar-expand-lg navbar-white bg-white border-bottom shadow-sm">
          <div class="container-fluid">
            <div class="d-flex align-items-center gap-3">
              <button class="btn btn-light d-none d-md-inline" id="sidebarCollapseLg"><i class="bi bi-list"></i></button>
              <div class="d-md-none fw-bold">Dashboard</div>
            </div>
            <div class="ms-auto d-flex align-items-center gap-3">
              <div class="d-none d-md-block small muted me-3">{{ now()->toDateString() }}</div>
              <div class="dropdown d-flex align-items-center">
                <a href="#" class="dropdown-toggle d-flex align-items-center gap-2 text-decoration-none p-1 px-2 rounded-2" data-bs-toggle="dropdown" aria-expanded="false">
                  <div class="profile-avatar-wrapper d-inline-flex align-items-center justify-content-center">
                    <img src="{{ auth()->user()->photo ? asset('storage/'.auth()->user()->photo) : 'https://i.pravatar.cc/40' }}" class="profile-avatar">
                  </div>
                  <div class="d-none d-md-block text-start">
                    <div class="fw-bold small mb-0 profile-name">{{ auth()->user()->name }}</div>
                    <div class="small muted profile-email">{{ auth()->user()->email }}</div>
                  </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                  <li><a class="dropdown-item" href="{{ route('profile.show') }}"><i class="bi bi-person-fill me-2 text-primary"></i>Profil</a></li>
                  <li><hr class="dropdown-divider"/></li>
                  <li>
                    <form method="POST" action="{{ route('logout') }}">@csrf
                      <button class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Keluar</button>
                    </form>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </nav>

        <main class="py-4">
          <div class="container-fluid">
            @yield('content')
          </div>
        </main>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      // sidebar toggles: use 'open' for mobile (width < 768) and 'collapsed' for desktop
      (function(){
        const sidebar = document.getElementById('sidebar');
        const btnSmall = document.getElementById('sidebarCollapse');
        const btnLarge = document.getElementById('sidebarCollapseLg');
        function toggleSidebar(){
          if(window.innerWidth < 768){
            // mobile: toggles 'open' to slide in/out
            sidebar.classList.toggle('open');
          } else {
            // desktop: toggle compact collapsed state
            sidebar.classList.toggle('collapsed');
          }
        }
        btnSmall?.addEventListener('click', toggleSidebar);
        btnLarge?.addEventListener('click', toggleSidebar);
      })();
    </script>
  </body>
</html>
