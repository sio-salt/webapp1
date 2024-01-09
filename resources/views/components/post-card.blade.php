@props(['post' => $post])

<div class="flex flex-col bg-white p-6 rounded-lg shadow-md">
    <div class="flex items-center justify-between mb-4 pl-4">
        <div class="text-lg font-bold text-blue-700">{{ $post->user->name }}</div>
        
        <div class="flex justify-end">
            <!--時間表示-->
            <div class="text-sm text-gray-500 mt-0.5 pt-2 px-2">{{ $post->created_at->diffForHumans() }}</div>
            @auth
                @if($post->user->id == Auth::user()->id)
            
                    <div x-data="{ isOpen: false }" class="relative inline-block">
                        <!-- Dropdown toggle button -->
                        <button @click="isOpen = !isOpen" class="relative block p-2 text-gray-700 bg-white border border-transparent rounded-md focus:border-blue-500 focus:ring-opacity-40 focus:ring-blue-300 focus:ring focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                            </svg>
                        </button>
                        
                        <!-- 編集・削除 Dropdown menu -->
                        <div x-show="isOpen"
                            @click.away="isOpen = false"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-90"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-90" 
                            class="absolute right-0 w-20 py-2 mt-2 origin-top-right bg-white rounded-md shadow-xl"
                        >
                            <a href="{{ route('edit_post', $post) }}" class="block px-4 py-1 text-sm text-gray-600 capitalize transition-colors duration-300 transform hover:bg-gray-100"> {{ __('Edit') }} </a>
                            <form action="{{ route('delete_post', $post) }}" id="form_{{ $post->id }}" method="post" class="">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="deletePost({{ $post->id }})" class="w-full text-left block px-4 py-1 text-sm text-gray-600 capitalize transition-colors duration-300 transform hover:bg-gray-100">{{ __('Delete') }}</button>
                            </form>
                        </div>
                    </div>        
                @endif
            @endauth
        </div>
    </div>

    <!--タイトル表示-->
    <h2 class="text-xl font-semibold mb-2 text-blue-900 pl-8">{{ $post->title }}</h2>
    <!--タグの表示-->
    <div class="mb-4 pl-8">
        @foreach ( $post->lectures as $lecture )
            <a href="{{ route('tag_search', ['lecture' => $lecture->name]) }}" 
                class="inline-block bg-blue-200 hover:bg-blue-300 text-indigo-900 px-2 py-1 rounded-full text-sm active:bg-blue-400 focus:outline-none focus:ring :ring-indigo-500">
                #{{ $lecture->name }}
            </a>
        @endforeach
        @foreach ( $post->tags as $tag )
            <a href="{{ route('tag_search', ['tag' => $tag->name]) }}" class="inline-block bg-blue-200 hover:bg-blue-300 text-indigo-900 px-2 py-1 rounded-full text-sm active:bg-blue-400 focus:outline-none focus:ring :ring-indigo-500">#{{ $tag->name }}</a>
        @endforeach
    </div>
    <div class="mb-4 pl-12">
        <ul>
            <li>• 開始時刻  :  {{ $post->start_at }}</li>
            <li>• 実施会場  :  {{ $post->place }}</li>
        </ul>
    </div>
    <div class="mb-4 pl-12">
        @if ($post->teacher_welcome == 1)
            <a class='px-4 py-1 rounded text-white bg-pink-400 border-black mb-4'>教えたい人歓迎</a>
        @endif
    </div>
    <p class="mb-6 text-black pl-8">{{ $post->body }}</p>
    <!--画像機能は後で付ける-->
    {{--<img class="mb-6 rounded object-scale-down h-64 w-full" src="{{ $post->image_url }}">--}}
    <!--<div class="flex flex-row items-center justify-center space-x-16">-->
    <div class="flex flex-row items-center justify-around space-x-4">
        @auth
            @if ($post->is_this_role_checked_by_auth_user(0))
                <button type="button" data-post-id="{{ $post->id }}" data-role="0" class="btn px-1 sm:px-4 py-1 rounded bg-lime-600 hover:bg-lime-700 text-white border-4 border-blue-400 active:bg-lime-800 focus:outline-none focus:border-blue-100">参加します! &nbsp;&nbsp; {{ $post->participations['participate'] }}</button>
            @else
                <button type="button" data-post-id="{{ $post->id }}" data-role="0" class="btn px-1 sm:px-4 py-1 rounded bg-lime-600 hover:bg-lime-700 text-white border border-black active:bg-lime-800 focus:outline-none focus:ring focus:ring-blue-400">参加します! &nbsp;&nbsp; {{ $post->participations['participate'] }}</button>
            @endif
            
            @if ($post->is_this_role_checked_by_auth_user(1))
                <button type="button" data-post-id="{{ $post->id }}" data-role="1" class="btn px-1 sm:px-4 py-1 rounded bg-green-500 hover:bg-green-600 text-white border-4 border-blue-400 active:bg-green-700 focus:outline-none focus:border-blue-100">参加するかも &nbsp;&nbsp; {{ $post->participations['participate_likely'] }}</button>
            @else
                <button type="button" data-post-id="{{ $post->id }}" data-role="1" class="btn px-1 sm:px-4 py-1 rounded bg-green-500 hover:bg-green-600 text-white border border-black active:bg-green-700 focus:outline-none focus:ring focus:ring-blue-400">参加するかも &nbsp;&nbsp; {{ $post->participations['participate_likely'] }}</button>
            @endif
            
            @if ($post->is_this_role_checked_by_auth_user(2))
                <button type="button" data-post-id="{{ $post->id }}" data-role="2" class="btn px-1 sm:px-4 py-1 rounded bg-pink-600 hover:bg-pink-700 text-white border-4 border-blue-300 active:bg-pink-800 focus:outline-none focus:border-blue-100">メンターとして参加 &nbsp;&nbsp; {{ $post->participations['participate_as_mentor'] }}</button>
            @else
                <button type="button" data-post-id="{{ $post->id }}" data-role="2" class="btn px-1 sm:px-4 py-1 rounded bg-pink-600 hover:bg-pink-700 text-white border border-black active:bg-pink-800 focus:outline-none focus:ring focus:ring-blue-300">メンターとして参加 &nbsp;&nbsp; {{ $post->participations['participate_as_mentor'] }}</button>
            @endif
        @endauth
        
        @guest
            <a href="/login" type="button" class="btn px-1 sm:px-4 py-1 rounded bg-lime-600 hover:bg-lime-700 text-white border border-black active:bg-lime-800 focus:outline-none focus:ring focus:ring-blue-400">参加します! &nbsp;&nbsp; {{ $post->participations['participate'] }}</a>
            <a href="/login" type="button" class="btn px-1 sm:px-4 py-1 rounded bg-green-500 hover:bg-green-600 text-white border border-black active:bg-green-700 focus:outline-none focus:ring focus:ring-blue-400">参加するかも &nbsp;&nbsp; {{ $post->participations['participate_likely'] }}</a>
            <a href="/login" type="button" class="btn px-1 sm:px-4 py-1 rounded bg-pink-600 hover:bg-pink-700 text-white border border-black active:bg-pink-800 focus:outline-none focus:ring focus:ring-blue-300">メンターとして参加 &nbsp;&nbsp; {{ $post->participations['participate_as_mentor'] }}</a>
        @endguest
    </div>
</div>

