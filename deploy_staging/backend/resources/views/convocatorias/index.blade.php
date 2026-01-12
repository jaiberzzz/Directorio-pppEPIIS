<x-public-layout>
    <!-- Hero Section -->
    <div class="relative bg-slate-900 py-8 overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10"
            style="background-image: radial-gradient(#4b5563 1px, transparent 1px); background-size: 32px 32px;"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center z-10">
            <!-- Search Bar -->
            <div class="max-w-xl mx-auto">
                <form action="{{ route('convocatorias.index') }}" method="GET" class="relative group">
                    <div
                        class="absolute -inset-0.5 bg-gradient-to-r from-blue-600 to-cyan-500 rounded-full blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200">
                    </div>
                    <div class="relative flex items-center bg-white rounded-full shadow-lg overflow-hidden px-2">
                        <div class="pl-3 text-gray-400">
                            <i class="fas fa-search text-base"></i>
                        </div>
                        <input type="text" name="search" id="search"
                            class="block w-full border-0 py-2.5 pl-3 pr-4 text-gray-900 placeholder-gray-500 focus:ring-0 text-sm md:text-base bg-transparent"
                            placeholder="Buscar prácticas..." value="{{ request('search') }}">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Active Convocatorias Grid -->
    <div class="bg-gray-50 py-16" id="convocatorias-container">
        @include('convocatorias.partials.list')
    </div>

    <!-- Scripts for Live Search -->
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const searchInput = document.getElementById('search');
                let timeout = null;

                searchInput.addEventListener('input', function () {
                    clearTimeout(timeout);
                    const query = this.value;

                    timeout = setTimeout(function () {
                        fetchResults(query);
                    }, 300); // Debounce de 300ms
                });

                // Handle pagination clicks via AJAX
                document.addEventListener('click', function (e) {
                    const link = e.target.closest('.pagination a');
                    if (link) {
                        e.preventDefault();
                        const url = link.href;
                        fetchResults(null, url);
                    }
                });

                function fetchResults(query, url = null) {
                    let fetchUrl = url || "{{ route('convocatorias.index') }}";

                    if (!url && query !== null) {
                        const urlObj = new URL(fetchUrl);
                        urlObj.searchParams.set('search', query);
                        fetchUrl = urlObj.toString();

                        // Update URL browser history
                        window.history.pushState({ path: fetchUrl }, '', fetchUrl);
                    }

                    // Add AJAX header
                    const headers = new Headers();
                    headers.append('X-Requested-With', 'XMLHttpRequest');

                    fetch(fetchUrl, { headers: headers })
                        .then(response => response.text())
                        .then(html => {
                            document.getElementById('convocatorias-container').innerHTML = html;
                        })
                        .catch(error => console.error('Error:', error));
                }
            });
        </script>
    @endpush

    <!-- Details Modal -->
    <div id="detailsModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="fixed inset-0 bg-gray-900/75 backdrop-blur-sm transition-opacity" onclick="closeDetailsModal()">
        </div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div
                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-xl">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-2xl font-bold leading-6 text-gray-900 mb-4" id="details-modal-title">
                                    Detalles de la Convocatoria</h3>
                                <div id="details-modal-body" class="mt-2 text-gray-600">
                                    <!-- Content injected via JS -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button type="button"
                            class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                            onclick="closeDetailsModal()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Postular Modal -->
    <div id="postularModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="fixed inset-0 bg-gray-900/75 backdrop-blur-sm transition-opacity" onclick="closePostularModal()">
        </div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div
                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div
                        class="bg-gray-50 px-4 py-4 sm:px-6 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-bold leading-6 text-gray-900">
                            Postular a <span id="modal-company-name" class="text-blue-600 ml-1 capitalize"></span>
                        </h3>
                        <button type="button" class="text-gray-400 hover:text-gray-500 transition"
                            onclick="closePostularModal()">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>

                    <div class="px-4 py-6 sm:p-6">
                        <p class="text-sm text-gray-500 mb-6 text-center">
                            Elige el medio de contacto preferido para enviar tu CV o realizar consultas:
                        </p>

                        <div class="space-y-3">
                            <!-- Email -->
                            <a id="modal-btn-email" href="#" target="_blank"
                                class="flex items-center p-4 rounded-xl border border-gray-200 hover-lift email group">
                                <div
                                    class="flex-shrink-0 h-12 w-12 rounded-full bg-red-100 flex items-center justify-center text-red-500 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-envelope text-xl"></i>
                                </div>
                                <div class="ml-4 flex-1">
                                    <p
                                        class="text-base font-bold text-gray-900 group-hover:text-red-700 transition-colors">
                                        Enviar Correo</p>
                                    <p class="text-sm text-gray-500">Se abrirá tu cliente de correo</p>
                                </div>
                                <i
                                    class="fas fa-chevron-right text-gray-300 group-hover:text-red-500 transition-colors"></i>
                            </a>

                            <!-- WhatsApp -->
                            <a id="modal-btn-whatsapp" href="#" target="_blank"
                                class="flex items-center p-4 rounded-xl border border-gray-200 hover-lift whatsapp group">
                                <div
                                    class="flex-shrink-0 h-12 w-12 rounded-full bg-green-100 flex items-center justify-center text-green-500 group-hover:scale-110 transition-transform">
                                    <i class="fab fa-whatsapp text-2xl"></i>
                                </div>
                                <div class="ml-4 flex-1">
                                    <p
                                        class="text-base font-bold text-gray-900 group-hover:text-green-700 transition-colors">
                                        WhatsApp</p>
                                    <p class="text-sm text-gray-500">Iniciar chat directo</p>
                                </div>
                                <i
                                    class="fas fa-chevron-right text-gray-300 group-hover:text-green-500 transition-colors"></i>
                            </a>

                            <!-- Phone -->
                            <a id="modal-btn-phone" href="#"
                                class="flex items-center p-4 rounded-xl border border-gray-200 hover-lift phone group">
                                <div
                                    class="flex-shrink-0 h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-500 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-phone-alt text-xl"></i>
                                </div>
                                <div class="ml-4 flex-1">
                                    <p
                                        class="text-base font-bold text-gray-900 group-hover:text-blue-700 transition-colors">
                                        Llamada Telefónica</p>
                                    <p class="text-sm text-gray-500">Llamar al contacto</p>
                                </div>
                                <i
                                    class="fas fa-chevron-right text-gray-300 group-hover:text-blue-500 transition-colors"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Postular Modal Logic
        function openPostularModal(company, email, phone, title) {
            document.getElementById('modal-company-name').innerText = company;

            // Email Logic
            const subject = encodeURIComponent('Postulación: ' + (title || 'Prácticas'));
            const emailBtn = document.getElementById('modal-btn-email');

            if (email) {
                emailBtn.href = `mailto:${email}?subject=${subject}`;
                emailBtn.classList.remove('opacity-50', 'pointer-events-none', 'grayscale');
            } else {
                emailBtn.href = 'javascript:void(0)';
                emailBtn.classList.add('opacity-50', 'pointer-events-none', 'grayscale');
            }

            // WhatsApp Logic
            const whatsappBtn = document.getElementById('modal-btn-whatsapp');
            if (phone) {
                const cleanPhone = phone.replace(/\D/g, '');
                let finalPhone = cleanPhone;

                // Add Peru country code (51) if missing
                if (cleanPhone.length === 9) {
                    finalPhone = '51' + cleanPhone;
                }

                const text = encodeURIComponent(`Hola, estoy interesado en la convocatoria de "${title}".`);
                whatsappBtn.href = `https://wa.me/${finalPhone}?text=${text}`;
                whatsappBtn.classList.remove('opacity-50', 'pointer-events-none', 'grayscale');
            } else {
                whatsappBtn.href = 'javascript:void(0)';
                whatsappBtn.classList.add('opacity-50', 'pointer-events-none', 'grayscale');
            }

            // Phone Logic
            const phoneBtn = document.getElementById('modal-btn-phone');
            if (phone) {
                phoneBtn.href = `tel:${phone}`;
                phoneBtn.classList.remove('opacity-50', 'pointer-events-none', 'grayscale');
            } else {
                phoneBtn.href = 'javascript:void(0)';
                phoneBtn.classList.add('opacity-50', 'pointer-events-none', 'grayscale');
            }

            document.getElementById('postularModal').classList.remove('hidden');
        }

        function closePostularModal() {
            document.getElementById('postularModal').classList.add('hidden');
        }

        // Details Modal Logic
        function openDetailsModal(id) {
            const content = document.getElementById('details-content-' + id).innerHTML;
            document.getElementById('details-modal-body').innerHTML = content;
            document.getElementById('detailsModal').classList.remove('hidden');
        }

        function closeDetailsModal() {
            document.getElementById('detailsModal').classList.add('hidden');
        }
    </script>
</x-public-layout>