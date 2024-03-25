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
    public $posts, $post, $title, $content, $search = '';
    public $deleteId = '';
    public $confirmingPostDeletion = false;
    public $confirmingPostEdit = false;


    /**
     * Update the password for the currently authenticated user.
     */

    public function resetDatas()
    {
        $this->reset('title', 'content');
    }
    public function createPost()
    {

        // dd('hi');
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
        // return redirect('/posts');
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


    // delete
    public function confirmPostDeletion($id)
    {
        $this->confirmingPostDeletion = $id;
    }

    public function getPostTitle($id)
    {
        return ModelsPost::findOrFail($id)->title;
    }

    public function deletePost(ModelsPost $post)
    {
        // dd('hi');
        // dd($post);
        $post->delete();
        $this->reset('title', 'content');
        $this->confirmingPostDeletion = false;
        session()->flash('message', 'Post Deleted Successfully');
        // return redirect('/posts');
    }

    // edit
    public function confirmPostEdit($id)
    {
        $this->title = ModelsPost::findOrFail($id)->title;
        $this->content = ModelsPost::findOrFail($id)->content;
        $this->confirmingPostEdit = $id;
    }




    public function editPost($id)
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
        $post = ModelsPost::findOrFail($id);
        // dd($tag);
        // dd($this->status);
        $post->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
        ]);

        $this->reset('title', 'content');
        $this->dispatch('postUpdated'); // Emit event on successful update

        // $this->title = '';
        // $this->content = '';
        // return redirect('posts')->with('post-updated', 'Post updated successfully');
    }
}
