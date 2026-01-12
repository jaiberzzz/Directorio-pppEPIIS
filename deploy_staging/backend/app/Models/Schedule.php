<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'practitioner_id',
        'day_of_week',
        'start_time',
        'end_time',
        'note',
    ];

    public function practitioner()
    {
        return $this->belongsTo(Practitioner::class);
    }
}
