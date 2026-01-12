<footer class="bg-[#1f2937] text-gray-300 py-10 border-t border-gray-700 mt-auto print:hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Col 1: Branding -->
            <div class="flex flex-col space-y-4">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo_unamba.png') }}" alt="UNAMBA"
                        class="h-12 w-auto brightness-0 invert opacity-80">
                    <div>
                        <h3 class="text-white font-bold text-lg leading-tight">UNAMBA</h3>
                        <p class="text-xs text-gray-400">Escuela Profesional de Ingeniería Informática y Sistemas</p>
                    </div>
                </div>
                <p class="text-sm text-gray-400 leading-relaxed">
                    Formando profesionales líderes en tecnología e innovación, comprometidos con el desarrollo de
                    nuestra región y el país.
                </p>
            </div>

            <!-- Col 2: Quick Links -->
            <div>
                <h4 class="text-white font-semibold mb-4 uppercase tracking-wider text-sm">Enlaces Rápidos</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ url('/') }}" class="hover:text-white hover:underline transition">Inicio</a></li>
                    <li><a href="{{ url('/convocatorias') }}"
                            class="hover:text-white hover:underline transition">Convocatorias</a></li>
                    <li><a href="{{ route('contact') }}"
                            class="hover:text-white hover:underline transition">Contacto</a></li>
                    @guest
                        <li><a href="{{ route('login') }}" class="hover:text-white hover:underline transition">Iniciar
                                Sesión</a></li>
                    @endguest
                </ul>
            </div>

            <!-- Col 3: Contact Info -->
            <div>
                <h4 class="text-white font-semibold mb-4 uppercase tracking-wider text-sm">Contacto</h4>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start gap-3">
                        <i class="fas fa-map-marker-alt mt-1 text-blue-500"></i>
                        <span>Av. Garcilaso de la Vega S/N,<br>Abancay, Apurímac</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fas fa-envelope text-blue-500"></i>
                        <a href="mailto:{{ \App\Models\Setting::get('contact_email', 'epiis@unamba.edu.pe') }}"
                            class="hover:text-white transition">{{ \App\Models\Setting::get('contact_email',
                            'epiis@unamba.edu.pe') }}</a>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fas fa-phone text-blue-500"></i>
                        <a href="tel:{{ \App\Models\Setting::get('contact_phone_raw', '083321987') }}"
                            class="hover:text-white transition">{{ \App\Models\Setting::get('contact_phone', '(083) 321-987') }}</a>
                    </li>
                </ul>
            </div>
        </div>

        <div
            class="border-t border-gray-700 mt-10 pt-6 flex flex-col md:flex-row justify-between items-center text-xs text-gray-500">
            <p>&copy; {{ date('Y') }} UNAMBA - EPIIS. Todos los derechos reservados.</p>
            <div class="flex space-x-4 mt-4 md:mt-0">
                <a href="#" class="hover:text-white transition"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="hover:text-white transition"><i class="fab fa-twitter"></i></a>
                <a href="#" class="hover:text-white transition"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
    </div>
</footer>