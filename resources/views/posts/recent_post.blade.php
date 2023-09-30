<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Blog</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <h1>最近の投稿一覧</h1>
        <div class='posts'>
            @foreach ($posts as $post)
                <div class='post'>
                    <h4 class='user'>{{ $post->user->name }}</h4>
                    <p class='created_at'>{{ $post->created_at }}</p>
                    <h3 class='title'>{{ $post->title }}</h3>
                        @foreach ($post->lectures as $lecture)
                            <p class='tags'>#{{ $lecture->name }}</p>
                        @endforeach
                    <p class='start_at'>•{{ $post->start_at }}</p>
                    <p class='place'>•{{ $post->place }}</p>
                    @if ($post->teacher_welcome == 1)
                        <h4 class='teacher_welcome'>{{ $post->teacher_welcome }}</h4>
                    @endif
                    <p class='body'>{{ $post->body }}</p>
                    <p class='participations'>参加します! {{ $post->participations['participate'] }}</p>
                    <p class='participations'>参加するかも {{ $post->participations['participate_likely'] }}</p>
                    <p class='participations'>メンターとして参加 {{ $post->participations['participate_as_mentor'] }}</p>
                </div>
            @endforeach
        </div>
    </body>
</html>