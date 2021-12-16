<?php

use Spatie\Comments\Exceptions\CannotCreateComment;
use Spatie\Comments\Models\Comment;
use Spatie\Comments\Tests\Support\Models\Post;
use Spatie\Comments\Tests\Support\Models\User;

beforeEach(function () {
    login();

    $this->post = Post::factory()->create();
});

it('can add comments', function () {
    $this->post->comment('my comment');

    expect($this->post->comments)->toHaveCount(1);

    expect($this->post->comments->first())
        ->user->toBeInstanceOf(User::class)
        ->comment->toBe('my comment');
});

it('can add multiple comments', function () {
    $this->post
        ->comment('comment 1')
        ->comment('comment 2')
        ->comment('comment 3');

    expect($this->post->comments)->toHaveCount(3);
});

it('will not create a comment if no one is logged in', function () {
    logout();

    $this->post->comment('my comment');
})->throws(CannotCreateComment::class);

it('can create a comment for a specific user', function () {
    $anotherUser = User::factory()->create();

    $this->post->comment('my comment', $anotherUser);

    expect($this->post->comments->first()->user)->isModel($anotherUser);
});

it('can create a nested comment', function () {
    $this->post->comment('top level comment');
    /** @var Comment $topLevelComment */
    $topLevelComment = Comment::first();

    $topLevelComment->comment('nested comment');
    $nestedComment = Comment::find(2);

    expect($topLevelComment->isTopLevel())->toBeTrue();
    expect($nestedComment->isTopLevel())->toBeFalse();
});

it('has a relation to get nested comments', function () {
    $this->post->comment('top level comment');
    /** @var Comment $topLevelComment */
    $topLevelComment = Comment::first();

    $topLevelComment->comment('nested comment');
    $nestedComment = Comment::find(2);

    expect($topLevelComment->nestedComments)->toHaveCount(1);
    expect($topLevelComment->nestedComments->first())->isModel($nestedComment);
    expect($nestedComment->nestedComments)->toHaveCount(0);
});
