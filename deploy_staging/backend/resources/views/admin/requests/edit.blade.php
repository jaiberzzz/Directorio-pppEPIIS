<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Revisar Solicitud') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <p class="text-sm text-gray-500">Estudiante</p>
                            <p class="font-bold text-lg">{{ $request->practitioner->user->name ?? 'Desconocido' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tipo de Solicitud</p>
                            <p class="font-bold text-lg capitalize">{{ $request->type }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Desde</p>
                            <p class="font-medium">{{ $request->start_date }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Hasta</p>
                            <p class="font-medium">{{ $request->end_date }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-500">Motivo</p>
                            <p class="p-4 bg-gray-50 rounded-md">{{ $request->reason }}</p>
                        </div>
                    </div>

                    <hr class="my-6">

                    <form action="{{ route('admin.requests.update', $request->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Estado</label>
                            <select name="status" id="status" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="pendiente" {{ $request->status == 'pendiente' ? 'selected' : '' }}>
                                    Pendiente</option>
                                <option value="aprobado" {{ $request->status == 'aprobado' ? 'selected' : '' }}>Aprobar
                                </option>
                                <option value="rechazado" {{ $request->status == 'rechazado' ? 'selected' : '' }}>Rechazar
                                </option>
                            </select>
                        </div>

                        <div>
                            <label for="admin_comment" class="block text-sm font-medium text-gray-700">Comentario /
                                Respuesta (Opcional)</label>
                            <textarea name="admin_comment" id="admin_comment" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $request->admin_comment }}</textarea>
                        </div>

                        <div class="flex justify-end">
                            <a href="{{ route('admin.requests.index') }}"
                                class="text-gray-600 hover:underline mr-4">Cancelar</a>
                            <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Guardar
                                Respuesta</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>