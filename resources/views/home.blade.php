@extends('layouts.landing')

@php use App\Models\Culture; @endphp

@section('content')

{{-- ============ HERO: foto budaya dari berbagai daerah ============ --}}
@if ($cultures->isNotEmpty())
<header id="beranda" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="6500" aria-label="Budaya dari berbagai daerah">
  @if ($cultures->count() > 1)
  <div class="carousel-indicators">
    @foreach ($cultures as $i => $c)
    <button type="button" data-bs-target="#beranda" data-bs-slide-to="{{ $i }}" class="{{ $i === 0 ? 'active' : '' }}" aria-label="{{ $c->name }}" {!! $i === 0 ? 'aria-current="true"' : '' !!}></button>
    @endforeach
  </div>
  @endif
  <div class="carousel-inner">
    @foreach ($cultures as $i => $c)
    <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
      <div class="hero-slide">
        <img src="{{ Culture::imageUrl($c->card_image) }}" alt="" @if ($i > 0) loading="lazy" @endif>
        <div class="container hero-content">
          <span class="hero-badge mb-3">{{ $c->province }}</span>
          <h1 class="mb-3">Budaya {{ $c->name }}</h1>
          <p class="lead mb-4">{{ $c->tagline }}</p>
          <a href="{{ route('culture.show', $c->slug) }}" class="btn btn-secondary">Jelajahi budaya {{ $c->name }}</a>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  @if ($cultures->count() > 1)
  <button class="carousel-control-prev" type="button" data-bs-target="#beranda" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Sebelumnya</span></button>
  <button class="carousel-control-next" type="button" data-bs-target="#beranda" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Berikutnya</span></button>
  @endif
</header>
@else
<header id="beranda" class="hero-empty">
  <div class="container">
    <h1 class="mb-3">Budaya Nusantara</h1>
    <p class="lead mb-0">Halaman budaya daerah sedang disiapkan.</p>
  </div>
</header>
@endif

{{-- ============ TENTANG ============ --}}
<section id="tentang" class="py-5 my-lg-4">
  <div class="container">
    <div class="row g-5 align-items-center">
      @if ($cultures->isNotEmpty())
      <div class="col-lg-6">
        <img class="about-img" src="{{ Culture::imageUrl($cultures->first()->card_image) }}" alt="Budaya {{ $cultures->first()->name }}" loading="lazy">
      </div>
      @endif
      <div class="col-lg-6">
        <span class="section-label mb-2">Tentang situs ini</span>
        <h2 class="mb-3">Satu pintu untuk mengenal budaya Indonesia</h2>
        <p class="mb-4">Indonesia punya ribuan budaya yang tumbuh di pulau-pulau berbeda. Situs ini mengumpulkannya di satu tempat, daerah demi daerah, lewat foto dan penjelasan yang ditulis supaya mudah dibaca siapa saja, termasuk pembaca dari luar negeri.</p>
        <ul class="list-unstyled about-list mb-0">
          <li><i>✓</i><span>Foto dan naskah asli dari tiap daerah</span></li>
          <li><i>✓</i><span>Penjelasan yang mudah diikuti sambil menggulir halaman</span></li>
          <li><i>✓</i><span>Satu halaman khusus untuk setiap budaya daerah</span></li>
        </ul>
      </div>
    </div>
  </div>
</section>

{{-- ============ ANGKA ============ --}}
<section class="facts py-5">
  <div class="container">
    <div class="row g-4 text-center">
      <div class="col-md-4"><h2 class="mb-1">{{ $cultures->count() }}</h2><p>Budaya daerah</p></div>
      <div class="col-md-4"><h2 class="mb-1">{{ $provinceCount }}</h2><p>Provinsi</p></div>
      <div class="col-md-4"><h2 class="mb-1">{{ $entryCount }}</h2><p>Foto dan penjelasan</p></div>
    </div>
  </div>
</section>

{{-- ============ DAFTAR BUDAYA ============ --}}
<section id="budaya" class="py-5 my-lg-4 bg-light">
  <div class="container">
    <div class="text-center mx-auto mb-5" style="max-width: 640px">
      <span class="section-label mb-2">Budaya Daerah</span>
      <h2 class="mb-3">Pilih daerah, lalu mulai membaca</h2>
      <p class="mb-0">Setiap kartu membuka halaman budaya daerahnya sendiri.</p>
    </div>
    <div class="row g-4">
      @forelse ($cultures as $c)
      <div class="col-md-6 col-lg-4">
        <article class="culture-card position-relative">
          <img src="{{ Culture::imageUrl($c->card_image) }}" alt="Budaya {{ $c->name }}" loading="lazy">
          <div class="p-4">
            <p class="province mb-1">{{ $c->province }}</p>
            <h3 class="h5 mb-2">{{ $c->name }}</h3>
            <p class="mb-3">{{ $c->tagline }}</p>
            <a class="stretched-link" href="{{ route('culture.show', $c->slug) }}">Buka halaman →</a>
          </div>
        </article>
      </div>
      @empty
      <p class="text-center">Belum ada budaya yang ditampilkan.</p>
      @endforelse
    </div>
  </div>
</section>

@endsection
