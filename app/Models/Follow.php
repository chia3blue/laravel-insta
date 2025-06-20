<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/****** このモデルの役割 **********
* この Follow モデルは、「誰が誰をフォローしているか」を記録するための中間テーブル（follows テーブル）に対応しています。
* 「ユーザーがユーザーをフォローする」関係を表現。
* follower() と following() は、ユーザー情報にアクセスするための関係定義。*/
class Follow extends Model
{
    /**** $timestamps = false; *******
    * Laravel の Eloquent モデルは、デフォルトで created_at と updated_at カラムを自動的に更新・管理します。
    * $timestamps = false を指定することで、それを無効化します。
    * つまり、このモデルでは、作成日時や更新日時の自動保存は行われません。
    * これを行わないと以下のようにエラーが出る可能性がある。
    * デフォルトで Laravel はそれらのカラムcreated_at / updated_atが存在するものとみなして SQL を作る。
    * そのため、INSERT や UPDATE 時に SQL エラーになる可能性がある. */
    public $timestamps = false;


    /**** belongsTo(A, B) の引数の意味 *********
     * A（第1引数） - 関連先のモデルクラス名（フルクラス名 or クラス） - 例）User::classなど
     * B（第2引数） - 外部キーのカラム名（このモデル内にある）- 例）'follower_id'など
     */

    #To get the info of a follower - followerの（User情報）を取得する
    /* 誰がフォローしているかを取得する。
    * 例：$follow->follower → follower_idに対応するUser（例：Alice） */
    public function follower()
    {
        // belongsTo:この follws テーブルにある外部キー(follower_id)
        // 仕組み（SQL的に見ると）
        // SELECT * FROM users WHERE users.id = follows.follower_id;
        return $this->belongsTo(User::class, 'follower_id')->withTrashed();
    }

    # To get the info of the user being followed
    /* 誰をフォローしているかを取得する。
    * 例：$follow->following → following_idに対応するUser（例：Bob）
    * このコードは、「このFollowモデルのfollowing_idカラムに対応するUserを取得してね」という意味です。*/
    public function following()
    {
        return $this->belongsTo(User::class, 'following_id')->withTrashed();
    }
}
