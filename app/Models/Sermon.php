<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sermon extends Model
{
    /** @use HasFactory<\Database\Factories\SermonFactory> */
    use HasFactory;

    public function preacher()
    {
        return $this->belongsTo(User::class);
    }
}
