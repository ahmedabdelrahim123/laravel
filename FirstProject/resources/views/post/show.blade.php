@extends('layouts.app')

@section('title') display post @endsection



@section('content')
    <div class="container">
      <div class="d-inline-flex">
<div class="card m-3">
  <div class="card-header">
    Post Info
  </div>
  <div class="card-body">
    <h5 class="card-title">Title:</h5>
    <p>{{$post['title']}}</p>
    <h5 class="card-title">Description:</h5>
    <p class="card-text">{{$post['description']}}</p>
    <p class=" text-danger card-text"><span class="fw-bold">created At:</span><br> {{ $post->created_at->format('l jS \\of F Y h:i:s A') }}</h5>  </div>
</div>
<div class="card m-3">
  <div class="card-header">
    Post Creator Info
  </div>
  <div class="card-body">
  <p class="card-title"><span class="fw-bold">Author:</span><br> {{ optional($post->user)->name ?? 'Not Found' }}</h5>
            <p class="card-text"><span class="fw-bold">Email:</span><br> {{optional($post->user)->email ?? 'Not Found'}}</p>
                <p class=" text-danger card-text"><span class="fw-bold">created At:</span><br> {{ $post->created_at->format('l jS \\of F Y h:i:s A') }}</h5>
   
  </div>
</div>


      </div>
      <div class="card mt-6">
        <div class="card-header">
            Comments
        </div>
        <div class="card-body">
            <table class="table mt-2">
            
            @foreach($post->comments as $comment)
                <tr>
                    <td>{{$comment->body}}</td>
                    <td>{{$comment->created_at}}</td>
                    <td>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal{{$comment->id}}" >
                        Edit
                    </button>
                    <div class="modal fade" id="exampleModal{{$comment->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit post</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" value="{{ $comment->id }}"></button>
                      </div>
                      <div class="modal-body">
                      <div class="form-outline w-100">
                                  
                              
                              </div>
                      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

      <form style="display: inline;" action="{{route('comments.update',$comment->id)}}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="post_id" value="{{ $post->id }}">
        <textarea class="form-control" id="textAreaExample" rows="4"
                  style="background: #fff;" name="body">{{$comment->body}}</textarea>
                <label class="form-label" for="textAreaExample">Message</label>
        <button type="submit" name="" class="btn btn-primary" >Edit</button>
          </form>
        
      </div>
    </div>
  </div>
</div>
                        <form method="POST" style="display: inline;" action="{{route('comments.destroy',$comment->id)}}">
                            <!-- Button trigger modal -->
<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" >
 Delete
</button>

<!-- Modal -->

    </td>
    </tr>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete comment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       do you want to delete this comment
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

      <form class="mx-5" action="{{ route('comments.destroy', $comment->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" name="" class="btn btn-danger" >delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
              
            </table>
           
        </div>

  <div class="card-footer py-3 border-0" style="background-color: #f8f9fa;">
            <div class="d-flex flex-start w-100">
              <img class="rounded-circle shadow-1-strong me-3"
                src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(19).webp" alt="avatar" width="40"
                height="40" />
              <div class="form-outline w-100">
                <form action="{{route('comments.store',$post->id)}}"  method="POST">
                  
                  @csrf
                <textarea class="form-control" id="textAreaExample" rows="4"
                  style="background: #fff;" name="body"></textarea>
                <label class="form-label" for="textAreaExample">Message</label>
              </div>
            </div>
            <div class="float-end mt-2 pt-1">
              <button type="submit" class="btn btn-primary btn-sm">Post comment</button>
              <button type="button" class="btn btn-outline-primary btn-sm">Cancel</button>
            </div>
            </form>
          </div>
      

@endsection