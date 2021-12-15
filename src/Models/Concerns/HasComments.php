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

        if (!$user) {
            throw CannotCreateComment::userIsRequired();
        }

        $commentClass = Config::getCommentModelName();

        $comment = new $commentClass([
            'user_id' => $user->getKey(),
            'commentable_id' => $this->getKey(),
            'commentable_type' => $this::class,
            'comment' => $comment,
        ]);

        $this->comments()->save($comment);

        return $this;
    }
}
