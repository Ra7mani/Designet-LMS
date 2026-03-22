<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapitre extends Model
{
    use HasFactory;

    protected $fillable = [
        'cours_id',
        'title',
        'order',
        'description',
    ];

    public function cours()
    {
        return $this->belongsTo(Cours::class);
    }

    public function lecons()
    {
        return $this->hasMany(Lecon::class);
    }
}