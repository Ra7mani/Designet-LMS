<?php

namespace App\Models;

use App\Enums\LessonType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecon extends Model
{
    use HasFactory;

    protected $fillable = [
        'chapitre_id',
        'title',
        'content',
        'video_url',
        'resource_path',
        'resource_name',
        'duration',
        'order',
        'type',
    ];

    protected $casts = [
        // 'type' => LessonType::class,
    ];

    public function chapitre()
    {
        return $this->belongsTo(Chapitre::class);
    }
}
