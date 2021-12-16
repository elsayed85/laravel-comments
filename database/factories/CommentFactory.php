<?php

namespace Spatie\Comments\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Comments\Models\Comment;
use Spatie\Comments\Tests\Support\Models\BlogPost;
use Spatie\Comments\Tests\Support\Models\Post;
use Spatie\Comments\Tests\Support\Models\User;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'commentable_id' => Post::factory(),
            'commentable_type' => Post::class,
            'text' => 'comment text',
        ];
    }
}
