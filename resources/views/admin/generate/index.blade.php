@extends('admin.layouts.app')
@section('title', 'Generate TF-IDF')
@section('page-title', 'Generate Dataset Rekomendasi')

@section('extra-style')
<style>
  .step-card { border-radius: 12px; border: 1px solid #e8e7e0; padding: 18px 20px; background:#fff }
  .step-icon { font-size: 28px; margin-bottom: 10px }
  .step-num  { width:22px; height:22px; border-radius:50%; background:#534AB7;
               color:#fff; font-size:11px; font-weight:600;
               display:inline-flex; align-items:center; justify-content:center; margin-bottom:8px }
  .log-box   { background:#1a1a18; color:#c2c0b6; font-family:monospace;
               font-size:12px; border-radius:10px; padding:16px;
               max-height:280px; overflow-y:auto; line-height:1.7 }
  .log-box .ok   { color: #5DCAA5 }
  .log-box .err  { color: #F09595 }
  .log-box .head { color: #AFA9EC; font-weight: bold }
  .prog-bar  { height:6px; border-radius:3px; background:#e8e7e0; overflow:hidden; margin-top:8px }
  .prog-fill { height:100%; border-radius:3px; background:#534AB7}
  .stat-num  { font-size:22px; font-weight:600 }
</style>
@endsection

@section('content')

{{-- ══ Stat Cards ══ --}}
<div class="row g-3 mb-4">
  <div class="col-6 col-md-3">
    <div class="step-card text-center">
      <div class="text-muted small mb-1">Total produk</div>
      <div class="stat-num text-primary">{{ $stats['total_products'] }}</div>
      <div class="prog-bar"><div class="prog-fill" style="width:100%"></div></div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="step-card text-center">
      <div class="text-muted small mb-1">Sudah preprocessing</div>
      <div class="stat-num text-success">{{ $stats['preprocessed'] }}</div>
      <div class="prog-bar">
        <div class="prog-fill" style="background:#1D9E75;width:{{ $stats['total_products'] > 0 ? ($stats['preprocessed']/$stats['total_products']*100) : 0 }}%"></div>
      </div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="step-card text-center">
      <div class="text-muted small mb-1">Sudah TF-IDF</div>
      <div class="stat-num" style="color:#854F0B">{{ $stats['normalized'] }}</div>
      <div class="prog-bar">
        <div class="prog-fill" style="background:#EF9F27;width:{{ $stats['total_products'] > 0 ? ($stats['normalized']/$stats['total_products']*100) : 0 }}%"></div>
      </div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="step-card text-center">
      <div class="text-muted small mb-1">Similarity pairs</div>
      <div class="stat-num text-secondary">{{ $stats['similarity_pairs'] }}</div>
      <div class="prog-bar"><div class="prog-fill" style="background:#9c9a92;width:100%"></div></div>
    </div>
  </div>
</div>

{{-- ══ Tombol Generate ══ --}}
<div class="card mb-4">
  <div class="card-header py-3 px-4 fw-medium">
    <i class="bi bi-cpu me-2"></i>Jalankan proses generate
  </div>
  <div class="card-body px-4 py-4">
    <div class="row g-3">

      {{-- Generate semua --}}
      <div class="col-12">
        <div class="step-card border-primary border-2 d-flex align-items-center gap-4 flex-wrap">
          <div>
            <div class="step-icon text-primary"><i class="bi bi-lightning-charge-fill"></i></div>
            <div class="fw-medium mb-1">Generate semua sekaligus</div>
            <div class="text-muted small">Jalankan preprocessing + TF-IDF + cosine similarity dalam satu klik</div>
          </div>
          <form action="{{ route('admin.generate.run') }}" method="POST" class="ms-auto"
            onsubmit="return confirm('Generate ulang akan menghapus data lama. Lanjutkan?')">
            @csrf
            <button type="submit" class="btn btn-pdc px-4">
              <i class="bi bi-play-fill me-1"></i>Generate sekarang
            </button>
          </form>
        </div>
      </div>

      {{-- Step 1: Preprocessing --}}
      <div class="col-md-4">
        <div class="step-card h-100">
          <div class="step-num">1</div>
          <div class="step-icon text-primary"><i class="bi bi-text-wrap"></i></div>
          <div class="fw-medium mb-1">Preprocessing</div>
          <div class="text-muted small mb-3">Lowercase · stopword removal · stemming</div>
          <form action="{{ route('admin.generate.preprocessing') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-primary w-100">
              <i class="bi bi-play me-1"></i>Jalankan
            </button>
          </form>
        </div>
      </div>

      {{-- Step 2: TF-IDF --}}
      <div class="col-md-4">
        <div class="step-card h-100">
          <div class="step-num">2</div>
          <div class="step-icon" style="color:#854F0B"><i class="bi bi-bar-chart-line"></i></div>
          <div class="fw-medium mb-1">Normalisasi TF-IDF</div>
          <div class="text-muted small mb-3">Hitung bobot term per dokumen</div>
          <form action="{{ route('admin.generate.normalization') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm w-100" style="border-color:#854F0B;color:#854F0B">
              <i class="bi bi-play me-1"></i>Jalankan
            </button>
          </form>
        </div>
      </div>

      {{-- Step 3: Cosine --}}
      <div class="col-md-4">
        <div class="step-card h-100">
          <div class="step-num">3</div>
          <div class="step-icon text-success"><i class="bi bi-bezier2"></i></div>
          <div class="fw-medium mb-1">Cosine similarity</div>
          <div class="text-muted small mb-3">Hitung kemiripan antar produk</div>
          <form action="{{ route('admin.generate.similarity') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-success w-100">
              <i class="bi bi-play me-1"></i>Jalankan
            </button>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>

{{-- ══ Log Output ══ --}}
@if(session('generate_log'))
<div class="card mb-4">
  <div class="card-header py-3 px-4 fw-medium">
    <i class="bi bi-terminal me-2"></i>Log proses
  </div>
  <div class="card-body px-4 py-3">
    <div class="log-box" id="logBox">
      @foreach(session('generate_log') as $line)
        @if(str_starts_with($line, '==='))
          <div class="head">{{ $line }}</div>
        @elseif(str_starts_with($line, '✓'))
          <div class="ok">{{ $line }}</div>
        @elseif(str_starts_with($line, '✗'))
          <div class="err">{{ $line }}</div>
        @else
          <div>{{ $line }}</div>
        @endif
      @endforeach
    </div>
  </div>
</div>
@endif

{{-- ══ Sample Preprocessing ══ --}}
@if($preprocessingSample->isNotEmpty())
<div class="card mb-4">
  <div class="card-header py-3 px-4 fw-medium">
    <i class="bi bi-text-wrap me-2"></i>Sample hasil preprocessing
  </div>
  <div class="table-responsive">
    <table class="table table-hover small mb-0">
      <thead class="table-light">
        <tr>
          <th class="ps-4">Produk</th>
          <th>Cleaned text (10 token pertama)</th>
          <th>Jumlah token</th>
        </tr>
      </thead>
      <tbody>
        @foreach($preprocessingSample as $prep)
        <tr>
          <td class="ps-4 fw-medium">{{ $prep->product->name ?? '-' }}</td>
          <td>
            <div class="d-flex flex-wrap gap-1">
              @foreach(array_slice(json_decode($prep->tokens, true) ?? [], 0, 10) as $token)
                <span class="badge badge-purple">{{ $token }}</span>
              @endforeach
            </div>
          </td>
          <td>{{ count(json_decode($prep->tokens, true) ?? []) }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endif

{{-- ══ Sample Similarity Score ══ --}}
@if($similaritySample->isNotEmpty())
<div class="card">
  <div class="card-header py-3 px-4 fw-medium">
    <i class="bi bi-bezier2 me-2"></i>Top 10 similarity score tertinggi
  </div>
  <div class="table-responsive">
    <table class="table table-hover small mb-0">
      <thead class="table-light">
        <tr>
          <th class="ps-4">Produk A</th>
          <th>Produk B</th>
          <th>Cosine score</th>
          <th>Tingkat kemiripan</th>
        </tr>
      </thead>
      <tbody>
        @foreach($similaritySample as $sim)
        <tr>
          <td class="ps-4 fw-medium">{{ $sim->productA->name ?? '-' }}</td>
          <td class="fw-medium">{{ $sim->productB->name ?? '-' }}</td>
          <td>
            @php $s = $sim->cosine_score; @endphp
            @if($s >= 0.7)
              <span class="badge badge-teal">{{ number_format($s, 4) }}</span>
            @elseif($s >= 0.4)
              <span class="badge badge-purple">{{ number_format($s, 4) }}</span>
            @else
              <span class="badge badge-amber">{{ number_format($s, 4) }}</span>
            @endif
          </td>
          <td>
            <div style="width:100px;background:#e8e7e0;border-radius:4px;height:8px;overflow:hidden">
              <div style="width:{{ $s * 100 }}%;background:#534AB7;height:100%;border-radius:4px"></div>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endif

@endsection

@section('scripts')
<script>
  // Auto scroll log ke bawah
  const logBox = document.getElementById('logBox');
  if (logBox) logBox.scrollTop = logBox.scrollHeight;
</script>
@endsection
