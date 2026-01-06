<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionRequest extends Model
{
    protected $fillable = [
        'practitioner_id',
        'type',
        'start_date',
        'end_date',
        'reason',
        'status',
        'admin_comment',
    ];

    public function practitioner()
    {
        return $this->belongsTo(Practitioner::class);
    }
}
