<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Computed;

class Session extends Model
{
    use HasFactory;

    protected $table = 'course_sessions';

    protected $fillable = [
        'title',
        'description',
        'start_time',
        'end_time',
        'status',
        'type',
        'session_room',
        'cours_id',
        'formateur_id',
        'virtual_room_link',
        'max_attendees',
        'auto_reminder_30m_enabled',
        'auto_reminder_30m_sent_at',
        'excluded_attendee_ids',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'auto_reminder_30m_enabled' => 'boolean',
        'auto_reminder_30m_sent_at' => 'datetime',
        'excluded_attendee_ids' => 'array',
    ];

    public function cours()
    {
        return $this->belongsTo(Cours::class);
    }

    public function formateur()
    {
        return $this->belongsTo(User::class, 'formateur_id');
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    #[Computed]
    public function isLiveNow()
    {
        return $this->start_time <= now() && $this->end_time >= now();
    }
}
