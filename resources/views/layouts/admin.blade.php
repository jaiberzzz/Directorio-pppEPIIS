<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Directorio de Practicantes') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-image: url('{{ asset('images/logo_unamba.png') }}');
            background-repeat: no-repeat;
            background-position: center;
            background-size: 50%; /* Adjust size as needed */
            background-attachment: fixed;
            background-blend-mode: overlay;
            background-color: rgba(243, 244, 246, 0.95); /* Gray-100 with high opacity to fade the bg */
        }

        .sidebar-link.active {
            background-color: #374151;
            /* gray-700 */
            border-left: 4px solid #3b82f6;
            /* blue-500 */
        }

        /* DataTables Custom Overrides */
        .dataTables_wrapper .dataTables_length select {
            padding-right: 2rem !important;
            padding-left: 0.5rem !important;
            padding-top: 0.25rem !important;
            padding-bottom: 0.25rem !important;
            margin: 0 0.5rem !important;
            width: auto !important;
            display: inline-block !important;
        }

        .dataTables_wrapper .dataTables_length label {
            display: flex !important;
            align-items: center !important;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-[#1f2937] text-white flex flex-col flex-shrink-0 transition-all duration-300 shadow-xl z-20">
            <!-- Sidebar Header -->
            <div class="h-16 flex items-center justify-center border-b border-gray-700 bg-[#111827]">
                <div class="flex items-center gap-2">
                    <i class="fas fa-user-shield text-xl text-blue-500"></i>
                    <span class="font-bold text-lg tracking-wide">Admin Panel</span>
                </div>
            </div>

            <!-- User Info -->
            <div class="p-4 border-b border-gray-700">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gray-600 flex items-center justify-center text-sm font-bold">
                        {{ substr(Auth::user()->name, 0, 2) }}
                    </div>
                    <div>
                        <p class="text-sm font-medium">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-400 capitalize">{{ Auth::user()->getRoleNames()->first() }}</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto py-4">
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('dashboard') }}"
                            class="sidebar-link flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt w-6"></i>
                            <span class="ml-2">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.practitioners.index') }}"
                            class="sidebar-link flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition {{ request()->routeIs('admin.practitioners.*') ? 'active' : '' }}">
                            <i class="fas fa-users w-6"></i>
                            <span class="ml-2">Practicantes</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.convocatorias.index') }}"
                            class="sidebar-link flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition {{ request()->routeIs('admin.convocatorias.*') ? 'active' : '' }}">
                            <i class="fas fa-briefcase w-6"></i>
                            <span class="ml-2">Convocatorias</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.requests.index') }}"
                            class="sidebar-link flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition {{ request()->routeIs('admin.requests.*') ? 'active' : '' }}">
                            <i class="fas fa-envelope-open-text w-6"></i>
                            <span class="ml-2">Permisos</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.news.index') }}"
                            class="sidebar-link flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                            <i class="fas fa-newspaper w-6"></i>
                            <span class="ml-2">Noticias</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.documents.index') }}"
                            class="sidebar-link flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition {{ request()->routeIs('admin.documents.*') ? 'active' : '' }}">
                            <i class="fas fa-file-alt w-6"></i>
                            <span class="ml-2">Documentos</span>
                        </a>
                    </li>
                    @role('Superadmin')
                    <li>
                        <a href="{{ route('admin.users.index') }}"
                            class="sidebar-link flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="fas fa-user-cog w-6"></i>
                            <span class="ml-2">Usuarios</span>
                        </a>
                    </li>
                    @endrole
                </ul>
            </nav>

            <!-- Bottom Actions -->
            <div class="p-4 border-t border-gray-700">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white py-2 rounded transition shadow-md">
                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6 z-10">
                <div class="flex items-center">
                    <h2 class="text-xl font-bold text-gray-800">
                        @if (isset($header))
                            {{ $header }}
                        @else
                            @yield('header', 'Dashboard')
                        @endif
                    </h2>
                </div>
                <div class="flex items-center gap-4">
                    <!-- Notifications Dropdown -->
                    <div class="relative ml-3">
                        <button onclick="document.getElementById('notificationDropdown').classList.toggle('hidden')" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 transition focus:outline-none group">
                            <div class="relative">
                                <i class="fas fa-bell text-xl text-gray-600 group-hover:text-gray-800"></i>
                                @if(auth()->user()->unreadNotifications->count() > 0)
                                    <span class="animate-ping absolute top-0 right-0 block h-2.5 w-2.5 rounded-full ring-2 ring-white bg-red-500 transform translate-x-1/2 -translate-y-1/2 opacity-75"></span>
                                    <span class="absolute top-0 right-0 block h-2.5 w-2.5 rounded-full ring-2 ring-white bg-red-500 transform translate-x-1/2 -translate-y-1/2"></span>
                                @endif
                            </div>
                            <span class="font-medium text-gray-700 group-hover:text-gray-900">Informes</span>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <span class="bg-red-100 text-red-600 text-xs font-bold px-2 py-0.5 rounded-md border border-red-200">
                                    {{ auth()->user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="notificationDropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200">
                            <div class="px-4 py-2 border-b border-gray-100 flex justify-between items-center">
                                <span class="text-sm font-semibold text-gray-700">Notificaciones</span>
                                @if(auth()->user()->unreadNotifications->count() > 0)
                                    <span class="text-xs text-gray-500">{{ auth()->user()->unreadNotifications->count() }} nuevas</span>
                                @endif
                            </div>
                            
                            <div class="max-h-64 overflow-y-auto">
                                @forelse(auth()->user()->unreadNotifications as $notification)
                                    <a href="{{ route('admin.notifications.read', $notification->id) }}" class="block px-4 py-3 hover:bg-gray-50 transition border-b border-gray-100 last:border-0">
                                        <p class="text-sm text-gray-800 font-medium">{{ $notification->data['student_name'] ?? 'Usuario' }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ $notification->data['message'] ?? 'Nueva notificación' }}</p>
                                        <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                    </a>
                                @empty
                                    <div class="px-4 py-3 text-center text-gray-500 text-sm">
                                        No tienes notificaciones nuevas.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('home') }}" target="_blank"
                        class="flex items-center gap-2 text-blue-600 hover:text-blue-800 font-medium transition bg-blue-50 px-3 py-1.5 rounded hover:bg-blue-100">
                        <i class="fas fa-external-link-alt"></i> Ver sitio
                    </a>
                </div>
            </header>

            <!-- Content Scroll Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).on('click', '.delete-btn', function (e) {
            e.preventDefault();
            let formId = $(this).data('form-id');
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#' + formId).submit();
                }
            })
        });
    </script>
    @stack('scripts')
</body>

</html>