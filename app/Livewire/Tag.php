<?php

namespace App\Livewire;

use App\Models\Tag as ModelsTag;
use Livewire\Component;

class Tag extends Component
{
    public $perPage = 10;
    public $search = '';
    public $confirmingtagDeletion, $confirmingtagEdit;
    public function render()
    {
        // dd(ModelsTag::all());
        return view('livewire.tag', [
            'tags'  => ModelsTag::search($this->search)->paginate($this->perPage),
        ]);
    }
}
