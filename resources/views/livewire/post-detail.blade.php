 <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
     <div class="p-6 text-gray-900 dark:text-gray-100">
         {{-- @if ($posts) --}}
         {{-- @dd($post) --}}
         <div
             class="max-w-sm p-6 bg-white  mb-4 border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
             <h5 class="mb-2 text-2xl text-center font-bold tracking-tight text-gray-900 dark:text-white">
                 {{ $post['title'] }}</h5>
             <p class="mb-3 font-normal text-justify text-gray-700 dark:text-gray-400">
                 {{ $post['content'] }}</p>
         </div>
         {{-- @else
                    <div class="text-center text-orange-500">
                        {{ __('No Post created yet!') }}
                    </div>
                @endif --}}
     </div>
 </div>
