<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class PostDetail extends Component
{
    public Post $post;

    public function mount($id)
    {
        $this->post = Post::findOrFail($id);
    }

    public function render()
    {
        return view('livewire.post-detail');
    }
}
