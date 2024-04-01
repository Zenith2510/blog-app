{{-- @dd($tags) --}}

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between " style="margin-bottom: 20px">
            <div class=""></div>
            <x-primary-button x-data="" wire:click="resetDatas"
                x-on:click.prevent="$dispatch('open-modal', 'confirm-tag-add')">
                {{ __('Create tag') }}
            </x-primary-button>
        </div>
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="flex justify-between p-6">
                <div class=""></div>

                {{-- search --}}
                @dd($tags)
                @if ($tags->count() > 0)
                    <form>
                        <x-text-input type="text" class=" search-input " wire:model.live="search"
                            class="mt-1 block w-1/4" placeholder="{{ __('Search') }}" />
                    </form>
                @endif

            </div>
            {{-- @dd($tags) --}}
            <div class="p-6 text-gray-900 dark:text-gray-100">
                @if ($tags->count() > 0)
                    @foreach ($tags as $tag)
                        {{-- @dd($tag) --}}
                        <div
                            class="max-w-sm p-6 bg-white text-center mb-4 border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                            <h5
                                class="mb-2 text-2xl text-center font-bold tracking-tight text-gray-900 dark:text-white">
                                {{ $tag['name'] }}</h5>
                            <p wire:click='tagDetail({{ $tag->id }})'
                                class="inline-flex text-center items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 tag_link">
                                Read more
                            </p>
                            <div class="mx-auto">
                                <x-primary-button x-data=""
                                    wire:click="confirmTagEdit({{ $tag->id }})"
                                    x-on:click.prevent="$dispatch('open-modal', 'confirm-tag-edit')">{{ __('Edit') }}</x-primary-button>
                                <x-danger-button x-data=""
                                    wire:click="confirmTagDeletion({{ $tag->id }})"
                                    x-on:click.prevent="$dispatch('open-modal', 'confirm-tag-delete')">{{ __('Delete') }}</x-danger-button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center mb-6">
                        {{ __('No tag created yet!') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="mt-5">
            {{ $tags->links() }}
        </div>
    </div>

    {{-- create modal --}}
    <x-modal name="confirm-tag-add" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="createtag" class="p-6 ">

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Create A New tag') }}
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

                <x-primary-button class="ms-3" x-on:click="$dispatch('close')">
                    {{ __('Create') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>


    {{-- delete modal --}}
    <x-modal wire:model.defer="confirmingtagDeletion" name="confirm-tag-delete" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="deletetag({{ $confirmingtagDeletion }})" x-on:click="$dispatch('close')" class="p-6">
            @if ($confirmingtagDeletion)
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Are you sure you want to delete your :title?', ['title' => $this->gettagTitle($confirmingtagDeletion)]) }}
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
    <x-modal wire:model.defer="confirmingtagEdit" name="confirm-tag-edit" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit.prevent="edittag({{ $confirmingtagEdit }})" class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Edit tag') }}
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

                <x-primary-button class="ms-3" x-on:click="$dispatch('close')">
                    {{ __('Save') }}
                </x-primary-button>
            </div>

        </form>

    </x-modal>
</div>
