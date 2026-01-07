<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Configuración del Sitio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if(session('success'))
                        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                            role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Contact Email -->
                            <div>
                                <label for="contact_email" class="block text-sm font-medium text-gray-700">Correo de
                                    Contacto</label>
                                <input type="email" name="contact_email" id="contact_email"
                                    value="{{ $settings['contact_email'] ?? '' }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Contact Phone (Display) -->
                            <div>
                                <label for="contact_phone" class="block text-sm font-medium text-gray-700">Teléfono
                                    (Visual)</label>
                                <input type="text" name="contact_phone" id="contact_phone"
                                    value="{{ $settings['contact_phone'] ?? '' }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="(083) 321-987">
                            </div>

                            <!-- Contact Phone (Raw for tel: link) -->
                            <div>
                                <label for="contact_phone_raw" class="block text-sm font-medium text-gray-700">Teléfono
                                    (Sin formato para enlace)</label>
                                <input type="text" name="contact_phone_raw" id="contact_phone_raw"
                                    value="{{ $settings['contact_phone_raw'] ?? '' }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="083321987">
                            </div>

                            <!-- Address -->
                            <div class="md:col-span-2">
                                <label for="contact_address"
                                    class="block text-sm font-medium text-gray-700">Dirección</label>
                                <textarea name="contact_address" id="contact_address" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $settings['contact_address'] ?? '' }}</textarea>
                            </div>

                            <!-- Google Maps Embed URL -->
                            <div class="md:col-span-2">
                                <label for="map_url" class="block text-sm font-medium text-gray-700">URL del Mapa
                                    (Embed)</label>
                                <input type="text" name="map_url" id="map_url" value="{{ $settings['map_url'] ?? '' }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <p class="mt-1 text-xs text-gray-500">Pega aquí la URL del iframe de Google Maps
                                    (src="...")</p>
                            </div>

                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition btn-anim">
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>