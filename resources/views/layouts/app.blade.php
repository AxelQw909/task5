<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'НарушенийНет') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <main class="py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @include('layouts.flash-messages')
                {{ $slot }}
            </div>
        </main>
    </div>
</body>
</html>