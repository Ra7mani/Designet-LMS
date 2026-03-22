<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'user_id',
        'score',
        'total_points',
        'correct_answers',
        'total_questions',
        'duration_seconds',
        'answers',
        'status',
        'passed',
        'xp_earned',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'answers' => 'array',
        'passed' => 'boolean',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getScorePercentAttribute(): int
    {
        if ($this->total_points === 0) {
            return 0;
        }
        return (int) round(($this->score / $this->total_points) * 100);
    }

    public function getDurationFormattedAttribute(): string
    {
        if (!$this->duration_seconds) {
            return '0:00';
        }
        $minutes = floor($this->duration_seconds / 60);
        $seconds = $this->duration_seconds % 60;
        return sprintf('%d:%02d', $minutes, $seconds);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopePassed($query)
    {
        return $query->where('passed', true);
    }
}
