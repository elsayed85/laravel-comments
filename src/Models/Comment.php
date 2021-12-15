<?php

namespace Spatie\Comments\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Comments\Models\Concerns\HasComments;
use Spatie\Comments\Support\Config;

class Comment extends Model
{
    use HasComments;

    protected $guarded = [];

    protected $casts = [
        'extra' => 'array',
    ];

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(Config::getUserModelName(), 'user_id');
    }
}
