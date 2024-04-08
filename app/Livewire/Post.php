<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\Post as ModelsPost;
use App\Models\Tag;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Url;

class Post extends Component
{
    use WithPagination;
    public  $post, $title, $content  = '';
    public $deleteId = '';
    public $confirmingPostDeletion = false;
    public $confirmingPostEdit = false;
    public $confirmingPostCreate = false;
    public $tags;
    public $tag;
    #[Url]
    public $search = '';

    /**
     * Update the password for the currently authenticated user.
     */

    public function resetDatas()
    {
        $this->reset('title', 'content', 'tag');
    }
    public function createPost()
    {

        // dd($this->tag);
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
            'tag_id'    => $this->tag,
        ]);
        $this->dispatch('post-created');
        $this->confirmingPostEdit = false;

        // return redirect('/posts');
    }

    public function render()
    {
        // sleep(1);
        $this->tags = Tag::pluck('name', 'id');
        $query = ModelsPost::query();
        // dd($query->get());
        if ($this->search != '') {
            $query = $query->where('title', 'like', "%$this->search%")
                ->orWhere('content', 'like', "%$this->search%");
        } else {
            $this->reset('search');
        }
        $posts = $query->paginate(10);
        // dd($posts);
        return view('livewire.post', [
            'posts' => $posts,
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
        $this->tag = ModelsPost::findOrFail($id)->tag_id;
        // dd($this->tag);
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
            'tag_id'    => $this->tag,
        ]);

        $this->reset('title', 'content');
        $this->dispatch('postUpdated'); // Emit event on successful update

        // $this->title = '';
        // $this->content = '';
        // return redirect('posts')->with('post-updated', 'Post updated successfully');
    }
}
