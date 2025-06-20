<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class HomeController extends Controller
{
    private $post;
    private $user;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Post $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $all_posts = $this->post->latest()->get();
        // 自分のpostsと、followingしている人のpostsのみ表示する。
        $home_posts = $this->getHomePosts();

        $suggested_users = $this->getSuggestedUsers();

        // return view('users.home')->with('all_posts', $all_posts);
        return view('users.home')->with('home_posts', $home_posts)->with('suggested_users', $suggested_users);
    }

    # Get the post of the users that the Auth user is following
    private function getHomePosts()
    {
        $all_posts = $this->post->latest()->get();
        $home_posts = []; // In case the $home_posts is empty, it will not rerturn null, but empty instesd

        foreach($all_posts as $post)
        {
            if($post->user->isFollowed() || $post->user->id === Auth::user()->id){
                $home_posts[] = $post;
            }
        }

        return $home_posts;
    }


    # Get the users that the Auth user is not following
    private function getSuggestedUsers()
    {
        $all_users = $this->user->all()->except(Auth::user()->id);
        $suggested_users = [];

        foreach($all_users as $user)
        {
            if(!$user->isFollowed()){
                $suggested_users[] = $user;
            }
        }

        return array_slice($suggested_users, 0, 5);
        // array_slice(x,y,z)
        // x - array_name
        // y - offset/ index number
        // z - length/ how many
    }

    public function search(Request $request)
    {
        $users = $this->user->where('name', 'like', '%' . $request->search . '%')->get();
        return view('users.search')->with('users', $users)->with('search', $request->search);
    }
}
