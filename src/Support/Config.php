<?php

namespace Spatie\Comments\Support;

use Spatie\Comments\Exceptions\InvalidConfig;

class Config
{
    public static function getUserModelName(): string
    {
        return config('comments.models.user')
            ?? config('auth.providers.users.model')
            ?? throw InvalidConfig::couldNotDetermineUserModelName();
    }

    public static function getCommentModelName(): string
    {
        return config('comments.models.comment');
    }

    public static function getReactionModelName(): string
    {
        return config('comments.models.reaction');
    }
}
