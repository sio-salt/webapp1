<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function lectures()
    {
        return $this->hasMany(Lecture::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
