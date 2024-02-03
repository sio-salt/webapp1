// 選択肢・Optionの作成と追加を実行する関数
function OptionCreator (selectPrefBox, optionList, oldId = -1) {
    
    optionList.forEach((opt, index) => {

        let option = document.createElement('option');
        option.setAttribute('value', opt.id);
        option.setAttribute('data-name', opt.value);
        option.innerText = opt.value;
        option.selected = false;
        if(opt.id === oldId) {
            option.selected = true;
            selectPrefBox.value = opt.value;
        }


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
function SelectCreator (selectPrefBox, optionList, searchList, searchBool, oldId = -1) {

    if (optionList.length == 0) return;

    selectPrefBox.innerHTML = ''; // 初期化処理
    

    // 検索結果の数をセレクトボックスの先頭に追加
    let option = document.createElement('option');
    option.setAttribute('value', '');
    option.innerText = `検索結果：${searchList.length}件`;
    selectPrefBox.appendChild(option);


    // 選択肢・Optionの作成と追加
    if (searchList.length !== 0 && searchBool) OptionCreator(selectPrefBox, searchList, oldId); //searchBoolがtrueならsearchListでoptionを作成する。
    else if (!searchBool) OptionCreator(selectPrefBox, optionList, oldId); //searchBoolがfalseならoptionListでoptionを作成する。
    else NoMatchOption(selectPrefBox);
}


function Filtering (optionCustom, searchStr, searchResult) {
    searchResult = optionCustom.filter((pref) => { // 検索文字列から絞り込む
        if (/^group@/.test(pref.value)) return false;

        // 正規表現で変数を使用するためには、RegExp-Classを使用する
        let reg = new RegExp(`${searchStr}`); // 部分一致

        // 検索文字列のパターンと、登録データがマッチするかでTestをする
        return reg.test(pref.value);
    });
    
    return searchResult;
}


// 1-1. Serverから受信した、DataSet
const lectureOption = window.Laravel.lectures;
const tagOption = window.Laravel.tags;
const oldLectureId = Number(window.Laravel.old_lecture_id);
const oldTagId = Number(window.Laravel.old_tag_id);

const selectBoxesData = [
    {selectId: "lectures", param: 'lecture', data: lectureOption, searchboxId: 'lecsearchbox', searchBtnId: 'lecSearch', oldId: oldLectureId},
    {selectId: 'tags', param: 'tag', data: tagOption, searchboxId: 'tagsearchbox', searchBtnId: 'tagSearch', oldId: oldTagId},
];

// URLのクエリパラメータを取得
let params = new URLSearchParams(window.location.search);


selectBoxesData.forEach((item) => {
    // 1-4. SelectBoxを取得する
    const selectPrefBox = document.getElementById(item.selectId);
    const searchbox = document.getElementById(item.searchboxId);
    
    const optionCustom = item.data;
    let searchStr = ''; // 検索文字列

    const queryParam = Number(params.get(item.param)); // queryParamはidになる。
    // paramが存在していればvalueに設定
    if (queryParam) {
        let foundObject = optionCustom.find(({ id }) => id === queryParam);
        document.getElementById(item.searchboxId).value = foundObject['value'];
        searchStr = foundObject['value'];
    }
 
    // 1-5. 初期のSelectBoxを作成する
    let searchResult = [];
    searchResult = Filtering(optionCustom, searchStr, searchResult);
    SelectCreator(selectPrefBox, optionCustom, searchResult, true, item.oldId);
    
    
    // 2-3. inputイベントで検索の入力文字列を受け取って、検索結果の配列を作成する
    searchbox.addEventListener('input', (e) => {
        
        searchStr = e.target.value; // 検索文字列
        
        searchResult = Filtering(optionCustom, searchStr, searchResult);
        
        // テキストを書き換えたときに自動でfiltering
        if (searchResult.length === 1) {
            const oneId = searchResult[0]['id'];
            SelectCreator(selectPrefBox, optionCustom, searchResult, true, oneId);
        }
        else {
            SelectCreator(selectPrefBox, optionCustom, searchResult, true);
        }
    });
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
        
        // data-name属性が入力されたタグ名と一致する<option>要素を探す
        let matchingOption = Array.from(selectPrefBox2.options).find(opt => opt.dataset.name === value);
        
        if (matchingOption) {
            // 一致する<option>要素が見つかった場合、そのvalue属性の値を<select>タグのvalue属性に設定
            selectPrefBox2.value = matchingOption.value;
        }
        
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
        selectPrefBox2.options[id].selected = true;

        
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

