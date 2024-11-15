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
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-cover bg-center" style="background-image: url('{{ asset('images/rl.jpg') }}');">
        @include('layouts.navigationdokter')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        @yield('content')
    </div>
    <!-- Footer Section -->
    <footer class="bg-gray-800 text-white py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center">
            <p class="text-sm text-gray-300">
                &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All Rights Reserved.
            </p>
            <ul class="flex space-x-4 mt-2 md:mt-0">
                <li>
                    <a href="{{ route('privacy.policy') }}" class="text-gray-300 hover:text-white transition">Privacy
                        Policy</a>
                </li>
                <li>
                    <a href="{{ route('terms.service') }}" class="text-gray-300 hover:text-white transition">Terms of
                        Service</a>
                </li>
            </ul>
        </div>
    </footer>
</body>

</html>