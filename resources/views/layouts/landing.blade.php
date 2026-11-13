<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', 'Budaya Nusantara — mengenal budaya Indonesia')</title>
<meta name="description" content="@yield('description', 'Kumpulan budaya Indonesia dari berbagai daerah, disajikan lewat foto dan penjelasan yang mudah dibaca.')">
<meta property="og:type" content="website">
<meta property="og:title" content="@yield('title', 'Budaya Nusantara — mengenal budaya Indonesia')">
<link rel="icon" href="data:image/svg+xml,%3Csvg%20xmlns%3D'http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg'%20viewBox%3D'0%200%2064%2064'%3E%3Crect%20width%3D'64'%20height%3D'64'%20rx%3D'14'%20fill%3D'%235B8C51'%2F%3E%3Ctext%20x%3D'32'%20y%3D'45'%20font-family%3D'Georgia%2Cserif'%20font-size%3D'38'%20font-weight%3D'700'%20text-anchor%3D'middle'%20fill%3D'%23fff'%3EB%3C%2Ftext%3E%3C%2Fsvg%3E">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
@php $landingCss = public_path('assets/landing/landing.css'); @endphp
<link href="{{ asset('assets/landing/landing.css') }}?v={{ is_file($landingCss) ? filemtime($landingCss) : 1 }}" rel="stylesheet">
</head>
<body id="top">
<nav class="navbar navbar-expand-lg sticky-top site-nav">
  <div class="container">
    <a class="navbar-brand" href="{{ route('home') }}">Budaya Nusantara</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Buka menu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#top">Beranda</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#tentang">Tentang</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#budaya">Budaya Daerah</a></li>
      </ul>
    </div>
  </div>
</nav>

@yield('content')

<footer class="site-footer py-5">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-6">
        <h5 class="brand-font mb-3">Budaya Nusantara</h5>
        <p class="mb-0">Mengenalkan kekayaan budaya Indonesia kepada pembaca di mana pun, daerah demi daerah, lewat foto dan penjelasan.</p>
      </div>
      <div class="col-lg-3 col-6">
        <h5 class="mb-3">Jelajahi</h5>
        <ul class="list-unstyled mb-0">
          <li><a href="{{ route('home') }}#tentang">Tentang</a></li>
          <li><a href="{{ route('home') }}#budaya">Budaya Daerah</a></li>
        </ul>
      </div>
      <div class="col-lg-3 col-6">
        <h5 class="mb-3">Budaya</h5>
        <ul class="list-unstyled mb-0">
          @foreach (($cultures ?? collect()) as $c)
          <li><a href="{{ route('culture.show', $c->slug) }}">{{ $c->name }}</a></li>
          @endforeach
        </ul>
      </div>
    </div>
    <div class="small-credit mt-4 pt-3 small d-flex flex-wrap justify-content-between gap-2">
      <span>© {{ date('Y') }} Budaya Nusantara</span>
      <span>Tampilan beranda terinspirasi template Dairy (HTML Codex)</span>
    </div>
  </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
