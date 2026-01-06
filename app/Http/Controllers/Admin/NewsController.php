<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\News;
use Yajra\DataTables\Facades\DataTables;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = News::query();
            return DataTables::of($data)
                ->editColumn('published_at', function ($row) {
                    return $row->published_at ? $row->published_at->format('d/m/Y H:i') : 'No publicado';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.news.edit', $row->id);
                    $deleteUrl = route('admin.news.destroy', $row->id);
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
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.news.index');
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
        ]);

        News::create($request->all());

        return redirect()->route('admin.news.index')->with('success', 'Noticia creada correctamente.');
    }

    public function edit(string $id)
    {
        $news = News::findOrFail($id);
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, string $id)
    {
        $news = News::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
        ]);

        $news->update($request->all());

        return redirect()->route('admin.news.index')->with('success', 'Noticia actualizada correctamente.');
    }

    public function show(string $id)
    {
    }

    public function destroy(string $id)
    {
        $news = News::findOrFail($id);
        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'Noticia eliminada correctamente.');
    }
}
