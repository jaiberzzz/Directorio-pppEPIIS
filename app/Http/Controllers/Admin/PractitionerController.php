<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Practitioner;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class PractitionerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Practitioner::with('user', 'supervisor1', 'supervisor2')->select('practitioners.*');
            return DataTables::of($data)
                ->addColumn('full_name', function ($row) {
                    return $row->user ? $row->user->name : '';
                })
                ->addColumn('supervisor1_name', function ($row) {
                    return $row->supervisor1 ? $row->supervisor1->name : 'N/A';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.practitioners.edit', $row->id);
                    $deleteUrl = route('admin.practitioners.destroy', $row->id);
                    $formId = 'delete-form-' . $row->id;

                    $btn = '<div class="flex items-center gap-2">';

                    if ($row->report_status === 'pending') {
                        $reviewUrl = route('admin.practitioners.review-report', $row->id);
                        $btn .= '<a href="' . $reviewUrl . '" class="bg-yellow-400 hover:bg-yellow-500 text-black px-3 py-1 rounded-md text-sm font-bold shadow-sm transition" title="Revisar Informe" target="_blank"><i class="fas fa-eye mr-1"></i> Revisar</a>';
                    }

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
        return view('admin.practitioners.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::role('Estudiante')->doesntHave('practitioner')->get(); // Only students without practitioner record
        $docentes = User::role('Docente')->get();
        return view('admin.practitioners.create', compact('users', 'docentes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Basic Validation first
        $request->validate([
            'student_name' => 'required|string|max:255',
            'student_email' => 'required|email',
            'dni' => 'required|digits:8|unique:practitioners,dni',
            'student_code' => 'required|digits:6|unique:practitioners,student_code',
            'phone' => 'nullable|digits:9',
            'semester' => 'required|string',
            'company_name' => 'required|string',
            'practice_area' => 'required|string',
            'academic_supervisor_1_id' => 'nullable|exists:users,id',
            'academic_supervisor_2_id' => 'nullable|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:por iniciar,en proceso,finalizado',
            'photo' => 'nullable|image|max:2048',
        ]);

        // 2. Resolve User
        $user = User::where('email', $request->student_email)->first();

        if (!$user) {
            // Create new user (Password = DNI)
            $user = User::create([
                'name' => $request->student_name,
                'email' => $request->student_email,
                'password' => \Illuminate\Support\Facades\Hash::make($request->dni),
            ]);
            $user->assignRole('Estudiante');
        } else {
            // Optional: Check if User already has a practitioner record?
            // The unique constraint on user_id in practitioners table will handle this, but better to check manually to give clear error.
            if (Practitioner::where('user_id', $user->id)->exists()) {
                return back()->with('error', 'El usuario con este correo ya tiene un registro de practicante asociado.')->withInput();
            }
        }

        // 3. Prepare Data
        $data = $request->except(['photo', 'student_name', 'student_email']);
        $data['user_id'] = $user->id;

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('practitioners/photos', 'public');
        }

        // 4. Create Practitioner
        Practitioner::create($data);

        return redirect()->route('admin.practitioners.index')->with('success', 'Practicante registrado correctamente.');
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
        $practitioner = Practitioner::findOrFail($id);
        $docentes = User::role('Docente')->get();
        return view('admin.practitioners.edit', compact('practitioner', 'docentes')); // Note: user cannot change student user_id easily
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $practitioner = Practitioner::findOrFail($id);

        $request->validate([
            'dni' => 'required|digits:8|unique:practitioners,dni,' . $practitioner->id,
            'student_code' => 'required|digits:6|unique:practitioners,student_code,' . $practitioner->id,
            'phone' => 'nullable|digits:9',
            'semester' => 'required|string',
            'company_name' => 'required|string',
            'practice_area' => 'required|string',
            'academic_supervisor_1_id' => 'nullable|exists:users,id',
            'academic_supervisor_2_id' => 'nullable|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:por iniciar,en proceso,finalizado',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['photo']);

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('practitioners/photos', 'public');
        }

        $practitioner->update($data);

        return redirect()->route('admin.practitioners.index')->with('success', 'Practicante actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $practitioner = Practitioner::findOrFail($id);

        // Delete photo if exists
        if ($practitioner->photo_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($practitioner->photo_path);
        }

        $practitioner->delete();

        return redirect()->route('admin.practitioners.index')->with('success', 'Practicante eliminado correctamente.');
    }
    /**
     * Approve the practitioner's report.
     */
    public function reviewReport($id)
    {
        $practitioner = Practitioner::with('user')->findOrFail($id);

        // Ensure only pending reports or reports with a file can be reviewed
        if (!$practitioner->final_report_path) {
            return redirect()->route('admin.practitioners.index')->with('error', 'El practicante no ha subido ningún informe.');
        }

        return view('admin.practitioners.review-report', compact('practitioner'));
    }

    public function approveReport($id)
    {
        $practitioner = Practitioner::findOrFail($id);

        $practitioner->update([
            'report_status' => 'approved',
            'status' => 'finalizado', // Auto-finalize the internship
        ]);

        return back()->with('success', 'Informe aprobado y prácticas finalizadas.');
    }

    /**
     * Reject the practitioner's report with feedback.
     */
    public function rejectReport(Request $request, $id)
    {
        $practitioner = Practitioner::findOrFail($id);

        $request->validate([
            'feedback' => 'required|string|max:1000',
        ]);

        $practitioner->update([
            'report_status' => 'rejected',
            'feedback' => $request->feedback,
        ]);

        return back()->with('success', 'Informe rechazado. Se ha notificado al estudiante.');
    }
}
