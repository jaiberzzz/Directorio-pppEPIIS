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
                <h3 class="text-2xl font-bold text-gray-800">Directorio de Practicantes Activos</h3>
            </div>
            
            <div class="bg-white rounded shadow border border-gray-200 overflow-hidden">
                <table id="practitioners-table" class="w-full text-left border-collapse">
                    <thead class="bg-[#2c3e50] text-white uppercase text-xs font-bold">
                        <tr>
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
                    <article class="bg-white p-6 rounded shadow-sm border border-gray-200">
                        <span class="text-xs text-blue-600 font-bold uppercase mb-2 block">{{ $item->published_at ? $item->published_at->format('d M, Y') : 'Reciente' }}</span>
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
                    <div class="bg-white p-6 rounded shadow-sm border border-gray-200 flex flex-col md:flex-row items-center justify-between gap-4">
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
                                <p class="text-sm text-gray-500">{{ $doc->description ?? 'Formato oficial para trámites.' }}</p>
                            </div>
                        </div>
                        <a href="{{ Storage::url($doc->file_path) }}" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded text-sm font-bold flex items-center gap-2 transition" download>
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
    <script>
        $(document).ready(function () {
            $('#practitioners-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("directory.data") }}',
                columns: [
                    { data: 'student_code', name: 'student_code' },
                    { data: 'full_name', name: 'user.name' }, 
                    { data: 'company_name', name: 'company_name' },
                    { data: 'practice_area', name: 'practice_area' },
                    { data: 'hours_completed', name: 'hours_completed', 
                        render: function(data) {
                            return data + ' hrs';
                        }
                    },
                    { data: 'action', name: 'action', orderable: false, searchable: false,
                        render: function(data, type, row) {
                            return '<button class="bg-blue-500 text-white px-3 py-1 rounded text-xs hover:bg-blue-600 transition"><i class="fas fa-eye mr-1"></i> Ver más</button>';
                        }
                    }
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
                },
                // Removing default DataTables styles to match the clean look
                dom: 'rt<"flex justify-between items-center mt-4"ip>',
                initComplete: function() {
                    $('#practitioners-table').addClass('border-collapse');
                }
            });
        });
    </script>
    @endpush
</x-public-layout>