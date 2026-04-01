<?php

namespace App\Models;

use App\Enums\QuizType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'cours_id',
        'chapitre_id',
        'title',
        'duration',
        'passing_score',
        'max_attempts',
        'type',
        'is_published',
        'random_order',
        'available_from',
        'available_until',
    ];

    protected $casts = [
        'type' => QuizType::class,
        'is_published' => 'boolean',
        'random_order' => 'boolean',
        'available_from' => 'datetime',
        'available_until' => 'datetime',
    ];

    public function cours()
    {
        return $this->belongsTo(Cours::class);
    }

    public function chapitre()
    {
        return $this->belongsTo(Chapitre::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class)->orderBy('order');
    }

    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function userAttempts($userId = null)
    {
        $userId = $userId ?? auth()->id();

        return $this->attempts()->where('user_id', $userId);
    }

    public function getBestScoreAttribute(): ?int
    {
        $attempt = $this->attempts()
            ->where('user_id', auth()->id())
            ->where('status', 'completed')
            ->orderByDesc('score')
            ->first();

        return $attempt ? $attempt->score_percent : null;
    }

    public function getAttemptsCountAttribute(): int
    {
        return $this->attempts()
            ->where('user_id', auth()->id())
            ->where('status', 'completed')
            ->count();
    }

    public function getCanAttemptAttribute(): bool
    {
        return $this->attempts_count < $this->max_attempts;
    }

    public function isExam(): bool
    {
        return $this->type === QuizType::Exam;
    }
}
