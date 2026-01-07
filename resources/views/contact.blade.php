<x-public-layout>
    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-base font-semibold text-blue-600 tracking-wide uppercase">Contáctanos</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Estamos aquí para ayudarte
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                    Si tienes alguna duda sobre el proceso de prácticas o el uso del directorio, no dudes en comunicarte
                    con nosotros.
                </p>
            </div>

            <div class="mt-16 grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Location -->
                <div
                    class="bg-white rounded-lg shadow-lg overflow-hidden hover-lift location border border-transparent">
                    <div class="px-6 py-8">
                        <div class="flex justify-center">
                            <span class="inline-flex p-3 bg-blue-50 rounded-lg text-blue-600">
                                <i class="fas fa-map-marker-alt text-2xl"></i>
                            </span>
                        </div>
                        <h3 class="mt-6 text-center text-lg font-medium text-gray-900">Ubicación</h3>
                        <p class="mt-4 text-center text-base text-gray-500 whitespace-pre-line">
                            {{ \App\Models\Setting::get('contact_address', 'Av. Garcilaso de la Vega S/N Abancay, Apurímac') }}
                        </p>
                    </div>
                </div>

                <!-- Email -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover-lift email border border-transparent">
                    <div class="px-6 py-8">
                        <div class="flex justify-center">
                            <span class="inline-flex p-3 bg-blue-50 rounded-lg text-blue-600">
                                <i class="fas fa-envelope text-2xl"></i>
                            </span>
                        </div>
                        <h3 class="mt-6 text-center text-lg font-medium text-gray-900">Correo Electrónico</h3>
                        <p class="mt-4 text-center text-base text-gray-500">
                            <a href="mailto:{{ \App\Models\Setting::get('contact_email', 'epiis@unamba.edu.pe') }}"
                                class="hover:text-blue-600 transition">{{ \App\Models\Setting::get('contact_email',
                                'epiis@unamba.edu.pe') }}</a>
                        </p>
                    </div>
                </div>

                <!-- Phone -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover-lift phone border border-transparent">
                    <div class="px-6 py-8">
                        <div class="flex justify-center">
                            <span class="inline-flex p-3 bg-blue-50 rounded-lg text-blue-600">
                                <i class="fas fa-phone text-2xl"></i>
                            </span>
                        </div>
                        <h3 class="mt-6 text-center text-lg font-medium text-gray-900">Teléfono</h3>
                        <p class="mt-4 text-center text-base text-gray-500">
                            <a href="tel:{{ \App\Models\Setting::get('contact_phone_raw', '083321987') }}"
                                class="hover:text-blue-600 transition">{{ \App\Models\Setting::get('contact_phone', '(083) 321-987') }}</a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Contact Form Section -->
            <div class="mt-16 bg-white rounded-lg shadow-lg overflow-hidden lg:grid lg:grid-cols-2">
                <div class="p-6 lg:p-10">
                    <h3 class="text-2xl font-bold text-gray-900">Envíanos un mensaje</h3>
                    <p class="mt-4 text-gray-500">
                        Completa el formulario y nos pondremos en contacto contigo lo antes posible.
                    </p>

                    @if(session('success'))
                        <div class="mt-6 bg-green-50 border-l-4 border-green-400 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle text-green-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-green-700">
                                        {{ session('success') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('contact.send') }}" method="POST" class="mt-6 space-y-6">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nombre Completo</label>
                            <input type="text" name="name" id="name" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Tu nombre">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Correo
                                Electrónico</label>
                            <input type="email" name="email" id="email" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="tucorreo@ejemplo.com">
                        </div>
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700">Asunto</label>
                            <input type="text" name="subject" id="subject" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Asunto del mensaje">
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700">Mensaje</label>
                            <textarea name="message" id="message" rows="4" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Escribe tu mensaje aquí..."></textarea>
                        </div>
                        <div>
                            <button type="submit"
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition btn-anim">
                                <i class="fas fa-paper-plane mr-2 mt-1"></i> Enviar Mensaje
                            </button>
                        </div>
                    </form>
                </div>
                <div class="relative hidden lg:block bg-blue-600">
                    <div class="absolute inset-0 flex items-center justify-center p-10 text-white">
                        <div class="text-center">
                            <i class="fas fa-comments text-6xl opacity-50 mb-4"></i>
                            <h4 class="text-xl font-bold">¿Prefieres llamarnos?</h4>
                            <p class="mt-2 text-blue-100">Nuestro equipo de atención está disponible de Lunes a Viernes
                                de 8:00 AM a 5:00 PM.</p>
                            <div class="mt-6">
                                <a href="tel:{{ \App\Models\Setting::get('contact_phone_raw', '083321987') }}"
                                    class="inline-block bg-white text-blue-600 px-6 py-2 rounded-full font-bold hover:bg-gray-100 transition">
                                    <i class="fas fa-phone mr-2"></i>
                                    {{ \App\Models\Setting::get('contact_phone', '(083) 321-987') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Map or Image Area -->
            <div class="mt-16 bg-white rounded-lg shadow-lg overflow-hidden">
                <iframe
                    src="{{ \App\Models\Setting::get('map_url', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15501.587877995393!2d-72.88764560000001!3d-13.633999999999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x916d02d871781255%3A0x6734107055745802!2sUniversidad%20Nacional%20Micaela%20Bastidas%20de%20Apurimac!5e0!3m2!1ses-419!2spe!4v1703964593414!5m2!1ses-419!2spe') }}"
                    width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</x-public-layout>