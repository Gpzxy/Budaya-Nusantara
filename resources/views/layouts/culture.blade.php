@php
    use App\Models\Culture;

    // Urutan CSS penting: layers.css harus pertama.
    $pageCss = [
        'layers.css',
        'base/fonts.css', 'base/tokens.css', 'base/base.css', 'base/components.css', 'base/layout.css', 'base/motion.css',
        'sections/header.css', 'sections/hero.css', 'sections/naskah.css', 'sections/footer.css',
        ['scenes/hero-arrival.css', 'scene:hero'],
    ];
    // Urutan JS penting: motion-kit dulu, scene paling akhir.
    $pageJs = [
        'motion-kit.js',
        'sections/header.js', 'sections/hero.js', 'sections/naskah.js',
        'scenes/hero-arrival.js',
    ];
    // asset + ?v=waktu-edit supaya browser selalu ambil file terbaru
    $av = function (string $path) {
        $file = public_path($path);
        return asset($path) . (is_file($file) ? '?v=' . filemtime($file) : '');
    };
    $title = $culture->name . ' — Budaya Nusantara';
    $desc  = $culture->tagline;
    $letter = rawurlencode(mb_strtoupper(mb_substr($culture->name, 0, 1)));
@endphp
<!doctype html>
<!--
  Dasar desain halaman budaya: template "Brume" by 8B (https://8b.com/templates/brume/), lisensi MIT.
-->
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ $title }}</title>
<meta name="description" content="{{ $desc }}">
<meta property="og:type" content="website">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $desc }}">
<meta property="og:image" content="{{ Culture::imageUrl($culture->card_image) }}">
<meta name="twitter:card" content="summary_large_image">
<link rel="icon" href="data:image/svg+xml,%3Csvg%20xmlns%3D'http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg'%20viewBox%3D'0%200%2064%2064'%3E%3Crect%20width%3D'64'%20height%3D'64'%20rx%3D'14'%20fill%3D'%230b0906'%2F%3E%3Ctext%20x%3D'32'%20y%3D'45'%20font-family%3D'Arial%2CHelvetica%2Csans-serif'%20font-size%3D'38'%20font-weight%3D'700'%20text-anchor%3D'middle'%20fill%3D'%23d0703f'%3E{{ $letter }}%3C%2Ftext%3E%3C%2Fsvg%3E">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<script src="{{ $av('assets/js/motion-gate.js') }}"></script>
@foreach ($pageCss as $css)
@php [$cssFile, $cssPart] = is_array($css) ? $css : [$css, null]; @endphp
<link rel="stylesheet" href="{{ $av('assets/css/' . $cssFile) }}"{!! $cssPart ? ' data-8b-part="' . e($cssPart) . '"' : '' !!}>
@endforeach
</head>
<body>
@include('culture.partials.header')
<main id="main">
@include('culture.partials.hero')
@include('culture.partials.gallery')
</main>
@include('culture.partials.footer')
@foreach ($pageJs as $js)
<script src="{{ $av('assets/js/' . $js) }}"></script>
@endforeach
</body>
</html>
