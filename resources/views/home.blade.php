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

            <div class="bg-white rounded shadow border border-gray-200 overflow-hidden">
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
            $(document).ready(function () {
                $('#practitioners-table').DataTable({
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
                                // Check if status is finalized and report path exists
                                // Note: 'status' field comes from row data. The controller returns 'status' capitalized in 'editColumn', 
                                // but let's check the raw data or the rendered data if possible. 
                                // Use row.status which might be 'Finalizado' due to the controller edit.
                                // Also need to ensure 'final_report_path' is included in the response.
                                // The controller selects 'practitioners.*', so it should be there.

                                // Adjust check to be case insensitive just in case or match controller output
                                let isApproved = (row.report_status === 'approved');
                                let hasReport = (row.final_report_path && row.final_report_path !== null);

                                if (isApproved && hasReport) {
                                    let reportUrl = '/storage/' + row.final_report_path;
                                    return `<a href="${reportUrl}" target="_blank" class="bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-700 transition inline-flex items-center btn-anim">
                                                                                <i class="fas fa-file-pdf mr-1"></i> Ver Informe
                                                                            </a>`;
                                } else {
                                    return `<button onclick="alert('Informe no disponible o en proceso')" class="bg-blue-400 text-black px-3 py-1 rounded text-xs inline-flex items-center font-bold btn-anim">
                                                                                <i class="fas fa-eye-slash mr-1"></i> En proceso
                                                                            </button>`;
                                }
                            }
                        }
                    ],
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
                    },
                    // Add 'f' for search and 'l' for length menu
                    dom: '<"flex flex-col md:flex-row justify-between items-center mb-6 gap-4"lf>rt<"flex flex-col md:flex-row justify-between items-center mt-6 gap-4"ip>',
                    initComplete: function () {
                        $('#practitioners-table').addClass('border-collapse w-full');
                    }
                });
            });
        </script>
    @endpush
</x-public-layout>