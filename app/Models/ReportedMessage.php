<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportedMessage extends Model
{
    protected $fillable = ['message_id', 'reporter_id', 'reason', 'description', 'status'];

    public $timestamps = true;

    public function message(): BelongsTo
    {
        return $this->belongsTo(ForumMessage::class);
    }

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }
}
