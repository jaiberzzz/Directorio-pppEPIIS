<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Convocatoria;
use Yajra\DataTables\Facades\DataTables;

class ConvocatoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Convocatoria::query();
            return DataTables::of($data)
                ->editColumn('is_active', function ($row) {
                    return $row->is_active ? '<span class="text-green-600 font-bold">Activa</span>' : '<span class="text-red-600">Finalizada</span>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.convocatorias.edit', $row->id);
                    $deleteUrl = route('admin.convocatorias.destroy', $row->id);
                    $formId = 'delete-form-' . $row->id;

                    $btn = '<div class="flex items-center gap-2">';
                    $btn .= '<a href="' . $editUrl . '" class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-sm" title="Editar"><i class="fas fa-edit"></i></a>';

                    $btn .= '<form id="' . $formId . '" action="' . $deleteUrl . '" method="POST" style="display:inline;">';
                    $btn .= csrf_field();
                    $btn .= method_field('DELETE');
                    $btn .= '<button type="button" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-sm delete-btn" data-form-id="' . $formId . '" title="Eliminar"><i class="fas fa-trash"></i></button>';
                    $btn .= '</form>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['is_active', 'action'])
                ->make(true);
        }
        return view('admin.convocatorias.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.convocatorias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'area' => 'required|string|max:255',
            'vacancies' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'contact_name' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string|max:20',
            'contact_details' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        Convocatoria::create($request->all());

        return redirect()->route('admin.convocatorias.index')->with('success', 'Convocatoria creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $convocatoria = Convocatoria::findOrFail($id);
        return view('admin.convocatorias.edit', compact('convocatoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $convocatoria = Convocatoria::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'area' => 'required|string|max:255',
            'vacancies' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'contact_name' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string|max:20',
            'contact_details' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $convocatoria->update($request->all());

        return redirect()->route('admin.convocatorias.index')->with('success', 'Convocatoria actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $convocatoria = Convocatoria::findOrFail($id);
        $convocatoria->delete();

        return redirect()->route('admin.convocatorias.index')->with('success', 'Convocatoria eliminada correctamente.');
    }
}
