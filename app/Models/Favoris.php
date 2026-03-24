<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favoris extends Model
{
    protected $table = 'favoris';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'cours_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cours(): BelongsTo
    {
        return $this->belongsTo(Cours::class);
    }
}
