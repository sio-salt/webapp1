<x-app-layout>
    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p class="flex justify-center text-lg text-black font-bold pb-4">{{ __('Tag Search Page') }}</p>
                    <form action="{{ route('tag_search') }}" method="GET">
                        <!--@csrf-->
                        
                        <!-- lectures Select-Box -->
                        <div class="mt-4 grid grid-cols-12 gap-2">
                            <label for="lectures" class="col-span-6">{{ __('Lecture') }}</label>
                            <label for="lecsearchbox" class="col-span-6">{{ __('Filtering') }}</label>
                            <!--<select name="post[lecture_id]" id="lectures" class="col-span-6 flex py-2 border-2 bg-gray-100 rounded-lg shadow-sm focus:outline-none sm:text-sm"></select>-->
                            <select name="lecture" id="lectures" class="col-span-6 flex py-2 border-2 bg-gray-100 rounded-lg shadow-sm focus:outline-none sm:text-sm"></select>
                            <input type="text" id="lecsearchbox" class="col-span-4 py-2 border-2 flex bg-gray-100 rounded-lg shadow-sm focus:outline-none sm:text-sm">
                            <input type="button" id="lecSearch" value="{{ __('Filter') }}" class="col-span-2 btn py-2 flex-initial text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        </div>
                        
                        <div class="mt-4 grid grid-cols-12 gap-2">
                            <label for="tags" class="col-span-6">{{ __('Tags') }}</label>
                            <label for="tagsearchbox" class="col-span-6">{{ __('Filtering') }}</label>
                            <!--<select name="post[tag_id]" id="tags" class="col-span-6 flex py-2 border-2 bg-gray-100 rounded-lg shadow-sm focus:outline-none sm:text-sm"></select>-->
                            <select name="tag" id="tags" class="col-span-6 flex py-2 border-2 bg-gray-100 rounded-lg shadow-sm focus:outline-none sm:text-sm"></select>
                            <input type="text" id="tagsearchbox" class="col-span-4 py-2 border-2 flex bg-gray-100 rounded-lg shadow-sm focus:outline-none sm:text-sm">
                            <input type="button" id="tagSearch" value="{{ __('Filter') }}" class="col-span-2 btn py-2 flex-initial text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        </div>
                        
                        <div class="content-center">
                            <button type="submit" class="flex-1 inline-flex w-30 mt-7 py-2 px-3 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <svg class="mr-2 -ml-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <span class="sm:inline hidden">{{ __('Search') }}</span>
                            </button>
                        </div>
                        
                    </div>
                </div>
            </div>
        </form>
    <div class='py-10 max-w-4xl mx-auto sm:px-6 lg:px-8 grid gap-y-2'>
        @if ($posts->count())
            @foreach ($posts as $post)
                <x-post-card :post="$post"/>
            @endforeach
        @endif
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
                option.setAttribute('value', opt.value);
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
    </script>
</x-app-layout>
