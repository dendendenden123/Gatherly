<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    /** @use HasFactory<\Database\Factories\NotificationFactory> */
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class);
    }

    public function recipients()
    {
        return $this->belongsToMany(User::class, 'notification_user')
            ->withPivot('read_at')
            ->withTimestamps();
    }
}
