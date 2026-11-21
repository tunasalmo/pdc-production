@extends('public.layouts.app')
@section('title', 'Kontak')

@section('extra-style')
<style>
  .contact-hero {
    background: linear-gradient(135deg, var(--pdc-accent-bg, #EEEDFE) 0%, var(--pdc-bg, #f5f5f0) 60%);
    padding: 56px 0 48px;
    border-bottom: 1px solid var(--pdc-border, #e0dfd8);
  }
  .contact-hero h1 {
    font-size: 28px;
    font-weight: 600;
    letter-spacing: -0.02em;
    color: var(--pdc-text, #232323);
  }
  .contact-card {
    border: 1px solid var(--pdc-border, #e8e7e0);
    border-radius: 16px;
    background: var(--pdc-bg-elevated, #fff);
    overflow: hidden;
  }
  .contact-item {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    padding: 20px 24px;
    border-bottom: 1px solid var(--pdc-border, #f0efe8);
    text-decoration: none;
    color: inherit;
    transition: background .15s;
  }
  .contact-item:last-child { border-bottom: none }
  .contact-item:hover { background: var(--pdc-bg-elevated, #fafaf8) }
  .contact-icon {
    width: 46px;
    height: 46px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 20px;
  }
  .contact-label {
    font-size: 12px;
    color: var(--pdc-text-muted, #9a9890);
    margin-bottom: 3px;
  }
  .contact-value {
    font-size: 14px;
    font-weight: 500;
    color: var(--pdc-text, #1a1a18);
  }
  .contact-sub {
    font-size: 12px;
    color: var(--pdc-text-muted, #9a9890);
    margin-top: 2px;
  }
  .form-card {
    border: 1px solid var(--pdc-border, #e8e7e0);
    border-radius: 16px;
    background: var(--pdc-bg-elevated, #fff);
    padding: 28px;
  }
  .form-label {
    font-size: 13px;
    font-weight: 500;
    color: var(--pdc-text, #3d3d3a);
    margin-bottom: 6px;
  }
  .form-control, .form-select {
    border: 1px solid var(--pdc-border, #e8e7e0);
    border-radius: 10px;
    font-size: 13px;
    padding: 10px 14px;
    transition: border-color .15s, box-shadow .15s, color .15s, background .15s;
    background: var(--pdc-bg-elevated, #fff);
    color: var(--pdc-text, #232323);
  }
  .form-control:focus, .form-select:focus {
    border-color: var(--pdc-accent, #534AB7);
    box-shadow: 0 0 0 3px rgba(83,74,183,.14);
    outline: none;
    background: var(--pdc-bg-elevated, #fff); /* Tidak berubah, tetap seperti tidak fokus */
    color: var(--pdc-text, #232323); /* Pastikan font tetap terang */
  }
  .form-control:-webkit-autofill,
  .form-select:-webkit-autofill {
    -webkit-box-shadow: 0 0 0 100px var(--pdc-bg-elevated, #fff) inset !important;
    -webkit-text-fill-color: var(--pdc-text, #232323) !important;
    caret-color: var(--pdc-text, #232323);
    transition: background-color 9999s ease-in-out 0s;
  }
  .form-control::placeholder, .form-select::placeholder {
    color: var(--pdc-text-muted, #9a9890);
    opacity: 1;
  }
  .btn-send {
    background: var(--pdc-accent, #534AB7);
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 11px 24px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: background .15s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }
  .btn-send:hover {
    background: #3d358f;
  }
  .btn-wa {
    background: #25D366;
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 11px 20px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: background .15s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
  }
  .btn-wa:hover {
    background: #1da851;
    color: #fff;
  }
  .map-placeholder {
    border-radius: 14px;
    overflow: hidden;
    border: 1px solid var(--pdc-border, #e8e7e0);
    background: var(--pdc-bg-elevated, #fff);
    height: 220px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    gap: 8px;
    color: var(--pdc-text-subtle, #6b6b67);
  }
  .faq-item {
    border: 1px solid var(--pdc-border, #e8e7e0);
    border-radius: 12px;
    padding: 18px 20px;
    background: var(--pdc-bg-elevated, #fff);
    margin-bottom: 10px;
  }
  .faq-q {
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 8px;
    color: var(--pdc-text, #232323);
  }
  .faq-a {
    font-size: 13px;
    color: var(--pdc-text-subtle, #6b6b67);
    line-height: 1.6;
  }
  
</style>
@endsection

@section('content')

{{-- Hero --}}
<div class="contact-hero">
  <div class="container">
    <div class="text-muted small mb-2">
      <i class="bi bi-envelope me-1"></i>Hubungi kami
    </div>
    <h1>Kontak</h1>
    <p class="text-muted mt-2" style="font-size:15px;max-width:480px">
      Ada pertanyaan tentang produk atau butuh informasi lebih lanjut?
      Tim kami siap membantu.
    </p>
  </div>
</div>

<div class="container py-5">
  <div class="row g-4">

    {{-- Kolom kiri: info kontak --}}
    <div class="col-md-5">

      {{-- Info kontak --}}
      <div class="contact-card mb-4">
        <a href="https://wa.me/6281315147845?text=Halo+PDC+Production%2C+saya+ingin+bertanya"
           target="_blank" class="contact-item">
          <div class="contact-icon">
            <i class="bi bi-whatsapp"></i>
          </div>
          <div>
            <div class="contact-label">WhatsApp</div>
            <div class="contact-value">+62 813-1514-7845</div>
            <div class="contact-sub">Senin–Sabtu, 09.00–17.00 WIB</div>
          </div>
          <i class="bi bi-arrow-right ms-auto text-muted"></i>
        </a>
        <a href="mailto:agusjkt99@gmail.com" class="contact-item">
          <div class="contact-icon">
            <i class="bi bi-envelope"></i>
          </div>
          <div>
            <div class="contact-label">Email</div>
            <div class="contact-value">agusjkt99@gmail.com</div>
            <div class="contact-sub">Dibalas dalam 1×24 jam</div>
          </div>
          <i class="bi bi-arrow-right ms-auto text-muted"></i>
        </a>
        <div class="contact-item">
          <div class="contact-icon">
            <i class="bi bi-geo-alt"></i>
          </div>
          <div>
            <div class="contact-label">Alamat</div>
            <div class="contact-value">MQ89+MR5, Pondok Cabe Ilir, Pamulang, South Tangerang City</div>
            <div class="contact-sub">Banten, Indonesia 15418</div>
          </div>
        </div>
        <div class="contact-item">
          <div class="contact-icon">
            <i class="bi bi-clock"></i>
          </div>
          <div>
            <div class="contact-label">Jam operasional</div>
            <div class="contact-value">Senin – Sabtu</div>
            <div class="contact-sub">09.00 – 17.00 WIB</div>
          </div>
        </div>
      </div>

      {{-- Maps placeholder --}}
      <div class="map-placeholder">
        <i class="bi bi-map" ></i>
        <div>MQ89+MR5, Pondok Cabe Ilir, Pamulang, South Tangerang City, Banten 15418</div>
        <a href="https://www.google.com/maps/place/MQ89%2BMR5,+Pondok+Cabe+Ilir,+Pamulang,+South+Tangerang+City,+Banten+15418/@-6.3333858,106.7694407,46m/data=!3m1!1e3!4m6!3m5!1s0x2e69efad3b757bbf:0x4bbf06a129356a96!8m2!3d-6.3333737!4d106.7694708!16s%2Fg%2F11sh6d_7xf?entry=ttu&g_ep=EgoyMDI2MDcyOS4wIKXMDSoASAFQAw%3D%3D" target="_blank">
          <i class="bi bi-box-arrow-up-right me-1"></i>Buka di Google Maps
        </a>
      </div>

    </div>

    {{-- Kolom kanan: form pesan --}}
    <div class="col-md-7">
      <div class="form-card">
        <div style="font-size:16px;font-weight:600;margin-bottom:4px">Kirim pesan</div>
        <div style="font-size:13px;color:#9a9890;margin-bottom:24px">
          Isi form di bawah dan kami akan segera menghubungi Anda
        </div>

        @if(session('success'))
          <div class="alert alert-success py-2 small mb-3" role="alert">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
          </div>
        @endif

        <form action="{{ route('public.contact.send') }}" method="POST" novalidate>
          @csrf
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label">Nama lengkap <span class="text-danger">*</span></label>
              <input required type="text" name="name" value="{{ old('name') }}"
                class="form-control @error('name') is-invalid @enderror"
                placeholder="Nama Anda">
              @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
              <label class="form-label">Nomor WhatsApp / Telepon</label>
              <input required type="text" name="phone" value="{{ old('phone') }}"
                class="form-control" placeholder="08xx-xxxx-xxxx">
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Email <span class="text-danger">*</span></label>
            <input required type="email" name="email" value="{{ old('email') }}"
              class="form-control @error('email') is-invalid @enderror"
              placeholder="nama@email.com">
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Topik</label>
            <select required name="topic" class="form-select">
              <option value="">-- Pilih topik --</option>
              <option value="info_produk"   {{ old('topic')=='info_produk'   ? 'selected':'' }}>Informasi produk</option>
              <option value="harga"         {{ old('topic')=='harga'         ? 'selected':'' }}>Harga dan pemesanan</option>
              <option value="ketersediaan"  {{ old('topic')=='ketersediaan'  ? 'selected':'' }}>Ketersediaan stok</option>
              <option value="pengiriman"    {{ old('topic')=='pengiriman'    ? 'selected':'' }}>Pengiriman</option>
              <option value="lainnya"       {{ old('topic')=='lainnya'       ? 'selected':'' }}>Lainnya</option>
            </select>
          </div>

          <div class="mb-4">
            <label class="form-label">Pesan <span class="text-danger">*</span></label>
            <textarea required name="message" rows="5"
              class="form-control @error('message') is-invalid @enderror"
              placeholder="Tuliskan pertanyaan atau pesan Anda...">{{ old('message') }}</textarea>
            @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="d-flex gap-2 flex-wrap">
            <button type="submit" class="btn-send">
              <i class="bi bi-send"></i> Kirim pesan
            </button>
            <a href="https://wa.me/6281234567890?text=Halo+PDC+Production%2C+saya+ingin+bertanya"
               target="_blank" class="btn-wa">
              <i class="bi bi-whatsapp"></i> Chat WhatsApp
            </a>
          </div>
        </form>
      </div>

      {{-- FAQ --}}
      <div class="mt-4">
        <div style="font-size:15px;font-weight:600;margin-bottom:14px">
          Pertanyaan yang sering ditanyakan
        </div>
        <div class="faq-item">
          <div class="faq-q">Apakah produk bisa dipesan secara online?</div>
          <div class="faq-a">Untuk pemesanan, Anda dapat menghubungi kami melalui WhatsApp atau email. Tim kami akan membantu proses pemesanan dan pengiriman.</div>
        </div>
        <div class="faq-item">
          <div class="faq-q">Bagaimana cara kerja rekomendasi produk?</div>
          <div class="faq-a">Sistem kami menggunakan algoritma Content-Based Filtering dengan TF-IDF dan Cosine Similarity untuk merekomendasikan produk serupa berdasarkan kemiripan deskripsi dan material.</div>
        </div>
        <div class="faq-item">
          <div class="faq-q">Apakah ada layanan pengiriman ke luar kota?</div>
          <div class="faq-a">Ya, kami melayani pengiriman ke seluruh Indonesia. Biaya dan estimasi pengiriman akan dikonfirmasi setelah pemesanan.</div>
        </div>
      </div>

    </div>
  </div>
</div>

@endsection
