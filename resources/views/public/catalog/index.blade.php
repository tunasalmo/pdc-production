@extends('public.layouts.app')
@section('title', 'Katalog Produk Interior')

@section('content')

{{-- Hero with Beams background --}}
<section class="hero-beams">
  <div id="hero-beams" class="hero-beams__canvas" aria-hidden="true"></div>
  <div class="hero-beams__overlay">
    <div class="container">
      <div class="hero-beams__content">
        <p class="hero-beams__eyebrow">
          <i class="bi bi-house me-1"></i>Interior · Rekomendasi cerdas
        </p>
        <h1 class="mb-0">Katalog produk interior</h1>
        <p class="hero-beams__subtitle">
          Temukan produk interior terbaik untuk ruangan Anda — dengan rekomendasi berbasis TF-IDF &amp; Cosine Similarity.
        </p>

        {{-- Search bar --}}
        <form action="{{ route('public.catalog.index') }}" method="GET">
          @if(request('category'))
            <input type="hidden" name="category" value="{{ request('category') }}">
          @endif
          <div class="search-wrap mb-3">
            <input type="text" name="search" value="{{ request('search') }}"
              placeholder="Cari produk, material, deskripsi...">
            <button type="submit">
              <i class="bi bi-search me-1"></i>Cari
            </button>
          </div>
        </form>
        {{-- Filter kategori --}}
        <div class="d-flex flex-wrap gap-2 align-items-center">
          <a href="{{ route('public.catalog.index', request()->except('category','page')) }}"
             class="badge-cat text-decoration-none {{ !request('category') ? 'active' : '' }}">
            Semua
          </a>
          @foreach($categories as $cat)
            <a href="{{ route('public.catalog.index', array_merge(request()->except('page'), ['category' => $cat->slug])) }}"
               class="badge-cat text-decoration-none"
               style="{{ request('category') == $cat->slug ? 'background:var(--pdc-accent);color:#fff;border-color:var(--pdc-accent)' : '' }}">
              {{ $cat->name }}
              <span class="opacity-60 ms-1">{{ $cat->products_count }}</span>
            </a>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>

{{-- Gallery Portfolio Section: Only Show On Home --}}
@if(request()->all() == [])
<style>
  .gallery-row-portfolio {
    display: flex;
    gap: 18px;
    overflow: hidden;
    padding: 8px 0;
    margin-bottom: 8px;
    position: relative;
    width: 100vw;
    left: 50%;
    right: 0;
    transform: translateX(-50%);
    max-width: 100vw;
  }
  .gallery-img-wrap {
    flex: 0 0 340px;
    height: 170px;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 4px 18px 0 #c9d1df26;
    background: #f2f4f9;
    transition: transform 0.3s;
    position: relative;
    margin: 0;
  }
  .gallery-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    border-radius: 24px;
    transition: transform 0.6s cubic-bezier(.32,2,.55,.27) !important;
  }
  .gallery-img-wrap:hover img {
    transform: scale(1.06) rotate(1deg);
  }
  .gallery-row-portfolio .gallery-track {
    display: flex;
    gap: 18px;
    animation-timing-function: linear;
    animation-iteration-count: infinite;
    width: max-content;
  }
  @keyframes infinite-left {
    0% { transform: translateX(0);}
    100% { transform: translateX(-50%);}
  }
  @keyframes infinite-right {
    0% { transform: translateX(-50%);}
    100% { transform: translateX(0);}
  }
  .gallery-row-portfolio.animate-left .gallery-track {
    animation-name: infinite-left;
    animation-duration: 22s;
  }
  .gallery-row-portfolio.animate-right .gallery-track {
    animation-name: infinite-right;
    animation-duration: 22s;
  }
  @media (max-width: 1200px) {
    .gallery-img-wrap {
      flex-basis: 250px;
      height: 125px;
    }
  }
  @media (max-width: 800px) {
    .gallery-img-wrap {
      flex-basis: 160px;
      height: 85px;
    }
    .gallery-row-portfolio {
      gap: 9px;
    }
    .gallery-row-portfolio .gallery-track {
      gap: 9px;
    }
  }
  @media (max-width: 575px) {
    .gallery-img-wrap {
      flex-basis: 72vw;
      height: 36vw;
      min-width: 120px;
      min-height: 54px;
      max-width: 99vw;
    }
    .gallery-row-portfolio {
      gap: 5px;
    }
    .gallery-row-portfolio .gallery-track {
      gap: 5px;
    }
  }
</style>
<section class="py-4" style="width:100vw;max-width:100vw;overflow-x:hidden;margin-left:calc(-50vw + 50%); background: transparent;">
  <div class="mb-3 text-center" style="font-weight:700;font-size:20px;color:var(--pdc-text);letter-spacing:-.03em;max-width:1200px;margin-inline:auto;">
    Our Project
  </div>
  {{-- Baris 1: slide ke kiri --}}
