<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mi Panel de Prácticas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @if($practitioner)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Status Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Estado de Prácticas</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Estado Actual</p>
                                <p
                                    class="font-semibold text-lg capitalize {{ $practitioner->status == 'finalizado' ? 'text-green-600' : ($practitioner->status == 'en proceso' ? 'text-blue-600' : 'text-yellow-600') }}">
                                    {{ ucfirst($practitioner->status) }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Horas Completadas</p>
                                <p class="font-semibold text-lg">{{ $practitioner->hours_completed }} / 480</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Fecha Inicio</p>
                                <p class="font-medium">{{ $practitioner->start_date }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Fecha Fin</p>
                                <p class="font-medium">{{ $practitioner->end_date }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Company Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Información de la Empresa</h3>
                        <div class="space-y-2">
                            <p><span class="text-gray-500">Empresa:</span> <span
                                    class="font-medium">{{ $practitioner->company_name }}</span></p>
                            <p><span class="text-gray-500">Área:</span> <span
                                    class="font-medium">{{ $practitioner->practice_area }}</span></p>
                            <p><span class="text-gray-500">Supervisor 1:</span> <span
                                    class="font-medium">{{ $practitioner->supervisor1 ? $practitioner->supervisor1->name : 'No asignado' }}</span>
                            </p>
                        </div>
                    </div>

                    <!-- Upload Report Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 md:col-span-2">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Informe Final de Prácticas</h3>

                        @if($practitioner->final_report_path)
                            <div
                                class="mb-4 p-4 bg-green-50 border border-green-200 rounded-md flex justify-between items-center">
                                <div>
                                    <span class="text-green-700 font-medium">Informe subido exitosamente</span>
                                    <p class="text-xs text-green-600">Puedes actualizarlo subiendo uno nuevo.</p>
                                </div>
                                <a href="{{ Storage::url($practitioner->final_report_path) }}" target="_blank"
                                    class="bg-white text-green-700 border border-green-300 px-3 py-1 rounded text-sm hover:bg-green-50">
                                    Ver Informe
                                </a>
                            </div>
                        @else
                            <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-md">
                                <span class="text-yellow-700 font-medium">Pendiente de entrega</span>
                            </div>
                        @endif

                        <form action="{{ route('student.report.upload') }}" method="POST" enctype="multipart/form-data"
                            class="mt-4">
                            @csrf
                            <label class="block mb-2 text-sm font-medium text-gray-900" for="final_report">Subir archivo
                                (PDF, Max 10MB)</label>
                            <div class="flex items-center gap-4">
                                <input
                                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                                    id="final_report" name="final_report" type="file" accept=".pdf" required>
                                <button type="submit"
                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                                    Subir
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Permission Request Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 md:col-span-2">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Solicitar Permiso / Vacaciones</h3>

                        <form action="{{ route('student.request.store') }}" method="POST"
                            class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @csrf
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Tipo de Solicitud</label>
                                <select name="type" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="permiso">Permiso Personal</option>
                                    <option value="vacaciones">Vacaciones</option>
                                    <option value="enfermedad">Licencia por Enfermedad</option>
                                    <option value="otro">Otro</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Fecha Inicio</label>
                                <input type="date" name="start_date" id="start_date" required min="{{ date('Y-m-d') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Fecha Fin</label>
                                <input type="date" name="end_date" id="end_date" required min="{{ date('Y-m-d') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Motivo</label>
                                <textarea name="reason" rows="3" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                            </div>

                            <div class="md:col-span-2 text-right">
                                <button type="submit"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                                    Enviar Solicitud
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay registro de prácticas</h3>
                    <p class="mt-1 text-sm text-gray-500">Aún no se ha creado tu ficha de practicante. Contacta con tu
                        coordinador.</p>
                </div>

                <!-- Active Convocations for Students without practice -->
                @if(isset($activeConvocatorias) && $activeConvocatorias->count() > 0)
                    <div class="mt-8">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Convocatorias Vigentes</h3>
                        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                            @foreach($activeConvocatorias as $convocatoria)
                                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                                    <h4 class="font-bold text-gray-800">{{ $convocatoria->company }}</h4>
                                    <p class="text-sm text-gray-600 mt-2 line-clamp-3">{{ $convocatoria->description }}</p>
                                    <a href="{{ route('convocatorias.index') }}"
                                        class="text-blue-600 text-sm mt-4 inline-block hover:underline">Ver detalles</a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif

        </div>
    </div>
</x-app-layout>