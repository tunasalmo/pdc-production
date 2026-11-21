@extends('public.layouts.app')
@section('title', 'Tentang Kami')

@section('extra-style')
<style>
  .about-hero {
    background: linear-gradient(135deg, var(--pdc-accent-bg, #EEEDFE) 0%, var(--pdc-bg, #f5f5f0) 60%);
    padding: 56px 0 48px;
    border-bottom: 1px solid var(--pdc-border, #e0dfd8);
  }
  .about-hero h1 {
    font-size: 28px;
    font-weight: 600;
    letter-spacing: -0.02em;
    color: var(--pdc-text, #232323);
  }
  .section-block {
    padding: 52px 0;
    border-bottom: 1px solid var(--pdc-border, #e8e7e0);
  }
  .section-block:last-child { border-bottom: none }
  .section-label {
    font-size: 11px; font-weight: 500; letter-spacing: .08em;
    text-transform: uppercase;
    color: var(--pdc-accent, #534AB7);
    margin-bottom: 10px;
  }
  .section-title {
    font-size: 20px;
    font-weight: 600;
    letter-spacing: -.01em;
    margin-bottom: 14px;
    color: var(--pdc-text, #232323);
  }
  .section-body  {
    font-size: 14px;
    color: var(--pdc-text-subtle, #6b6b67);
    line-height: 1.75;
  }
  .feature-card {
    border: 1px solid var(--pdc-border, #e8e7e0);
    border-radius: 14px;
    padding: 22px 20px;
    background: var(--pdc-bg-elevated, #fff);
    height: 100%;
  }
  .feature-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    background: var(--pdc-bg-elevated, #fff);
    border: 1px solid var(--pdc-border, #e8e7e0);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 14px;
  }
  .feature-icon i {
    font-size: 20px;
    color: var(--pdc-accent, #534AB7);
  }
  .feature-title  {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 6px;
    color: var(--pdc-text, #232323);
  }
  .feature-desc   {
    font-size: 13px;
    color: var(--pdc-text-subtle, #6b6b67);
    line-height: 1.6;
  }
  .step-row {
    display: flex;
    gap: 16px;
    align-items: flex-start;
    margin-bottom: 28px;
  }
  .step-num {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: var(--pdc-accent, #534AB7);
    color: #fff;
    font-size: 13px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-top: 2px;
  }
  .step-title {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 4px;
    color: var(--pdc-text, #232323);
  }
  .step-desc  {
    font-size: 13px;
    color: var(--pdc-text-subtle, #6b6b67);
    line-height: 1.6;
  }
  .algo-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    margin: 4px;
    background: var(--pdc-bg-elevated, #fff);
    color: var(--pdc-accent, #534AB7);
    border: 1px solid var(--pdc-accent, #534AB7,);
  }
  .tech-row {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 14px;
  }
  .tech-pill {
    padding: 5px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    border: 1px solid var(--pdc-border, #e8e7e0);
    background: var(--pdc-bg-elevated, #fff);
    color: var(--pdc-text, #3d3d3a);
  }

</style>
@endsection

@section('content')

{{-- Hero --}}
<div class="about-hero">
  <div class="container">
    <div class="text-muted small mb-2">
      <i class="bi bi-info-circle me-1"></i>Tentang kami
    </div>
    <h1>PDC Production</h1>
    <p class="text-muted mt-2" style="font-size:15px;max-width:560px">
      Platform katalog produk interior berbasis sistem rekomendasi Content-Based Filtering
      untuk membantu pelanggan menemukan produk yang paling sesuai kebutuhan.
    </p>
  </div>
</div>

<div class="container">

  {{-- Tentang --}}
  <div class="section-block">
    <div class="row align-items-center g-5">
      <div class="col-md-6">
        <div class="section-label">Tentang sistem</div>
        <div class="section-title">Kenali produk interior terbaik dengan rekomendasi cerdas</div>
        <div class="section-body">
          PDC Production adalah sistem katalog produk interior yang dilengkapi dengan
          fitur rekomendasi berbasis kecerdasan buatan. Sistem ini dirancang untuk membantu
          pelanggan menemukan produk serupa secara otomatis berdasarkan kemiripan deskripsi
          dan material produk, sehingga pengalaman belanja menjadi lebih efisien dan terarah.
        </div>
        <div class="section-body mt-3">
          Sistem ini dibangun sebagai bagian dari penelitian di bidang sistem informasi
          dengan pendekatan <em>Content-Based Filtering</em> menggunakan algoritma
          TF-IDF dan Cosine Similarity.
        </div>
      </div>
      <div class="col-md-6">
        <div class="row g-3">
          <div class="col-6">
            <div class="feature-card">
              <div class="feature-icon"><i class="bi bi-grid-3x3-gap"></i></div>
              <div class="feature-title">Katalog lengkap</div>
              <div class="feature-desc">Daftar produk interior terorganisir berdasarkan kategori dan material</div>
            </div>
          </div>
          <div class="col-6">
            <div class="feature-card">
              <div class="feature-icon"><i class="bi bi-search"></i></div>
              <div class="feature-title">Pencarian cepat</div>
              <div class="feature-desc">Temukan produk dengan kata kunci nama, deskripsi, atau material</div>
            </div>
          </div>
          <div class="col-6">
            <div class="feature-card">
              <div class="feature-icon"><i class="bi bi-cpu"></i></div>
              <div class="feature-title">Rekomendasi otomatis</div>
              <div class="feature-desc">Produk serupa ditampilkan otomatis saat membuka detail produk</div>
            </div>
          </div>
          <div class="col-6">
            <div class="feature-card">
              <div class="feature-icon"><i class="bi bi-whatsapp"></i></div>
              <div class="feature-title">Tanya langsung</div>
              <div class="feature-desc">Hubungi tim kami via WhatsApp langsung dari halaman produk</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Cara kerja algoritma --}}
  <div class="section-block">
    <div class="row g-5">
      <div class="col-md-5">
        <div class="section-label">Cara kerja</div>
        <div class="section-title">Bagaimana sistem rekomendasi bekerja?</div>
        <div class="section-body">
          Sistem menggunakan pendekatan <strong>Content-Based Filtering</strong>
          yang menganalisis kemiripan antar produk berdasarkan konten teksnya,
          bukan berdasarkan perilaku pengguna.
        </div>
        <div class="mt-3 d-flex flex-wrap">
          <span class="algo-badge" >
            <i class="bi bi-text-wrap"></i> TF-IDF
          </span>
          <span class="algo-badge" >
            <i class="bi bi-bezier2"></i> Cosine Similarity
          </span>
          <span class="algo-badge" >
            <i class="bi bi-diagram-3"></i> Content-Based Filtering
          </span>
        </div>
      </div>
      <div class="col-md-7">
        <div class="step-row">
          <div class="step-num">1</div>
          <div>
            <div class="step-title">Preprocessing teks</div>
            <div class="step-desc">
              Teks deskripsi dan material setiap produk dibersihkan — diubah ke huruf kecil,
              dihapus karakter khusus, dihilangkan kata umum (stopword removal),
              dan disederhanakan ke bentuk dasar (stemming).
            </div>
          </div>
        </div>
        <div class="step-row">
          <div class="step-num">2</div>
          <div>
            <div class="step-title">Pembobotan TF-IDF</div>
            <div class="step-desc">
              Setiap kata dalam dokumen diberi bobot menggunakan rumus
              Term Frequency–Inverse Document Frequency. Kata yang sering muncul
              di satu produk tapi jarang di produk lain mendapat bobot lebih tinggi.
            </div>
          </div>
        </div>
        <div class="step-row">
          <div class="step-num">3</div>
          <div>
            <div class="step-title">Perhitungan cosine similarity</div>
            <div class="step-desc">
              Vektor TF-IDF setiap pasang produk dibandingkan menggunakan rumus
              cosine similarity. Nilai mendekati 1 berarti sangat mirip,
              mendekati 0 berarti tidak mirip.
            </div>
          </div>
        </div>
        <div class="step-row" style="margin-bottom:0">
          <div class="step-num">4</div>
          <div>
            <div class="step-title">Tampilkan rekomendasi Top-N</div>
            <div class="step-desc">
              Saat pelanggan membuka detail produk, sistem mengambil 5 produk
              dengan skor cosine similarity tertinggi dan menampilkannya
              sebagai rekomendasi produk serupa.
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Teknologi --}}
  <div class="section-block">
    <div class="section-label">Teknologi</div>
    <div class="section-title">Dibangun dengan</div>
    <div class="row g-4 mt-1">
      <div class="col-md-3 col-6">
        <div class="feature-card text-center">
          <div class="feature-icon mx-auto"><i class="bi bi-code-slash"></i></div>
          <div class="feature-title">Laravel</div>
          <div class="feature-desc">Framework PHP untuk backend dan routing sistem</div>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="feature-card text-center">
          <div class="feature-icon mx-auto"><i class="bi bi-database"></i></div>
          <div class="feature-title">MySQL</div>
          <div class="feature-desc">Penyimpanan data produk, vektor TF-IDF, dan similarity</div>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="feature-card text-center">
          <div class="feature-icon mx-auto"><i class="bi bi-bootstrap"></i></div>
          <div class="feature-title">Bootstrap 5</div>
          <div class="feature-desc">Framework CSS untuk tampilan antarmuka yang responsif</div>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="feature-card text-center">
          <div class="feature-icon mx-auto"><i class="bi bi-translate"></i></div>
          <div class="feature-title">Sastrawi</div>
          <div class="feature-desc">Library stemming bahasa Indonesia untuk preprocessing</div>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection
