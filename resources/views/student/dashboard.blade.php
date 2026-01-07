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
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <!-- Photo Header Section -->
                        <div class="bg-white pt-6 pb-2 flex justify-center">
                            <div class="h-16 w-16 rounded-full border-2 border-gray-100 shadow-lg overflow-hidden relative">
                                @if($practitioner->photo_path)
                                    <img src="{{ Storage::url($practitioner->photo_path) }}" alt="Foto de Perfil"
                                        class="w-full h-full object-cover">
                                @else
                                    <img src="{{ asset('images/default_user.png') }}" alt="Foto por defecto"
                                        class="w-full h-full object-cover opacity-80">
                                @endif
                            </div>
                        </div>

                        <!-- Info Section -->
                        <div class="px-6 pb-6 text-center">
                            <h3 class="text-xl font-bold text-gray-900 mb-6 border-b border-gray-100 pb-2">Estado de Prácticas</h3>
                            <div class="grid grid-cols-2 gap-y-4 gap-x-6 text-left">
                                <div class="flex flex-col items-center">
                                    <p class="text-xs uppercase tracking-wide text-gray-400 font-semibold">Estado Actual</p>
                                    <p
                                        class="font-bold text-lg capitalize {{ $practitioner->status == 'finalizado' ? 'text-green-600' : ($practitioner->status == 'en proceso' ? 'text-blue-600' : 'text-yellow-600') }}">
                                        {{ ucfirst($practitioner->status) }}
                                    </p>
                                </div>
                                <div class="flex flex-col items-center">
                                    <p class="text-xs uppercase tracking-wide text-gray-400 font-semibold">Horas Completadas</p>
                                    <p class="font-bold text-lg text-gray-700">{{ $practitioner->hours_completed }} <span class="text-sm font-normal text-gray-400">/ 480</span></p>
                                </div>
                                <div class="flex flex-col items-center">
                                    <p class="text-xs uppercase tracking-wide text-gray-400 font-semibold">Fecha Inicio</p>
                                    <p class="font-medium text-gray-700">{{ \Carbon\Carbon::parse($practitioner->start_date)->format('d M, Y') }}</p>
                                </div>
                                <div class="flex flex-col items-center">
                                    <p class="text-xs uppercase tracking-wide text-gray-400 font-semibold">Fecha Fin</p>
                                    <p class="font-medium text-gray-700">{{ \Carbon\Carbon::parse($practitioner->end_date)->format('d M, Y') }}</p>
                                </div>
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
                            @if($practitioner->report_status == 'approved')
                                <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-md flex justify-between items-center">
                                    <div>
                                        <span class="text-green-700 font-medium">Informe Aprobado</span>
                                        <p class="text-xs text-green-600">Tu informe ha sido revisado y aceptado.</p>
                                    </div>
                                    <a href="{{ Storage::url($practitioner->final_report_path) }}" target="_blank"
                                        class="bg-white text-green-700 border border-green-300 px-3 py-1 rounded text-sm hover:bg-green-50">
                                        Ver Informe
                                    </a>
                                </div>
                            @elseif($practitioner->report_status == 'rejected')
                                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-md">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <!-- Heroicon name: x-circle -->
                                            <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-sm font-medium text-red-800">Informe Rechazado</h3>
                                            <div class="mt-2 text-sm text-red-700">
                                                <p><span class="font-bold">Motivo:</span> {{ $practitioner->feedback }}</p>
                                                <p class="mt-1">Por favor, corrige las observaciones y vuelve a subir el archivo.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-md">
                                    <span class="text-blue-700 font-medium">En Revisión</span>
                                    <p class="text-xs text-blue-600">Tu informe está siendo revisado por el docente.</p>
                                    <div class="mt-2">
                                        <a href="{{ Storage::url($practitioner->final_report_path) }}" target="_blank"
                                        class="text-blue-600 hover:text-blue-800 text-sm underline">
                                        Ver archivo enviado
                                    </a>
                                    </div>
                                </div>
                            @endif
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
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Solicitar Permiso / Vacaciones</h3>

                        <form action="{{ route('student.request.store') }}" method="POST"
                            class="grid grid-cols-1 gap-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tipo de Solicitud</label>
                                <select name="type" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="permiso">Permiso Personal</option>
                                    <option value="vacaciones">Vacaciones</option>
                                    <option value="enfermedad">Licencia por Enfermedad</option>
                                    <option value="otro">Otro</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
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
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Motivo</label>
                                <textarea name="reason" rows="3" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                            </div>

                            <div class="text-right">
                                <button type="submit"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition w-full sm:w-auto">
                                    Enviar
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Permission History Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Historial de Permisos</h3>
                        <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Desde - Hasta</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Motivo</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($permissionRequests as $request)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $request->created_at->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm capitalize text-gray-900">
                                            {{ $request->type }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($request->start_date)->format('d/m') }} - {{ \Carbon\Carbon::parse($request->end_date)->format('d/m') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ Str::limit($request->reason, 50) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($request->status == 'aprobado')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Aprobado
                                                </span>
                                            @elseif($request->status == 'rechazado')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Rechazado
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Pendiente
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                            No hay solicitudes registradas.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
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