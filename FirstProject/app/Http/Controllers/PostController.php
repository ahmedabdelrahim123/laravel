<?php

namespace App\Http\Controllers;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use App\Http\Requests\StorePostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Str;
use App\Jobs\PruneOldPostsJobs;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\WhitespacePathNormalizer;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;

class PostController extends Controller
{
    public function index()
    {
        $allPosts= Post::paginate(10);
        PruneOldPostsJobs::dispatch();
        return view("post.index", ["posts"=>$allPosts]);
    }

    public function removeOldPosts()
    {
        PruneOldPostsJobs::dispatch();
        return to_route('posts.index');
    }

    public function show($id)
    {
        $post=Post::where('id', $id)->first();
        return view("post.show", ["post"=>$post]);
    }

    public function create()
    {
        $users=User::all();
        return view("post.create", ['users' => $users]);
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


    public function edit($id)
    {
        $post = DB::table('posts')->where('id', $id)->first();
        $users=User::all();
        return view("post.edit")->with('post', $post)->with('users', $users);
    }

    public function update(UpdatePostRequest $request, $id)
    {
    
 

        
            $post = Post::findOrFail($id);
        
            if ($request->hasFile('image')) {
                if ($post->image) {
                    Storage::delete($post->image);
                }
                $image = $request->file('image');
                $filename = $image->getClientOriginalName();
                $path = Storage::putFileAs('public/posts', $image, $filename);
                $post->image = $path;
            }
        
            $post->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'description' => $request->description,
                'user_id' => $request->post_creator,
            ]);
        
 
                $post->save();
               
        return redirect()->route('posts.index');
    }

    public function delete($id)
    {
        $post = Post::find($id);
        if ($post->image && Storage::exists($post->image)) {
            Storage::delete($post->image);
        }
        $post->delete();
        return redirect()->route('posts.index');
    }
}