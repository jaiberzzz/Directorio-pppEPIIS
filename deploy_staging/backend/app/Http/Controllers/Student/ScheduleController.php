<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function update(Request $request)
    {
        $user = auth()->user();
        $practitioner = $user->practitioner;

        if (!$practitioner) {
            return back()->with('error', 'No tienes un registro de prácticas asociado.');
        }

        // Validate input (array of schedules)
        $request->validate([
            'schedules' => 'array',
            'schedules.*.day' => 'required|string',
            'schedules.*.start_time' => 'nullable|date_format:H:i',
            'schedules.*.end_time' => 'nullable|date_format:H:i|after:schedules.*.start_time',
        ]);

        try {
            DB::beginTransaction();

            // Clear existing schedule to replace with new one (simpler logic for this static schedule)
            // Or update/create if identifying by day. Let's do updateOrCreate for each day.

            // Update Global Schedule Observation
            if ($request->has('observation')) {
                $practitioner->update(['schedule_observation' => $request->observation]);
            }

            // Loop through the 7 possible days (lunes-domingo) from input
            foreach ($request->schedules as $day => $times) {
                if (!empty($times['start_time']) && !empty($times['end_time'])) {
                    Schedule::updateOrCreate(
                        ['practitioner_id' => $practitioner->id, 'day_of_week' => $day],
                        [
                            'start_time' => $times['start_time'],
                            'end_time' => $times['end_time']
                            // Removed per-day note saving
                        ]
                    );
                } else {
                    Schedule::where('practitioner_id', $practitioner->id)
                        ->where('day_of_week', $day)
                        ->delete();
                }
            }

            DB::commit();
            return back()->with('success', 'Horario actualizado correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al actualizar el horario: ' . $e->getMessage());
        }
    }
}
