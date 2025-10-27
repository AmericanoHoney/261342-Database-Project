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

        <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 m-0 p-0 overflow-x-hidden">
        <!-- Wrapper -->
        <div class="min-h-screen pb-12"> <!-- pb-12 กันไม่ให้เนื้อหาทับ footer -->
            
            <!-- Navbar -->
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow-none mb-0 border-0">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="mb-0">
                {{ $slot }}
            </main>
        </div>

        <!-- 🌸 Fixed Footer (แนบขอบล่างสุดตลอดเวลา) -->
        <footer class="w-full bg-pink-600 text-white text-center py-3 z-50 m-0 border-0 rounded-none shadow-none">
            <p class="text-sm font-medium">
                © {{ date('Y') }} Flortalera | All Rights Reserved
            </p>
        </footer>
    </body>
</html>
