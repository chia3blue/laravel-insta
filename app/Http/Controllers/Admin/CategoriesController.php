<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;

class CategoriesController extends Controller
{
    private $category;
    private $post;


    public function __construct(Category $category, Post $post)
    {
        $this->category = $category;
        $this->post = $post;
    }

    public function index()
    {
        $all_categories = $this->category->orderBy('updated_at', 'desc')->paginate(10);
        // $categories_count = $this->category->count();

        $uncategorized_count = 0;
        $all_posts = $this->post->all();
        foreach($all_posts as $post){
            if($post->categoryPost->count() == 0){
                $uncategorized_count ++;
            }
        }

        return view('admin.categories.index')->with('all_categories', $all_categories)->with('uncategorized_count', $uncategorized_count);
    }

    //activity
    public function store(Request $request)
    {
        // validation
        $request->validate([
            'name' => 'required|min:1|max:50|unique:categories,name'
        ]);

        $this->category->name = ucwords(strtolower($request->name));
        $this->category->save();

        return redirect()->back();
    }

    // activity
    public function update(Request $request, $id)
    {
        $category = $this->category->findOrFail($id);
        
        // unique:categories,name,{$category->id} の部分で、同じ名前でも「今編集中のレコード」ならバリデーションOKになるようにしています。
        // $request->validate([
        //     'name' => 'required|min:1|max:50|unique:categories,name,' . $category->id,
        // ]);
        $request->validate([
            'name' => 'required|min:1|max:50|unique:categories,name,' . $id,
        ]);

        $category->name = ucwords(strtolower($request->name));
        $category->save();

        return redirect()->back();
    }

    //activity
    public function destroy($id)
    {
        $this->category->destroy($id);

        return redirect()->back();
    }

}
