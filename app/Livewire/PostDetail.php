<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class PostDetail extends Component
{
    public Post $post;
    #[Validate('required')]
    public $comment;
    public $user;
    // public $user_id = $post->comments->first()->;

    public function mount($id)
    {
        $this->post = Post::findOrFail($id);


        // $user_id = $this->post->comments->first()->user_id;
        // $this->user = User::findOrFail($user_id)->name;

        if ($this->post->comments->isNotEmpty()) {
            // Retrieve the user_id of the first comment
            $user_id = $this->post->comments->first()->user_id;

            // Find the user based on user_id and assign the name to $this->user
            $this->user = User::findOrFail($user_id)->name;
        }

        // dd($user);
    }



    public function createComment()
    {
        // dd($this->comment);
        $this->validate();
        Comment::create([
            'content' => $this->comment,
            'post_id'   => $this->post->id,
            'user_id'   => Auth::user()->id,
        ]);
        $this->reset('comment');
        // dd($this->comment);
    }

    public function render()
    {
        // dump($this->comment);
        return view('livewire.post-detail');
    }

    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        // dd($comment);
    }
}
