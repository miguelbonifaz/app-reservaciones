<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {!! app('seotools')->generate() !!}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    @livewireStyles
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body
    class="font-sans h-screen antialiased">
{{ $slot }}
@livewireScripts
<script src="{{ mix('js/app.js')  }}"></script>
</body>
</html>
