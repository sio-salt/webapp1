<x-app-layout>
    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <p class="flex justify-center text-lg text-black font-bold pb-4 pt-6">{{ __('Edit Post')  }}</p>
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="/posts/{{ $old_values->id }}" method="POST" id='edit_form' onsubmit="return false;">
                        @csrf
                        @method('PUT')
                        <x-make-post :oldvalues="$old_values"/> <!--コンポーネントに値を渡すときはアンダースコア使えない!-->
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        // 別jsに変数を渡す。
        window.Laravel = {};
        window.Laravel.lectures = @json($lectures);
        window.Laravel.tags = @json($tags);
        window.Laravel.old_lecture_id = @json($old_values['lecture_id']);
        window.Laravel.old_tag_id = @json($old_values['tag_id']);
    </script>
</x-app-layout>
