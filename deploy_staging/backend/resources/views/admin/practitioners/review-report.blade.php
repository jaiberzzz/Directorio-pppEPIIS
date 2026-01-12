<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Revisión: {{ $practitioner->user->name }}</title>
    <!-- Tailwind & Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
            overflow: hidden;
            background: #2d3748;
        }

        #pdf-viewer {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
            z-index: 1;
        }

        #ui-layer {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 10;
        }

        .interactive {
            pointer-events: auto;
        }
    </style>
</head>

<body>

    <!-- 1. PDF BACKGROUD -->
    @if($practitioner->final_report_path)
        <iframe id="pdf-viewer" src="{{ Storage::url($practitioner->final_report_path) }}#view=Fit"></iframe>
    @else
        <div class="flex items-center justify-center h-full text-white">
            <h1 class="text-2xl">Archivo PDF no encontrado</h1>
        </div>
    @endif

    <!-- 2. FLOATING UI LAYER -->
    <div id="ui-layer">

        <!-- Top Left: Back Button -->
        <div class="absolute top-4 left-4 interactive">
            <a href="{{ route('admin.practitioners.index') }}"
                class="bg-white text-gray-800 hover:bg-gray-100 px-4 py-2 rounded-full shadow-lg font-bold flex items-center gap-2 transition transform hover:scale-105">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <div class="mt-2 text-white drop-shadow-md bg-black/50 px-3 py-1 rounded">
                <p class="font-bold text-lg">{{ $practitioner->user->name }}</p>
                <p class="text-xs uppercase tracking-wide opacity-90">{{ $practitioner->company_name }}</p>
            </div>
        </div>

        <!-- Bottom Right: Evaluate Button -->
        <div class="absolute bottom-8 right-8 interactive">
            <button onclick="document.getElementById('modal').classList.remove('hidden')"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-4 rounded-full shadow-2xl font-bold text-lg flex items-center gap-3 border-2 border-white/20 transition transform hover:scale-110">
                <i class="fas fa-clipboard-check"></i> Evaluar Informe
            </button>
        </div>

        <!-- 3. MODAL (Hidden by default) -->
        <div id="modal"
            class="fixed inset-0 bg-black/80 backdrop-blur-sm hidden interactive flex items-center justify-center z-50">
            <div
                class="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all scale-100">

                <!-- Modal Header -->
                <div class="bg-gray-100 px-6 py-4 border-b flex justify-between items-center">
                    <h3 class="font-bold text-gray-800 text-lg">Evaluación Final</h3>
                    <button onclick="document.getElementById('modal').classList.add('hidden')"
                        class="text-gray-500 hover:text-red-500 text-2xl leading-none">&times;</button>
                </div>

                <!-- Modal Content -->
                <div class="p-6 space-y-6">

                    <!-- Approve Option -->
                    <form action="{{ route('admin.practitioners.approve-report', $practitioner->id) }}" method="POST">
                        @csrf
                        <div
                            class="bg-green-50 border border-green-200 rounded-lg p-4 hover:shadow-md transition cursor-pointer group">
                            <h4 class="text-green-800 font-bold mb-1 flex items-center gap-2">
                                <i class="fas fa-check-circle"></i> Aprobar
                            </h4>
                            <p class="text-xs text-green-700 mb-3">El alumno finalizará sus prácticas
                                satisfactotiamente.</p>
                            <button type="submit"
                                class="w-full bg-green-600 group-hover:bg-green-700 text-white font-bold py-2 rounded shadow">
                                Confirmar Aprobación
                            </button>
                        </div>
                    </form>

                    <div class="relative flex py-1 items-center">
                        <div class="flex-grow border-t border-gray-300"></div>
                        <span class="flex-shrink-0 mx-4 text-gray-400 text-xs">O</span>
                        <div class="flex-grow border-t border-gray-300"></div>
                    </div>

                    <!-- Reject Option -->
                    <form action="{{ route('admin.practitioners.reject-report', $practitioner->id) }}" method="POST">
                        @csrf
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4 hover:shadow-md transition">
                            <h4 class="text-red-800 font-bold mb-1 flex items-center gap-2">
                                <i class="fas fa-times-circle"></i> Rechazar
                            </h4>
                            <textarea name="feedback" rows="2"
                                class="w-full mt-2 p-2 text-sm border border-red-300 rounded focus:ring-red-500 focus:border-red-500"
                                placeholder="Motivo del rechazo..." required></textarea>
                            <button type="submit"
                                class="w-full mt-3 bg-red-600 hover:bg-red-700 text-white font-bold py-2 rounded shadow">
                                Enviar Correcciones
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>

</body>

</html>