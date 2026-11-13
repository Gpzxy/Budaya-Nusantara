<footer id="footer" data-8b-section="footer">
  <div class="ft-next"><span class="ft-rule" data-8b-motion="rule" data-8b-enter="94%"></span><a href="#naskah">{{ $culture->hero_cta_label }}</a></div>
  <div class="ft-grid">
    <div>
      <h2 class="m-text-4">{{ $culture->name }}</h2>
      <ul>
        <li><a class="m-link-2" href="#naskah">{{ $culture->gallery_label }}</a></li>
        <li><a class="m-link-2" href="#hero">Ke atas</a></li>
      </ul>
    </div>
    @if ($culture->about)
    <div>
      <h2 class="m-text-4">Tentang dokumentasi</h2>
      <p class="m-text-6">{{ $culture->about }}</p>
    </div>
    @endif
    @if ($culture->sources)
    <div>
      <h2 class="m-text-4">Sumber</h2>
      <p class="m-text-6">{{ $culture->sources }}</p>
    </div>
    @endif
    <div>
      <h2 class="m-text-4">Budaya lain</h2>
      <ul>
        <li><a class="m-link-2" href="{{ route('home') }}">Semua budaya</a></li>
        @foreach ($others as $other)
        <li><a class="m-link-2" href="{{ route('culture.show', $other->slug) }}">{{ $other->name }}</a></li>
        @endforeach
      </ul>
    </div>
  </div>
  <div class="ft-base m-text-6">
    <span>© {{ date('Y') }} Budaya Nusantara · Desain halaman: Brume by 8B (MIT)</span>
    <a class="m-link-2 ft-top" href="#hero">Ke atas</a>
  </div>
</footer>
