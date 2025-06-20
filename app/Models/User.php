<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    const ADMIN_ROLE_ID = 1;
    const USER_ROLE_ID = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    #To get all the posts of a user
    public function posts()
    {
        return $this->hasMany(Post::class)->latest();
    }


    /**** hasMany(A, B) の引数の意味 *********
     * A（第1引数） - 関連するモデルクラス名（対象となる「多数」側） - 例）Follow::classなど
     * B（第2引数） - 相手のテーブルにある外部キーカラム名- 例）'following_id'など
     */

    # To get all the followers of a user
    public function followers()
    {
        // hasMany:この場合の 'following_id' は「相手テーブル（follows）にある外部キー」です。
        // 仕組み（SQL的に見ると）
        // SELECT * FROM follows WHERE follows.following_id = users.id;
        return $this->hasMany(Follow::class, 'following_id');
        /*** このリレーションの意味 ***
         * users.id と follows.following_id を一致させて
         * 該当する Follows の一覧を取得する
         */
    }

    # To get all the users that the user is following
    public function following()
    {
        return $this->hasMany(Follow::class, 'follower_id');
    }


    public function isFollowed()
    {
        return $this->followers()->where('follower_id', Auth::user()->id)->exists();
        // Auth::user()->id is the follower_id
        // Firstly, get all the followers of the user($this->followers()). Then, from that list, search for the auth user
        // from the follower column.
    }
}
