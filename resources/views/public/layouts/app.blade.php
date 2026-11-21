<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Katalog') — PDC Production</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
    :root {
      /* Color System */
      --pdc-bg: #f7fafc;
      --pdc-bg-elevated: #fff;
      --pdc-surface: #eef2fa;
      --pdc-surface-hover: #e2e8fa;
      --pdc-border: rgba(30, 69, 160, 0.13);
      --pdc-border-accent: rgba(37, 119, 253, 0.13);
      --pdc-text: #212759;
      --pdc-text-muted: #8891af;
      --pdc-text-subtle: #b2bdd3;
      --pdc-accent: #216dda;
      --pdc-accent-hover: #164b98;
      --pdc-accent-light: #b6d8ff;
      --pdc-glow: rgba(37,119,253,0.12);
      --pdc-glass: rgba(180, 210, 250, 0.11);
    }

    body {
      background: var(--pdc-bg);
      background-image:
        radial-gradient(ellipse 90% 38% at 50% -14%, rgba(37, 119, 253, 0.1), transparent),
        radial-gradient(ellipse 65% 44% at 109% 0%, rgba(68, 181, 255, 0.10), transparent);
      font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
      font-size: 15px;
      color: var(--pdc-text);
      min-height: 100dvh;
      -webkit-font-smoothing: antialiased;
      line-height: 1.7;
    }

    /* -- Navbar -- */
    .navbar-pdc {
      background: rgba(255,255,255,0.94);
      backdrop-filter: blur(13px);
      -webkit-backdrop-filter: blur(13px);
      border-bottom: 1px solid var(--pdc-border);
      padding: 16px 0;
    }
    .navbar-brand {
      font-size: 17px;
      font-weight: 700;
      color: var(--pdc-accent) !important;
      letter-spacing: -0.015em;
    }
    .nav-link {
      color: var(--pdc-text-muted) !important;
      font-size: 13.5px;
      transition: color 0.16s;
      font-weight: 500;
      border-radius: 6px;
      padding: 5px 13px;
    }
    .nav-link:hover,
    .nav-link.active {
      color: var(--pdc-accent) !important;
      background: var(--pdc-accent-light);
    }

    /* -- Search -- */
    .search-wrap {
      background: var(--pdc-glass);
      border: 1px solid var(--pdc-border);
      border-radius: 12px;
      display: flex;
      align-items: center;
      max-width: 540px;
      backdrop-filter: blur(9px);
      box-shadow: 0 2px 14px 0 var(--pdc-glow);
      overflow: hidden;
      transition: box-shadow .17s;
    }
    .search-wrap:focus-within {
      box-shadow: 0 4px 20px var(--pdc-accent-light), 0 0 0 2px var(--pdc-accent-light);
      border-color: var(--pdc-accent);
    }
    .search-wrap input {
      border: none;
      outline: none;
      background: transparent;
      color: var(--pdc-text);
      padding: 13px 17px;
      font-size: 13.5px;
      flex: 1 1 auto;
      min-width: 0;
    }
    .search-wrap input::placeholder {
      color: var(--pdc-accent);
      opacity: 1;
      font-weight: 400;
    }
    .search-wrap button {
      background: var(--pdc-accent);
      color: #fff;
      border: none;
      padding: 12px 21px;
      font-size: 13px;
      cursor: pointer;
      transition: background 0.14s;
      font-weight: 600;
      border-radius: 0 11px 11px 0;
    }
    .search-wrap button:hover {
      background: var(--pdc-accent-hover);
    }

    /* -- Product Cards -- */
    .prod-card {
      border: 1px solid var(--pdc-border);
      border-radius: 14px;
      background: var(--pdc-surface);
      text-decoration: none;
      color: inherit;
      display: block;
      height: 100%;
      transition: box-shadow 0.18s, transform 0.18s, border-color 0.17s;
    }
    .prod-card:hover {
      box-shadow: 0 8px 32px var(--pdc-glow);
      border-color: var(--pdc-border-accent);
      transform: translateY(-2px) scale(1.012);
    }
    .prod-img {
      height: 170px;
      background: var(--pdc-bg-elevated);
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      border-bottom: 1px solid var(--pdc-border);
    }
    .prod-img img { width: 100%; height: 100%; object-fit: cover; }
    .prod-img i   { font-size: 46px; color: var(--pdc-text-subtle);}
    .prod-body    { padding: 14px 16px;}
    .prod-cat     { font-size: 11px; color: var(--pdc-accent); margin-bottom: 5px; }
    .prod-name    { font-size: 13px; font-weight: 600; margin-bottom: 7px; line-height: 1.45; color: var(--pdc-text);}
    .prod-price   { font-size: 15px; font-weight: 600; color: var(--pdc-accent);}

    /* -- Badges -- */
    .badge-cat {
      display: inline-block;
      font-size: 11px;
      padding: 4px 11px;
      border-radius: 20px;
      font-weight: 500;
      background: var(--pdc-glass);
      color: var(--pdc-accent);
      border: 1.1px solid var(--pdc-border);
      transition: background 0.13s, color 0.13s, border-color 0.13s;
      cursor: pointer;
      user-select: none;
    }
    .badge-cat.active,
    .badge-cat[aria-current="true"] {
      background: var(--pdc-accent-hover) !important;
      color: #fff !important;
      border-color: var(--pdc-accent) !important;
      box-shadow: 0 2px 11px var(--pdc-glow);
    }
    .badge-cat:hover {
      background: var(--pdc-accent-light);
      color: var(--pdc-accent);
      border-color: var(--pdc-accent);
    }
    .badge-sim {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      font-size: 11px;
      padding: 3px 10px;
      border-radius: 20px;
      background: #e3f0fe;
      color: var(--pdc-accent);
      border: 1px solid var(--pdc-border-accent);
    }

    /* -- Typography Helpers -- */
    .section-title {
      font-size: 1.25rem;
      font-weight: 700;
      letter-spacing: -0.02em;
      color: var(--pdc-accent);
    }
    .text-muted {
      color: var(--pdc-text-muted) !important;
    }
    .text-dark {
      color: var(--pdc-text) !important;
    }

    /* -- Buttons -- */
    .btn-pdc {
      background: var(--pdc-accent);
      color: #fff;
      border: none;
      border-radius: 10px;
      padding: 8px 18px;
      font-size: 13.5px;
      transition: background 0.14s;
      font-weight: 600;
      box-shadow: 0 1px 7px var(--pdc-glow);
    }
    .btn-pdc:hover, .btn-pdc:focus {
      background: var(--pdc-accent-hover);
      color: #fff;
    }
    .btn-outline-pdc {
      background: transparent;
      color: var(--pdc-accent);
      border: 1.3px solid var(--pdc-accent);
      border-radius: 10px;
      padding: 7px 15px;
      font-size: 13.2px;
      transition: background 0.13s, border-color 0.13s, color 0.13s;
      font-weight: 600;
    }
    .btn-outline-pdc:hover, .btn-outline-pdc:focus {
      background: var(--pdc-accent-light);
      color: var(--pdc-accent-hover);
      border-color: var(--pdc-accent-hover);
    }

    /* -- Pagination -- */
    .pagination .page-link {
      background: var(--pdc-surface);
      border-color: var(--pdc-border);
      color: var(--pdc-accent);
      border-radius: 8px !important;
      margin: 0 2px;
      font-size: 13.4px;
      font-weight: 500;
    }
    .pagination .page-link:hover {
      background: var(--pdc-accent-light);
      border-color: var(--pdc-border-accent);
      color: var(--pdc-accent-hover);
    }
    .pagination .page-item.active .page-link {
      background: var(--pdc-accent);
      border-color: var(--pdc-accent);
      color: #fff;
    }
    .pagination .page-item.disabled .page-link {
      background: var(--pdc-bg-elevated);
      border-color: var(--pdc-border);
      color: var(--pdc-text-subtle);
    }

    /* -- Breadcrumb -- */
    .breadcrumb {
      background: transparent;
      padding: 0;
      font-size: 13px;
      font-weight: 500;
    }
    .breadcrumb-item a {
      color: var(--pdc-accent);
      text-decoration: none;
    }
    .breadcrumb-item a:hover { text-decoration: underline; }
    .breadcrumb-item.active { color: var(--pdc-text-muted); }
    .breadcrumb-item + .breadcrumb-item::before {
      color: var(--pdc-text-subtle);
    }

    /* -- Detail page -- */
    .detail-img-wrap {
      border-radius: 15px;
      overflow: hidden;
      border: 1px solid var(--pdc-border);
      background: var(--pdc-bg-elevated);
      aspect-ratio: 4 / 3;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .detail-img-wrap img { width: 100%; height: 100%; object-fit: cover; }
    .detail-img-wrap i   { font-size: 72px; color: var(--pdc-text-subtle);}
    .spec-table td {
      padding: 10px 0;
      border-bottom: 1px solid var(--pdc-border);
      font-size: 13px;
      color: var(--pdc-text);
    }
    .spec-table td:first-child { color: var(--pdc-text-muted); width: 120px; }
    .spec-table tr:last-child td { border-bottom: none; }

    /* -- Recommendation cards -- */
    .reco-card {
      border: 1px solid var(--pdc-border);
      border-radius: 12px;
      background: var(--pdc-surface);
      text-decoration: none;
      color: inherit;
      display: flex;
      flex-direction: column;
      height: 100%;
      transition: box-shadow 0.13s, transform 0.13s, border-color 0.13s;
    }
    .reco-card:hover {
      box-shadow: 0 6px 20px var(--pdc-glow);
      border-color: var(--pdc-border-accent);
      transform: translateY(-1px) scale(1.008);
    }
    .reco-img {
      height: 130px;
      background: var(--pdc-bg-elevated);
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      flex-shrink: 0;
    }
    .reco-img img { width: 100%; height: 100%; object-fit: cover; }
    .reco-img i   { font-size: 34px; color: var(--pdc-text-subtle);}
    .reco-body    { 
      padding: 11px 13px;
      flex: 1 1 auto;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
    }
    /* Batasi hanya 1 baris untuk judul (contoh: digunakan pada elemen .reco-title di dalam .reco-body) */
    .reco-title {
      font-size: 13px;
      font-weight: 600;
      color: var(--pdc-text);
      line-height: 1.3;
      margin-bottom: 6px;
      display: -webkit-box;
      -webkit-box-orient: vertical;
      -webkit-line-clamp: 1;
      overflow: hidden;
      min-height: 1.3em;
      max-height: 1.3em;
      white-space: normal;
    }
    .score-bar-wrap {
      height: 5px;
      background: var(--pdc-border);
      border-radius: 3px;
      overflow: hidden;
      margin-top: 6px;
    }
    .score-bar-fill {
      height: 100%;
      border-radius: 3px;
      background: linear-gradient(90deg, var(--pdc-accent-light), var(--pdc-accent));
    }

    /* -- Page sections -- */
    .page-section {
      border-top: 1px solid var(--pdc-border);
      padding-top: 34px;
    }
    .page-header-bar {
      background: var(--pdc-bg-elevated);
      border-bottom: 1px solid var(--pdc-border);
      padding: 18px 0;
    }

    /* -- Footer -- */
    footer {
      margin-top: 52px;
      border-top: 1px solid var(--pdc-border);
      padding: 22px 0;
      background: var(--pdc-bg-elevated);
      color: var(--pdc-text-muted);
      font-size: 12.5px;
      text-align: center;
    }

    /* -- Button WhatsApp -- */
    .btn-wa-pdc {
      background: var(--pdc-surface);
      color: var(--pdc-accent);
      border-radius: 10px;
      padding: 11px 18px;
      font-weight: 500;
      font-size: 14px;
      text-decoration: none;
      border: 1.2px solid var(--pdc-accent);
      transition: background .15s, color .15s, border-color .15s, box-shadow .15s;
      box-shadow: 0 1px 3px var(--pdc-glow);
      display: inline-block;
    }
    .btn-wa-pdc:hover, .btn-wa-pdc:focus {
      background: var(--pdc-accent);
      color: #fff;
      border-color: var(--pdc-accent-light);
      box-shadow: 0 2px 12px var(--pdc-glow);
      text-decoration: none;
    }
 
    /* -- Hero beams -- */
    .hero-beams {
      position: relative;
      min-height: min(600px, 80dvh);
      overflow: hidden;
      border-bottom: 1px solid var(--pdc-border);
      background: var(--pdc-bg);
    }
    .hero-beams__canvas {
      position: absolute;
      inset: 0;
      z-index: 0;
      pointer-events: none;
    }
    @media (min-width: 992px) {
      .hero-beams__canvas {
        left: 33%;
      }
    }
    .hero-beams__overlay {
      position: relative;
      z-index: 1;
      min-height: min(530px, 80dvh);
      display: flex;
      align-items: center;
      padding: 48px 0 38px;
      background: linear-gradient(
        108deg,
        rgba(176, 210, 252, 0.97) 0%,
        rgba(217, 229, 255, 0.91) 46%,
        rgba(177, 212, 252, 0.60) 76%,
        transparent 100%
      );
    }
    @media (max-width: 991px) {
      .hero-beams__overlay {
        background: linear-gradient(
          180deg,
          rgba(177, 212, 252, 0.89) 0%,
          rgba(177, 212, 252, 0.67) 60%,
          rgba(177, 212, 252, 0.26) 100%
        );
      }
    }
    .hero-beams__content {
      max-width: 620px;
    }
    .hero-beams__eyebrow {
      color: var(--pdc-accent);
      font-size: 12.3px;
      font-weight: 600;
      letter-spacing: 0.045em;
      text-transform: uppercase;
      margin-bottom: 13px;
    }
    .hero-beams h1 {
      font-size: clamp(1.78rem, 4vw, 2.53rem);
      font-weight: 700;
      letter-spacing: -0.022em;
      color: var(--pdc-accent-hover);
      line-height: 1.16;
      margin-bottom: 13px;
      text-shadow: 0 2px 10px var(--pdc-accent-light);
    }
    .hero-beams__subtitle {
      color: var(--pdc-accent);
      font-size: 15.2px;
      line-height: 1.6;
      margin-bottom: 28px;
      text-shadow: 0 1px 6px var(--pdc-accent-light);
    }
    .hero-beams .search-wrap {
      background: var(--pdc-glass);
      border: 1.4px solid var(--pdc-border-accent);
      backdrop-filter: blur(11px);
      max-width: 100%;
      box-shadow: 0 2px 16px 0 var(--pdc-glow);
    }
    .hero-beams .search-wrap input {
      color: var(--pdc-accent-hover);
      background: transparent;
    }
    .hero-beams .search-wrap input::placeholder {
      color: var(--pdc-text-muted);
      opacity: 1;
    }
    .hero-beams .badge-cat.active,
    .hero-beams .badge-cat[aria-current="true"] {
      background: var(--pdc-accent-hover) !important;
      color: #fff !important;
      border-color: var(--pdc-accent-light) !important;
      box-shadow: 0 2px 12px var(--pdc-glow);
    }

    @yield('extra-style')
  </style>
</head>
<body>

{{-- Navbar --}}
<nav class="navbar navbar-pdc sticky-top">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="{{ route('public.catalog.index') }}">
      <img src="{{ asset('images/logo/logo.png') }}"
          alt="PDC Production"
          width="40"
          height="40"
          class="me-2">
      <span>PDC Production</span>
  </a>
    <div class="d-flex align-items-center gap-3">
      <a href="{{ route('public.catalog.index') }}"
         class="nav-link {{ request()->routeIs('public.catalog.index') ? 'active fw-medium' : '' }}">
        Katalog
      </a>
      <a href="{{ route('public.about') }}"
         class="nav-link {{ request()->routeIs('public.about') ? 'active fw-medium' : '' }}">
        Tentang
      </a>
      <a href="{{ route('public.contact') }}"
         class="nav-link {{ request()->routeIs('public.contact') ? 'active fw-medium' : '' }}">
        Kontak
      </a>
      <a href="{{ route('admin.login') }}" class="nav-link">
        <i class="bi bi-lock me-1"></i>Admin
      </a>
    </div>
  </div>
</nav>

@yield('content')

<footer>
  <div class="container text-center">
    © {{ date('Y') }} PDC Production · Sistem Rekomendasi Produk Interior
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
