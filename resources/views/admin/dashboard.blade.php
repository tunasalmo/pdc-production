@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row g-3 mb-4">
  <div class="col-6 col-md-3">
    <div class="stat-card">
      <div class="stat-label"><i class="bi bi-box-seam me-1"></i>Total produk</div>
      <div class="stat-val text-primary">{{ $stats['total_products'] }}</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="stat-card">
      <div class="stat-label"><i class="bi bi-tag me-1"></i>Kategori</div>
      <div class="stat-val text-success">{{ $stats['total_categories'] }}</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="stat-card">
      <div class="stat-label"><i class="bi bi-cpu me-1"></i>Status TF-IDF</div>
      <div class="stat-val" style="font-size:16px;margin-top:8px">
        @if($stats['tfidf_status'] === 'Aktif')
          <span class="badge badge-teal px-3 py-2">✓ Aktif</span>
        @else
          <span class="badge badge-amber px-3 py-2">Belum di-generate</span>
        @endif
      </div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="stat-card">
      <div class="stat-label"><i class="bi bi-vector-pen me-1"></i>Similarity pairs</div>
      <div class="stat-val text-warning">{{ $stats['total_similarity'] }}</div>
    </div>
  </div>
</div>

{{-- Tabel produk terbaru --}}
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center py-3 px-4">
    <span><i class="bi bi-clock-history me-2"></i>Produk terbaru</span>
    <a href="{{ route('admin.product.index') }}" class="btn btn-sm btn-pdc">
      Lihat semua
    </a>
  </div>
  <div class="table-responsive">
    <table class="table table-hover mb-0 small">
      <thead class="table-light">
        <tr>
          <th class="ps-4">Nama produk</th>
          <th>Kategori</th>
          <th>Harga</th>
          <th>Dibuat</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($latest_products as $product)
        <tr>
          <td class="ps-4 fw-medium">{{ $product->name }}</td>
          <td>
            <span class="badge badge-purple">{{ $product->category->name ?? '-' }}</span>
          </td>
          <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
          <td class="text-muted">{{ $product->created_at->format('d M Y') }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="4" class="text-center text-muted py-4">
            <i class="bi bi-inbox fs-4 d-block mb-2"></i>
            Belum ada produk. <a href="{{ route('admin.product.create') }}">Tambah sekarang</a>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
