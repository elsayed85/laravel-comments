<?php

namespace Spatie\Comments\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class CommentsComponent extends Component
{
    use WithPagination;

    public $model;

    protected $listeners = [
        'refresh' => '$refresh'
    ];

    public $newCommentText = '';

    protected $rules = [
        'newCommentText' => 'required',
    ];

    public function createComment()
    {
        $comment = $this->model->comment($this->newCommentText);

        $comment->save();

        $this->newCommentText = '';

        $this->goToPage(1);
    }

    public function render()
    {
        $comments = $this->model
            ->comments()
            ->with('user', 'nestedComments.user')
            ->paginate(10);

        return view('comments::comments', [
            'comments' => $comments
        ]);
    }
}
