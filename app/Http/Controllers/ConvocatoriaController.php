<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConvocatoriaController extends Controller
{
    // Listar convocatorias activas paginadas
    public function index()
    {
        $convocatorias = \App\Models\Convocatoria::where('is_active', true)
            ->latest()
            ->paginate(10);

        return view('convocatorias.index', compact('convocatorias'));
    }
}
