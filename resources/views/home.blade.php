<x-public-layout>
    <!-- Hero Section -->
    <div class="bg-gradient-to-b from-[#1e40af] to-[#2563eb] py-16 text-center text-white">
        <h2 class="text-3xl font-bold mb-2">Bienvenido al Directorio de Practicantes</h2>
        <p class="text-blue-100 text-lg">Sistema de gestión para prácticas preprofesionales</p>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-12 bg-gray-50">

        <!-- Section: Directory -->
        <section id="directory">
            <div class="flex items-center gap-2 mb-6 text-gray-700">
                <i class="fas fa-users text-2xl text-blue-600"></i>
                <h3 class="text-2xl font-bold text-gray-800">Conoce a Nuestros Practicantes:</h3>
            </div>

            <div class="bg-white rounded shadow border border-gray-200 overflow-x-auto">
                <table id="practitioners-table" class="w-full text-left border-collapse">
                    <thead class="bg-[#2c3e50] text-white uppercase text-xs font-bold">
                        <tr>
                            <th class="px-6 py-4">Foto</th>
                            <th class="px-6 py-4">Código</th>
                            <th class="px-6 py-4">Nombre Completo</th>
                            <th class="px-6 py-4">Empresa</th>
                            <th class="px-6 py-4">Área</th>
                            <th class="px-6 py-4">Horas</th>
                            <th class="px-6 py-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700 text-sm"></tbody>
                </table>
            </div>
        </section>

        <!-- Section: News -->
        <section id="news">
            <div class="flex items-center gap-2 mb-6 text-gray-700">
                <i class="fas fa-newspaper text-2xl text-blue-600"></i>
                <h3 class="text-2xl font-bold text-gray-800">Últimas Noticias</h3>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <!-- If no news, show placeholder to match layout -->
                @forelse($news as $item)
                    <article class="bg-white p-6 rounded shadow-sm border border-gray-200 hover-lift clean">
                        <span
                            class="text-xs text-blue-600 font-bold uppercase mb-2 block">{{ $item->published_at ? $item->published_at->format('d M, Y') : 'Reciente' }}</span>
                        <h4 class="font-bold text-lg text-gray-900 mb-2">{{ $item->title }}</h4>
                        <p class="text-gray-600 text-sm mb-4">{{ Str::limit($item->content, 100) }}</p>
                        <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-800">Leer más &rarr;</a>
                    </article>
                @empty
                    <div class="col-span-3 bg-white p-6 rounded border border-gray-100 text-center text-gray-500">
                        No hay noticias registradas.
                    </div>
                @endforelse
            </div>
        </section>

        <!-- Section: Documents -->
        <section id="documents">
            <div class="flex items-center gap-2 mb-6 text-gray-700">
                <i class="fas fa-file-alt text-2xl text-blue-600"></i>
                <h3 class="text-2xl font-bold text-gray-800">Formatos y Documentos</h3>
            </div>

            <div class="space-y-4">
                @forelse($documents as $doc)
                    <div
                        class="bg-white p-6 rounded shadow-sm border border-gray-200 flex flex-col md:flex-row items-center justify-between gap-4 hover-lift clean">
                        <div class="flex items-center gap-4">
                            <!-- Icon logic: Simple check for extension or default PDF icon -->
                            @php
                                $ext = pathinfo($doc->file_path, PATHINFO_EXTENSION);
                                $iconColor = $ext == 'docx' || $ext == 'doc' ? 'text-blue-500' : 'text-red-500';
                                $iconClass = $ext == 'docx' || $ext == 'doc' ? 'fa-file-word' : 'fa-file-pdf';
                            @endphp
                            <div class="text-4xl {{ $iconColor }}">
                                <i class="fas {{ $iconClass }}"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">{{ $doc->title }}</h4>
                                <p class="text-sm text-gray-500">{{ $doc->description ?? 'Formato oficial para trámites.' }}
                                </p>
                            </div>
                        </div>
                        <a href="{{ Storage::url($doc->file_path) }}"
                            class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded text-sm font-bold flex items-center gap-2 transition"
                            download>
                            <i class="fas fa-download"></i> Descargar
                        </a>
                    </div>
                @empty
                    <p class="text-gray-500">No hay documentos disponibles.</p>
                @endforelse
            </div>
        </section>

    </div>

    <!-- Profile Modal -->
    <div id="profileModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                onclick="closeProfileModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Perfil del
                                Practicante</h3>
                            <div class="mt-4 border-t border-gray-100 pt-4" id="modal-content">
                                <!-- Dynamic Content -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                        onclick="closeProfileModal()">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <style>
            /* Custom DataTables Styling */
            .dataTables_wrapper .dataTables_filter input {
                border: 1px solid #d1d5db;
                border-radius: 0.5rem;
                padding: 0.5rem 1rem;
                font-size: 0.875rem;
                outline: none;
                box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
                transition: all 0.2s;
                margin-left: 0.5rem;
            }

            .dataTables_wrapper .dataTables_filter input:focus {
                border-color: #3b82f6;
                ring: 2px solid #3b82f6;
            }

            .dataTables_wrapper .dataTables_length select {
                border: 1px solid #d1d5db;
                border-radius: 0.5rem;
                padding: 0.5rem 2rem 0.5rem 1rem;
                font-size: 0.875rem;
                outline: none;
                margin-right: 0.5rem;
                background-position: right 0.5rem center;
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button {
                padding: 0.25rem 0.75rem;
                margin: 0 0.25rem;
                border-radius: 0.25rem;
                border: 1px solid #d1d5db;
                background: white;
                color: #374151 !important;
                font-size: 0.875rem;
                cursor: pointer;
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
                background: #f3f4f6 !important;
                color: #111827 !important;
                border-color: #9ca3af;
                background-image: none !important;
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button.current {
                background: #2563eb !important;
                color: white !important;
                border-color: #2563eb;
                background-image: none !important;
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
                opacity: 0.5;
                cursor: not-allowed;
            }
        </style>
        <script>
            let table; // Global reference

            $(document).ready(function () {
                table = $('#practitioners-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route("directory.data") }}',
                    columns: [
                        {
                            data: 'photo_path', name: 'photo_path', orderable: false, searchable: false,
                            render: function (data, type, row) {
                                if (data) {
                                    return `<img src="/storage/${data}" alt="Foto" class="w-10 h-10 rounded-full object-cover border border-gray-300">`;
                                } else {
                                    return `<div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold border border-gray-300">
                                                                                            ${row.full_name ? row.full_name.charAt(0) : '?'}
                                                                                        </div>`;
                                }
                            }
                        },
                        { data: 'student_code', name: 'student_code' },
                        { data: 'full_name', name: 'user.name' },
                        { data: 'company_name', name: 'company_name' },
                        { data: 'practice_area', name: 'practice_area' },
                        {
                            data: 'hours_completed', name: 'hours_completed',
                            render: function (data) {
                                return data + ' hrs';
                            }
                        },
                        {
                            data: 'action', name: 'action', orderable: false, searchable: false,
                            render: function (data, type, row) {
                                let buttons = '<div class="flex gap-2">';

                                // View Profile/Schedule Button
                                buttons += `<button onclick='openProfileModal(${JSON.stringify(row)})' class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs inline-flex items-center btn-anim" title="Ver Horario y Detalles">
                                                    <i class="fas fa-calendar-alt"></i>
                                                </button>`;

                                // Report Button
                                let isApproved = (row.report_status === 'approved');
                                let hasReport = (row.final_report_path && row.final_report_path !== null);

                                if (isApproved && hasReport) {
                                    let reportUrl = '/storage/' + row.final_report_path;
                                    buttons += `<a href="${reportUrl}" target="_blank" class="bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-700 transition inline-flex items-center btn-anim" title="Ver Informe">
                                                        <i class="fas fa-file-pdf"></i>
                                                    </a>`;
                                }

                                buttons += '</div>';
                                return buttons;
                            }
                        }
                    ],
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
                    },
                    dom: '<"flex flex-col md:flex-row justify-between items-center mb-6 gap-4"lf>rt<"flex flex-col md:flex-row justify-between items-center mt-6 gap-4"ip>',
                    initComplete: function () {
                        $('#practitioners-table').addClass('border-collapse w-full');
                    }
                });
            });

            function openProfileModal(data) {
                let modal = document.getElementById('profileModal');
                let content = document.getElementById('modal-content');

                // Format Schedule
                let scheduleHtml = '';
                if (data.schedules && data.schedules.length > 0) {
                    scheduleHtml = '<div class="mt-4"><h4 class="font-bold text-sm text-gray-700 mb-2">Horario de Prácticas</h4><div class="grid grid-cols-2 gap-2 text-sm">';
                    const days = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];

                    days.forEach(day => {
                        let sch = data.schedules.find(s => s.day_of_week === day);
                        scheduleHtml += `<div class="bg-gray-50 p-2 rounded border border-gray-100 flex justify-between">
                                        <span class="capitalize font-medium text-gray-600">${day}</span>
                                        <span class="text-blue-600 font-bold">${sch ? (sch.start_time.substring(0, 5) + ' - ' + sch.end_time.substring(0, 5)) : '-'}</span>
                                    </div>`;
                    });
                    scheduleHtml += '</div>';

                    // Add Global Observation if exists
                    if (data.schedule_observation) {
                        scheduleHtml += `<div class="mt-3 p-2 bg-yellow-50 border border-yellow-100 rounded text-xs">
                                    <strong class="text-yellow-800 block mb-1">Notas:</strong>
                                    <p class="text-gray-700 italic">${data.schedule_observation}</p>
                                </div>`;
                    }

                    scheduleHtml += '</div>';
                } else {
                    scheduleHtml = '<p class="text-sm text-gray-500 mt-4 italic">No hay horario registrado.</p>';
                }

                // Populate Content
                content.innerHTML = `
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <p class="text-xs text-gray-500 uppercase font-bold">Practicante</p>
                                            <p class="font-bold text-gray-900 text-lg">${data.full_name}</p>
                                            <p class="text-sm text-gray-600">${data.student_code}</p>
                                        </div>
                                         <div>
                                            <p class="text-xs text-gray-500 uppercase font-bold">Empresa</p>
                                            <p class="font-bold text-gray-900 text-lg">${data.company_name}</p>
                                            <p class="text-sm text-gray-600">${data.practice_area}</p>
                                        </div>
                                    </div>
                                    ${scheduleHtml}
                                `;

                modal.classList.remove('hidden');
            }

            function closeProfileModal() {
                document.getElementById('profileModal').classList.add('hidden');
            }
        </script>
    @endpush
</x-public-layout>