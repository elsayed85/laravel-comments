<?php

namespace Spatie\Comments\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Comments\Support\Config;

class Reaction extends Model
{
    public $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(Config::getUserModelName(), 'user_id');
    }

    public function comment(): BelongsTo
    {
        return $this->belongsTo(Config::getCommentModelName(), 'comment_id');
    }
}
