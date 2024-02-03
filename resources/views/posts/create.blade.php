<x-app-layout>
    <!--ヘッダーバナーをつけるか否かでコメントアウト-->
    {{--
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('New Post')  }}
            </h2>
        </div>
    </x-slot>
    --}}
    
    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <p class="flex justify-center text-lg text-black font-bold pb-4 pt-6">{{ __('New Post')  }}</p>
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('recent_post') }}" method="POST" id='create_form' onsubmit="return false;">
                        @csrf
                        <x-make-post :oldvalues="$old_values"/> <!--コンポーネントに値を渡すときはアンダースコア使えない!-->
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        // 別jsに変数を渡す。
        window.Laravel = {};
        window.Laravel.lectures = @json($lectures);   // bladeからjavascriptに変数を渡すときはjsonディレクティブを使う。
        window.Laravel.tags = @json($tags);
        window.Laravel.old_lecture_id = @json($old_values['lecture_id']);
        window.Laravel.old_tag_id = @json($old_values['tag_id']);
    </script>
</x-app-layout>

