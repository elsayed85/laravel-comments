<?php

namespace Spatie\Comments\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Comments\Models\Concerns\HasComments;
use Spatie\Comments\Support\Config;

class Comment extends Model
{
    use HasComments;
    use HasFactory;

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

    public function reactions(): HasMany
    {
        return $this->hasMany(Config::getReactionModelName());
    }

    public function react(string $reaction, Model $user = null): self
    {
        $user ??= auth()->user();

        $this->reactions()->firstOrCreate([
            'user_id' => $user->getKey(),
            'reaction' => $reaction,
        ]);


        return $this;
    }

    public function removeReaction(string $reaction, Model $user = null): self
    {
        $user ??= auth()->user();

        $this
            ->reactions()
            ->where('user_id', $user->getKey())
            ->where('reaction', $reaction)
            ->delete();

        return $this;
    }
}
