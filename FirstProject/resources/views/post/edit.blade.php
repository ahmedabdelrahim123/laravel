@extends('layouts.app')

@section('title') edit @endsection

@section('content')


<div class="container">
  @if ($errors->any())
  <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
  </div>
@endif
    <div class="mb-3">
        <form   method="post" action="{{route('posts.update',$post->id)}}" enctype="multipart/form-data" >
            @csrf
        @method('PUT')
        <label for="exampleFormControlInput1" class="form-label">title</label>
  <input type="text" class="form-control" id="exampleFormControlInput1" name="title" value="{{$post->title}}" >
</div>
<div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
  <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description">{{$post->description}}</textarea>
</div>
<div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label">Image</label>
  <input type="file" name="image" accept=".jpg,.png" class="form-control" >
  
</div>
<div class="mb-3">
<label for="exampleFormControlTextarea1" class="form-label">Post Creator</label>
            <select name="post_creator" class="form-control" value="{{$post->user_id}}">

    @foreach($users as $user)
    <option value="{{$user->id}}">{{$user->name}}</option>

    @endforeach
    </select>
  </div>

</div>
<div class="col-auto">
    <button  type="submit" class="btn btn-primary mb-3">Create</button>
  </div>
  </form>
    </div>


@endsection
