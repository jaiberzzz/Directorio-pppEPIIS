<x-admin-layout>
    @section('header', 'Dashboard General')

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Card 1 -->
        <div class="bg-white rounded-lg shadow-sm p-6 flex items-center border border-gray-100">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                <i class="fas fa-users text-2xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Practicantes</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['total_practitioners'] }}</p>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white rounded-lg shadow-sm p-6 flex items-center border border-gray-100">
            <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                <i class="fas fa-user-check text-2xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Practicantes Activos</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['active_practitioners'] }}</p>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white rounded-lg shadow-sm p-6 flex items-center border border-gray-100">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                <i class="fas fa-bullhorn text-2xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Convocatorias Activas</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['active_convocatorias'] }}</p>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="bg-white rounded-lg shadow-sm p-6 flex items-center border border-gray-100">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                <i class="fas fa-file-alt text-2xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Documentos</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['total_documents'] }}</p>
            </div>
        </div>
    </div>

    <!-- Recent Practitioners Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-history text-gray-400"></i> Últimos Practicantes Registrados
            </h3>
            <a href="{{ route('admin.practitioners.index') }}"
                class="text-sm text-blue-600 hover:underline font-medium">Ver todos</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-3">Código</th>
                        <th class="px-6 py-3">Nombre</th>
                        <th class="px-6 py-3">Empresa</th>
                        <th class="px-6 py-3">Estado</th>
                        <th class="px-6 py-3">Fecha Registro</th>
                        <th class="px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($recentPractitioners as $p)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-3 font-mono text-gray-500">{{ $p->student_code }}</td>
                            <td class="px-6 py-3 font-medium text-gray-900">{{ $p->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-3">{{ $p->company_name }}</td>
                            <td class="px-6 py-3">
                                @if($p->status == 'finalizado')
                                    <span
                                        class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full font-bold">Finalizado</span>
                                @elseif($p->status == 'en proceso')
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full font-bold">En
                                        Proceso</span>
                                @else
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full font-bold">Por
                                        Iniciar</span>
                                @endif
                            </td>
                            <td class="px-6 py-3 text-gray-500">{{ $p->created_at->format('d/m/Y') }}</td>
                            <td class="px-6 py-3">
                                <a href="{{ route('admin.practitioners.edit', $p->id) }}"
                                    class="bg-blue-500 hover:bg-blue-600 text-white p-1.5 rounded shadow-sm transition"
                                    title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">No hay practicantes registrados
                                recientemente.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>