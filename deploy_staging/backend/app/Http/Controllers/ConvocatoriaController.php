<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConvocatoriaController extends Controller
{
    // Listar convocatorias activas paginadas con búsqueda
    public function index(Request $request)
    {
        $query = \App\Models\Convocatoria::where('is_active', true);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%")
                    ->orWhere('area', 'like', "%{$search}%");
            });
        }

        $convocatorias = $query->latest()->paginate(10);

        if ($request->ajax()) {
            return view('convocatorias.partials.list', compact('convocatorias'));
        }

        return view('convocatorias.index', compact('convocatorias'));
    }
}
