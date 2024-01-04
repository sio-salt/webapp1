<h1 align="left"><a href="https://ym-study-group-4371b65c8ce9.herokuapp.com/"> 
ym-study-group ・ 山形大学 勉強会 掲示板</a></h1>

> Online bulletin board exclusively for Yamagata University students to host study groups

大学の勉強って難しいのにみんなで取り組むことって少ないですよね。自由参加の勉強会を開いて学生間で教え合いませんか?

**Link** ： https://ym-study-group-4371b65c8ce9.herokuapp.com/


### :desktop_computer: PC
<img width="960" alt="スクリーンショット 2023-11-23 231533" src="https://github.com/sio-salt/ym-study-group/assets/105919668/464c1640-006d-4584-b949-d4dc000f483d">  
<br></br>
<img width="642" alt="image" src="https://github.com/sio-salt/ym-study-group/assets/105919668/dc0cb01f-fcec-4a68-b0a4-bef212d0c41b">


### :iphone: Smartphone
<img width="300" alt="IMG_0800" src="https://github.com/sio-salt/ym-study-group/assets/105919668/6f220c27-0970-477e-be91-a086cf10f031">



## :star: Main Feature
- 投稿の閲覧
    - ログインなしに開かれている勉強会をチェックできます。
- 投稿のタグ検索
    - 気になる講義やジャンルの投稿に絞り込んで表示できます。
    - タグ検索ページ、もしくはタグのクリックから絞り込み検索。
- 新規投稿 （ログイン必須）
    - タイトル、勉強会開始時刻、実施会場、講義タグ、フリータグ、コメントを付けて投稿できます。
    - 講義タグはすでに登録してある山形大学のほぼ全ての講義から選択できます。
    - 投稿後に編集と削除が可能です。
- 参加表明 （ログイン必須）
    - 投稿の参加ボタンを押してホストに参加意思を表明できます。
- ページネーション


## 使用技術
**フロントエンド**
- HTML
- Tailwind CSS
- JavaScript

**バックエンド**
- PHP 8.2.12
- Laravel 9.52.16
- JawsDB MySQL (本番環境)
- MariaDB MySQL (開発環境)
- composer

**インフラ**
- AWS (EC2, IAM) (開発環境)
- HEROKU

**その他**
- Git / GitHub


## ER図
![lev成果物ER図 drawio (1)](https://github.com/sio-salt/ym-study-group/assets/105919668/292c94a8-3fcd-4ab5-8b52-a79f9353c563)


## アプリケーション概要・作成背景
 このアプリケーションは特定の講義や分野について勉強する際に、自由参加の勉強会として場所と時間、勉強内容を含めて投稿をすることで生徒間で勉強を教え合う文化を創生することを目指したものです。山形大学の学生向けに特化しており、大学の全講義をデータベースに登録してあります。

 大学では高校までのようにクラスが無いため、自分の友人グループ以外とは関係が希薄で、生徒間で勉強を教え合う文化はあまりありません。しかし、大学の講義内容は高度であり、成績の良い人から教えてもらうことが非常に助けになります。そこで、自分が大学で特定の勉強をしているときにそれを自由参加の勉強会として掲示板に投稿するアプリケーションを作成すれば、友人グループで固まることなく広く生徒間で勉強を助け合う文化を作れるのではないかと考えました。



## Author
- 加藤 勇有
- 山形大学理工学研究科
- saltinthedesertyou@gmail.com


## Future Plans
- アカウントページの充実化。
- Google、X（旧Twitter）等を用いたログイン。
- ヘルプページの作成。
- 参加表明ボタンの非同期通信化。
- 画像付き投稿機能。
- 勉強会開始時刻での空き教室のサジェスト。
- 現在、過去に受けた講義の登録と学期末の自動変更。
- 投稿スレッドへのコメント機能。
- アカウントへのDM機能。
- 気になる講義の登録、その講義に関する投稿時の通知。
- 年度更新時に大学で追加、名称変更された講義の自動DB追加。
- 勉強会の参加記録に応じたポイント付与。
