<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avis extends Model
{
    use HasFactory;

    protected $fillable = [
        'inscription_id',
        'rating',
        'comment',
        'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'rating' => 'integer',
    ];

    public function inscription()
    {
        return $this->belongsTo(Inscription::class);
    }

    /**
     * Get the etudiant who wrote this review (through inscription)
     */
    public function getEtudiantAttribute()
    {
        return $this->inscription?->etudiant;
    }

    /**
     * Get the cours this review is for (through inscription)
     */
    public function getCoursAttribute()
    {
        return $this->inscription?->cours;
    }

    /**
     * Scope to get only approved reviews
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope to get reviews for a specific cours
     */
    public function scopeForCours($query, $coursId)
    {
        return $query->whereHas('inscription', function ($q) use ($coursId) {
            $q->where('cours_id', $coursId);
        });
    }
}
