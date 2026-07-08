<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data
      x-init="
        if (localStorage.getItem('darkMode') === 'true' || localStorage.getItem('darkMode') === null) {
            document.documentElement.classList.add('dark');
            localStorage.setItem('darkMode', 'true');
        }
      ">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>DriveKeeper - {{ $title ?? 'Dashboard' }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">

    <div class="flex h-screen overflow-hidden">

        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Main Content --}}
        <div class="flex flex-col flex-1 overflow-hidden">

            {{-- Navbar --}}
            @include('layouts.navbar')

            {{-- Page Content --}}
            <main class="flex-1 overflow-y-auto p-6">
                {{ $slot }}
            </main>

            {{-- Footer --}}
            <footer class="text-center py-2 text-xs text-gray-600 dark:text-gray-700 border-t border-surface-700 flex-shrink-0">
                DriveKeeper &copy; {{ date('Y') }} • Developed by <span class="text-primary font-semibold">KrishhhV2</span>
            </footer>

        </div>
    </div>

    @livewireScripts
</body>
</html>
