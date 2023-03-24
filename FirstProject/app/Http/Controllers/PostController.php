<?php

namespace App\Http\Controllers;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use App\Http\Requests\StorePostRequest;
use App\Jobs\PruneOldPostsJobs;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Str;


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
         
        // $file_name = $this->saveImage($request->image, 'images/imgpost');
        $path = Storage::putFile('public', $request->file('image'));
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $path = Storage::putFileAs('public/posts', $image, $filename);
        }
        $slug = SlugService::createSlug(Post::class, 'slug', request()->title);
        //insert the form data in the database
        Post::create([

            'title' => $slug ?? $title,
            'description' => $description,
            'user_id' => $postCreator,
            'image' => $path
        ]);
       
        //redirect to index route
        return to_route('posts.index');
    }
  

 public function edit($id){
    $users = User::all();
    $post = Post::find($id);
    // dd($post);   
    return view('post.edit',['post' => $post],['users' => $users]); }   

    public function removeOldPosts()
    {
        // dispatch(new PruneOldPostsJob);

        PruneOldPostsJobs::dispatch();

        return to_route('posts.index');
    }
public function update(StorePostRequest $request ,$id){
    $post=Post::find($id);
    $title= request()->title;
    $description=request()->description;
    $postCreator=request()->post_creator;

    $path = Storage::putFile('public', $request->file('image'));
        
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $filename = $image->getClientOriginalName();
        $path = Storage::putFileAs('public/posts', $image, $filename);
        $post->image = $path;
    }

    if ($post->title!=$title){
        $post->title=$title;
    }if($post->description!=$description){
        $post->description=$description;
    }if($post->user_id!=$postCreator){
        $post->user_id=$postCreator;
    }

    $post->save();
    return redirect()->back();
}



public function destroy($id)
{
    $post = Post::find($id);
    $post->delete();

    return redirect()->route('posts.index')
                     ->with('success', 'Post deleted successfully.');
}}