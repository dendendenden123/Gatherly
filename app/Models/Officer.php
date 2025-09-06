<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Officer extends Model
{
    /** @use HasFactory<\Database\Factories\OfficerFactory> */
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    public function getRoleDescriptionAttribute()
    {
        switch ($this->role) {
            case 0:
                return 'None';
            case 1:
                return 'Minister';
            case 2:
                return 'Head Deacon';
            case 3:
                return 'Deacon';
            case 4:
                return 'Deaconess';
            case 5:
                return 'Choir';
            case 6:
                return 'Secretary';
            case 7:
                return 'Finance';
            case 8:
                return 'SCAN';
            case 9:
                return 'Overseer';
            default:
                return 'Unknown';
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
