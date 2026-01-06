<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Practitioner extends Model
{
    protected $fillable = [
        'user_id',
        'dni',
        'student_code',
        'phone',
        'semester',
        'company_name',
        'practice_area',
        'academic_supervisor_1_id',
        'academic_supervisor_2_id',
        'start_date',
        'end_date',
        'status',
        'hours_completed',
        'photo_path',
        'final_report_path',
    ];

    // Relación: Un practicante pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el primer supervisor académico
    public function supervisor1()
    {
        return $this->belongsTo(User::class, 'academic_supervisor_1_id');
    }

    // Relación con el segundo supervisor académico
    public function supervisor2()
    {
        return $this->belongsTo(User::class, 'academic_supervisor_2_id');
    }
}
