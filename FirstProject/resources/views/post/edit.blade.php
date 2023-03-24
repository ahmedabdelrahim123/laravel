@extends('layouts.app')

@section('title')
    edit
@endsection

@section('content')
@if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{route('posts.update', $post->id)}}" enctype="multipart/form-data">
        @csrf
        @method('PUT');
    
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Title</label>
            <input name="title" type="text" class="form-control" id="exampleFormControlInput1" value="{{$post['title']}}" >
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Description</label>
            <textarea name="description" class="form-control" id="exampleFormControlTextarea1" rows="3">{{$post['description']}}</textarea>
        </div>

        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Post Creator</label>
            <select name="post_creator" class="form-control">
            @foreach($users as $user)
                    <option value="{{$user->id}}">{{$user->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Post Image</label>
            <input type="file" name="image" class="form-control" id="exampleFormControlTextarea1" >
            @if($post->image)
            <img src="{{Storage::url($post->image)}}" width="250px"   alt="{{$post->image}}">
            @endif
        </div>
        <button class="btn btn-success">Update</button>
    </form>
@endsection