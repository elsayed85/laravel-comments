<?php

namespace Spatie\Comments\Livewire;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class CommentComponent extends Component
{
    //use AuthorizesRequests;

    /** @var \Spatie\Comments\Models\Comment */
    public $comment;

    protected $listeners = [
        'refresh' => '$refresh',
    ];

    public $replyCommentText = '';

    public $isReplying = false;

    public $isEditing = false;

    public $editCommentText = '';

    public function updatedIsEditing($isEditing)
    {
        if (! $isEditing) {
            return;
        }

        $this->editCommentText = $this->comment->text;
    }

    public function editComment()
    {
        //$this->authorize('update', $this->comment);

        $this->comment->update([
            'text' => $this->editCommentText,
        ]);

        $this->isEditing = false;
    }

    public function deleteComment()
    {
        //$this->authorize('destroy', $this->comment);

        $this->comment->delete();

        $this->emitUp('refresh');
    }

    public function postReply()
    {
        if (! $this->comment->isTopLevel()) {
            return;
        }

        $this->validate([
            'replyCommentText' => 'required',
        ]);

        $this->comment->comment($this->replyCommentText);

        $this->replyCommentText = '';

        $this->isReplying = false;

        $this->emitSelf('refresh');
    }

    public function render()
    {
        return view('comments::comment');
    }
}
