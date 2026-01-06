<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Directorio de Practicantes') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800 antialiased flex flex-col min-h-screen">

    <!-- Header -->
    <header class="w-full bg-[#3070a8] text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo & Title -->
                <div class="flex items-center gap-4">
                    <div class="text-3xl opacity-90">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold leading-tight">Directorio de Practicantes</h1>
                        <p class="text-xs text-blue-100 font-light tracking-wide opacity-90">Escuela Profesional de
                            Ingeniería Informática</p>
                    </div>
                </div>

                <!-- Desktop Menu -->
                <nav class="hidden md:flex items-center space-x-6">
                    <a href="{{ url('/') }}"
                        class="text-blue-50 hover:text-white hover:underline transition text-sm font-medium px-3 py-2 bg-white/10 rounded">Inicio</a>
                    <a href="{{ url('/convocatorias') }}"
                        class="text-blue-50 hover:text-white hover:underline transition text-sm font-medium">Convocatorias</a>
                    <a href="{{ url('/#contact') }}"
                        class="text-blue-50 hover:text-white hover:underline transition text-sm font-medium">Contacto</a>

                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="bg-[#ef4444] hover:bg-red-600 text-white px-4 py-2 rounded shadow transition text-sm font-bold flex items-center gap-2">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="bg-[#ef4444] hover:bg-red-600 text-white px-4 py-2 rounded shadow transition text-sm font-bold flex items-center gap-2">
                                <i class="fas fa-lock"></i> Admin
                            </a>
                        @endauth
                    @endif
                </nav>
            </div>
        </div>
    </header>

    <!-- Content -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-[#3070a8] text-white py-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-sm text-blue-100 opacity-90">&copy; {{ date('Y') }} Escuela Profesional de Ingeniería
                Informática y Sistemas. Todos los derechos reservados.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    @stack('scripts')
</body>

</html>