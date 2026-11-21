<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard') — PDC Admin</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <style>
    body { background:#f5f5f0; font-size:14px }
    .sidebar {
      width: 220px; min-height: 100vh;
      background: #fff; border-right: 1px solid #e8e7e0;
      position: fixed; top: 0; left: 0; z-index: 100;
    }
    .sidebar-brand {
      padding: 20px 20px 16px;
      font-weight: 600; font-size: 15px;
      border-bottom: 1px solid #e8e7e0;
      color: #1a1a18;
    }
    .sidebar-menu { padding: 12px 8px; }
    .sidebar-menu .nav-link {
      color: #6b6b67; border-radius: 8px;
      padding: 9px 14px; font-size: 13px;
      display: flex; align-items: center; gap: 10px;
      margin-bottom: 2px; transition: all .15s;
    }
    .sidebar-menu .nav-link:hover,
    .sidebar-menu .nav-link.active {
      background: #EEEDFE; color: #534AB7; font-weight: 500;
    }
    .sidebar-menu .nav-link i { font-size: 16px; }
    .topbar {
      margin-left: 220px; background: #fff;
      border-bottom: 1px solid #e8e7e0;
      padding: 12px 24px;
      display: flex; align-items: center; justify-content: space-between;
      position: sticky; top: 0; z-index: 99;
    }
    .main-content { margin-left: 220px; padding: 24px; }
    .card { border: 1px solid #e8e7e0; border-radius: 12px; box-shadow: none; }
    .card-header { background: #fafaf8; border-bottom: 1px solid #e8e7e0; font-weight: 500; }
    .stat-card { border-radius: 12px; padding: 18px 20px; border: 1px solid #e8e7e0; background: #fff; }
    .stat-card .stat-val { font-size: 26px; font-weight: 600; margin-top: 4px; }
    .stat-card .stat-label { font-size: 12px; color: #8a8a85; }
    .badge-teal   { background:#E1F5EE; color:#085041; }
    .badge-purple { background:#EEEDFE; color:#26215C; }
    .badge-amber  { background:#FAEEDA; color:#633806; }
    .btn-pdc      { background:#534AB7; color:#fff; border:none; }
    .btn-pdc:hover { background:#3d358f; color:#fff; }
    @yield('extra-style')
  </style>
</head>
<body>

{{-- Sidebar --}}
<nav class="sidebar">
  <div class="sidebar-brand">
    <img src="{{ asset('images/logo/logo.png') }}"
          alt="PDC Production"
          width="40"
          height="40"
          class="me-2">PDC Admin
  </div>
  <div class="sidebar-menu">
    <a href="{{ route('admin.dashboard') }}"
       class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <i class="bi bi-speedometer2"></i> Dashboard
    </a>
    <a href="{{ route('admin.category.index') }}"
       class="nav-link {{ request()->routeIs('admin.category*') ? 'active' : '' }}">
      <i class="bi bi-tag"></i> Kategori
    </a>
    <a href="{{ route('admin.product.index') }}"
       class="nav-link {{ request()->routeIs('admin.product*') ? 'active' : '' }}">
      <i class="bi bi-box-seam"></i> Produk
    </a>
    
    <a href="{{ route('admin.generate.index') }}"
       class="nav-link {{ request()->routeIs('admin.generate*') ? 'active' : '' }}">
      <i class="bi bi-cpu"></i> Generate TF-IDF
    </a>

    <a href="{{ route('admin.stopword.index') }}"
      class="nav-link {{ request()->routeIs('admin.stopword*') ? 'active' : '' }}">
      <i class="bi bi-filter"></i> Stopword
    </a>
  </div>
</nav>

{{-- Topbar --}}
<div class="topbar">
  <div class="fw-medium">@yield('page-title', 'Dashboard')</div>
  <div class="d-flex align-items-center gap-3">
    <span class="text-muted small">
      <i class="bi bi-person-circle me-1"></i>{{ session('admin_username') }}
    </span>
    <form action="{{ route('admin.logout') }}" method="POST" class="m-0">
      @csrf
      <button type="submit" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-box-arrow-right me-1"></i>Logout
      </button>
    </form>
  </div>
</div>

{{-- Konten utama --}}
<div class="main-content">

  {{-- Alert sukses --}}
  @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show py-2 small mb-3" role="alert">
      <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
      <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
    </div>
  @endif

  {{-- Alert error --}}
  @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show py-2 small mb-3" role="alert">
      <i class="bi bi-exclamation-circle me-1"></i> {{ session('error') }}
      <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
    </div>
  @endif

  @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
