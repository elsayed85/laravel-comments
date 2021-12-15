<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Comments\Tests\Support\Models\User;
use Spatie\Comments\Tests\Support\TestCase;

uses(TestCase::class)
    ->beforeEach(function () {
        config()->set('comments.models.user', User::class);
    })
    ->in(__DIR__);

function login(User $user = null): void
{
    Auth::login($user ?? User::factory()->create());
}

function logout(): void
{
    Auth::logout();
}

expect()->extend('isModel', function (Model $model) {
    expect($this->value)->is($model)->toBeTrue();
});
