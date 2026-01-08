<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Control y Estadísticas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- KPI Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Card -->
                <div
                    class="bg-white overflow-hidden shadow-sm rounded-lg p-6 border-l-4 border-blue-500 hover:shadow-lg transition">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-500 mr-4">
                            <i class="fas fa-users text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Practicantes</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_practitioners'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Active Card -->
                <div
                    class="bg-white overflow-hidden shadow-sm rounded-lg p-6 border-l-4 border-green-500 hover:shadow-lg transition">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-500 mr-4">
                            <i class="fas fa-user-clock text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">En Proceso</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['active_practitioners'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Completed Card -->
                <div
                    class="bg-white overflow-hidden shadow-sm rounded-lg p-6 border-l-4 border-gray-500 hover:shadow-lg transition">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-gray-100 text-gray-500 mr-4">
                            <i class="fas fa-user-check text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Finalizados</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['completed_practitioners'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Pending Reports Card -->
                <div
                    class="bg-white overflow-hidden shadow-sm rounded-lg p-6 border-l-4 border-yellow-500 hover:shadow-lg transition">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                            <i class="fas fa-file-contract text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Informes Pendientes</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_reports'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Status Chart -->
                <!-- Status Chart -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                    <div class="flex justify-between items-center mb-4 border-b pb-2">
                        <h3 class="text-lg font-semibold text-gray-800">Estado de Prácticas</h3>
                        <!-- Filter Form -->
                        <form method="GET" action="{{ route('admin.dashboard') }}" class="flex items-center">
                            <label for="semester" class="mr-2 text-sm text-gray-600">Semestre:</label>
                            <select name="semester" id="semester" onchange="this.form.submit()" class="text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                @foreach($semesters as $sem)
                                    <option value="{{ $sem }}" {{ $selectedSemester == $sem ? 'selected' : '' }}>
                                        {{ $sem }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                    <div class="relative h-64">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>

                <!-- Companies Chart -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Top 5 Empresas</h3>
                    <div class="relative h-64">
                        <canvas id="companiesChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Recent Activity Table -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                <div class="flex justify-between items-center mb-4 border-b pb-2">
                    <h3 class="text-lg font-semibold text-gray-800">Actividad Reciente</h3>
                    <a href="{{ route('admin.practitioners.index') }}"
                        class="text-blue-600 hover:text-blue-800 text-sm font-bold hover:underline">Ver todos</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Practicante</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Empresa</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Fecha Inicio</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Estado</th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acción</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($recentPractitioners as $practitioner)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                @if($practitioner->photo_path)
                                                    <img class="h-10 w-10 rounded-full object-cover"
                                                        src="{{ Storage::url($practitioner->photo_path) }}" alt="">
                                                @else
                                                    <div
                                                        class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold">
                                                        {{ substr($practitioner->user->name, 0, 1) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $practitioner->user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $practitioner->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $practitioner->company_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($practitioner->start_date)->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($practitioner->status == 'en proceso')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">En
                                                Proceso</span>
                                        @elseif($practitioner->status == 'finalizado')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Finalizado</span>
                                        @else
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">{{ ucfirst($practitioner->status) }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.practitioners.edit', $practitioner->id) }}"
                                            class="text-blue-600 hover:text-blue-900 hover:underline">Editar</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No hay registros recientes.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <!-- Chart.js CDN -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Prepare Data from Blade
                const statusCounts = @json($statusCounts);
                const companyLabels = @json($companyLabels);
                const companyData = @json($companyData);

                // --- Chart 1: Status Distribution (Doughnut) ---
                const statusCtx = document.getElementById('statusChart').getContext('2d');
                new Chart(statusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: Object.keys(statusCounts).map(s => s.charAt(0).toUpperCase() + s.slice(1)),
                        datasets: [{
                            data: Object.values(statusCounts),
                            backgroundColor: [
                                '#F59E0B', // Yellow (Por iniciar)
                                '#10B981', // Green (En proceso)
                                '#6B7280', // Gray (Finalizado)
                                '#EF4444'  // Red (Other)
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right',
                            }
                        }
                    }
                });

                // --- Chart 2: Top Companies (Bar) ---
                const companiesCtx = document.getElementById('companiesChart').getContext('2d');
                new Chart(companiesCtx, {
                    type: 'bar',
                    data: {
                        labels: companyLabels,
                        datasets: [{
                            label: 'Practicantes',
                            data: companyData,
                            backgroundColor: '#3B82F6', // Blue
                            borderRadius: 4,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        indexAxis: 'y', // Horizontal Bar Chart
                        scales: {
                            x: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
</x-admin-layout>