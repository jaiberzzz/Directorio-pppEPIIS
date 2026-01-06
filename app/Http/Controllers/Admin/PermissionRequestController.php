<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PermissionRequest;
use Yajra\DataTables\Facades\DataTables;

class PermissionRequestController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PermissionRequest::with(['practitioner.user'])->select('permission_requests.*');
            return DataTables::of($data)
                ->addColumn('student_name', function ($row) {
                    return $row->practitioner && $row->practitioner->user ? $row->practitioner->user->name : 'N/A';
                })
                ->editColumn('status', function ($row) {
                    $colors = [
                        'pendiente' => 'text-yellow-600',
                        'aprobado' => 'text-green-600',
                        'rechazado' => 'text-red-600'
                    ];
                    return '<span class="font-bold ' . ($colors[$row->status] ?? '') . '">' . ucfirst($row->status) . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('admin.requests.edit', $row->id) . '" class="text-blue-600 hover:underline mr-2">Revisar</a>';
                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        return view('admin.requests.index');
    }

    public function create()
    {
        // Not used, students create requests
    }

    public function store(Request $request)
    {
        // Not used
    }

    public function edit(string $id)
    {
        $request = PermissionRequest::with('practitioner.user')->findOrFail($id);
        return view('admin.requests.edit', compact('request'));
    }

    public function update(Request $request, string $id)
    {
        $permissionRequest = PermissionRequest::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pendiente,aprobado,rechazado',
            'admin_comment' => 'nullable|string',
        ]);

        $permissionRequest->update([
            'status' => $request->status,
            'admin_comment' => $request->admin_comment,
        ]);

        return redirect()->route('admin.requests.index')->with('success', 'Solicitud actualizada correctamente.');
    }

    public function show(string $id)
    {
    }
    public function destroy(string $id)
    {
    }
}
