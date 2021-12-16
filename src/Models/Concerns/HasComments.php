<?php

namespace Spatie\Comments\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Comments\Exceptions\CannotCreateComment;
use Spatie\Comments\Support\Config;

trait HasComments
{
    public function comments(): MorphMany
    {
        return $this->morphMany(Config::getCommentModelName(), 'commentable');
    }

    public function comment(string $comment, Model $user = null): self
    {
        $user ??= auth()->user();

        if (! $user) {
            throw CannotCreateComment::userIsRequired();
        }

        $parentId = ($this::class === Config::getCommentModelName())
            ? $this->id
            : null;

        $this->comments()->create([
            'user_id' => $user->getKey(),
            'comment' => $comment,
            'parent_id' => $parentId,
        ]);

        return $this;
    }
}
