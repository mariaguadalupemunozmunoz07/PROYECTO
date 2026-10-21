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
            .tarjeta-guest {
                background-color: #d8c9fc;
                border: 1px solid #c4b5fd;
            }
            .tarjeta-guest label,
            .tarjeta-guest label span,
            .tarjeta-guest .text-gray-600,
            .tarjeta-guest .text-gray-700 {
                color: #be185d !important;
                font-weight: 500;
            }
            .tarjeta-guest a {
                color: #be185d !important;
            }
            .tarjeta-guest a:hover {
                color: #9d174d !important;
            }
            .tarjeta-guest button[type="submit"] {
                background-color: #fbcfe8 !important;
                color: #be185d !important;
                border: 1px solid #f9a8d4 !important;
                border-radius: 8px;
                font-weight: 700;
            }
            .tarjeta-guest button[type="submit"]:hover {
                background-color: #f9a8d4 !important;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased" style="background-color: #e9d5ff; min-height: 100vh;">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0" style="background-color: #e9d5ff; min-height: 100vh;">
            <div style="text-align: center;">
                <a href="{{ route('login') }}">
                    <x-application-logo style="width: 140px; height: 140px; margin: 0 auto;" />
                </a>
                <div style="margin-top: 8px; font-weight: 700; letter-spacing: 0.2em; color: #4c1d95; font-size: 14px;">
                    BIBLIOTECA MUNICIPAL DE MIRANDA
                </div>
            </div>

            <div class="tarjeta-guest w-full sm:max-w-md mt-6 px-6 py-4 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>