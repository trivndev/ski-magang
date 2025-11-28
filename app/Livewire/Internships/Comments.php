<?php

namespace App\Livewire\Internships;

use App\Models\Comment;
use App\Models\Internship;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Comments extends Component
{
    public Internship $internship;

    #[Validate('required|string|min:1|max:1000')]
    public string $newComment = '';

    public function mount(Internship $internship): void
    {
        $this->internship = $internship;
    }

    public function addComment(): void
    {
        if (!auth()->check()) {
            return;
        }

        $this->validate();

        Comment::create([
            'internship_id' => $this->internship->id,
            'user_id' => auth()->id(),
            'content' => trim($this->newComment),
        ]);

        $this->newComment = '';
        $this->internship->refresh();
    }

    public function deleteComment(int $commentId): void
    {
        $comment = Comment::find($commentId);

        if (!$comment) {
            return;
        }

        if ($comment->user_id !== auth()->id()) {
            return;
        }

        $comment->delete();
        $this->internship->refresh();
    }

    public function render()
    {
        return view('livewire.internships.comments', [
            'comments' => $this->internship->comments()
                ->with('user')
                ->latest()
                ->get(),
        ]);
    }
}
