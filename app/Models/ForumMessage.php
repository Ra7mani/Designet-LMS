<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ForumMessage extends Model
{
    protected $fillable = ['channel_id', 'user_id', 'content', 'is_read', 'is_pinned', 'is_solution', 'is_hidden', 'pinned_by'];

    protected $casts = [
        'is_read' => 'boolean',
        'is_pinned' => 'boolean',
        'is_solution' => 'boolean',
        'is_hidden' => 'boolean',
    ];

    public function channel(): BelongsTo
    {
        return $this->belongsTo(ForumChannel::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pinnedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pinned_by');
    }

    public function reactions(): HasMany
    {
        return $this->hasMany(MessageReaction::class, 'message_id');
    }

    public function reports(): HasMany
    {
        return $this->hasMany(ReportedMessage::class, 'message_id');
    }

    public function reactionsCount($emoji = null)
    {
        $query = $this->reactions();
        if ($emoji) {
            $query->where('emoji', $emoji);
        }

        return $query->count();
    }

    public function userReaction($userId, $emoji)
    {
        return $this->reactions()
            ->where('user_id', $userId)
            ->where('emoji', $emoji)
            ->first();
    }
}
