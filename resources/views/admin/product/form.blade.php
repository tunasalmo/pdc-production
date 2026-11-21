{{--
  Dipakai untuk CREATE dan EDIT.
  Variabel: $product (null = create, ada = edit), $categories
--}}
@extends('admin.layouts.app')
@section('title', isset($product) ? 'Edit Produk' : 'Tambah Produk')
@section('page-title', isset($product) ? 'Edit Produk' : 'Tambah Produk')

@section('extra-style')
<style>
  .img-preview { width:120px; height:120px; object-fit:cover; border-radius:10px; border:1px solid #e8e7e0 }
  .drop-zone {
    border: 2px dashed #d0cfc8; border-radius: 10px;
    padding: 28px; text-align: center; cursor: pointer;
    transition: border-color .2s;
  }
  .drop-zone:hover { border-color: #534AB7; }
</style>
@endsection

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8">
    <a href="{{ route('admin.product.index') }}" class="btn btn-sm btn-outline-secondary mb-3">
      <i class="bi bi-arrow-left me-1"></i>Kembali ke daftar
    </a>

    <div class="card">
      <div class="card-header py-3 px-4">
        <i class="bi bi-box-seam me-2"></i>
        {{ isset($product) ? 'Edit produk: ' . $product->name : 'Form tambah produk baru' }}
      </div>
      <div class="card-body px-4 py-4">
        <form
          action="{{ isset($product) ? route('admin.product.update', $product) : route('admin.product.store') }}"
          method="POST"
          enctype="multipart/form-data">
          @csrf
          @if(isset($product)) @method('PUT') @endif

          <div class="row g-3">

            {{-- Nama produk --}}
            <div class="col-12">
              <label class="form-label small fw-medium">Nama produk <span class="text-danger">*</span></label>
              <input type="text" name="name"
                value="{{ old('name', $product->name ?? '') }}"
                class="form-control @error('name') is-invalid @enderror"
                placeholder="cth: Sofa minimalis 3-seater">
              @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Kategori --}}
            <div class="col-md-6">
              <label class="form-label small fw-medium">Kategori <span class="text-danger">*</span></label>
              <select name="category_id"
                class="form-select @error('category_id') is-invalid @enderror">
                <option value="">-- Pilih kategori --</option>
                @foreach ($categories as $cat)
                  <option value="{{ $cat->id }}"
                    {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                  </option>
                @endforeach
              </select>
              @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Harga --}}
            <div class="col-md-6">
              <label class="form-label small fw-medium">Harga (Rp) <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text small">Rp</span>
                <input type="number" name="price" min="0"
                  value="{{ old('price', $product->price ?? '') }}"
                  class="form-control @error('price') is-invalid @enderror"
                  placeholder="0">
                @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            {{-- Deskripsi --}}
            <div class="col-12">
              <label class="form-label small fw-medium">
                Deskripsi <span class="text-danger">*</span>
                <span class="text-muted fw-normal">(digunakan untuk TF-IDF)</span>
              </label>
              <textarea name="description" rows="4"
                class="form-control @error('description') is-invalid @enderror"
                placeholder="Deskripsikan produk secara lengkap...">{{ old('description', $product->description ?? '') }}</textarea>
              @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Material --}}
            <div class="col-12">
              <label class="form-label small fw-medium">
                Material <span class="text-danger">*</span>
                <span class="text-muted fw-normal">(digunakan untuk TF-IDF)</span>
              </label>
              <input type="text" name="material"
                value="{{ old('material', $product->material ?? '') }}"
                class="form-control @error('material') is-invalid @enderror"
                placeholder="cth: Kayu jati solid, busa high-density, kain linen abu-abu">
              @error('material') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Upload Gambar --}}
            <div class="col-12">
              <label class="form-label small fw-medium">Gambar produk</label>
              <div class="d-flex align-items-start gap-3 flex-wrap">

                {{-- Preview gambar --}}
                <div id="imgWrapper" class="position-relative" style="width: 140px; height: 140px; flex-shrink: 0;">
                  @php
                    $hasImage = isset($product) && $product->image_url;
                  @endphp
                  <div 
                    id="imgPlaceholder"
                    class="img-preview d-flex align-items-center justify-content-center bg-light position-absolute top-0 start-0 w-100 h-100 {{ $hasImage ? 'd-none' : '' }}"
                    style="border: 1px solid #e5e7eb; border-radius: 10px; width: 140px; height: 140px; overflow: hidden;"
                  >
                    <i class="bi bi-image fs-2 text-muted"></i>
                  </div>
                  <img
                    id="imgPreview"
                    src="{{ $hasImage ? asset($product->image_url) : '' }}"
                    class="img-preview position-absolute top-0 start-0 w-100 h-100 object-fit-cover {{ $hasImage ? '' : 'd-none' }}"
                    style="border: 1px solid #e5e7eb; border-radius: 10px; width: 140px; height: 140px; object-fit: cover; overflow: hidden;"
                    alt="preview"
                  >
                </div>
           

                {{-- Drop zone --}}
                <div class="flex-grow-1">
                  <div class="drop-zone" onclick="document.getElementById('imageInput').click()">
                    <i class="bi bi-cloud-upload fs-3 text-muted d-block mb-2"></i>
                    <div class="small text-muted">Klik untuk pilih gambar</div>
                    <div style="font-size:11px" class="text-muted mt-1">JPG, PNG, WEBP · Maks 2MB</div>
                  </div>
                  <input type="file" id="imageInput" name="image" accept="image/*" class="d-none">
                  @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
              </div>
            </div>

          </div>{{-- end row --}}

          <hr class="my-4">

          <div class="d-flex gap-2 justify-content-end">
            <a href="{{ route('admin.product.index') }}" class="btn btn-outline-secondary">
              Batal
            </a>
            <button type="submit" class="btn btn-pdc">
              <i class="bi bi-check-lg me-1"></i>
              {{ isset($product) ? 'Perbarui produk' : 'Simpan produk' }}
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('imageInput').addEventListener('change', function(e) {
  const file = e.target.files[0];
  if (!file) return;
  const reader = new FileReader();
  reader.onload = function(ev) {
    const preview     = document.getElementById('imgPreview');
    const placeholder = document.getElementById('imgPlaceholder');
    preview.src = ev.target.result;
    preview.classList.remove('d-none');
    if (placeholder) placeholder.classList.add('d-none');
  };
  reader.readAsDataURL(file);
});
</script>
@endsection
