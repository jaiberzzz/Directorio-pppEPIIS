<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Mostrar página de inicio con noticias y documentos recientes
    public function index()
    {
        $news = \App\Models\News::latest()->take(3)->get();
        $documents = \App\Models\Document::all();
        return view('home', compact('news', 'documents'));
    }

    // Obtener listado de practicantes para DataTables (AJAX)
    // Retorna JSON para ser consumido por el frontend
    public function getPractitioners()
    {
        // Obtener practicantes con su usuario relacionado
        $practitioners = \App\Models\Practitioner::with('user')
            ->select('practitioners.*');

        return \Yajra\DataTables\Facades\DataTables::of($practitioners)
            ->addColumn('full_name', function ($practitioner) {
                return $practitioner->user ? $practitioner->user->name : 'N/A';
            })
            ->addColumn('student_code', function ($practitioner) {
                return $practitioner->student_code;
            })
            ->addColumn('hours_completed', function ($practitioner) {
                return $practitioner->hours_completed;
            })
            ->filterColumn('full_name', function ($query, $keyword) {
                $query->whereHas('user', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->editColumn('status', function ($practitioner) {
                return ucfirst($practitioner->status); // Capitalizar estado
            })
            ->make(true);
    }

    // Procesar y enviar formulario de contacto
    public function storeContact(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // La lógica para enviar correo iría aquí.
        // Por ahora, solo retornamos con un mensaje de éxito.

        return redirect()->route('home', ['#contact'])->with('success', '¡Gracias por contactarnos! Tu mensaje ha sido recibido.');
    }
}
