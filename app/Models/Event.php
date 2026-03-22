<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'event_type',
        'location',
        'session_id',
        'quiz_id',
        'cours_id',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function cours()
    {
        return $this->belongsTo(Cours::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

