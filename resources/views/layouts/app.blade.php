<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel</title>
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <livewire:styles />
</head>
<body>

<div>
    <x-navbar/>

    <x-header :headerTitle="$headerTitle"/>

    <main class="bg-gray-50 h-screen">
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </main>
</div>

<livewire:scripts />
<livewire:livewire-ui-modal/>
</body>
</html>
