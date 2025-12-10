<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Generated Page' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- CDN CSS di HEAD (bootstrap, swiper css, fontawesome, dll) --}}
    @foreach ($headCss as $asset)
        <link rel="stylesheet" href="{{ $asset->url }}">
    @endforeach

    {{-- CDN JS di HEAD kalau ada (tailwind cdn, dll) --}}
    @foreach ($headJs as $asset)
        <script src="{{ $asset->url }}"></script>
    @endforeach

    {{-- CSS custom dari AI --}}
    @if (!empty($css))
        <style>
            {!! $css !!}
        </style>
    @endif
</head>
<body>
    {!! $html !!}

    {{-- CDN JS di akhir body (bootstrap bundle, swiper, aos, gsap, dll) --}}
    @foreach ($bodyJs as $asset)
        <script src="{{ $asset->url }}"></script>
    @endforeach

    {{-- JS custom dari AI --}}
    @if (!empty($js))
        <script>
            {!! $js !!}
        </script>
    @endif
</body>
</html>
