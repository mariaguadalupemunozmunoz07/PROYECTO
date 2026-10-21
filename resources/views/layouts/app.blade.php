<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .franja-titulo h2 { color: #4c1d95 !important; font-weight: 700; }
        </style>
    </head>
    <body class="font-sans antialiased" style="background-color: #e9d5ff; min-height: 100vh;">
        <div style="background-color: #e9d5ff; min-height: 100vh;">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="franja-titulo shadow" style="background-color: #d8c9fc; border-bottom: 1px solid #c4b5fd;">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>