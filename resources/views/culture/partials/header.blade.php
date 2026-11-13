@php
    $nav = [
        ['href' => route('home'), 'label' => 'Beranda', 'menu' => 'Beranda — semua budaya'],
        ['href' => '#naskah', 'label' => $culture->gallery_label, 'menu' => $culture->gallery_label . ' ' . $culture->name],
        ['href' => '#footer', 'label' => 'Tentang', 'menu' => 'Tentang dokumentasi'],
    ];
@endphp
<a class="visually-hidden" href="#main">Lompat ke konten</a>
<header id="header" data-8b-section="navigation">
  <a class="hd-logo" href="#hero" aria-label="{{ $culture->name }}, kembali ke atas"><span class="hd-mark" aria-hidden="true"><i></i><i></i><i></i></span><span class="hd-word">{{ $culture->name }}</span></a>
  <nav class="hd-nav" aria-label="Utama">
    <ul>
      @foreach ($nav as $item)
      <li><a class="m-link-2" href="{{ $item['href'] }}">{{ $item['label'] }}</a></li>
      @endforeach
    </ul>
  </nav>
  <a class="m-btn hd-book" href="#naskah"><span class="m-btn__label">{{ $culture->hero_cta_label }}</span></a>
  <button class="m-icon hd-menu" type="button" aria-expanded="false" aria-controls="menu"><span class="visually-hidden">Buka menu</span><span class="m-icon__glyph" aria-hidden="true"></span></button>
  <div id="menu" role="dialog" aria-modal="true" aria-label="Menu" hidden>
    <div class="mn-top"><button class="m-icon mn-close" type="button"><span class="visually-hidden">Tutup menu</span><span class="m-icon__glyph m-icon__glyph--close" aria-hidden="true"></span></button></div>
    <ul class="mn-list">
      @foreach ($nav as $item)
      <li><a href="{{ $item['href'] }}">{{ $item['menu'] }}</a></li>
      @endforeach
    </ul>
    <p class="mn-foot m-text-6"><span>Budaya Nusantara · {{ $culture->province }}</span></p>
  </div>
</header>
