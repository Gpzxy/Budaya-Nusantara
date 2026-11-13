@php
    use App\Models\Culture;
    $entries = $culture->entries;
    $total = $entries->count();
    $pad = fn ($n) => str_pad((string) $n, 2, '0', STR_PAD_LEFT);
    $titleLines = Culture::lines($culture->gallery_title);
@endphp
<section id="naskah" class="l-sec" data-8b-section="naskah" aria-labelledby="naskah-title">
  <p class="m-rail">{{ $culture->gallery_label }}</p>
  <div class="nk-head">
    <h2 id="naskah-title" class="m-text-3 nk-title">@foreach ($titleLines as $line)<span>{{ $line }}</span>@endforeach</h2>
    <p class="m-text-5" data-8b-motion="steam">{{ $culture->gallery_intro }}</p>
    @if ($culture->gallery_note)
    <p class="nk-note m-text-6">{{ $culture->gallery_note }}</p>
    @endif
  </div>
  <div class="nk-body{{ $culture->photo_side === 'left' ? ' nk-body--left' : '' }}">
    <ol class="nk-steps">
      @foreach ($entries as $i => $p)
      <li class="nk-step{{ $i === 0 ? ' is-active' : '' }}" data-index="{{ $i }}">
        <p class="nk-num m-text-4">{{ $i + 1 }} dari {{ $total }}@if ($p->group_label) · {{ $p->group_label }}@endif</p>
        <h3 class="m-text-7">{{ $p->title }}</h3>
        @if ($p->lead)<p class="m-text-5">{{ $p->lead }}</p>@endif
        <p class="m-text">{{ $p->body }}</p>
        @if ($p->meta)<p class="nk-meta m-text-4">{{ $p->meta }}</p>@endif
      </li>
      @endforeach
    </ol>
    <div class="nk-aside">
      <div class="nk-frame">
        @foreach ($entries as $i => $p)
        @php $src = Culture::imageUrl($p->image); @endphp
        <figure class="nk-page{{ $i === 0 ? ' is-active' : '' }}">
          <a href="{{ $src }}" target="_blank" rel="noopener" aria-label="Buka foto {{ $i + 1 }} ukuran penuh"><img src="{{ $src }}" alt="{{ $p->alt }}"@if ($p->width) width="{{ $p->width }}" height="{{ $p->height }}"@endif loading="{{ $i < 2 ? 'eager' : 'lazy' }}"></a>
        </figure>
        @endforeach
      </div>
      <p class="nk-cap m-text-4"><span class="nk-counter">{{ $pad(1) }} / {{ $pad($total) }}</span><span>Klik foto untuk memperbesar</span></p>
    </div>
  </div>
</section>
