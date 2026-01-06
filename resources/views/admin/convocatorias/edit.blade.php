<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Convocatoria') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.convocatorias.update', $convocatoria->id) }}" method="POST"
                        class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Basic Info -->
                            <div class="col-span-1 md:col-span-2">
                                <label for="title" class="block text-sm font-medium text-gray-700">Título de la
                                    Convocatoria</label>
                                <input type="text" name="title" id="title" required
                                    placeholder="Ej: Practicante de Desarrollo Web"
                                    value="{{ old('title', $convocatoria->title) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label for="company" class="block text-sm font-medium text-gray-700">Empresa</label>
                                <input type="text" name="company" id="company" required
                                    value="{{ old('company', $convocatoria->company) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label for="area" class="block text-sm font-medium text-gray-700">Área</label>
                                <input type="text" name="area" id="area" required
                                    placeholder="Ej: Desarrollo de Software"
                                    value="{{ old('area', $convocatoria->area) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label for="vacancies" class="block text-sm font-medium text-gray-700">Vacantes</label>
                                <input type="number" name="vacancies" id="vacancies" min="1" required
                                    value="{{ old('vacancies', $convocatoria->vacancies) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Dates -->
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Fecha de
                                    Inicio</label>
                                <input type="date" name="start_date" id="start_date" required
                                    value="{{ old('start_date', optional($convocatoria->start_date)->format('Y-m-d')) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">Fecha de
                                    Cierre</label>
                                <input type="date" name="end_date" id="end_date" required
                                    value="{{ old('end_date', optional($convocatoria->end_date)->format('Y-m-d')) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Description -->
                            <div class="col-span-1 md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700">Descripción del
                                    Puesto</label>
                                <textarea name="description" id="description" rows="4" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $convocatoria->description) }}</textarea>
                            </div>

                            <!-- Requirements -->
                            <div class="col-span-1 md:col-span-2">
                                <label for="requirements" class="block text-sm font-medium text-gray-700">Requisitos
                                    (separar por puntos o enter)</label>
                                <textarea name="requirements" id="requirements" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 placeholder-gray-400"
                                    placeholder="Ej: Conocimiento de PHP&#10;Proactivo&#10;Estudiante de 8vo ciclo">{{ old('requirements', $convocatoria->requirements) }}</textarea>
                            </div>

                            <!-- Contact Info -->
                            <div class="col-span-1 md:col-span-2 border-t pt-4 mt-2">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Datos de Contacto</h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label for="contact_name"
                                            class="block text-sm font-medium text-gray-700">Persona de Contacto</label>
                                        <input type="text" name="contact_name" id="contact_name"
                                            value="{{ old('contact_name', $convocatoria->contact_name) }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label for="contact_email" class="block text-sm font-medium text-gray-700">Email
                                            de Contacto</label>
                                        <input type="email" name="contact_email" id="contact_email"
                                            value="{{ old('contact_email', $convocatoria->contact_email) }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label for="contact_phone"
                                            class="block text-sm font-medium text-gray-700">Teléfono</label>
                                        <input type="text" name="contact_phone" id="contact_phone"
                                            value="{{ old('contact_phone', $convocatoria->contact_phone) }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div class="col-span-1 md:col-span-3">
                                        <label for="contact_details"
                                            class="block text-sm font-medium text-gray-700">Detalles Adicionales
                                            (Opcional)</label>
                                        <textarea name="contact_details" id="contact_details" rows="2"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('contact_details', $convocatoria->contact_details) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center mt-4">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ $convocatoria->is_active ? 'checked' : '' }}
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                            <label for="is_active" class="ml-2 block text-sm text-gray-900">Convocatoria Activa</label>
                        </div>

                        <div class="flex justify-end">
                            <a href="{{ route('admin.convocatorias.index') }}"
                                class="text-gray-600 hover:underline mr-4">Cancelar</a>
                            <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Actualizar
                                Convocatoria</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>