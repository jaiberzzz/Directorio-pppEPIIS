<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalles del Practicante') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center">
                            <div
                                class="h-20 w-20 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold text-2xl overflow-hidden mr-4">
                                @if($practitioner->photo_path)
                                    <img src="{{ Storage::url($practitioner->photo_path) }}"
                                        alt="{{ $practitioner->user->name }}" class="h-full w-full object-cover">
                                @else
                                    {{ substr($practitioner->user->name, 0, 1) }}
                                @endif
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900">{{ $practitioner->user->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $practitioner->user->email }}</p>
                                <div class="mt-2">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $practitioner->status == 'finalizado' ? 'bg-green-100 text-green-800' : ($practitioner->status == 'en proceso' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ ucfirst($practitioner->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.practitioners.edit', $practitioner->id) }}"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow btn-anim">
                                <i class="fas fa-edit mr-2"></i> Editar
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h4 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">Información Académica
                            </h4>
                            <dl class="grid grid-cols-1 gap-y-3">
                                <div class="grid grid-cols-3">
                                    <dt class="text-sm font-medium text-gray-500">DNI</dt>
                                    <dd class="text-sm text-gray-900 col-span-2">{{ $practitioner->dni }}</dd>
                                </div>
                                <div class="grid grid-cols-3">
                                    <dt class="text-sm font-medium text-gray-500">Código</dt>
                                    <dd class="text-sm text-gray-900 col-span-2">{{ $practitioner->student_code }}</dd>
                                </div>
                                <div class="grid grid-cols-3">
                                    <dt class="text-sm font-medium text-gray-500">Semestre</dt>
                                    <dd class="text-sm text-gray-900 col-span-2">{{ $practitioner->semester }}</dd>
                                </div>
                                <div class="grid grid-cols-3">
                                    <dt class="text-sm font-medium text-gray-500">Teléfono</dt>
                                    <dd class="text-sm text-gray-900 col-span-2">{{ $practitioner->phone ?? 'N/A' }}
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h4 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">Información de Prácticas
                            </h4>
                            <dl class="grid grid-cols-1 gap-y-3">
                                <div class="grid grid-cols-3">
                                    <dt class="text-sm font-medium text-gray-500">Empresa</dt>
                                    <dd class="text-sm text-gray-900 col-span-2">{{ $practitioner->company_name }}</dd>
                                </div>
                                <div class="grid grid-cols-3">
                                    <dt class="text-sm font-medium text-gray-500">Área</dt>
                                    <dd class="text-sm text-gray-900 col-span-2">{{ $practitioner->practice_area }}</dd>
                                </div>
                                <div class="grid grid-cols-3">
                                    <dt class="text-sm font-medium text-gray-500">Supervisor(es)</dt>
                                    <dd class="text-sm text-gray-900 col-span-2">
                                        <p>{{ $practitioner->supervisor1 ? $practitioner->supervisor1->name : 'N/A' }}
                                        </p>
                                        @if($practitioner->supervisor2)
                                            <p>{{ $practitioner->supervisor2->name }}</p>
                                        @endif
                                    </dd>
                                </div>
                                <div class="grid grid-cols-3">
                                    <dt class="text-sm font-medium text-gray-500">Periodo</dt>
                                    <dd class="text-sm text-gray-900 col-span-2">
                                        {{ \Carbon\Carbon::parse($practitioner->start_date)->format('d/m/Y') }} -
                                        {{ \Carbon\Carbon::parse($practitioner->end_date)->format('d/m/Y') }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Schedule Section -->
                    <div class="mt-8">
                        <h4 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">Horario de Prácticas</h4>
                        @if($practitioner->schedules->count() > 0)
                            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4">
                                @foreach(['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'] as $day)
                                    @php
                                        $schedule = $practitioner->schedules->firstWhere('day_of_week', $day);
                                    @endphp
                                    <div
                                        class="bg-gray-50 rounded p-3 text-center border {{ $schedule ? 'border-blue-200 bg-blue-50' : 'border-gray-100' }}">
                                        <p class="text-xs uppercase font-bold text-gray-500 mb-1">{{ substr($day, 0, 3) }}</p>
                                        @if($schedule)
                                            <p class="text-sm font-semibold text-blue-700">
                                                {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} -
                                                {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                            </p>
                                        @else
                                            <p class="text-xs text-gray-400">-</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <!-- Global Observation Display -->
                            @if($practitioner->schedule_observation)
                                <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-md">
                                    <h5 class="text-xs font-bold text-yellow-800 uppercase mb-1">Notas / Observaciones</h5>
                                    <p class="text-sm text-gray-700 italic">{{ $practitioner->schedule_observation }}</p>
                                </div>
                            @endif
                        @else
                            <p class="text-gray-500 italic text-sm">El estudiante aún no ha registrado su horario.</p>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>