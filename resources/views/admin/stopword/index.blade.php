@extends('admin.layouts.app')
@section('title', 'Manajemen Stopword')
@section('page-title', 'Manajemen Stopword')

@section('extra-style')
<style>
  .word-grid {
    display: flex; flex-wrap: wrap; gap: 8px;
  }
  .word-badge {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 5px 10px; border-radius: 20px; font-size: 12px;
    background: #f5f5f0; border: 1px solid #e8e7e0;
    color: #3d3d3a; transition: all .15s;
  }
  .word-badge:hover { background: #FCEBEB; border-color: #F09595 }
  .word-badge .del-btn {
    background: none; border: none; cursor: pointer;
    color: #c0bfb8; padding: 0; line-height: 1;
    font-size: 13px; transition: color .15s;
  }
  .word-badge:hover .del-btn { color: #E24B4A }
  .search-active { background: #EEEDFE; border-color: #AFA9EC; color: #26215C }
  .tab-btn {
    padding: 8px 16px; border: none; background: transparent;
    font-size: 13px; color: var(--text-secondary); cursor: pointer;
    border-bottom: 2px solid transparent; transition: all .15s;
  }
  .tab-btn.active { color: #534AB7; border-bottom-color: #534AB7; font-weight: 500 }
  .tab-content { display: none }
  .tab-content.active { display: block }
</style>
@endsection

@section('content')

{{-- ══ Stat bar ══ --}}
<div class="d-flex align-items-center gap-3 mb-3 flex-wrap">
  <div class="card px-4 py-2 d-flex flex-row align-items-center gap-3 mb-0" style="border-radius:10px">
    <div>
      <div style="font-size:11px;color:#9a9890">Total stopword</div>
      <div style="font-size:22px;font-weight:600;color:#534AB7">{{ $total }}</div>
    </div>
    <i class="bi bi-filter fs-3 text-muted opacity-25"></i>
  </div>
  <div class="text-muted small">
    <i class="bi bi-info-circle me-1"></i>
    Stopword adalah kata umum yang diabaikan saat proses TF-IDF.
    Setelah mengubah daftar ini, jalankan ulang <strong>Generate TF-IDF</strong>.
  </div>
  <form action="{{ route('admin.stopword.reset') }}" method="POST" class="ms-auto"
    onsubmit="return confirm('Reset akan menghapus semua stopword kustom dan kembali ke daftar default. Lanjutkan?')">
    @csrf
    <button type="submit" class="btn btn-sm btn-outline-danger">
      <i class="bi bi-arrow-counterclockwise me-1"></i>Reset ke default
    </button>
  </form>
</div>

<div class="row g-3">

  {{-- ══ Kolom kiri: form tambah ══ --}}
  <div class="col-md-4">

    {{-- Tab --}}
    <div class="card">
      <div class="card-header px-0 pt-3 pb-0">
        <div class="d-flex px-3">
          <button class="tab-btn active" onclick="switchTab('single', this)">
            <i class="bi bi-plus-circle me-1"></i>Tambah satu
          </button>
          <button class="tab-btn" onclick="switchTab('bulk', this)">
            <i class="bi bi-collection me-1"></i>Tambah banyak
          </button>
        </div>
        <hr class="mt-0 mb-0">
      </div>
      <div class="card-body px-4 py-3">

        {{-- Tab: tambah satu --}}
        <div class="tab-content active" id="tab-single">
          <form action="{{ route('admin.stopword.store') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label class="form-label small fw-medium">Kata stopword</label>
              <input type="text" name="word" value="{{ old('word') }}"
                class="form-control form-control-sm @error('word') is-invalid @enderror"
                placeholder="cth: sangat, juga, hanya"
                autocomplete="off">
              @error('word')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <div class="form-text">Huruf kecil, satu kata per field</div>
            </div>
            <button type="submit" class="btn btn-pdc btn-sm w-100">
              <i class="bi bi-plus me-1"></i>Tambahkan
            </button>
          </form>
        </div>

        {{-- Tab: tambah banyak --}}
        <div class="tab-content" id="tab-bulk">
          <form action="{{ route('admin.stopword.bulk') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label class="form-label small fw-medium">Daftar kata</label>
              <textarea name="words" rows="7"
                class="form-control form-control-sm @error('words') is-invalid @enderror"
                placeholder="Masukkan kata dipisah koma, spasi, atau enter:&#10;&#10;sangat, juga, hanya&#10;namun&#10;tersebut, selain">{{ old('words') }}</textarea>
              @error('words')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <div class="form-text">Pisahkan dengan koma, spasi, titik koma, atau enter</div>
            </div>
            <button type="submit" class="btn btn-pdc btn-sm w-100">
              <i class="bi bi-collection me-1"></i>Tambahkan semua
            </button>
          </form>
        </div>

      </div>
    </div>

    {{-- Info cara kerja --}}
    <div class="card mt-3" style="border-color:#AFA9EC">
      <div class="card-body px-4 py-3">
        <div class="fw-medium small mb-2" style="color:#534AB7">
          <i class="bi bi-lightbulb me-1"></i>Cara kerja stopword
        </div>
        <div class="text-muted" style="font-size:12px;line-height:1.7">
          Kata yang ada di daftar ini akan <strong>diabaikan</strong> saat proses
          preprocessing TF-IDF. Kata umum seperti "dan", "yang", "dengan"
          tidak membantu membedakan produk satu dengan yang lain,
          sehingga lebih baik dihapus agar vektor TF-IDF lebih akurat.
          <br><br>
          <strong>Kapan perlu ditambah?</strong><br>
          Jika ada kata yang sering muncul di banyak produk tapi tidak
          bermakna sebagai pembeda, seperti "tersedia", "pilihan", "cocok".
          <br><br>
          <strong>Kapan perlu dikurangi?</strong><br>
          Jika ada kata yang ternyata penting sebagai ciri khas produk
          tapi tidak sengaja masuk daftar stopword.
        </div>
      </div>
    </div>
  </div>

  {{-- ══ Kolom kanan: daftar stopword ══ --}}
  <div class="col-md-8">
    <div class="card">
      <div class="card-header py-3 px-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span class="fw-medium">
          <i class="bi bi-list-ul me-2"></i>Daftar stopword
          <span class="badge bg-secondary ms-1">{{ $total }}</span>
        </span>

        {{-- Search --}}
        <form method="GET" action="{{ route('admin.stopword.index') }}"
          class="d-flex gap-2">
          <input type="text" name="search" value="{{ request('search') }}"
            class="form-control form-control-sm"
            placeholder="Cari kata..." style="width:180px">
          <button type="submit" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-search"></i>
          </button>
          @if(request('search'))
            <a href="{{ route('admin.stopword.index') }}"
               class="btn btn-sm btn-outline-danger">
              <i class="bi bi-x"></i>
            </a>
          @endif
        </form>
      </div>
      <div class="card-body px-4 py-3">

        @if(request('search'))
          <div class="mb-3 small text-muted">
            Hasil pencarian "<strong>{{ request('search') }}</strong>" —
            {{ $stopwords->total() }} kata ditemukan
          </div>
        @endif

        @if($stopwords->isEmpty())
          <div class="text-center py-5 text-muted">
            <i class="bi bi-search fs-2 d-block mb-2 opacity-30"></i>
            <div>Tidak ada kata yang cocok dengan "{{ request('search') }}"</div>
          </div>
        @else
          <div class="word-grid">
            @foreach($stopwords as $sw)
              <div class="word-badge">
                <span>{{ $sw->word }}</span>
                <form action="{{ route('admin.stopword.destroy', $sw->id) }}"
                  method="POST" class="d-inline"
                  onsubmit="return confirm('Hapus kata &quot;{{ $sw->word }}&quot; dari stopword?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="del-btn" title="Hapus">
                    <i class="bi bi-x"></i>
                  </button>
                </form>
              </div>
            @endforeach
          </div>

          {{-- Pagination --}}
          @if($stopwords->hasPages())
            <div class="mt-3">{{ $stopwords->links() }}</div>
          @endif
        @endif

      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
function switchTab(name, btn) {
  document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
  document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
  document.getElementById('tab-' + name).classList.add('active');
  btn.classList.add('active');
}
</script>
@endsection
