<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" href="{{ asset('images/wiralab-icon.ico') }}" type="image/x-icon">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css'])

        <script>
            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>

        @vite(['resources/js/app.js'])
        
        {{-- Untuk Trix Editor/CSS Halaman Spesifik --}}
        @stack('styles')
    </head>
    <body class="font-sans antialiased">
        
        {{-- 1. Tambahkan 'flex flex-col' untuk layout sticky footer --}}
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col">
            
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            {{-- 2. Tambahkan 'flex-grow' agar konten mengisi ruang --}}
            <main class="flex-grow">
                {{ $slot }}
            </main>

            {{-- 3. Panggil file footer partial menggunakan @include --}}
            @include('layouts.footer')
            
        </div>

        {{-- Untuk Trix Editor/JS Halaman Spesifik --}}
        @stack('scripts')
    </body>
</html>