@extends('layouts.app')


@section('title') Index @endsection

@section('content')
    <div class="text-center">
        <a href="{{route('posts.create')}}" class="mt-4 btn btn-success">Create Post</a>
    </div>
    <table class="table mt-4">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Posted By</th>
            <th scope="col">Created At</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>

        @foreach($posts as $post)
            <tr>
                <td>{{$post->id}}</td>
                    <td>{{$post->title}}</td>     
               <td>{{ optional($post->user)->name ?? 'Not Found' }}</td>
                <td>{{$post->created_at->format('Y-m-d')}}</td>
                <td>
                <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                        
                    <a href="{{route('posts.show', $post->id)}}" class="btn btn-info">View</a>
                    <a href="{{route('posts.edit', $post->id)}}" class="btn btn-primary">Edit</a>
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
        <h5 class="modal-title" id="exampleModalLabel">Delete post</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       do you want to delete this post
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

      <form action="{{route('posts.destroy',$post['id'])}}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" name="" class="btn btn-danger" >delete</button>
                </form>
                </td>
            </tr>
        @endforeach



        </tbody>
    </table>
   {{$posts->links()}}
@endsection

