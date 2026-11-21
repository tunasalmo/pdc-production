@extends('admin.layouts.app')
@section('title', 'Produk')
@section('page-title', 'Manajemen Produk')

@section('content')
{{-- Toolbar --}}
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
  <form class="d-flex gap-2 flex-wrap" method="GET" action="{{ route('admin.product.index') }}">
    <input type="text" name="search" value="{{ request('search') }}"
      class="form-control form-control-sm" placeholder="Cari produk..." style="width:200px">
    <select name="category_id" class="form-select form-select-sm" style="width:160px">
      <option value="">Semua kategori</option>
      @foreach ($categories as $cat)
        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
          {{ $cat->name }}
        </option>
      @endforeach
    </select>
    <button type="submit" class="btn btn-sm btn-outline-secondary">
      <i class="bi bi-search"></i> Filter
    </button>
    @if(request()->anyFilled(['search','category_id']))
      <a href="{{ route('admin.product.index') }}" class="btn btn-sm btn-outline-danger">
        <i class="bi bi-x"></i> Reset
      </a>
    @endif
  </form>
  <a href="{{ route('admin.product.create') }}" class="btn btn-sm btn-pdc">
    <i class="bi bi-plus-lg me-1"></i>Tambah produk
  </a>
</div>

{{-- Tabel --}}
<div class="card">
  <div class="table-responsive">
    <table class="table table-hover small mb-0">
      <thead class="table-light">
        <tr>
          <th class="ps-4" style="width:40px">#</th>
          <th style="width:60px">Gambar</th>
          <th>Nama produk</th>
          <th>Kategori</th>
          <th>Harga</th>
          <th>TF-IDF</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($products as $i => $product)
        <tr>
          <td class="ps-4 text-muted">{{ $products->firstItem() + $i }}</td>
          <td>
            @if ($product->image_url)
              <img src="{{ asset($product->image_url) }}" width="44" height="44"
                class="rounded object-fit-cover border">
            @else
              <div class="rounded border bg-light d-flex align-items-center justify-content-center"
                style="width:44px;height:44px">
                <i class="bi bi-image text-muted"></i>
              </div>
            @endif
          </td>
          <td>
            <div class="fw-medium">{{ $product->name }}</div>
            <div class="text-muted" style="font-size:11px">{{ Str::limit($product->description, 60) }}</div>
          </td>
          <td><span class="badge badge-purple">{{ $product->category->name ?? '-' }}</span></td>
          <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
          <td>
            @if ($product->normalization)
              <span class="badge badge-teal"><i class="bi bi-check-circle me-1"></i>Sudah</span>
            @else
              <span class="badge badge-amber"><i class="bi bi-clock me-1"></i>Belum</span>
            @endif
          </td>
          <td>
            <div class="d-flex gap-1">
              <a href="{{ route('admin.product.edit', $product) }}"
                class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-pencil"></i>
              </a>
              <form action="{{ route('admin.product.destroy', $product) }}" method="POST"
                onsubmit="return confirm('Hapus produk {{ addslashes($product->name) }}? Data preprocessing dan similarity-nya juga akan terhapus.')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger">
                  <i class="bi bi-trash"></i>
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7" class="text-center text-muted py-5">
            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
            Belum ada produk.
            <a href="{{ route('admin.product.create') }}">Tambah sekarang</a>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if ($products->hasPages())
  <div class="card-footer py-2 px-4">
    {{ $products->links() }}
  </div>
  @endif
</div>
@endsection
