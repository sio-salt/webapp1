<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Post extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'title',
        'lecture_id',
        'tag_id',
        'faculty_id',
        'start_at',
        'place',
        'body',
        'image_url',
        'teacher_welcome',
    ];
    
    
    public function is_this_role_checked_by_auth_user($role)
    {
        $id = Auth::id();
        
        // userParticipations() にカッコを付けないとエラーになる
        return $this->userParticipations()->where(['user_id' => $id, 'role' => $role])->exists();
    }
    
    public function is_this_post_checked_by_auth_user()
    {
        $id = Auth::id();
        return $this->userParticipations()->where(['user_id' => $id])->exists();
    }
    
    // $roleには0~2の3つの役割が入る
    public function participate_as_role($role)
    {
        if ($this->is_this_role_checked_by_auth_user($role)) {      // check済みなら何もしない
        }
        elseif ($this->is_this_post_checked_by_auth_user()) {       // check済みではなくレコードが存在する場合はレコードのroleを$roleにアップデートする
            $id = Auth::id();
            $this->users()->updateExistingPivot($id, [
                'role' => $role,
            ]);
        }
        else {      // 上記条件以外なら新しくレコードを作成する。
            $user = auth()->user();
            $user->posts()->attach($this->id, ['role' => $role]);
        }
    }

    public function unparticipate($role) {
        if ($this->is_this_role_checked_by_auth_user($role)) {      // チェックを外すとき該当のレコードを削除
            $user = auth()->user();
            $user->posts()->detach($this->id);
        }
    }


    public function getPaginateByLimit (int $limit_count = 20)
    {
        return $this->orderBy('created_at', 'DESC')->paginate($limit_count);
    }
    
    public function getPaginateByLimitWithTagLectureId ($tagId, $lectureId, int $limit_count = 20)
    {
        $query = $this->orderBy('created_at', 'DESC');
        
        if (!is_null($tagId)) {
            $query = $query->whereHas('tags', function ($q) use ($tagId) {
                $q->where('id', $tagId);
            });
        }
        
        if (!is_null($lectureId)) {
            $query = $query->whereHas('lectures', function ($q) use ($lectureId) {
                $q->where('id', $lectureId);
            });
        }
        
        return $query->paginate($limit_count);
    }
    
    public function getPaginateByLimitWithTagLectureName ($tagName, $lectureName, int $limit_count = 20)
    {
        $query = $this->orderBy('created_at', 'DESC');
        
        if (!is_null($tagName)) {
            $query = $query->whereHas('tags', function ($q) use ($tagName) {
                $q->where('name', $tagName);
            });
        }
        
        if (!is_null($lectureName)) {
            $query = $query->whereHas('lectures', function ($q) use ($lectureName) {
                $q->where('name', $lectureName);
            });
        }
        
        return $query->paginate($limit_count);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'post_user_participations')->withPivot('role');
    }
    
    public function userParticipations()
    {
        return $this->hasMany(PostUserParticipation::class);
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function lectures()
    {
        return $this->belongsToMany(Lecture::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
