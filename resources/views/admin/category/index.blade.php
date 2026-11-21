@extends('admin.layouts.app')

@section('title', 'Kategori')
@section('page-title', 'Manajemen Kategori')

@section('content')
<div class="row g-4">

  {{-- Form Tambah / Edit Kategori --}}
  <div class="col-md-4">
    <div class="card">
      <div class="card-header py-3 px-4">
        <i class="bi bi-plus-circle me-2"></i>Tambah Kategori
      </div>
      <div class="card-body px-4 py-3">
        <form action="{{ route('admin.category.store') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label class="form-label small fw-medium">Nama kategori</label>
            <input type="text" name="name" value="{{ old('name') }}"
              class="form-control form-control-sm @error('name') is-invalid @enderror"
              placeholder="cth: Sofa & Kursi">
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
          <div class="mb-3">
            <label class="form-label small fw-medium">Deskripsi <span class="text-muted">(opsional)</span></label>
            <textarea name="description" rows="3"
              class="form-control form-control-sm"
              placeholder="Deskripsi kategori...">{{ old('description') }}</textarea>
          </div>
          <button type="submit" class="btn btn-pdc btn-sm w-100">
            <i class="bi bi-plus me-1"></i>Simpan kategori
          </button>
        </form>
      </div>
    </div>
  </div>

  {{-- Daftar Kategori --}}
  <div class="col-md-8">
    <div class="card">
      <div class="card-header py-3 px-4">
        <i class="bi bi-tag me-2"></i>Daftar Kategori
        <span class="badge bg-secondary ms-2">{{ $categories->count() }}</span>
      </div>
      <div class="table-responsive">
        <table class="table table-hover small mb-0">
          <thead class="table-light">
            <tr>
              <th class="ps-4" style="width:40px">#</th>
              <th>Nama</th>
              <th>Slug</th>
              <th>Produk</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($categories as $i => $cat)
            <tr>
              <td class="ps-4 text-muted">{{ $i + 1 }}</td>
              <td class="fw-medium">{{ $cat->name }}</td>
              <td><code class="text-muted">{{ $cat->slug }}</code></td>
              <td><span class="badge badge-purple">{{ $cat->products_count }}</span></td>
              <td>
                <div class="d-flex gap-1">
                  {{-- Tombol Edit --}}
                  <button class="btn btn-sm btn-outline-secondary"
                    onclick="openEdit({{ $cat->id }}, '{{ addslashes($cat->name) }}', '{{ addslashes($cat->description) }}')">
                    <i class="bi bi-pencil"></i>
                  </button>
                  {{-- Tombol Hapus --}}
                  <form action="{{ route('admin.category.destroy', $cat->id) }}" method="POST"
                    onsubmit="return confirm('Hapus kategori {{ $cat->name }}?')">
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
              <td colspan="5" class="text-center text-muted py-4">
                <i class="bi bi-inbox fs-4 d-block mb-2"></i>Belum ada kategori
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

{{-- Modal Edit Kategori --}}
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header py-3">
        <h6 class="modal-title"><i class="bi bi-pencil me-2"></i>Edit Kategori</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="editForm" method="POST">
        @csrf @method('PUT')
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label small fw-medium">Nama</label>
            <input type="text" name="name" id="editName" class="form-control form-control-sm">
          </div>
          <div class="mb-3">
            <label class="form-label small fw-medium">Deskripsi</label>
            <textarea name="description" id="editDesc" rows="3" class="form-control form-control-sm"></textarea>
          </div>
        </div>
        <div class="modal-footer py-2">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-sm btn-pdc">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
function openEdit(id, name, desc) {
  document.getElementById('editName').value = name;
  document.getElementById('editDesc').value = desc;
  document.getElementById('editForm').action = '/admin/category/' + id;
  new bootstrap.Modal(document.getElementById('editModal')).show();
}
</script>
@endsection
