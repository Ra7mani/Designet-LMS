<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ForumChannel extends Model
{
    protected $fillable = ['cours_id', 'name', 'description', 'icon'];

    public function cours(): BelongsTo
    {
        return $this->belongsTo(Cours::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ForumMessage::class, 'channel_id');
    }

    public function unreadCount($userId): int
    {
        return $this->messages()
            ->where('user_id', '!=', $userId)
            ->where('is_read', false)
            ->count();
    }

    public function lastMessage()
    {
        return $this->messages()->latest()->first();
    }
}
