
window.onload = function() {
    const lectureOption = JSON.parse(document.getElementById('lectureOption').textContent);
    console.log(lectureOption);
    const tagOption = JSON.parse(document.getElementById('tagOption').textContent);
    console.log(tagOption);
}


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

