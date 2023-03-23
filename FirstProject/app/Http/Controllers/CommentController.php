<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store($id)
    {
        $post=Post::find($id);

        $comment = new Comment();

        $comment->body=Request()->body;

        $post->Comments()->save($comment);
        return back();
    }

    public function destroy($id)
    {
        $comment= Comment::find($id);
        $comment->delete();
        $post_id=$comment->commentable->id;
        return to_route('posts.show', $post_id);
    }

    public function update(Request $request,$id)
    {
        $comment=Comment::find($id);

        if($comment->body != $request->body)
            $comment->body= $request->body;

        $post_id=$comment->commentable->id;

        $comment->save();

        return to_route('posts.show', $post_id);

    }
}