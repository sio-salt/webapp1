<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'faculty_id',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
