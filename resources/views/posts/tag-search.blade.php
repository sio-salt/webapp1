<x-app-layout>
    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p class="flex justify-center text-lg text-black font-bold pb-4">{{ __('Tag Search Page') }}</p>
                    <form action="{{ route('tag_search') }}" method="GET" onsubmit="return false;">
                        <!--@csrf-->
                        
                        <!-- lectures Select-Box -->
                        <div class="mt-4 grid grid-cols-12 gap-2">
                            <label for="lectures" class="col-span-7">{{ __('Lecture Tag') }}</label>
                            <label for="lecsearchbox" class="col-span-5">{{ __('Filtering') }}</label>
                            <!--<select name="post[lecture_id]" id="lectures" class="col-span-6 flex py-2 border-2 bg-gray-100 rounded-lg shadow-sm focus:outline-none sm:text-sm"></select>-->
                            <select name="lecture" id="lectures" class="col-span-7 flex py-2 border-2 bg-gray-100 rounded-lg shadow-sm focus:outline-none sm:text-sm"></select>
                            <input type="text" id="lecsearchbox" placeholder="e.g. 量子" class="col-span-5 py-2 border-2 flex bg-gray-100 rounded-lg shadow-sm focus:outline-none sm:text-sm">
                            <!--<input type="button" id="lecSearch" value="{{ __('Filter') }}" class="col-span-5 btn py-2 flex-initial text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">-->
                            <!--<input type="button" id="lecSearch" value="{{ __('Filter') }}" class="col-span-5 btn py-2 flex-initial text-sm {{--hidden sm:block--}} font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">-->
                        </div>
                        
                        <div class="mt-4 grid grid-cols-12 gap-2">
                            <label for="tags" class="col-span-7">{{ __('Free Tag') }}</label>
                            <label for="tagsearchbox" class="col-span-5">{{ __('Filtering') }}</label>
                            <!--<select name="post[tag_id]" id="tags" class="col-span-6 flex py-2 border-2 bg-gray-100 rounded-lg shadow-sm focus:outline-none sm:text-sm"></select>-->
                            <select name="tag" id="tags" class="col-span-7 flex py-2 border-2 bg-gray-100 rounded-lg shadow-sm focus:outline-none sm:text-sm"></select>
                            <input type="text" id="tagsearchbox" placeholder="e.g. 物理" class="col-span-5 py-2 border-2 flex bg-gray-100 rounded-lg shadow-sm focus:outline-none sm:text-sm">
                            <!--<input type="button" id="tagSearch" value="{{ __('Filter') }}" class="col-span-5 btn py-2 flex-initial text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">-->
                        </div>
                        
                        <div class="content-center">
                            <button type="button" onclick="submit();" class="flex-1 inline-flex w-30 mt-7 py-2 px-3 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <svg class="mr-2 -ml-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <span class="inline">{{ __('Search') }}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="py-7 max-w-4xl mx-auto sm:px-6 lg:px-8 grid">
            <p1>検索結果 ： {{ $posts->count() }} 件</p1>
            <div class="border-2 border-b border-sky-700"></div>
        </div>
        <div class='py-1 max-w-4xl mx-auto sm:px-6 lg:px-8 grid gap-y-4'>
            @if ($posts->count())
                @foreach ($posts as $post)
                    <x-post-card :post="$post"/>
                @endforeach
            @endif
        </div>
    </div>
    <script>
        window.Laravel = {};
        window.Laravel.lectures = @json($lectures);
        window.Laravel.tags = @json($tags);
    </script>
</x-app-layout>
