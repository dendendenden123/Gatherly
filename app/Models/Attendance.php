<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    /** @use HasFactory<\Database\Factories\AttendanceFactory> */
    use HasFactory;

    protected $guarded = [];
    protected $table = "attendances";

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event_occurrence()
    {
        return $this->belongsTo(EventOccurrence::class);
    }
}
