<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;
use Illuminate\Database\Query\Processors\PostgresProcessor;

class PostController extends Controller
{
    public function index()
    {
        $allPosts=Post::with('user')->paginate(3);
        // $response=[];
        // foreach($allPosts as $post){
        //     $response []=[
        //         'id'=> $post->id,
        //         'title'=>$post->title,
        //         'description'=>$post->description,
        //     ];
        // }
        return PostResource::collection($allPosts);
    }

    public function show($id)
    {
        $post = Post::find($id);
        // return [
        //    'id'=> $post->id,
        //     'title'=>$post->title,
        //     'description'=>$post->description,

        // ];
        return new PostResource($post);
    }

    public function store(Request $request)
    {
        $post = Post::create([
            'title' =>  $request->title,
            'description' => $request->description,
            'user_id' => $request->post_creator,
            'slug'=>$request->slug,
        ]);


        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $path = Storage::putFileAs('public/posts', $image, $filename);
            $post->image = $path;
            $post->save();
        }
        // return [
        //     'id'=> $post->id,
        //      'title'=>$post->title,
        //      'description'=>$post->description,

        //  ];
        return new PostResource($post);
    }
}