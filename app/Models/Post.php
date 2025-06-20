<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
// activity
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{

    // activity
    use SoftDeletes;


    # A post belongs to user
    # To get the owner of the post
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    #To get categories under a post
    public function categoryPost()
    {
        return $this->hasMany(CategoryPost::class);
    }

    # To get all the comments of a post
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    # To get the likes of a post
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    # Returns TRUE if the Auth user already liked the post
    public function isLiked()
    {
        return $this->likes()->where('user_id', Auth::user()->id)->exists();
    }
}
