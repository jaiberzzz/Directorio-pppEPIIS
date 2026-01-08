<x-guest-layout>
    <div class="mb-10 text-center animate-fade-in-down delay-100">
        <h2 class="text-3xl font-bold text-white uppercase tracking-[0.2em] mb-2">Bienvenido</h2>
        <div class="h-1 w-10 bg-white mx-auto rounded-full opacity-50"></div>
    </div>

    <!-- Estatus de Sesión -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Correo Electrónico -->
        <div class="relative group animate-fade-in-up delay-200">
            <input id="email"
                class="block w-full px-6 py-3 rounded-full border-none bg-white text-gray-800 placeholder-gray-400 focus:ring-0 focus:scale-105 transition-all duration-300 shadow-lg text-center font-medium"
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                placeholder="Usuario" />
        </div>

        <!-- Contraseña -->
        <div class="relative group animate-fade-in-up delay-300">
            <input id="password"
                class="block w-full px-6 py-3 rounded-full border-none bg-white text-gray-800 placeholder-gray-400 focus:ring-0 focus:scale-105 transition-all duration-300 shadow-lg text-center font-medium"
                type="password" name="password" required autocomplete="current-password" placeholder="Contraseña" />
        </div>

        <!-- Recordarme & Olvidó su contraseña -->
        <div class="flex items-center justify-between mt-6 text-sm animate-fade-in-up delay-300">
            <label for="remember_me"
                class="inline-flex items-center cursor-pointer opacity-80 hover:opacity-100 transition-opacity text-white">
                <input id="remember_me" type="checkbox"
                    class="h-4 w-4 rounded border-white/50 bg-blue-600 text-blue-800 focus:ring-offset-blue-500 focus:ring-white"
                    name="remember">
                <span class="ml-2 font-medium">{{ __('Recordar') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-white opacity-80 hover:opacity-100 hover:underline transition-all font-medium"
                    href="{{ route('password.request') }}">
                    {{ __('¿Olvidó su contraseña?') }}
                </a>
            @endif
        </div>

        <div class="pt-8 flex justify-center animate-fade-in-up delay-300">
            <button type="submit" style="background-color: #0d1b3e;"
                class="w-48 py-3 px-6 border border-blue-400/30 rounded-full shadow-lg text-sm font-bold text-white uppercase tracking-widest hover:bg-blue-900 focus:outline-none focus:ring-4 focus:ring-blue-500/50 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-2xl active:scale-95 btn-anim">
                {{ __('INGRESAR') }}
            </button>
        </div>
    </form>
</x-guest-layout>