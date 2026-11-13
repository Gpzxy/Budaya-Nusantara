@php
    use App\Models\Culture;
    $introLines = Culture::lines($culture->intro_heading);
    $floats = $culture->entries->whereNotNull('float_slot')->sortBy('float_slot')->take(3);
@endphp
<section id="hero" data-8b-section="opening" aria-label="{{ $culture->name }}">
  <div class="op-stage-wrap"><div class="op-stage">
    <img class="op-room" src="{{ Culture::imageUrl($culture->hero_image_room) }}" alt="" width="1600" height="1200" fetchpriority="low">
    <div class="op-room-shade"></div>
    <div class="op-room-dark"></div>
  </div></div>
  <div class="op-first">
    <div class="op-hold">
      <div class="op-lake-wrap">
        <img class="op-lake" src="{{ Culture::imageUrl($culture->hero_image_wide) }}" alt="" width="1600" height="857" fetchpriority="high">
      </div>
      <div class="op-veil" aria-hidden="true"><span class="op-fog op-fog--1"></span><span class="op-fog op-fog--2"></span><span class="op-fog op-fog--3"></span></div>
    </div>
    <div class="op-hero">
      <h1 class="m-text-2">{{ $culture->hero_title }}</h1>
      <p class="m-text-5">{{ $culture->hero_intro }}</p>
      <div class="op-actions">
        <a class="m-btn" href="#naskah"><span class="m-btn__label">{{ $culture->hero_cta_label }}</span></a>
        <a class="m-link" href="{{ route('home') }}"><span class="m-link__label">Semua budaya</span></a>
      </div>
    </div>
    @if (!empty($culture->readings))
    <dl class="op-readings">
      @foreach (array_slice($culture->readings, 0, 3) as $reading)
      <div><dt class="m-text-4">{{ $reading[0] }}</dt><dd>{{ $reading[1] }}</dd></div>
      @endforeach
    </dl>
    @endif
  </div>
  <div class="op-second">
    <p class="m-rail">Pengantar</p>
    <div class="op-copy">
      <h2 class="m-text-3 op-title">@foreach ($introLines as $line)<span class="op-line">{{ $line }}</span>@endforeach</h2>
      <p class="m-text">{{ $culture->intro_text }}</p>
      <a class="m-link" href="#naskah"><span class="m-link__label">{{ $culture->intro_link_label }}</span></a>
    </div>
    @if ($floats->isNotEmpty())
    <div class="op-floats">
      @foreach ($floats as $n => $entry)
      <figure class="m-photo op-float op-float--{{ $loop->iteration }}" data-depth="{{ [160, 300, 220][$loop->index] }}"><img src="{{ Culture::imageUrl($entry->image) }}" alt="{{ $entry->alt }}" width="{{ $entry->width ?: 1204 }}" height="{{ $entry->height ?: 1600 }}" loading="lazy"></figure>
      @endforeach
    </div>
    @endif
  </div>
</section>
