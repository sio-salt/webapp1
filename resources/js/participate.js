$(function() {
    let $pushed_participation_btn = $("[data-role]");
    let post_id;
    let role;
    $pushed_participation_btn.on('click', function(event) {
        event.preventDefault();  // デフォルトの送信動作をキャンセル
        let $this = $(this);
        post_id = $this.data('post-id'); //post-card.blade.phpのbuttonタグのdata-post-idの値を取得
        role = parseInt($this.data('role'));
        $.ajax({
            headers: {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },
            url: '/posts/' + post_id + '/toggle_participation',
            method: 'POST',
            data: { //サーバーに送信するデータ
                'post_id': post_id, //投稿のidを送る
                'role': role,
            },
        })
        //通信成功した時の処理
        .done(function (data) {
            let which_checked = data.which_checked;
            let role_mapping = ['participate', 'participate_likely', 'participate_as_mentor'];
            let comment_mapping = ['参加します!', '参加するかも', 'メンターとして参加'];
            let new_participation_counts = data.new_participation_counts;
            
            for (let i = 0; i < 3; i++) {
                let $btn = $("[data-role='" + i + "'][data-post-id='" + post_id + "']");
                let btn_role = $btn.data('role');
                console.log(btn_role, i);
                let buttonText = comment_mapping[btn_role] + " &nbsp;&nbsp; " + new_participation_counts[role_mapping[btn_role]];
                $btn.html(buttonText);
                if (which_checked[i] || i === role) {
                    $btn.toggleClass("border-black border-4 border-blue-400 focus:ring focus:border-blue-100 focus:ring-blue-400"); // ボタンが押されている状態と押されていない状態の入れ換え
                }
            }
        })
        //通信失敗した時の処理
        .fail(function () {
          console.log('fail');
        });
    })
});

