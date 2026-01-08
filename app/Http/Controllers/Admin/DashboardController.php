<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Practitioner;
use App\Models\Convocatoria;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Get Semesters for Filter
        $semesters = Practitioner::select('semester')->distinct()->orderBy('semester', 'desc')->pluck('semester');
        $selectedSemester = $request->input('semester', $semesters->first());

        // 2. KPI Cards Data (Global Statistics)
        $stats = [
            'total_practitioners' => Practitioner::count(),
            'active_practitioners' => Practitioner::where('status', 'en proceso')->count(),
            'completed_practitioners' => Practitioner::where('status', 'finalizado')->count(),
            'pending_reports' => Practitioner::where('report_status', 'pending')->count(),
        ];

        // 3. Chart 1: Practitioners by Status (Filtered by Semester)
        $query = Practitioner::query();
        if ($selectedSemester) {
            $query->where('semester', $selectedSemester);
        }
        $statusCounts = $query->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // 3. Chart 2: Top 5 Companies (Bar Chart)
        $topCompanies = Practitioner::select('company_name', DB::raw('count(*) as total'))
            ->groupBy('company_name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $companyLabels = $topCompanies->pluck('company_name');
        $companyData = $topCompanies->pluck('total');

        // 4. Recent Activity (Newest Practitioners)
        $recentPractitioners = Practitioner::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'statusCounts',
            'companyLabels',
            'companyData',
            'recentPractitioners',
            'semesters',
            'selectedSemester'
        ));
    }
}
