<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900 dark:text-gray-100">
        <div
            class="max-w-sm p-6 bg-white  mb-4 border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <h5 class="mb-2 text-2xl text-center font-bold tracking-tight text-gray-900 dark:text-white">
                {{ $post['title'] }}</h5>
            <p class="mb-3 font-normal text-justify text-gray-700 dark:text-gray-400">
                {{ $post['content'] }}</p>
        </div>
    </div>
    {{-- @dd() --}}
    @if ($this->post->comments->isNotEmpty())
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <div
                class="max-w-sm p-6 bg-white  mb-4 border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                @foreach ($post->comments as $comment)
                    <div class="flex">
                        <p class="mb-3 font-normal text-justify" style="margin-bottom: 20px">
                            {{ $comment->content }}
                            <span
                                class="text-gray-400 ms-3">{{ $comment->created_at ? $comment->created_at->diffForHumans() : '' }}</span>
                            <span
                                class="bg-white  text-gray-400 items-center mx-5 px-3 py-0.5 rounded-full ">{{ $user ?? '' }}</span>
                        </p>
                        {{-- @dd($comment->id) --}}
                        @can('delete-comment', $comment)
                            <div style="margin-left: auto">
                                <button
                                    class="border-gray-200 rounded-lg py-1 px-2 shadow-sm bg-white text-gray-400 items-center"
                                    style="background: red;color: white"
                                    wire:click='deleteComment({{ $comment->id }})'>Delete</button>
                            </div>
                        @endcan
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    <div class="p-6 text-gray-900 dark:text-gray-100">
        <form wire:submit='createComment' wire:keydown.enter.prevent='createComment'>
            <x-input-error :messages="$errors->get('comment')" class="mt-2" />
            <x-text-area wire:model.lazy="comment" id="comment" name="comment" type="text"
                class="mt-1 block w-full" placeholder="{{ __('Comment') }}" />

            <div class="mt-4 flex justify-end">
                <x-primary-button class="">
                    {{ __('Comment') }}
                </x-primary-button>

            </div>
        </form>
        {{-- @dump($comment) --}}
    </div>
</div>
