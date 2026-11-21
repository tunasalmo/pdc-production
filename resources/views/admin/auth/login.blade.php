<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin — PDC Production</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <style>
    body {
      background: #f5f5f0;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .login-card {
      width: 100%;
      max-width: 400px;
      border: 1px solid #e0dfd8;
      border-radius: 16px;
      padding: 36px 32px;
      background: #fff;
      box-shadow: 0 2px 16px rgba(0,0,0,.06);
    }
    .brand {
      font-size: 18px;
      font-weight: 600;
      color: #1a1a18;
      letter-spacing: -.01em;
    }
    .form-control:focus {
      border-color: #534AB7;
      box-shadow: 0 0 0 3px rgba(83,74,183,.12);
    }
    .btn-primary-pdc {
      background: #534AB7;
      border: none;
      color: #fff;
      font-weight: 500;
      padding: 10px;
      border-radius: 8px;
      transition: background .15s;
    }
    .btn-primary-pdc:hover { background: #3d358f; }
    .toggle-pass {
      cursor: pointer;
      border-left: none;
      background: #fff;
    }
  </style>
</head>
<body>
  <div class="login-card">
    {{-- Logo --}}
    <div class="text-center mb-4">
      <div class="brand">
        <img src="{{ asset('images/logo/logo.png') }}"
          alt="PDC Production"
          width="40"
          height="40"
          class="me-2"> PDC Production
      </div>
    </div>

    {{-- Alert error umum --}}
    @if (session('error'))
      <div class="alert alert-danger alert-dismissible fade show py-2 small" role="alert">
        <i class="bi bi-exclamation-circle me-1"></i> {{ session('error') }}
        <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
      </div>
    @endif

    {{-- Form login --}}
    <form action="{{ route('admin.login.post') }}" method="POST" novalidate>
      @csrf

      {{-- Email --}}
      <div class="mb-3">
        <label for="email" class="form-label fw-medium small">Email</label>
        <input
          type="email"
          id="email"
          name="email"
          value="{{ old('email') }}"
          class="form-control @error('email') is-invalid @enderror"
          placeholder="admin@pdcproduction.com"
          autofocus
        >
        @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- Password --}}
      <div class="mb-4">
        <label for="password" class="form-label fw-medium small">Password</label>
        <div class="input-group">
          <input
            type="password"
            id="password"
            name="password"
            class="form-control @error('password') is-invalid @enderror"
            placeholder="••••••••"
          >
          <span class="input-group-text toggle-pass" onclick="togglePassword()">
            <i class="bi bi-eye" id="eyeIcon"></i>
          </span>
          @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>

      {{-- Submit --}}
      <button type="submit" class="btn btn-primary-pdc w-100">
        <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
      </button>
    </form>

    {{-- Tambahan baru --}}
    <div class="text-center mt-3">
        <a href="{{ route('public.catalog.index') }}"
          style="font-size:12px;color:#534AB7;text-decoration:none">
            <i class="bi bi-grid-3x3-gap me-1"></i>Kunjungi halaman katalog
        </a>
    </div>

    <div class="text-center mt-3 text-muted" style="font-size:12px">
      Lupa password? Hubungi superadmin
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function togglePassword() {
      const input = document.getElementById('password');
      const icon  = document.getElementById('eyeIcon');
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
      }
    }
  </script>
</body>
</html>
