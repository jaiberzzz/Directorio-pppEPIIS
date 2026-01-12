<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-white mb-2 tracking-wide">Crear Cuenta</h2>
        <p class="text-blue-200 text-xs">Regístrate para gestionar tus prácticas</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div class="space-y-1">
            <x-input-label for="name" :value="__('Nombre Completo')"
                class="text-blue-100 text-xs uppercase font-bold tracking-wider" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-user text-blue-300"></i>
                </div>
                <input id="name"
                    class="block w-full pl-10 pr-3 py-2 border border-white/20 rounded-lg leading-5 bg-black/20 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out backdrop-blur-sm"
                    type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                    placeholder="Tu nombre" />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <!-- Email Address -->
        <div class="space-y-1">
            <x-input-label for="email" :value="__('Correo Institucional')"
                class="text-blue-100 text-xs uppercase font-bold tracking-wider" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-envelope text-blue-300"></i>
                </div>
                <input id="email"
                    class="block w-full pl-10 pr-3 py-2 border border-white/20 rounded-lg leading-5 bg-black/20 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out backdrop-blur-sm"
                    type="email" name="email" :value="old('email')" required autocomplete="username"
                    placeholder="usuario@unamba.edu.pe" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div class="space-y-1">
            <x-input-label for="password" :value="__('Contraseña')"
                class="text-blue-100 text-xs uppercase font-bold tracking-wider" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-lock text-blue-300"></i>
                </div>
                <input id="password"
                    class="block w-full pl-10 pr-3 py-2 border border-white/20 rounded-lg leading-5 bg-black/20 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out backdrop-blur-sm"
                    type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div class="space-y-1">
            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')"
                class="text-blue-100 text-xs uppercase font-bold tracking-wider" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-lock text-blue-300"></i>
                </div>
                <input id="password_confirmation"
                    class="block w-full pl-10 pr-3 py-2 border border-white/20 rounded-lg leading-5 bg-black/20 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out backdrop-blur-sm"
                    type="password" name="password_confirmation" required autocomplete="new-password"
                    placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <div class="pt-4">
            <button type="submit"
                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg btn-anim bg-gradient-to-r from-blue-600 to-indigo-600">
                {{ __('Registrarse') }}
            </button>
        </div>

        <div class="text-center pt-2">
            <a class="underline text-sm text-blue-200 hover:text-white transition-colors" href="{{ route('login') }}">
                {{ __('¿Ya estás registrado?') }}
            </a>
        </div>
    </form>
</x-guest-layout>