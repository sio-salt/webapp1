<x-app-layout>
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
                    <form action="{{ route('recent_post') }}" method="POST">
                        @csrf
                        <div>
                            <label for="title">{{ __('Title') }}</label>
                            <textarea name="post[title]" id="title" cols="30" rows="2" class="w-full rounded-lg border-2 bg-gray-100 @error('title') border-red-500 @enderror"
                            placeholder="～講義の～レポートを解く会" >{{ old('post.title') }}</textarea>
                            
                            @error('post.title')
                            <div class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        
                        <div class="mt-4">
                            <label for="start_at">{{ __('Start Time') }}</label>
                            <input name="post[start_at]" id="start_at" type="datetime-local" min="2023-10-01T12:00" value="{{ old('post.start_at') }}" 
                            class="mt-1 block w-full py-2 px-3 border-2 bg-gray-100 rounded-lg shadow-sm focus:outline-none sm:text-sm @error('start_at') border-red-500 @enderror"/>
                            
                            @error('post.start_at')
                            <div class="text-red-500 text-sm mt-2">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        
                        <div class="mt-4">
                            <label for="place">{{ __('Place') }}</label>
                            <textarea name="post[place]" id="place" cols="30" rows="1" class="w-full rounded-lg border-2 bg-gray-100 @error('place') border-red-500 @enderror"
                            placeholder="～棟～番教室">{{ old('post.place') }}</textarea>
                            
                            @error('post.place')
                            <div class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        
                        
                        
                        <!-- lectures Select-Box -->
                        <div class="mt-4 grid grid-cols-24 gap-2">
                            <label for="lectures" class="col-span-12">{{ __('Lecture') }}</label>
                            <label for="lecsearchbox" class="col-span-12">{{ __('Filtering') }}</label>
                            <select name="post[lecture_id]" id="lectures" class="col-span-12 flex py-2 border-2 bg-gray-100 rounded-lg shadow-sm focus:outline-none sm:text-sm"></select>
                            <input type="text" id="lecsearchbox" class="col-span-7 py-2 border-2 flex bg-gray-100 rounded-lg shadow-sm focus:outline-none sm:text-sm">
                            <input type="button" id="lecSearch" value="{{ __('Filter') }}" 
                                class="col-span-5 btn py-2 flex-initial text-sm {{--hidden sm:block--}} font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <!--<button type="button" id="lecSearch" class="flex justify-center items-center col-span-2 btn py-2 flex-initial text-sm sm:hidden font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">-->
                            <!--    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">-->
                            <!--        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>-->
                            <!--    </svg>-->
                            <!--</button>-->
                        </div>
                        
                        <div class="mt-4 grid grid-cols-24 gap-2">
                            <label for="tags" class="col-span-12">{{ __('Tags') }}</label>
                            <label for="tagsearchbox" class="col-span-12">{{ __('Filtering') }}</label>
                            <select name="post[tag_id]" id="tags" class="col-span-12 flex py-2 border-2 bg-gray-100 rounded-lg shadow-sm focus:outline-none sm:text-sm"></select>
                            <input type="text" id="tagsearchbox" class="col-span-7 py-2 border-2 flex bg-gray-100 rounded-lg shadow-sm focus:outline-none sm:text-sm">
                            <input type="button" id="tagSearch" value="{{ __('Filter') }}" 
                                class="col-span-5 btn py-2 flex-initial text-sm {{--hidden sm:block--}} font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <!--<button type="button" id="tagsearchbox" class="flex justify-center items-center col-span-2 btn py-2 flex-initial text-sm sm:hidden font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">-->
                            <!--    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">-->
                            <!--        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>-->
                            <!--    </svg>-->
                            <!--</button>-->
                        </div>
                        
                        <div class="mt-4 grid grid-cols-12 gap-2">
                            {{--
                            <label for="free_tag" class="col-span-10">{{ __('Free Tag') }}</label>
                            <label for="tag_add_btn" class="col-span-2">{{ __('Tag Add') }}</label>
                            --}}
                            <textarea name="tag[name]" id="free_tag" cols="30" rows="1" placeholder="{{ __('Free Tag') }}" class="col-span-10 rounded-lg border-2 bg-gray-100 @error('tag') border-red-500 @enderror"></textarea>
                            <button id="tag_add_btn" 
                                class="col-span-2 btn py-2 flex-initial text-sm font-medium text-white bg-gray-500 rounded-lg border border-gray-700 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{ __('Add') }}</button>
                            <p id="exist_alert" class="col-span-12 text-red-500 text-sm mt-1"></p>
                            
                            {{--
                            @error('post.tag')
                            <div class="text-red-500 text-sm mt-2">
                                {{ $message }}
                            </div>
                            @enderror
                            --}}
                        </div>
                        
                        <div class="mt-4">
                          <label for="body">{{ __('Comment') }}</label>
                          <textarea name="post[body]" id="body" cols="30" rows="4" class="w-full rounded-lg border-2 bg-gray-100 @error('comment') border-red-500 @enderror"
                          placeholder="今回のレポートは～です!">{{ old('post.body') }}</textarea>
                          
                          @error('post.body')
                          <div class="text-red-500 text-sm mt-1 mb-2">
                            {{ $message }}
                          </div>
                          @enderror
                        </div>
                        
                        <label for="teacher_welcome">
                            <input name="post[teacher_welcome]" type="hidden" value="0"/>
                            <input name="post[teacher_welcome]" type="checkbox" value="1" id="teacher_welcome"/>
                            {{ __('Welcome those who want to teach') }}
                        </label>
                        
                        <div class="mt-4">
                            <input type="submit" value="{{ __('Submit') }}" class="btn bg-blue-500 rounded font-medium px-4 py-2 text-white hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring :ring-indigo-500"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
    
    // 選択肢・Optionの作成と追加を実行する関数
    function OptionCreator (selectPrefBox, optionList) {
        
        optionList.forEach((opt, index) => {
    
            // 最初は、<option value="">選択してください</option> を作成する
            if (index == 0) {
                let option = document.createElement('option');
                option.setAttribute('value', '');
                option.innerText = '選択してください';
                selectPrefBox.appendChild(option);
            }
    
            let option = document.createElement('option');
            option.setAttribute('value', opt.id);
            option.innerText = opt.value;
    
            selectPrefBox.appendChild(option);
        });
    }

    
    function NoMatchOption (selectPrefBox) {
        let option = document.createElement('option');
        option.setAttribute('value', '');
        option.innerText = '検索に該当はありません';
        selectPrefBox.appendChild(option);
    }
    
    // SelectBoxを作成する関数
    
    
    // [ 1. Serverから受信した optionData から動的に SelectBoxを作成する ]
    function SelectCreator (selectPrefBox, optionList, searchList, searchBool) {
    
        if (optionList.length == 0) return;
    
        selectPrefBox.innerHTML = ''; // 初期化処理
    
        // 選択肢・Optionの作成と追加
        if (searchList.length !== 0 && searchBool) OptionCreator(selectPrefBox, searchList);
        else if (!searchBool) OptionCreator(selectPrefBox, optionList);
        else NoMatchOption(selectPrefBox);
    }
    
    // 1-1. Serverから受信した、DataSet
    const lectureOption = @json($lectures);
    // console.log(lectureOption)
    const tagOption = @json($tags);
    // console.log(tagOption)
    
    const selectBoxesData = [
        {selectId: "lectures", data: lectureOption, searchboxId: 'lecsearchbox', searchBtnId: 'lecSearch'},
        {selectId: 'tags', data: tagOption, searchboxId: 'tagsearchbox', searchBtnId: 'tagSearch'},
    ];
    
    selectBoxesData.forEach((item) => {
        // 1-4. SelectBoxを取得する
        const selectPrefBox = document.getElementById(item.selectId);
        const searchbox = document.getElementById(item.searchboxId);
        const searchBtn = document.getElementById(item.searchBtnId);
        
        const optionCustom = item.data;
        
        // 1-5. 初期のSelectBoxを作成する
        SelectCreator(selectPrefBox, optionCustom, [], false);
        
        // 2-2. 検索結果のOption-List
        let searchResult = [];
        
        // 2-3. inputイベントで検索の入力文字列を受け取って、検索結果の配列を作成する
        searchbox.addEventListener('input', (e) => {
        
            let searchStr = e.target.value; // 検索文字列
        
            searchResult = optionCustom.filter((pref) => { // 検索文字列から絞り込む
                if (/^group@/.test(pref.value)) return false;
        
                // 正規表現で変数を使用するためには、RegExp-Classを使用する
                let reg = new RegExp(`${searchStr}`); // 部分一致
        
                // 検索文字列のパターンと、登録データがマッチするかでTestをする
                return reg.test(pref.value);
            });
            console.log({searchResult});
        });
        
        
        // 2-5. 検索ボタンに、clickイベントを追加する
        // searchResultで SelectBoxを作成する
        searchBtn.onclick = () => SelectCreator(selectPrefBox, optionCustom, searchResult, true);
    });
    
    
    // textareaからの入力をtagOptionに追加する
    const tagTextarea = document.getElementById('free_tag');
    const tagAddBtn = document.getElementById('tag_add_btn');
    const existAlert = document.getElementById('exist_alert');
    const orignalTagLength = tagOption.length;
    
    tagAddBtn.onclick = (event) => {
        event.preventDefault(); // ページのリロードを防ぐ
        
        const value = tagTextarea.value;
        const existingOption = tagOption.find(opt => opt.value === value);
        
        if (existingOption) {
            // 既存のオプションが見つかった場合、それを選択状態にする
            const tagSearchBox = document.getElementById('tagsearchbox');
            tagSearchBox.value = "";
            const selectPrefBox2 = document.getElementById('tags');
            selectPrefBox2.value = existingOption.id;
            
            existAlert.textContent = "既に存在します";
        }
        else {
            while (tagOption.length > orignalTagLength) {
                tagOption.pop();
            }
            
            const id = tagOption.length + 1; // 新しいIDを生成
            tagOption.push({id: id, value: value}); // tagOptionに新しいデータを追加
        
            // 2つ目のselectタグを更新し、新しく追加したオプションを選択状態にする
            const selectPrefBox2 = document.getElementById('tags');
            SelectCreator(selectPrefBox2, tagOption, [], false);
            selectPrefBox2.value = id;
            
            existAlert.textContent = "";
        }
    };
    
    $(function () {
        $('#add_tag') // cancelEnterとついたIDにkeydownイベントを付与
            .on('keydown', function (e) {
            // e.key == 'Enter'でエンターキーが押された場合の条件を設定
            if (e.key == 'Enter') {
                // 何もせずに処理を終える
                return false;
            }
        })
    });

    </script>
</x-app-layout>

