<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Convocatorias - Directorio de Practicantes</title>

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800 antialiased font-inter">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white font-bold text-lg" style="background-color: #3B82F6;">E</div>
                        <span class="text-xl font-bold text-gray-900 tracking-tight">EPIIS <span style="color: #3B82F6;">Practicantes</span></span>
                    </a>
                </div>
                <!-- Menu -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}"
                        class="text-gray-500 font-medium transition-colors text-sm hover:text-blue-600">
                        <i class="fas fa-arrow-left mr-1"></i> Volver al Inicio
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <div style="background: linear-gradient(to right, #0f4c81, #1e293b);" class="py-12 text-center text-white shadow-md">
        <div class="max-w-4xl mx-auto px-4">
            <div class="inline-flex items-center justify-center mb-3">
                <i class="fas fa-bullhorn text-3xl mr-3 opacity-90"></i>
                <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-white">Convocatorias para Prácticas</h1>
            </div>
            <p class="text-blue-100 text-lg font-light">
                Oportunidades de prácticas preprofesionales en empresas e instituciones
            </p>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid gap-6">
            @forelse($convocatorias as $convocatoria)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-300">
                    
                    <div class="p-6 md:p-8">
                        <!-- Header: Title + Badge -->
                        <div class="flex flex-col md:flex-row justify-between items-start gap-4 mb-6">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-800 mb-1">
                                    {{ $convocatoria->title ?? 'Practicante' }}
                                </h2>
                                <h3 class="font-semibold text-sm flex items-center gap-2" style="color: #3B82F6;">
                                    <i class="fas fa-building"></i> {{ $convocatoria->company }}
                                </h3>
                            </div>
                            <span class="self-start text-white text-sm font-bold px-4 py-1.5 rounded-full flex items-center gap-2 shadow-sm" style="background-color: #10B981;">
                                <i class="fas fa-users"></i> 
                                {{ $convocatoria->vacancies ?? 1 }} {{ ($convocatoria->vacancies ?? 1) == 1 ? 'vacante' : 'vacantes' }}
                            </span>
                        </div>

                        <!-- Info Ribbon -->
                        <div class="mb-6 p-4 rounded-lg bg-gray-50 border border-gray-100">
                            <div class="grid grid-cols-1 md::grid-cols-4 gap-4 text-sm text-gray-700">
                                <div class="flex items-center">
                                    <div class="w-8 flex justify-center mr-1"><i class="fas fa-laptop-code text-lg" style="color: #3B82F6;"></i></div>
                                    <div class="truncate">
                                        <span class="font-bold block text-gray-900 text-xs uppercase mb-0.5" style="color: #64748b;">Área</span>
                                        {{ $convocatoria->area ?? 'General' }}
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-8 flex justify-center mr-1"><i class="fas fa-calendar-alt text-lg" style="color: #3B82F6;"></i></div>
                                    <div class="truncate">
                                        <span class="font-bold block text-gray-900 text-xs uppercase mb-0.5" style="color: #64748b;">Inicio</span>
                                        {{ optional($convocatoria->start_date)->format('d/m/Y') ?? '--' }}
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-8 flex justify-center mr-1"><i class="fas fa-calendar-check text-lg" style="color: #3B82F6;"></i></div>
                                    <div class="truncate">
                                        <span class="font-bold block text-gray-900 text-xs uppercase mb-0.5" style="color: #64748b;">Cierre</span>
                                        {{ optional($convocatoria->end_date)->format('d/m/Y') ?? '--' }}
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-8 flex justify-center mr-1"><i class="fas fa-clock text-lg" style="color: #3B82F6;"></i></div>
                                    <div class="truncate">
                                        <span class="font-bold block text-gray-900 text-xs uppercase mb-0.5" style="color: #64748b;">Publicado</span>
                                        {{ $convocatoria->created_at->format('d/m/Y') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <h4 class="font-bold text-gray-900 mb-2 flex items-center gap-2 text-base">
                                <i class="fas fa-info-circle text-gray-800"></i> Descripción
                            </h4>
                            <div class="text-gray-600 text-sm leading-relaxed pl-1">
                                {!! nl2br(e($convocatoria->description)) !!}
                            </div>
                        </div>

                        <!-- Requirements -->
                        @if($convocatoria->requirements)
                            <div class="p-5 mb-8 rounded-md" style="background-color: #FFFBEB; border-left: 4px solid #FCD34D;">
                                <h4 class="font-bold text-sm mb-2 flex items-center gap-2" style="color: #92400E;">
                                    <i class="fas fa-check-circle"></i> Requisitos
                                </h4>
                                <ul class="text-sm pl-4 list-disc space-y-1" style="color: #92400E;">
                                    <!-- Simple split by newline to simulate list items if it's plain text -->
                                    @foreach(explode("\n", $convocatoria->requirements) as $req)
                                        @if(trim($req)) <li>{{ trim($req) }}</li> @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <hr class="border-gray-200 mb-6">

                        <!-- Footer Actions -->
                        <div class="flex flex-col md:flex-row justify-between items-end gap-6">
                            <!-- Contact Info -->
                            <div class="text-sm text-gray-500 w-full space-y-1">
                                @if($convocatoria->contact_name)
                                    <div class="flex items-center gap-2">
                                        <div class="w-5 text-center"><i class="fas fa-user text-gray-400"></i></div>
                                        <span class="font-semibold text-gray-700">Contacto:</span> {{ $convocatoria->contact_name }}
                                    </div>
                                @endif
                                @if($convocatoria->contact_email)
                                    <div class="flex items-center gap-2">
                                        <div class="w-5 text-center"><i class="fas fa-envelope text-gray-400"></i></div>
                                        <a href="mailto:{{ $convocatoria->contact_email }}" class="hover:underline transition-colors block truncate" style="color: #64748b;">{{ $convocatoria->contact_email }}</a>
                                    </div>
                                @endif
                                @if($convocatoria->contact_phone)
                                    <div class="flex items-center gap-2">
                                        <div class="w-5 text-center"><i class="fas fa-phone text-gray-400"></i></div>
                                        <span>{{ $convocatoria->contact_phone }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- CTA Button -->
                            @auth
                                <button 
                                    data-company="{{ $convocatoria->company }}"
                                    data-email="{{ $convocatoria->contact_email }}"
                                    data-phone="{{ $convocatoria->contact_phone }}"
                                    data-title="{{ $convocatoria->title }}"
                                    onclick="openPostularModal(this)"
                                   class="w-full md:w-auto text-white font-bold py-3 px-8 rounded-md shadow-sm hover:shadow-md hover:opacity-90 transition-all flex items-center justify-center gap-2 whitespace-nowrap" style="background-color: #E04F44;">
                                    <i class="fas fa-paper-plane"></i> Postular
                                </button>
                            @else
                                <a href="{{ route('login') }}" 
                                   class="w-full md:w-auto text-white font-bold py-3 px-8 rounded-md shadow-sm hover:shadow-md hover:opacity-90 transition-all flex items-center justify-center gap-2 whitespace-nowrap" style="background-color: #E04F44;">
                                    <i class="fas fa-sign-in-alt"></i> Iniciar Sesión para Postular
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-16 bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="inline-block p-4 rounded-full bg-gray-50 mb-4">
                        <i class="far fa-folder-open text-4xl text-gray-300"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">No hay convocatorias vigentes</h3>
                    <p class="text-gray-500 mt-1">Vuelve a consultar más tarde.</p>
                </div>
            @endforelse

            <div class="mt-8">
                {{ $convocatorias->links() }}
            </div>
        </div>
    </div>

    <!-- Postular Modal -->
    <div id="postularModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closePostularModal()">
        </div>

        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div
                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">

                    <div
                        class="bg-gray-50 px-4 py-4 sm:px-6 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-bold leading-6 text-gray-900" id="modal-title">
                            Postular a <span id="modal-company-name" class="text-[#3B82F6]"></span>
                        </h3>
                        <button type="button" class="text-gray-400 hover:text-gray-500" onclick="closePostularModal()">
                            <span class="sr-only">Cerrar</span>
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <div class="px-4 py-5 sm:p-6">
                        <p class="text-sm text-gray-500 mb-5">
                            Selecciona una opción para contactar e iniciar tu proceso de postulación:
                        </p>
                        <div class="grid gap-3">
                            <!-- Email -->
                            <a id="modal-btn-email" href="javascript:void(0)"
                                class="group flex items-center p-3 rounded-md border border-gray-200 hover:border-[#E04F44] hover:bg-red-50 transition-all">
                                <div
                                    class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-orange-100 text-[#E04F44]">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="font-bold text-gray-900 text-sm">Enviar Correo</p>
                                    <p class="text-xs text-gray-500">Adjuntar CV</p>
                                </div>
                                <i class="fas fa-chevron-right text-gray-300 group-hover:text-[#E04F44]"></i>
                            </a>

                            <!-- WhatsApp -->
                            <a id="modal-btn-whatsapp" href="#" target="_blank"
                                class="group flex items-center p-3 rounded-md border border-gray-200 hover:border-[#25D366] hover:bg-green-50 transition-all">
                                <div
                                    class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-green-100 text-[#25D366]">
                                    <i class="fab fa-whatsapp text-lg"></i>
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="font-bold text-gray-900 text-sm">WhatsApp</p>
                                    <p class="text-xs text-gray-500">Chat directo</p>
                                </div>
                                <i class="fas fa-chevron-right text-gray-300 group-hover:text-[#25D366]"></i>
                            </a>

                            <!-- Phone -->
                            <a id="modal-btn-phone" href="#"
                                class="group flex items-center p-3 rounded-md border border-gray-200 hover:border-[#3B82F6] transition-all">
                                <div
                                    class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-blue-100 text-[#3B82F6]">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="font-bold text-gray-900 text-sm">Llamada</p>
                                    <p class="text-xs text-gray-500">Convencional</p>
                                </div>
                                <i class="fas fa-chevron-right text-gray-300 group-hover:text-[#3B82F6]"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        #modal-btn-email:hover { background-color: #fff7ed !important; } /* orange-50 */
        #modal-btn-phone:hover { background-color: #eff6ff !important; } /* blue-50 */
    </style>

    <script>
        function openPostularModal(element) {
            const { company, email, phone, title } = element.dataset;
            document.getElementById('modal-company-name').innerText = company;
             // Email Logic (Gmail Redirect)
            const subject = encodeURIComponent('Postulación: ' + (title || 'Prácticas'));
            const emailBtn = document.getElementById('modal-btn-email');

            if (email) {
                // Generate Gmail Web Composer Link
                emailBtn.href = `https://mail.google.com/mail/?view=cm&fs=1&to=${email}&su=${subject}`;
                emailBtn.target = '_blank';
                emailBtn.classList.remove('opacity-50', 'pointer-events-none', 'grayscale');
            } else {
                emailBtn.href = 'javascript:void(0)';
                emailBtn.removeAttribute('target');
                emailBtn.classList.add('opacity-50', 'pointer-events-none', 'grayscale');
            }

            // WhatsApp Logic
            const whatsappBtn = document.getElementById('modal-btn-whatsapp');
            if (phone) {
                const cleanPhone = phone.replace(/\D/g, '');
                const finalPhone = cleanPhone.length === 9 ? '51' + cleanPhone : cleanPhone;
                const text = encodeURIComponent(`Hola, estoy interesado en la convocatoria de "${title || company}". Mi nombre es...`);
                whatsappBtn.href = `https://wa.me/${finalPhone}?text=${text}`;
                whatsappBtn.classList.remove('opacity-50', 'pointer-events-none', 'grayscale');
            } else {
                whatsappBtn.href = '#';
                whatsappBtn.classList.add('opacity-50', 'pointer-events-none', 'grayscale');
            }

            // Phone Logic
            const phoneBtn = document.getElementById('modal-btn-phone');
            if (phone) {
                phoneBtn.href = `tel:${phone}`;
                phoneBtn.classList.remove('opacity-50', 'pointer-events-none', 'grayscale');
            } else {
                phoneBtn.href = '#';
                phoneBtn.classList.add('opacity-50', 'pointer-events-none', 'grayscale');
            }

            document.getElementById('postularModal').classList.remove('hidden');
        }

        function closePostularModal() {
            document.getElementById('postularModal').classList.add('hidden');
        }
    </script>
</body>

</html>