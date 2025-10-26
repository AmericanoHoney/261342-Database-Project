<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Flortalera') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="min-h-screen flex flex-col">
    {{-- ส่วน header / navbar --}}
    @include('layouts.navigation')

    {{-- ส่วนเนื้อหาหลัก --}}
    <main class="flex-grow container mx-auto py-6">
        {{ $slot }}
    </main>

    {{-- ส่วน footer --}}
    @include('layouts.footer')

</body>
</html>
