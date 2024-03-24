{{-- @dd($posts) --}}
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between " style="margin-bottom: 20px">
            <div class=""></div>
            <x-primary-button x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-post-add')">{{ __('Create Post') }}</x-primary-button>
        </div>
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="flex justify-between p-6">
                <div class=""></div>

                {{-- search --}}
                <form>
                    <x-text-input type="text" class="search-input" wire:model.live="search" class="mt-1 block w-1/4"
                        placeholder="{{ __('Search') }}" />
                </form>

            </div>
            <div class="p-6 text-gray-900 dark:text-gray-100">
                {{-- @if ($posts) --}}
                @foreach ($posts as $post)
                    {{-- @dd($post) --}}
                    <div
                        class="max-w-sm p-6 bg-white text-center mb-4 border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <h5 class="mb-2 text-2xl text-center font-bold tracking-tight text-gray-900 dark:text-white">
                            {{ $post['title'] }}</h5>
                        <p class="mb-3 font-normal text-center text-gray-700 dark:text-gray-400">
                            {{ $post['content'] }}</p>
                        <p wire:click='postDetail({{ $post->id }})'
                            class="inline-flex text-center items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 post_link">
                            Read more
                        </p>
                        <div class="mx-auto">
                            <x-danger-button x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-post-delete')">{{ __('Delete') }}</x-danger-button>
                        </div>
                    </div>
                @endforeach
                {{-- @else
                    <div class="text-center text-orange-500">
                        {{ __('No Post created yet!') }}
                    </div>
                @endif --}}
            </div>
        </div>
        <div class="mt-5">
            {{-- {{ $posts->links() }} --}}
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


            <div class="mt-6 flex justify-center">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3">
                    {{ __('Create') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>

    {{-- delete modal --}}
    <x-modal name="confirm-post-delete" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="deletePost" class="p-6">

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Are you sure you want to delete your Post?') }}
            </h2>
            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Delete') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</div>
