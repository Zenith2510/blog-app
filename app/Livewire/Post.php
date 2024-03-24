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
    public $posts, $post, $title, $content, $search;
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
        $this->addPost = false;
        $this->reset($this->title, $this->content);
    }

    #[On('deletePost')]
    public function deleteData()
    {
        dd('hi');
    }

    public function render()
    {

        $this->posts = ModelsPost::query();
        // dd($this->posts);
        if ($this->search != '') {
            $this->posts = $this->posts->where('title', 'like', "%$this->search%")
                ->orWhere('content', 'like', "%$this->search%");
        }
        $this->posts = $this->posts->get();
        return view('livewire.post', [
            'posts' => $this->posts,
        ]);
    }

    // go to post detail
    public function postDetail($id)
    {
        // return redirect()->route('posts', ['id' => $id]);
        return redirect()->route('post-detail', ['id' => $id]);
    }
}
