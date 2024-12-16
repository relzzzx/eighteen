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
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M14.348 14.849a1 1 0 010 1.414l-1.415 1.415a1 1 0 01-1.414 0L10 13.415l-1.518 1.518a1 1 0 01-1.414 0l-1.415-1.415a1 1 0 010-1.414L8.586 10 7.068 8.482a1 1 0 010-1.414l1.415-1.415a1 1 0 011.414 0L10 6.586l1.518-1.518a1 1 0 011.414 0l1.415 1.415a1 1 0 010 1.414L11.415 10l1.518 1.518a1 1 0 011.414 0l1.415 1.415z"/>
                    </svg>
                </span>
            </div>
        @endif
        
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M14.348 14.849a1 1 0 010 1.414l-1.415 1.415a1 1 0 01-1.414 0L10 13.415l-1.518 1.518a1 1 0 01-1.414 0l-1.415-1.415a1 1 0 010-1.414L8.586 10 7.068 8.482a1 1 0 010-1.414l1.415-1.415a1 1 0 011.414 0L10 6.586l1.518-1.518a1 1 0 011.414 0l1.415 1.415a1 1 0 010 1.414L11.415 10l1.518 1.518a1 1 0 011.414 0l1.415 1.415z"/>
                    </svg>
                </span>
            </div>
        @endif
              
        
            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
        </div>
    </body>
</html>
