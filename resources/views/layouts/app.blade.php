<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root{
                --primary-color: #4B2C20; /* pramuka brown */
                --secondary-color: #F2C94C; /* pramuka gold */
                --muted-color: #6b7280;
            }

            /* Page and card adjustments */
            .bg-white { background-color: #fff !important; }
            .shadow { box-shadow: 0 6px 18px rgba(21,21,21,0.06) !important; }
            .prose a { color: var(--primary-color); font-weight: 600; }
            .prose h1, .prose h2, .prose h3 { color: var(--primary-color); }

            /* Page hero (for scout history) */
            .page-hero { border-bottom: 6px solid var(--secondary-color); }
            .page-hero .hero-bg{ padding: 80px 0; background-size: cover; background-position: center; }
            .page-hero .display-5 { color: #fff; text-shadow: 0 2px 6px rgba(0,0,0,0.35); }

            /* Sidebar tweaks */
            .sidebar-card { border-radius: 12px; overflow: hidden; }
            .sidebar-card .profile-banner { padding: 20px; text-align: center; }
            .sidebar-card .profile-banner img { box-shadow: 0 8px 20px rgba(0,0,0,0.12); }
            .sidebar-card .popular-item img { border-radius: 6px; }

            @media (max-width: 1024px){
                .page-hero .hero-bg{ padding: 48px 0; }
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Main layout: content (left) + sidebar (right) -->
            <main>
                <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                    <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                        <!-- Main content -->
                        <div class="lg:col-span-8">
                            <div class="bg-white shadow sm:rounded-lg p-6">
                                {{-- Blade section for pages that use @extends('layouts.app') --}}
                                @yield('content')

                                {{-- Slot for components that pass $slot --}}
                                @if(isset($slot))
                                    {{ $slot }}
                                @endif
                            </div>
                        </div>

                        <!-- Sidebar (right) -->
                        <aside class="hidden lg:block lg:col-span-4">
                            <div class="space-y-6">
                                @include('layouts.sidebar')
                            </div>
                        </aside>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
