<?php

namespace App\Models;

use App\Enums\CourseStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    use HasFactory;

    protected $fillable = [
        'categorie_id',
        'formateur_id',
        'title',
        'description',
        'price',
        'level',
        'status',
        'thumbnail',
        'rating',
        'certificating',
        'discussion_forum',
        'promo_code',
        'language',
    ];

    protected $casts = [
        'status' => CourseStatus::class,
        'price' => 'decimal:2',
        'certificating' => 'boolean',
        'discussion_forum' => 'boolean',
        'rating' => 'decimal:2',
    ];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function formateur()
    {
        return $this->belongsTo(User::class, 'formateur_id');
    }

    public function chapitres()
    {
        return $this->hasMany(Chapitre::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    public function avis()
    {
        return $this->hasManyThrough(Avis::class, Inscription::class, 'cours_id', 'inscription_id');
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favoris', 'cours_id', 'user_id')->withTimestamps();
    }
}