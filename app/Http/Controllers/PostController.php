<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Carbon\Carbon;

/**
 * Post一覧を表示
 *
 * @param Post Postモデル
 * @return array Postモデルリスト
 */

class PostController extends Controller
{
    public function recentPost(Post $post)
    {
        $posts = $post->getPaginateByLimit();
        Carbon::setLocale('ja');
        foreach ($posts as $post) {
            // 各ポストの開始日時をフォーマット
            $post->start_at = Carbon::parse($post->start_at)->isoFormat('M月D日(dd) H:mm');
            
            foreach ($post->userParticipations as $userParticipation) {
                $participations = array('participate' => 0, 'participate_likely' => 0, 'participate_as_mentor' => 0);
                if ($userParticipation->role == 0) {
                    $participations['participate'] += 1;
                } 
                elseif ($userParticipation->role == 1) {
                    $participations['participate_likely'] += 1;
                } 
                elseif ($userParticipation->role == 2) {
                    $participations['participate_as_mentor'] += 1;
                }
            }
            // 各postに$participations配列を追加
            $post->participations = $participations;
        }
    
        // index bladeに取得したデータを渡す
        return view('posts.recent_post')->with([
          'posts' => $posts,
        ]);
    }

}
