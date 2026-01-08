<nav x-data="{ open: false }" class="bg-[#3070a8] border-b border-blue-600 shadow-md">
    <!-- Menú de Navegación Principal -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <!-- Logotipo -->
                <div class="shrink-0 flex items-center gap-3">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <img src="{{ asset('images/logo_unamba.png') }}" alt="UNAMBA" class="block h-10 w-auto">
                        <span class="text-white font-bold text-lg hidden md:block">Portal Estudiantes</span>
                    </a>
                </div>

                <!-- Enlaces de Navegación -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                        class="text-white hover:text-blue-100 border-transparent hover:border-blue-200">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @role('Superadmin|Docente')
                    <x-nav-link :href="route('admin.practitioners.index')"
                        :active="request()->routeIs('admin.practitioners.*')" class="text-blue-100 hover:text-white">
                        {{ __('Gestionar Practicantes') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.convocatorias.index')"
                        :active="request()->routeIs('admin.convocatorias.*')" class="text-blue-100 hover:text-white">
                        {{ __('Convocatorias') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.news.index')" :active="request()->routeIs('admin.news.*')"
                        class="text-blue-100 hover:text-white">
                        {{ __('Noticias') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.documents.index')" :active="request()->routeIs('admin.documents.*')"
                        class="text-blue-100 hover:text-white">
                        {{ __('Documentos') }}
                    </x-nav-link>
                    @endrole
                </div>
            </div>

            <!-- Menú Desplegable de Configuración -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-blue-800 bg-white hover:bg-blue-50 focus:outline-none transition ease-in-out duration-150 shadow-sm">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            <i class="fas fa-user-edit mr-2"></i> {{ __('Perfil') }}
                        </x-dropdown-link>

                        <!-- Autenticación -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                <i class="fas fa-sign-out-alt mr-2"></i> {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburguesa (Móvil) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-blue-100 hover:text-white hover:bg-blue-600 focus:outline-none focus:bg-blue-600 focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menú de Navegación Responsivo -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-blue-700">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                class="text-white border-blue-400 bg-blue-800 focus:bg-blue-800 focus:border-blue-400">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Opciones de Configuración Responsivas -->
        <div class="pt-4 pb-1 border-t border-blue-500">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-blue-200">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')"
                    class="text-blue-100 hover:text-white hover:bg-blue-600 focus:bg-blue-600">
                    <i class="fas fa-user-edit mr-2"></i> {{ __('Perfil') }}
                </x-responsive-nav-link>

                <!-- Autenticación -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();
                                        this.closest('form').submit();"
                        class="text-blue-100 hover:text-white hover:bg-blue-600 focus:bg-blue-600">
                        <i class="fas fa-sign-out-alt mr-2"></i> {{ __('Cerrar Sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>