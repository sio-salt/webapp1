<x-app-layout>
    <div class='py-10 max-w-4xl mx-auto sm:px-6 lg:px-8 grid gap-y-2'>
        @if ($posts->count())
            @foreach ($posts as $post)
                <x-post-card :post="$post"/>
            @endforeach
        @endif
    </div>

    <div class="flex items-center justify-around w-full h-16 px-3 border-t border-neutral-200">
        <div class=''>
            {{ $posts->links('vendor.pagination.my-pagination') }}
        </div>
    </div>

    <script>
        function deletePost(id) {
            'use strict'
            
            if (confirm('削除すると復元できません。\n本当に削除しますか?')) {
                document.getElementById(`form_${id}`).submit();
            }
        }
        
        
        
        
        // 仮
        function participate(post_id, role) {
            $.ajax({
               headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                //url: "/posts/" + `${post_id}` + "/participate" + "?role=" + role,
                url: `/posts/${post_id}/participate`,
                type: "GET",
                data: {
                    role: role
                }
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
                url: `/posts/${post_id}/unparticipate`,
                type: "GET",
                data: {
                    role: role
                }
            })
                .done(function (data, status, xhr) {
                    console.log(data);
                })
                .fail(function (xhr, status, error) {
                    console.log();
                });
        }
        
        
    </script>
</x-app-layout>
