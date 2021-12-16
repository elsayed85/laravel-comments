<?php

namespace Spatie\Comments;

use Livewire\Livewire;
use Spatie\Comments\Livewire\CommentComponent;
use Spatie\Comments\Livewire\CommentsComponent;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CommentsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-comments')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_comments_tables');
    }

    public function packageBooted()
    {
        Livewire::component('comments', CommentsComponent::class);
        Livewire::component('comment', CommentComponent::class);

    }
}
