<x-app-layout>
<!--    <!DOCTYPE html>-->
<!--    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">-->
<!--        <x-slot name='header'>-->
<!--            <head>-->
<!--                <meta charset="utf-8" name="csrf-token" content="{{ csrf_token() }}">-->
<!--                <title>recent posts</title>-->
                <!-- Fonts -->
<!--                <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">-->
<!--            </head>-->
<!--        </x-slot>-->
        <!--<body>-->
            <div class='py-12 max-w-4xl mx-auto sm:px-6 lg:px-8 grid gap-y-2'>
                @if ($posts->count())
                    @foreach ($posts as $post)
                        <x-post-card :post="$post"/>
                    @endforeach
                @endif
            </div>
            <script>
                function participate(post_id, role) {
                    $.ajax({
                       headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                        url: `/participate/${post_id}` + "?role=" + role,
                        type: "POST",
                    })
                        .done(function (data, status, xhr) {
                        console.log(data);
                    })
                        .fail(function (xhr, status, error) {
                        console.log();
                    });
                }
                
                function unparticipate(post_id, role) {
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                        url: `/unparticipate/${post_id}` + "?role=" + role,
                        type: "POST",
                    })
                        .done(function (data, status, xhr) {
                            console.log(data);
                        })
                        .fail(function (xhr, status, error) {
                            console.log();
                        });
                }
            </script>
    <!--    </body>-->
    <!--</html>-->
</x-app-layout>
