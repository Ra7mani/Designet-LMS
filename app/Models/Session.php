<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'cours_id',
        'formateur_id',
        'virtual_room_link',
        'max_attendees',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
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

    #[\Livewire\Attributes\Computed]
    public function isLiveNow()
    {
        return $this->start_time <= now() && $this->end_time >= now();
    }
}