<div class="gallery-row-portfolio animate-left">
    <div class="gallery-track">
        @php
            $gallery1 = [
                'gallery1-1.jpg',
                'gallery1-2.jpg',
                'gallery1-3.jpg',
                'gallery1-4.jpg',
            ];
        @endphp

        @foreach ($gallery1 as $image)
            <div class="gallery-img-wrap">
                <img src="{{ asset('images/gallery/' . $image) }}" alt="{{ $image }}">
            </div>
        @endforeach

        {{-- Repeat untuk efek infinite --}}
        @foreach ($gallery1 as $image)
            <div class="gallery-img-wrap">
                <img src="{{ asset('images/gallery/' . $image) }}" alt="{{ $image }}">
            </div>
        @endforeach
    </div>
</div>

{{-- Baris 2: slide ke kanan --}}
<div class="gallery-row-portfolio animate-right">
    <div class="gallery-track">
        @php
            $gallery2 = [
                'gallery2-1.jpg',
                'gallery2-2.jpg',
                'gallery2-3.jpg',
                'gallery2-4.jpg',
            ];
        @endphp

        @foreach ($gallery2 as $image)
            <div class="gallery-img-wrap">
                <img src="{{ asset('images/gallery/' . $image) }}" alt="{{ $image }}">
            </div>
        @endforeach

        {{-- Repeat untuk efek infinite --}}
        @foreach ($gallery2 as $image)
            <div class="gallery-img-wrap">
                <img src="{{ asset('images/gallery/' . $image) }}" alt="{{ $image }}">
            </div>
        @endforeach
    </div>
</div>

{{-- Baris 3: slide ke kiri --}}
<div class="gallery-row-portfolio animate-left">
    <div class="gallery-track">
        @php
            $gallery3 = [
                'gallery3-1.jpg',
                'gallery3-2.jpg',
                'gallery3-3.jpg',
                'gallery3-4.jpg',
            ];
        @endphp

        @foreach ($gallery3 as $image)
            <div class="gallery-img-wrap">
                <img src="{{ asset('images/gallery/' . $image) }}" alt="{{ $image }}">
            </div>
        @endforeach

        {{-- Repeat untuk efek infinite --}}
        @foreach ($gallery3 as $image)
            <div class="gallery-img-wrap">
                <img src="{{ asset('images/gallery/' . $image) }}" alt="{{ $image }}">
            </div>
        @endforeach
    </div>
</div>
</section>
<script>
  // Pause animations on tab switch for all gallery-row-portfolio tracks
  document.addEventListener('visibilitychange', function() {
    document.querySelectorAll('.gallery-row-portfolio .gallery-track').forEach(t => {
      t.style.animationPlayState = document.visibilityState === 'visible' ? 'running' : 'paused';
    });
  });
</script>
@endif

{{-- Konten katalog --}}
<div class="container py-4">

  {{-- Info hasil --}}
  <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div class="text-muted small">
      @if(request('search'))
        Hasil pencarian "<strong class="text-dark">{{ request('search') }}</strong>" ·
      @endif
      {{ $products->total() }} produk ditemukan
    </div>
    @if(request()->anyFilled(['search','category']))
      <a href="{{ route('public.catalog.index') }}" class="btn btn-sm btn-outline-pdc">
        <i class="bi bi-x me-1"></i>Hapus filter
      </a>
    @endif
  </div>

  {{-- Grid produk --}}
  @if($products->isEmpty())
    <div class="text-center py-5 text-muted">
      <i class="bi bi-search fs-1 d-block mb-3 opacity-30"></i>
      <div class="fs-5 fw-medium mb-2">Produk tidak ditemukan</div>
      <div class="small">Coba kata kunci lain atau hapus filter</div>
      <a href="{{ route('public.catalog.index') }}" class="btn btn-outline-pdc mt-3">
        Lihat semua produk
      </a>
    </div>
  @else
    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3 mb-4">
      @foreach($products as $product)
      <div class="col">
        <a href="{{ route('public.catalog.show', $product) }}" class="prod-card">
          <div class="prod-img">
            @if($product->image_url)
              <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}">
            @else
              <i class="bi bi-image"></i>
            @endif
          </div>
          <div class="prod-body">
            <div class="prod-cat">{{ $product->category->name ?? '-' }}</div>
            <div class="prod-name">{{ $product->name }}</div>
            <div class="prod-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
          </div>
        </a>
      </div>
      @endforeach
    </div>

    {{-- Pagination --}}
    {{ $products->links() }}
  @endif

</div>
@endsection

@section('scripts')
@endsection
