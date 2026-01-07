<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Document;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Document::query();
            return DataTables::of($data)
                ->addColumn('file', function ($row) {
                    return '<a href="' . Storage::url($row->file_path) . '" target="_blank" class="text-blue-600 hover:underline">Descargar</a>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.documents.edit', $row->id);
                    $deleteUrl = route('admin.documents.destroy', $row->id);
                    $formId = 'delete-form-' . $row->id;

                    $btn = '<div class="flex items-center gap-2">';
                    $btn .= '<a href="' . $editUrl . '" class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-sm btn-anim" title="Editar"><i class="fas fa-edit"></i></a>';

                    $btn .= '<form id="' . $formId . '" action="' . $deleteUrl . '" method="POST" style="display:inline;">';
                    $btn .= csrf_field();
                    $btn .= method_field('DELETE');
                    $btn .= '<button type="button" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-sm delete-btn btn-anim" data-form-id="' . $formId . '" title="Eliminar"><i class="fas fa-trash"></i></button>';
                    $btn .= '</form>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['file', 'action'])
                ->make(true);
        }
        return view('admin.documents.index');
    }

    public function create()
    {
        return view('admin.documents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file' => 'required|file|mimes:pdf,doc,docx|max:10240', // 10MB
        ]);

        $path = $request->file('file')->store('documents', 'public');

        Document::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $path,
        ]);

        return redirect()->route('admin.documents.index')->with('success', 'Documento subido correctamente.');
    }

    public function edit(string $id)
    {
        $document = Document::findOrFail($id);
        return view('admin.documents.edit', compact('document'));
    }

    public function update(Request $request, string $id)
    {
        $document = Document::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
        ];

        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($document->file_path) {
                Storage::disk('public')->delete($document->file_path);
            }
            $data['file_path'] = $request->file('file')->store('documents', 'public');
        }

        $document->update($data);

        return redirect()->route('admin.documents.index')->with('success', 'Documento actualizado correctamente.');
    }

    public function show(string $id)
    {
    }

    public function destroy(string $id)
    {
        $document = Document::findOrFail($id);

        // Delete file
        if ($document->file_path) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return redirect()->route('admin.documents.index')->with('success', 'Documento eliminado correctamente.');
    }
}
