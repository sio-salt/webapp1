<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('New Post')  }}
            </h2>
        </div>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('recent_post') }}" method="POST">
                        @csrf
                        <div>
                            <label for="title">{{ __('Title') }}</label>
                            <textarea name="post[title]" id="title" cols="30" rows="2" class="w-full rounded-lg border-2 bg-gray-100 @error('title') border-red-500 @enderror"
                            placeholder="～講義の～レポートを解く会" >{{ old('post.title') }}</textarea>
                            
                            @error('post.title')
                            <div class="text-red-500 text-sm mt-2">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        
                        <div class="mt-4">
                            <label for="start_at">{{ __('Start Time') }}</label>
                            <input name="post[start_at]" id="start_at" type="datetime-local" min="2023-10-01T12:00" class="mt-1 block w-full py-2 px-3 border-2 bg-gray-100 rounded-lg shadow-sm focus:outline-none sm:text-sm @error('start_at') border-red-500 @enderror"/>
                            
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
                            <div class="text-red-500 text-sm mt-2">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        
                        
                        
                        <!-- lectures Select-Box -->
                        <div class="mt-4 grid grid-cols-12 gap-2">
                            <label for="lecture" class="col-span-6">{{ __('Lecture') }}</label>
                            <label for="searchbox" class="col-span-6">{{ __('Search') }}</label>
                            <select name="post[lecture_id]" id="lecture" class="col-span-6 flex py-2 border-2 bg-gray-100 rounded-lg shadow-sm focus:outline-none sm:text-sm"> </select>
                            <input type="text" id="searchbox" class="col-span-4 py-2 border-2 flex bg-gray-100 rounded-lg shadow-sm focus:outline-none sm:text-sm">
                            <input type="button" id="search" value="{{ __('Search') }}" class="col-span-2 btn py-2 flex-initial text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        </div>
                        {{--
                        <div class="mt-2 flex flex-row space-x-4 justify-center">
                            <div class="mt-1 w-48 flex-initial min-w-0 bg-gray-400">
                             <!--検索入力フォーム -->
                                <label for="searchbox">{{ __('Search') }}</label>
                                <input type="text" id="searchbox" class="py-2 border-2 flex-initial bg-gray-100 rounded-lg shadow-sm focus:outline-none sm:text-sm">
                            </div>
                             <!--検索ボタン・リセットボタン -->
                            <div class="mt-8 w-16 flex-initial min-w-0 bg-gray-400">
                                <label for="search"></label>
                                <input type="button" id="search" value="{{ __('Search') }}" class="btn py-2 flex-initial text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <!--<input type="button" id="reset" value="リセット" class="btn w-30 mt-7 py-2 px-3 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">-->
                            </div>
                        </div>
                        --}}
                        
                        <div class="mt-4">
                            {{--<label for="tag">{{ __('Major') }}</label>--}}
                            <label for="tag">{{ __('Classification') }}</label>
                            <select name="post[tag_id]" id="tag" class="mt-1 block w-full py-2 px-3 border-2 bg-gray-100 rounded-lg shadow-sm focus:outline-none sm:text-sm @error('start_at') border-red-500 @enderror">
                            <!--<select name="post[tag_id]" id="lecture" class="select_search">-->
                                <option value="" selected>{{ __('Select') }}</option>
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mt-4">
                          <label for="body">{{ __('Comment') }}</label>
                          <textarea name="post[body]" id="body" cols="30" rows="4" class="w-full rounded-lg border-2 bg-gray-100 @error('comment') border-red-500 @enderror"
                          placeholder="今回のレポートは～です!">{{ old('post.body') }}</textarea>
                          
                          @error('post.body')
                          <div class="text-red-500 text-sm mt-2">
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
                            <input type="submit" value="{{ __('Submit') }}" class="btn bg-blue-500 rounded font-medium px-4 py-2 text-white"/>
                        </div>
                        
                        <!--@if ($errors->any())-->
                        <!--    <div>-->
                        <!--        <ul>-->
                        <!--            @foreach ($errors->all() as $error)-->
                        <!--                <li>{{ $error }}</li>-->
                        <!--            @endforeach-->
                        <!--        </ul>-->
                        <!--    </div>-->
                        <!--@endif-->
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
    
    // 選択肢・Optionの作成と追加を実行する関数
    function OptionCreator (selectPrefBox, optionList, optGroupList) {
        
        optionList.forEach((opt, index) => {
    
        // 1. 最初は、<option value="">選択してください</option> を作成する
        if (index == 0) {
            let option = document.createElement('option');
            option.setAttribute('value', '');
            option.innerText = '選択してください';
            selectPrefBox.appendChild(option);
        }
    
        let option = document.createElement('option');
        option.setAttribute('value', opt.id);
        option.innerText = opt.value;
    
        let groupId = opt.groupId;
    
        let belongToGroup = document.getElementById(`${groupId}`);
    
        // 所属するoptgroupがなかったら、追加する
        if (belongToGroup == null) {
    
            const belong = optGroupList.find(group => group.id == groupId);
    
            selectPrefBox.appendChild(belong);
    
            belongToGroup = document.getElementById(`${groupId}`); // 再度、取得する
        }
    
        belongToGroup.appendChild(option);
    
        });
    }
    
    function NoMatchOption (selectPrefBox) {
        let option = document.createElement('option');
        option.setAttribute('value', '');
        option.innerText = '検索に該当はありません';
        selectPrefBox.appendChild(option);
    }
    
    // SelectBoxを作成する関数
    function SelectCreator (selectPrefBox, optionList, optGroup, searchList, searchBool) {
    
        if (optionList.length == 0) return;
    
        selectPrefBox.innerHTML = ''; // 初期化処理
    
        // 1. グループ・カテゴリを作成する
        // optgroupタグを作成 => グループカテゴリを作成する
        const optGroupList = optGroup.map((group) => {
            let optgroup = document.createElement('optgroup');
            optgroup.setAttribute('id', group.id);
            optgroup.setAttribute('label', group.value);
            return optgroup;
        });
        
        // 2. 選択肢・Optionの作成と追加
        if (searchList.length !== 0 && searchBool) OptionCreator(selectPrefBox, searchList, optGroupList);
        else if (!searchBool) OptionCreator(selectPrefBox, optionList, optGroupList);
        else NoMatchOption(selectPrefBox);
    }
    
    
    // [ 1. Serverから受信した optionData から動的に SelectBoxを作成する ]
    
    // 1-1. Serverから受信した、DataSet
    const optionData = @json($lectures);
    console.log(optionData)
    
    
    // 1-2. Group-配列 => {id: 'group_1', value: '北海道'}[]
    const optGroup = [];
    
    let groupCount = 1;
    let groupId = '';
    
    // 1-3. 47都道府県データに、groupを紐づける
    // {id: 1, value: '北海道', groupId: 'group_1'}[]
    const optionCustom = optionData.filter((opt, index) => {
    
        // グループ・データなら、加工して、optGroupに投入する
        if (/^group@/.test(opt.value)) {
            groupId = `group_${groupCount}`;
            groupCount++;
            opt.id = groupId;
            opt.value = opt.value.replace("group@", "");
            optGroup.push(opt);
        } else {
            opt.groupId = groupId;
            return opt;
        }
    });
    
    // console.log({optionCustom});
    
    // console.log({optGroup});
    
    // 1-4. SelectBoxを取得する
    let selectPrefBox = document.getElementById('lecture');
    
    // 1-5. 初期のSelectBoxを作成する
    SelectCreator(selectPrefBox, optionCustom, optGroup, [], false);
    
    
    // [ 2. 検索で、動的にSelectBoxを再作成する  ]
    
    // 2-1. 検索のための入力フォームを取得する
    const searchbox = document.getElementById('searchbox');
    
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
    
    // 2-4. 検索ボタン
    let searchBtn = document.getElementById('search');
    
    // 2-5. 検索ボタンに、clickイベントを追加する
    // searchResultで SelectBoxを作成する
    search.onclick = () => SelectCreator(selectPrefBox, optionCustom, optGroup, searchResult, true);

    // [ 3. SelectBoxで選択したものは、画面に表示される => 複数選択が可能である ]
    
    // 3-1. 選択中のものを表示するInput-Boxを取得する
    let dispDiv = document.getElementById('disp-select');
    
    // 3-2. SelectBoxに changeイベントを追加する
    selectPrefBox.addEventListener('change', (e) => {
    
        // 選択してくださいは、弾く！
        if (!e.target.value) return;
    
        // 1. 上限を5つまでにして、それ以上は、弾く！
        if (6 <= dispDiv.childElementCount + 1) {
            alert('選択できる数は、5つまでです');
            return;
        }
    
        // 2. valueにidを付与している
        const id = Number(e.target.value);
    
        // 3. 選択済みの都道府県は、弾く！
        const idList = [...dispDiv.children].map(btn => btn.id);
    
        //console.log({idList});
    
        if (idList.some(i => Number(i) == id)) {
            alert('選択済みです');
            return;
        }
    
        // 4. 該当の optionデータを取得する
        const option = optionCustom.find(opt => opt.id === id);
        //console.log(option);
    
        // 5. input-btn を作成して、optionのデータを紐付ける
        let input = document.createElement('input');
        input.setAttribute('type', 'button');
        input.setAttribute('id', option.id);
        input.setAttribute('value', option.value);
        input.classList.add('btn');
    
        // 6. 選択を解除する機能を作成した input-btn に付与する
        input.onclick = e => dispDiv.removeChild(e.target);
    
        // 7. 選択されたoptionを input-btnとして画面に表示する
        dispDiv.appendChild(input);
    
    });
    
    // [ 4. 検索状態をResetする機能を作成する ]
    
    // 4-1. 検索・リセットボタンを取得する
    let resetBtn = document.getElementById('reset');
    
    // 4-2. 検索・リセットボタンに、clickイベントを追加する
    // SelectBoxの optionをリセットする
    resetBtn.onclick = () => SelectCreator(selectPrefBox, optionCustom, optGroup, [], false);
    
    </script>
</x-app-layout>

