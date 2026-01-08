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

<body class="font-sans text-gray-900 antialiased">
    <div style="background: linear-gradient(to bottom, #eff6ff 0%, #93c5fd 50%, #2563eb 100%);"
        class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden">

        <!-- Tarjeta Principal Dividida -->
        <div
            class="w-full max-w-4xl bg-white rounded-[2rem] shadow-[0_20px_60px_-15px_rgba(0,0,0,0.3)] overflow-hidden flex flex-col md:flex-row min-h-[550px] animate-fade-in-up">

            <!-- Lado Izquierdo: Ilustración (Blanco) -->
            <div
                class="hidden md:flex md:w-1/2 bg-white p-12 items-center justify-center relative overflow-hidden group">

                <div class="text-center relative z-10 animate-fade-in-left">
                    <div
                        class="mb-8 relative inline-block transform group-hover:scale-110 transition-transform duration-500">
                        <img src="{{ asset('images/logo_unamba.png') }}"
                            class="w-48 h-auto relative z-10 drop-shadow-xl" alt="Logo Unamba">
                    </div>
                    <h2 class="text-3xl font-extrabold text-gray-800 mb-3 tracking-tight">Directorio de Practicantes
                    </h2>
                    <p class="text-gray-500 text-sm max-w-xs mx-auto leading-relaxed">
                        Plataforma oficial de gestión de prácticas pre-profesionales.
                    </p>
                </div>
            </div>

            <!-- Lado Derecho: Formulario (Azul) -->
            <div class="w-full md:w-1/2 bg-blue-600 p-8 md:p-12 flex flex-col justify-center relative">
                <div class="relative z-10 w-full max-w-xs mx-auto animate-fade-in-right">
                    {{ $slot }}
                </div>
            </div>

        </div>
    </div>
    </div>

    <style>
        /* Animation Utilities */
        .animate-fade-in-down {
            animation: fadeInDown 0.8s ease-out both;
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out 0.2s both;
        }

        .animate-fade-in-left {
            animation: fadeInLeft 0.8s ease-out 0.4s both;
        }

        .animate-fade-in-right {
            animation: fadeInRight 0.8s ease-out 0.4s both;
        }

        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }

        .delay-300 {
            animation-delay: 0.3s;
        }

        /* Keyframes */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</body>

</html>