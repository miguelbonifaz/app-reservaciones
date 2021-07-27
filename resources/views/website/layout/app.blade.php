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
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:wght@400;700" rel="stylesheet">
    <style>
        * {
            font-family: 'PT Sans', sans-serif;
            font-weight: 400;
            letter-spacing: .3px;
        }
    </style>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body
    class="h-screen antialiased">
{{ $slot }}
<script src="{{ mix('js/app.js')  }}"></script>
</body>
</html>
