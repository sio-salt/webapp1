<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Lecture;
use App\Models\Tag;
use App\Http\Requests\PostRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Post一覧を表示
 *
 * @param Post Postモデル
 * @return array Postモデルリスト
 */

class PostController extends Controller
{
    
    public function __construct()
    {
        $this->middleware(['auth', 'verified'])->only(['participate', 'unparticipate']);
    }
    
    
    public function recentPost(Post $post)
    {
        $posts = $post->getPaginateByLimit();
        Carbon::setLocale('ja');
        foreach ($posts as $post) {
            // 各ポストの開始日時をフォーマット
            $post->start_at = Carbon::parse($post->start_at)->isoFormat('M月D日(dd) H:mm');
            
            // それぞれの役割の人が何人いるかを数える
            $participations = array('participate' => 0, 'participate_likely' => 0, 'participate_as_mentor' => 0);
            $participations['participate'] = $post->userParticipations->where('role', 0)->count();
            $participations['participate_likely'] = $post->userParticipations->where('role', 1)->count();
            $participations['participate_as_mentor'] = $post->userParticipations->where('role', 2)->count();
            // 各postに$participations配列を追加
            $post->participations = $participations;
        }
    
        // index bladeに取得したデータを渡す
        return view('posts.recent_post')->with([
          'posts' => $posts,
        ]);
    }
    
    
    public function tagSearch(Post $post, Lecture $lecture, Tag $tag, Request $request)
    {
        $tag_query = $request->query('tag');
        $lec_query = $request->query('lecture');
        if (is_null($tag_query) && is_null($lec_query)) {
            $posts = collect();
        }
        else {
            $posts = $post->getPaginateByLimitWithTagLecture($tag_query, $lec_query);
            Carbon::setLocale('ja');
            foreach ($posts as $post) {
                // 各ポストの開始日時をフォーマット
                $post->start_at = Carbon::parse($post->start_at)->isoFormat('M月D日(dd) H:mm');
                
                // それぞれの役割の人が何人いるかを数える
                $participations = array('participate' => 0, 'participate_likely' => 0, 'participate_as_mentor' => 0);
                $participations['participate'] = $post->userParticipations->where('role', 0)->count();
                $participations['participate_likely'] = $post->userParticipations->where('role', 1)->count();
                $participations['participate_as_mentor'] = $post->userParticipations->where('role', 2)->count();
                // 各postに$participations配列を追加
                $post->participations = $participations;
            }
        }
        
        $lectures = $lecture->get();
        $lec_id_name = [];
        // $lec_id_name[] = ['id' => null, 'value' => 'group@講義'];
        foreach($lectures as $lec) {
            $lec_id_name[] = ['id' => $lec->id, 'value' => $lec->name];
        }
        $tags = $tag->get();
        $tag_id_name = [];
        foreach($tags as $ta) {
            $tag_id_name[] = ['id' => $ta->id, 'value' => $ta->name];
        }
        return view('posts.tag-search')->with([
            'posts' => $posts,
            'lectures' => $lec_id_name,
            'tags' => $tag_id_name,
        ]);
    }
    
    
    public function create(Lecture $lecture, Tag $tag)
    {
        $lectures = $lecture->get();
        $lec_id_name = [];
        // $lec_id_name[] = ['id' => null, 'value' => 'group@講義'];
        foreach($lectures as $lec) {
            $lec_id_name[] = ['id' => $lec->id, 'value' => $lec->name];
        }
        $tags = $tag->get();
        $tag_id_name = [];
        foreach($tags as $ta) {
            $tag_id_name[] = ['id' => $ta->id, 'value' => $ta->name];
        }
        return view('posts.create')->with([
            'lectures' => $lec_id_name,
            'tags' => $tag_id_name,
        ]);
    }
    
    
    public function store(PostRequest $request)
    {
        DB::transaction(function () use ($request) {
            $user = auth()->user();
            if (empty($request['tag']['name'])) {
                //
            }
            else {
                $tag = new Tag;
                $tag->fill($request['tag']);
                $tag->save();
            }
            
            $post = new Post;
            $post->fill($request['post']);
            $post->user_id = $user->id;
            $post->faculty_id = $user->faculty_id;
            $post->save();
            $post->lectures()->attach($post->lecture_id);
            $post->tags()->attach($post->tag_id);
            $user->posts()->attach($post->id, ['role' => '0']);
        });
        
        return redirect()->route("recent_post");
    }
    
    
    public function updatePost(PostRequest $request, Post $post, Lecture $lecture, Tag $tag)
    {
        DB::transaction(function () use ($request, $post) {
            $user = auth()->user();
            if (empty($request['tag']['name'])) {
                //
            }
            else {
                $tag->fill($request['tag']);
                $tag->save();
            }
            
            $post->fill($request['post']);
            $post->user_id = $user->id;
            // $post->faculty_id = $user->faculty_id;
            $post->save();
            $post->lectures()->sync($post->lecture_id);
            $post->tags()->sync($post->tag_id);
        });
        
        return redirect()->route("recent_post");
    }
    
    public function deletePost (Post $post) {
        $post->delete();
        return redirect('/posts');
    }
    
    public function editPost (Post $post, Lecture $lecture, Tag $tag) {
        $lectures = $lecture->get();
        $lec_id_name = [];
        foreach($lectures as $lec) {
            $lec_id_name[] = ['id' => $lec->id, 'value' => $lec->name];
        }
        $tags = $tag->get();
        $tag_id_name = [];
        foreach($tags as $ta) {
            $tag_id_name[] = ['id' => $ta->id, 'value' => $ta->name];
        }
        return view('posts.edit_post')->with([
            'post' => $post,
            'lectures' => $lec_id_name,
            'tags' => $tag_id_name,
        ]);
    }
    
    public function participate (Post $post, Request $request) {
        $user = auth()->user();
        $post->participate_as_role($request->input('role'));
        // dd($request->query('page'));
        // return redirect('/posts');
        return redirect(url()->previous() . http_build_query(request()->query()));
    }
    
    public function unparticipate (Post $post, Request $request) {
        $user = auth()->user();
        $post->unparticipate($request->input('role'));
        return redirect('/posts');
    }
    
}
