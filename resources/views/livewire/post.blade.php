{{-- @dd($posts) --}}
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between " style="margin-bottom: 20px">
            <div class=""></div>
            <x-primary-button x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-post-add')">{{ __('Create Post') }}</x-primary-button>
        </div>
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            {{-- @dd($posts) --}}
            <div class="p-6 text-gray-900 dark:text-gray-100">
                @if ($posts)
                    @foreach ($posts as $post)
                        <div
                            class="max-w-sm p-6 bg-white text-end mb-4 border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                            <h5
                                class="mb-2 text-2xl text-center font-bold tracking-tight text-gray-900 dark:text-white">
                                {{ $post->title }}</h5>
                            <p class="mb-3 font-normal text-center text-gray-700 dark:text-gray-400">
                                {{ $post->content }}</p>
                            <a href="#"
                                class="inline-flex text-center items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Read more
                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </a>
                        </div>
                    @endforeach
                @else
                    <div class="text-center text-orange-500">
                        {{ __('No Post created yet!') }}
                    </div>
                @endif
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
</div>
