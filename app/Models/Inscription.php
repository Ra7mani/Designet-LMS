<?php

namespace App\Models;

use App\Enums\EnrollStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'etudiant_id',
        'cours_id',
        'enrolled_at',
        'completed_at',
        'progress',
        'status',
    ];

    protected $casts = [
        'status' => EnrollStatus::class,
        'enrolled_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function etudiant()
    {
        return $this->belongsTo(User::class, 'etudiant_id');
    }

    public function cours()
    {
        return $this->belongsTo(Cours::class);
    }

    public function paiement()
    {
        return $this->hasOne(Paiement::class);
    }

    public function certificat()
    {
        return $this->hasOne(Certificat::class);
    }

    public function badge()
    {
        return $this->hasOne(Badge::class);
    }

    public function avis()
    {
        return $this->hasMany(Avis::class);
    }
}
