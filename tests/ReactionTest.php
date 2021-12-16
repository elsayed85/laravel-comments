<?php

use Spatie\Comments\Models\Comment;
use Spatie\Comments\Tests\Support\Models\User;

beforeEach(function() {
   $this->currentUser = login();

    $this->comment = Comment::factory()->create();
});

it('can add a reaction to a comment', function() {
    $this->comment->react('👍');

    expect($this->comment->reactions)->toHaveCount(1);

    expect($this->comment->reactions->first())
        ->user->isModel($this->currentUser)
        ->reaction->toBe('👍');
});

it('will make sure reactions are unique for a user', function() {
    $this->comment->react('👍');
    $this->comment->react('👍');

    expect($this->comment->reactions)->toHaveCount(1);

    $this->comment->react('🥳');
    expect($this->comment->fresh()->reactions)->toHaveCount(2);

    $anotherUser = User::factory()->create();
    $this->comment->react('👍', $anotherUser);

    expect($this->comment->fresh()->reactions)->toHaveCount(3);
});

it('can remove a reaction', function() {
    $this->comment->react('👍');

    $this->comment->removeReaction('👍');
    expect($this->comment->fresh()->reactions)->toHaveCount(0);
});

it('will not complain when trying to remove a non-existing reaction', function() {
    $this->comment->removeReaction('👍');

    expectNoExceptionsThrown();
});

it('will remove the reaction of a specific user', function() {
    $anotherUser = User::factory()->create();
    $this->comment->react('👍');
    $this->comment->react('👍', $anotherUser);

    $this->comment->removeReaction('👍', $anotherUser);

    expect($this->comment->reactions)->toHaveCount(1);

    expect($this->comment->reactions->first()->user)->isModel($this->currentUser);
});
