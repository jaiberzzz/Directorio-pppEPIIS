<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" id="convocatorias-grid">
    <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Ofertas Disponibles</h2>
            <p class="mt-1 text-gray-500">Postula a las convocatorias más recientes.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center justify-center bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-bold shadow-sm">
                {{ $convocatorias->total() }}
            </span>
            <span class="text-gray-500 text-sm font-medium">Resultados encontrados</span>
        </div>
    </div>

    @if ($convocatorias->count() > 0)
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($convocatorias as $convocatoria)
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden flex flex-col h-full transform hover:-translate-y-1">
                    <!-- Top Decorator -->
                    <div class="h-2 bg-gradient-to-r from-blue-500 to-cyan-400"></div>
                    
                    <div class="p-6 flex-grow flex flex-col">
                        <!-- Heading -->
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex-1 pr-4">
                                    <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors leading-snug capitalize">
                                    {{ $convocatoria->title }}
                                </h3>
                                <div class="mt-2 flex items-center text-sm font-medium text-slate-500">
                                    <i class="far fa-building mr-1.5 text-blue-400"></i>
                                    <span class="capitalize">{{ $convocatoria->company }}</span>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                    @if($convocatoria->created_at->diffInDays() < 7)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-green-50 text-green-700 border border-green-100">
                                        NUEVO
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-gray-50 text-gray-600 border border-gray-100">
                                        ACTIVO
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Bits of Info -->
                        <div class="py-4 border-t border-b border-gray-50 grid grid-cols-2 gap-y-3 gap-x-2 text-sm">
                            <div class="flex items-center text-gray-600">
                                <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center mr-2 text-blue-500">
                                    <i class="fas fa-layer-group text-xs"></i>
                                </div>
                                <span class="truncate">{{ $convocatoria->area }}</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <div class="w-8 h-8 rounded-full bg-indigo-50 flex items-center justify-center mr-2 text-indigo-500">
                                    <i class="fas fa-users text-xs"></i>
                                </div>
                                <span>{{ $convocatoria->vacancies }} Vacantes</span>
                            </div>
                            <div class="flex items-center text-gray-600 col-span-2">
                                <div class="w-8 h-8 rounded-full bg-orange-50 flex items-center justify-center mr-2 text-orange-500">
                                    <i class="fas fa-clock text-xs"></i>
                                </div>
                                <span>Cierre: {{ optional($convocatoria->end_date)->format('d \d\e M, Y') ?? 'Indefinido' }}</span>
                            </div>
                        </div>
                        
                        <!-- Description Snippet -->
                        <div class="mt-4 mb-4">
                                <p class="text-sm text-gray-500 line-clamp-3 leading-relaxed">
                                {!! Str::limit(strip_tags($convocatoria->description), 140) !!}
                            </p>
                        </div>

                        <!-- Actions -->
                        <div class="mt-auto flex items-center gap-3 pt-4">
                            <button
                                onclick="openDetailsModal('{{ $convocatoria->id }}')"
                                class="flex-1 py-2.5 px-4 bg-gray-50 text-gray-700 font-semibold rounded-lg hover:bg-gray-100 transition-colors text-sm text-center border border-gray-200">
                                Ver Más
                            </button>
                                @auth
                                    <button 
                                        onclick="openPostularModal(
                                            '{{ addslashes($convocatoria->company) }}', 
                                            '{{ $convocatoria->contact_email }}', 
                                            '{{ $convocatoria->contact_phone }}', 
                                            '{{ addslashes($convocatoria->title) }}'
                                        )"
                                        style="background: linear-gradient(to right, #f97316, #dc2626);"
                                        class="flex-1 py-2.5 px-4 text-white font-bold rounded-lg shadow-md hover:shadow-xl transition-all text-sm text-center transform hover:-translate-y-0.5 flex items-center justify-center gap-2 btn-anim">
                                        Postular <i class="fas fa-paper-plane text-xs"></i>
                                    </button>
                            @else
                                <a href="{{ route('login') }}" 
                                    class="flex-1 py-2.5 px-4 bg-slate-800 text-white font-semibold rounded-lg hover:bg-slate-700 transition-colors text-sm text-center">
                                    Login
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>

                <!-- Details Modal Content (Hidden) -->
                <div id="details-content-{{ $convocatoria->id }}" class="hidden">
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4 text-sm bg-gray-50 p-4 rounded-lg">
                            <div><strong>Empresa:</strong> {{ $convocatoria->company }}</div>
                            <div><strong>Área:</strong> {{ $convocatoria->area }}</div>
                            <div><strong>Vacantes:</strong> {{ $convocatoria->vacancies }}</div>
                            <div><strong>Fecha Inicio:</strong>
                                {{ optional($convocatoria->start_date)->format('d/m/Y') ?? '--' }}</div>
                            <div><strong>Fecha Cierre:</strong>
                                {{ optional($convocatoria->end_date)->format('d/m/Y') ?? '--' }}</div>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-1">Descripción</h4>
                            <div
                                class="text-sm text-gray-600 whitespace-pre-line bg-white border border-gray-200 p-3 rounded-lg max-h-40 overflow-y-auto">
                                {{ $convocatoria->description }}
                            </div>
                        </div>
                        @if($convocatoria->requirements)
                            <div>
                                <h4 class="font-bold text-gray-900 mb-1">Requisitos</h4>
                                <ul class="text-sm text-gray-600 list-disc pl-5 space-y-1">
                                    @foreach(explode("\n", $convocatoria->requirements) as $req)
                                        @if(trim($req))
                                        <li>{{ trim($req) }}</li> @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="text-sm text-gray-500 pt-2 border-t border-gray-100">
                            @if($convocatoria->contact_name)
                                <p><span class="font-semibold">Contacto:</span> {{ $convocatoria->contact_name }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $convocatorias->appends(['search' => request('search')])->links() }}
        </div>
    @else
        <div class="text-center py-20 bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="inline-flex items-center justify-center p-4 bg-gray-100 rounded-full mb-4">
                <i class="fas fa-search text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900">No se encontraron resultados</h3>
            <p class="mt-2 text-gray-500">Intenta buscar con otros términos o limpia el filtro.</p>
            <a href="{{ route('convocatorias.index') }}"
                class="mt-4 inline-flex items-center text-blue-600 hover:underline">
                Ver todas las convocatorias
            </a>
        </div>
    @endif
</div>
