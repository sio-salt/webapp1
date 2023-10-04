<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'lecture_id',
        'major_id',
        'faculty_id',
        'start_at',
        'place',
        'body',
        'image_url',
        'teacher_welcome',
    ];

    public function getPaginateByLimit (int $limit_count = 20)
    {
        return $this->orderBy('created_at', 'DESC')->paginate($limit_count);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
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

    public function majors()
    {
        return $this->belongsToMany(Major::class);
    }
}
