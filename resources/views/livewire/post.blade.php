{{-- @dd($posts) --}}

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between " style="margin-bottom: 20px">
            <div class=""></div>
            <x-primary-button x-data="" wire:click="resetDatas"
                x-on:click.prevent="$dispatch('open-modal', 'confirm-post-add')">
                {{ __('Create Post') }}
            </x-primary-button>
        </div>
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="flex justify-between p-6">
                <div class=""></div>

                {{-- search --}}
                {{-- @if ($posts->count() > 0) --}}
                <form>
                    <x-text-input type="text" class="search-input " wire:model.live.debounce.1000="search"
                        class="mt-1 block w-1/4" placeholder="{{ __('Search') }}" />
                </form>
                {{-- @endif --}}

            </div>
            {{-- @dd($posts) --}}
            <div class="p-6 text-gray-900 dark:text-gray-100">
                @forelse ($posts as $post)
                    <div
                        class="max-w-sm p-6 bg-white text-center mb-4 border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <h5 class="mb-2 text-lg text-start font-bold tracking-tight text-gray-900 dark:text-white">
                            {{ $post['title'] }} <span
                                class="text-gray-400">{{ $post->created_at ? $post->created_at->diffForHumans() : '' }}</span>
                            <span
                                class="bg-white text-start text-gray-400 items-center me-2 px-3 py-0.5 rounded-full ">{{ $post->tag->name }}</span>
                        </h5>

                        <p class="mb-3 mt-3 font-normal  text-gray-700 dark:text-gray-400" style="text-align: justify">
                            {{ $post['content'] }}</p>
                        <p wire:click='postDetail({{ $post->id }})' style="cursor: pointer;"
                            class="inline-flex text-center items-center px-3 py-2 mt-3 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 post_link">
                            Read more
                        </p>
                        <div class="mx-auto mt-3">
                            <x-primary-button x-data="" wire:click="confirmPostEdit({{ $post->id }})"
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-post-edit')">{{ __('Edit') }}</x-primary-button>
                            <x-danger-button x-data=""
                                wire:click="confirmPostDeletion({{ $post->id }})"
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-post-delete')">{{ __('Delete') }}</x-danger-button>
                        </div>
                    </div>
                @empty
                    <div class="text-center mb-6">
                        {{ __('No Post created yet!') }}
                    </div>
                @endforelse ($posts as $post)
                {{-- @dd($post) --}}

            </div>
        </div>
        <div class="space-y-3" style="margin-top: 20px">
            {{ $posts->links() }}
        </div>
    </div>

    {{-- create modal --}}
    <x-modal name="confirm-post-add" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="createPost" class="p-6 ">

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Create A New Post') }}
            </h2>
            <!-- Title -->
            <div class="mt-6">
                <x-input-label for="title" value="{{ __('title') }}" class="sr-only" />

                <x-text-input wire:model="title" id="title" name="title" type="text" class="mt-1 block w-3/4"
                    placeholder="{{ __('Title') }}" />

                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <div class="mt-6">
                <x-input-label for="title" value="{{ __('Content') }}" class="sr-only" />

                <x-text-input wire:model="content" id="content" name="content" type="text" class="mt-1 block w-3/4"
                    placeholder="{{ __('Content') }}" />

                <x-input-error :messages="$errors->get('content')" class="mt-2" />
            </div>

            <div class="mt-6">
                <x-select-box wire:model='tag' class="mt-1 block w-3/4" :options="$tags" placeholder="Tag" />
            </div>


            <div class="mt-6 flex justify-center">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3" x-on:click="$dispatch('close')">
                    {{ __('Create') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>


    {{-- delete modal --}}
    <x-modal wire:model.defer="confirmingPostDeletion" name="confirm-post-delete" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="deletePost({{ $confirmingPostDeletion }})" x-on:click="$dispatch('close')" class="p-6">
            @if ($confirmingPostDeletion)
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Are you sure you want to delete your :title?', ['title' => $this->getPostTitle($confirmingPostDeletion)]) }}
                </h2>
            @endif
            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button type='submit' class="ms-3">
                    {{ __('Delete') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>

    {{-- edit modal --}}
    <x-modal wire:model.defer="confirmingPostEdit" name="confirm-post-edit" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit.prevent="editPost({{ $confirmingPostEdit }})" class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Edit Post') }}
            </h2>
            <!-- Title -->
            <div class="mt-6">
                <x-input-label for="title" value="{{ __('title') }}" class="sr-only" />

                <x-text-input wire:model="title" id="title" name="title" type="text" class="mt-1 block w-3/4"
                    placeholder="{{ __('Title') }}" />

                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <div class="mt-6">
                <x-input-label for="title" value="{{ __('Content') }}" class="sr-only" />

                <x-text-input wire:model="content" id="content" name="content" type="text"
                    class="mt-1 block w-3/4" placeholder="{{ __('Content') }}" />

                <x-input-error :messages="$errors->get('content')" class="mt-2" />
            </div>
            <div class="mt-6">
                <x-select-box wire:model='tag' class="mt-1 block w-3/4" :options="$tags" placeholder="Tag" />
                <x-input-error :messages="$errors->get('content')" class="mt-2" />

            </div>


            <div class="mt-6 flex justify-center">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3" x-on:click="$dispatch('close')">
                    {{ __('Save') }}
                </x-primary-button>
            </div>

        </form>

    </x-modal>
</div>
