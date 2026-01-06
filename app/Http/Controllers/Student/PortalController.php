<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Convocatoria;

class PortalController extends Controller
{
    // Dashboard principal: Vista diferente para Estudiante vs Admin
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('Estudiante')) {
            $practitioner = $user->practitioner()->with(['supervisor1', 'supervisor2'])->first();
            $activeConvocatorias = Convocatoria::where('is_active', true)->latest()->take(3)->get();
            return view('student.dashboard', compact('practitioner', 'activeConvocatorias'));
        }

        // Lógica de estadísticas para Admin
        $stats = [
            'total_practitioners' => \App\Models\Practitioner::count(),
            'active_practitioners' => \App\Models\Practitioner::where('status', 'en proceso')->count(),
            'active_convocatorias' => Convocatoria::where('is_active', true)->count(),
            'total_documents' => \App\Models\Document::count(),
        ];

        $recentPractitioners = \App\Models\Practitioner::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentPractitioners'));
    }

    // Subir informe final del practicante (PDF)
    public function uploadReport(Request $request)
    {
        $request->validate([
            'final_report' => 'required|file|mimes:pdf|max:10240', // 10MB PDF
        ]);

        $user = auth()->user();
        $practitioner = $user->practitioner;

        if (!$practitioner) {
            return back()->with('error', 'No tienes un registro de prácticas asociado.');
        }

        if ($request->hasFile('final_report')) {
            // Eliminar anterior si existe
            if ($practitioner->final_report_path) {
                Storage::disk('public')->delete($practitioner->final_report_path);
            }

            $path = $request->file('final_report')->store('practitioners/reports', 'public');

            $practitioner->update([
                'final_report_path' => $path,
            ]);

            return back()->with('success', 'Informe final subido correctamente.');
        }

        return back()->with('error', 'Error al subir el archivo.');
    }

    // Almacenar solicitud de permiso o justificación
    public function storeRequest(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'reason' => 'required|string',
        ]);

        $practitioner = auth()->user()->practitioner;

        if (!$practitioner) {
            return back()->with('error', 'No tienes un registro de prácticas asociado.');
        }

        \App\Models\PermissionRequest::create([
            'practitioner_id' => $practitioner->id,
            'type' => $request->type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'status' => 'pendiente',
        ]);

        return back()->with('success', 'Solicitud enviada correctamente.');
    }
}
