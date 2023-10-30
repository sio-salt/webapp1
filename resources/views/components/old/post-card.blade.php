@props(['post' => $post])

<div class="flex flex-col bg-white p-6 rounded-lg shadow-md">
    <div class="flex items-center justify-between mb-4 pl-4">
        <div class="text-lg font-bold text-blue-700">{{ $post->user->name }}</div>
        <div class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</div>
    </div>
    <h2 class="text-xl font-semibold mb-2 text-blue-900 pl-8">{{ $post->title }}</h2>
    <div class="mb-4 pl-8">
        @foreach ( $post->lectures as $lecture )
            <span class="inline-block bg-blue-200 text-indigo-900 px-2 py-1 rounded-full text-sm">#{{ $lecture->name }}</span>
        @endforeach
    </div>
    <div class="mb-4 pl-12">
        <ul>
            <li>• {{ $post->start_at }}</li>
            <li>• {{ $post->place }}</li>
        </ul>
    </div>
    @if ($post->teacher_welcome == 1)
        <h4 class='teacher_welcome'>{{ $post->teacher_welcome }}</h4>
    @endif
    <p class="mb-6 text-black pl-8">{{ $post->body }}</p>
    <div class="flex items-center justify-center space-x-16">
        @if ($post->is_this_role_checked_by_auth_user(0))
            <form action="{{ route('unparticipate', $post) }}" method="get">
            <!--<form method="post">-->
                @csrf
                <!--<button type="submit" formaction="/unparticipate/{{ $post->id }}" class="btn px-4 py-1 rounded bg-lime-600 text-white border-4 border-sky-400">参加します!   {{ $post->participations['participate'] }}</button>-->
                <button type="button" onclick="unparticipate({{ $post->id }}, 0)" class="btn px-4 py-1 rounded bg-lime-600 text-white border-4 border-sky-400">参加します!   {{ $post->participations['participate'] }}</button>
            </form>
        @else
            <form action="{{ route('participate', $post) }}" method="get">
                @csrf
                <!--<a type="submit" formaction="/participate/{{ $post->id }}?role=0" class="px-4 py-1 rounded bg-lime-600 text-white border border-black">参加します!   {{ $post->participations['participate'] }}</a>-->
                <button type="button" onclick="participate({{ $post->id }}, 0)" class="btn px-4 py-1 rounded bg-lime-600 text-white border border-black">参加します!   {{ $post->participations['participate'] }}</button>
            </form>
        @endif
            
            <!--@if ($post->is_this_role_checked_by_auth_user(1))-->
            <!--    <button onclick="participate({{$post->id}}, 1)" class="px-4 py-1 rounded bg-lime-600 text-white border-4 border-sky-600">参加するかも   {{ $post->participations['participate_likely'] }}</button>-->
            <!--@else-->
            <!--    <button class="px-4 py-1 rounded bg-green-500 text-white border border-black">参加するかも   {{ $post->participations['participate_likely'] }}</button>-->
            <!--@endif-->
            
            <!--@if ($post->is_this_role_checked_by_auth_user(2))-->
            <!--    <button onclick="participate({{$post->id}}, 2)" class="px-4 py-1 rounded bg-lime-600 text-white border-4 border-sky-600">メンターとして参加   {{ $post->participations['participate_as_mentor'] }}</button>-->
            <!--@else-->
            <!--    <button class="px-4 py-1 rounded bg-pink-600 text-white border border-blue">メンターとして参加   {{ $post->participations['participate_as_mentor'] }}</button>-->
            @endif
    </div>
    <!--<form action="/posts/{{ $post->id }}" id="form_{{ $post->id }}" method="post">-->
    <form action="{{ route('delete_post', $post) }}" id="form_{{ $post->id }}" method="post">
        @csrf
        @method('DELETE')
        <button type="button" onclick="deletePost({{ $post->id }})" class="btn px-4 py-1 rounded bg-red-300 text-white border border-black">削除</button>
        <!--<button type="button" onclick="deletePost({{ $post }})" class="btn px-4 py-1 rounded bg-red-300 text-white border border-black">削除</button>-->
    </form>
</div>

