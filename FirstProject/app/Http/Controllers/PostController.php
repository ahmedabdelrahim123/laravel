<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $allPosts = Post::paginate(2); //select * from posts

        return view('post.index', ['posts' => $allPosts]);
    }

    public function show($id)
    {
//        $post = Post::find($id); //select * from posts where id = 1 limit 1;

        $postCollection = Post::where('id', $id)->get(); //Collection object .... select * from posts where id = 1;

        $post = Post::where('id', $id)->first(); //Post model object ... select * from posts where id = 1 limit 1;

//        Post::where('title', 'Laravel')->first();

        return view('post.show', ['post' => $post]);
    }

    public function create()
    {
        $users = User::all();

        return view('post.create', ['users' => $users]);
    }

    public function store(StorePostRequest $request)
    {

        $title = request()->title;
        $description = request()->description;
        $postCreator = request()->post_creator;

        //insert the form data in the database
        Post::create([
            'title' => $title,
            'description' => $description,
            'user_id' => $postCreator,
        ]);

        //redirect to index route
        return to_route('posts.index');
    }

 public function edit($id){
    $users = User::all();
    $post = Post::find($id);
    // dd($post);   
    return view('post.edit',['post' => $post],['users' => $users]); }   


public function update(Request $request,$id){
    Post::find($id)->update([
        'title' => request('title'),
        'description' => request('description')
    ]);
    return to_route('posts.index');
}


public function destroy($id)
{
    $post = Post::find($id);
    $post->delete();

    return redirect()->route('posts.index')
                     ->with('success', 'Post deleted successfully.');
}}