<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Preview - {{ $title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- CSS & JS CDN di HEAD --}}
    @foreach ($headCss as $asset)
        <link rel="stylesheet" href="{{ $asset->url }}">
    @endforeach

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

    {{-- JS CDN di akhir body --}}
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
