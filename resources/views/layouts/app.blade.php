<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel</title>
    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    @livewireResourceTimeGridScripts
    @livewireStyles
</head>
<body class="bg-gray-50">

<div>
    <x-navbar/>

    <x-header :headerTitle="$headerTitle"/>

    <main>
        <div class="{{ $maxWidth }} mx-auto py-6 sm:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </main>
</div>

@livewireScripts
<livewire:livewire-ui-modal/>
</body>
</html>
