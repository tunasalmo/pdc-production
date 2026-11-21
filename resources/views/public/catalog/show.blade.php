@extends('public.layouts.app')
@section('title', $product->name)

@section('content')

{{-- Page header --}}
<div class="page-header-bar">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item">
          <a href="{{ route('public.catalog.index') }}">Katalog</a>
        </li>
        @if($product->category)
        <li class="breadcrumb-item">
          <a href="{{ route('public.catalog.index', ['category' => $product->category->slug]) }}">
            {{ $product->category->name }}
          </a>
        </li>
        @endif
        <li class="breadcrumb-item active">{{ Str::limit($product->name, 40) }}</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container py-4">

  {{-- Detail produk --}}
  <div class="row g-4 mb-5">

    {{-- Gambar --}}
    <div class="col-md-5">
      <div class="detail-img-wrap">
        @if($product->image_url)
          <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}">
        @else
          <i class="bi bi-image"></i>
        @endif
      </div>
    </div>

    
    {{-- Info --}}
    <div class="col-md-7">
      <span class="badge-cat mb-2 d-inline-block">{{ $product->category->name ?? '-' }}</span>
      <h1 style="font-size:22px;font-weight:600;letter-spacing:-.02em;line-height:1.3;color:var(--pdc-text)" class="mb-2">
        {{ $product->name }}
      </h1>
      <div style="font-size:26px;font-weight:700;color:var(--pdc-text)" class="mb-3">
        Rp {{ number_format($product->price, 0, ',', '.') }}
      </div>

      <p class="text-muted" style="font-size:13px;line-height:1.7">
        {{ $product->description }}
      </p>

      <table class="spec-table w-100 mt-3">
        <tr>
          <td>Material</td>
          <td class="fw-medium">{{ $product->material }}</td>
        </tr>
        <tr>
          <td>Kategori</td>
          <td>
            <a href="{{ route('public.catalog.index', ['category' => $product->category->slug ?? '']) }}"
               class="text-decoration-none" style="color:var(--pdc-accent-light)">
              {{ $product->category->name ?? '-' }}
            </a>
          </td>
        </tr>
        <tr>
          <td>Ditambahkan</td>
          <td class="text-muted">{{ $product->created_at->format('d F Y') }}</td>
        </tr>
        <tr>
          <td>Status TF-IDF</td>
          <td>
            @if($product->normalization)
              <span class="badge-sim"><i class="bi bi-check-circle"></i>Terdaftar di dataset</span>
            @else
              <span style="font-size:11px;color:var(--pdc-text-muted)">Belum di-generate</span>
            @endif
          </td>
        </tr>
      </table>
    </div>
  </div>

  {{-- Tombol Tanyakan via WhatsApp --}}
  @if($product->category)
    @php
        $nomorWA = '6281234567890'; // Ganti dengan nomor WhatsApp toko

        $pesan = "Halo PDC Production! 👋\n\n"
              . "Saya tertarik dengan produk berikut:\n\n"
              . "🛋️ *{$product->name}*\n"
              . "📂 Kategori : {$product->category->name}\n"
              . "💰 Harga    : Rp " . number_format($product->price, 0, ',', '.') . "\n"
              . "🪵 Material : {$product->material}\n\n"
              . "Boleh minta info lebih lanjut?\n\n"
              . "🔗 " . url('/produk/' . $product->id);

        $linkWA = 'https://wa.me/' . $nomorWA . '?text=' . rawurlencode($pesan);
    @endphp
    <a href="{{ $linkWA }}" target="_blank" rel="noopener"
      class="btn btn-wa-pdc w-100 mt-3 d-flex align-items-center justify-content-center gap-2">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
        <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
      </svg>
      Tanyakan via WhatsApp
    </a>
    @endif

  {{-- Rekomendasi Produk Serupa --}}
  <div class="page-section">
    <div class="d-flex align-items-center gap-3 mb-4 flex-wrap">
      <div class="section-title">Produk serupa</div>
      <span class="badge-sim">
        <i class="bi bi-cpu"></i>Content-Based Filtering · Cosine Similarity
      </span>
    </div>

    @if(count($recommendations) > 0)
      <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-3">
        @foreach($recommendations as $reco)
        <div class="col">
          <a href="{{ route('public.catalog.show', $reco) }}" class="reco-card">
            <div class="reco-img">
              @if($reco->image_url)
                <img src="{{ asset($reco->image_url) }}" alt="{{ $reco->name }}">
              @else
                <i class="bi bi-image"></i>
              @endif
            </div>
            <div class="reco-body" style="display: flex; flex-direction: column; height: 100%;">
              <div style="font-size:10px;color:var(--pdc-text);margin-bottom:3px">
                {{ $reco->category->name ?? '-' }}
              </div>
              <div 
                style="
                  font-size:12px;
                  font-weight:600;
                  line-height:1.4;
                  margin-bottom:5px;
                  color:var(--pdc-text);
                  min-height:2.8em;
                  display:-webkit-box;
                  -webkit-box-orient: vertical;
                  -webkit-line-clamp: 2;
                  overflow:hidden;
                  white-space: normal;
                ">
                {{ Str::limit($reco->name, 50) }}
              </div>
              <div style="font-size:13px;font-weight:600;color:var(--pdc-text)">
                Rp {{ number_format($reco->price, 0, ',', '.') }}
              </div>
              <div class="d-flex align-items-center gap-1 mt-2">
                <i class="bi bi-graph-up" style="font-size:10px;color:var(--pdc-text-muted)"></i>
                <span style="font-size:10px;color:var(--pdc-text-muted)">
                  Skor: {{ number_format($reco->cosine_score, 4) }}
                </span>
              </div>
              <div class="score-bar-wrap mt-auto">
                <div class="score-bar-fill"
                  style="width:{{ min($reco->cosine_score * 100, 100) }}%"></div>
              </div>
            </div>
          </a>
        </div>
        @endforeach
      </div>
 

    @else
      <div class="text-center py-5 text-muted">
        <i class="bi bi-cpu fs-2 d-block mb-2 opacity-30"></i>
        <div class="small">Rekomendasi belum tersedia.</div>
        <div class="small">Admin perlu menjalankan generate TF-IDF terlebih dahulu.</div>
      </div>
    @endif
  </div>

  {{-- Tombol kembali --}}
  <div class="mt-5">
    <a href="{{ route('public.catalog.index') }}" class="btn btn-outline-pdc">
      <i class="bi bi-arrow-left me-1"></i>Kembali ke katalog
    </a>
  </div>

</div>
@endsection
