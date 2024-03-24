<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\Post as ModelsPost;
use Illuminate\Validation\ValidationException;

class Post extends Component
{
    use WithPagination;
    public $posts, $post, $title, $content;
    public $addPost, $deletePost, $editPost = false;

    /**
     * Update the password for the currently authenticated user.
     */
    public function createPost()
    {

        try {
            $validated = $this->validate([
                'title' => ['required', 'string'],
                'content' => ['required', 'string'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('title', 'content');

            throw $e;
        }
        // dd('hi');
        ModelsPost::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
        ]);
        $this->dispatch('post-created');
        return redirect('/posts');
    }

    #[On('close')]
    public function resetFields()
    {
        // dd('hi');
        $this->addPost = false;
        $this->reset($this->title, $this->content);
    }

    public function render()
    {

        $this->posts = ModelsPost::all();
        return view('livewire.post', [
            'posts' => $this->posts,
        ]);
    }
}
