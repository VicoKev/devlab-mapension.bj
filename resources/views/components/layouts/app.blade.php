<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    @include('partials.utils.meta')

    <title>{{ config('app.name') }}{{ $title ? ' - ' . $title : '' }}</title>

    <!-- App favicon -->
    @include('partials.utils.favicon')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="bg-gray-50 min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-gradient-to-r from-emerald-600 to-teal-600 shadow-lg">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('landing') }}" class="flex items-center space-x-3">
                    <div class="bg-white rounded-lg p-2 shadow-md">
                        <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white">MaPension.BJ</h1>
                        <p class="text-emerald-100 text-sm">Paiements de Masse</p>
                    </div>
                </a>
                <div class="hidden md:flex items-center space-x-4">
                    <span class="text-white text-sm">{{ now()->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 container mx-auto px-4 py-6 md:py-8">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-auto">
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="font-bold text-lg mb-3">MaPension.BJ</h3>
                    <p class="text-gray-400 text-sm">Plateforme sécurisée pour les paiements de pensions de retraite au
                        Bénin.</p>
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-3">Contact</h3>
                    <p class="text-gray-400 text-sm">Email: contact@mapension.bj</p>
                    <p class="text-gray-400 text-sm">Tél: +229 XX XX XX XX XX</p>
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-3">Liens Utiles</h3>
                    <ul class="text-gray-400 text-sm space-y-1">
                        <li><a href="#" class="hover:text-emerald-400 transition">Documentation</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition">Support Technique</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition">Conditions d'Utilisation</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-400 text-sm">
                <p>
                    @php
                        $startYear = 2025;
                        $currentYear = date('Y');
                    @endphp
                    &copy; {{ $startYear }} {{ $startYear != $currentYear ? ' - ' . $currentYear : '' }} MaPension.BJ - Service Public de Gestion des Pensions du Bénin. Tous droits réservés | Powered by Mojaloop</p>
            </div>
        </div>
    </footer>

    <!-- Toast -->
    <x-utils.toast />
</body>

</html>
