@php
    try {
        $ssr = Http::post('http://localhost:9000/render', $page)->throw()->json();
        ray($ssr);
    } catch (Exception $e) {
        $ssr = null;
        ray('no SSR');
    }
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title inertia>{{ config('app.name', 'Laravel') }}</title>
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <!-- Scripts -->
        @routes
        <script src="{{ mix('js/app.js') }}" defer></script>
        @foreach($ssr['head'] ?? [] as $element)
            {!! $element !!}
        @endforeach
    </head>
    <body class="font-sans antialiased">
        @if ($ssr)
            {!! $ssr['body'] !!}
        @else
            @inertia
        @endif
        @env ('local')
        @endenv
    </body>
</html>
