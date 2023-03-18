@extends('layouts.app')

@section('title') Index @endsection

@section('content')

<h2>Create New Post </h2>

<form>
  <label for="Tiltle" class="mt-3">Tiltle</label><br>
  <input type="text" id="Tiltle" name="Tiltle" class="rounded"><br>
  <label for="PostedBy" class="mt-3">Posted By</label><br>
  <input type="text" id="PostedBy" name="PostedBy"class="rounded"><br>
  <label for="Describtion" class="mt-3">Describtion</label><br>
  <textarea id="Describtion" name="Describtion" class="rounded" ></textarea><br>
  <button  type="button" class="mt-4 btn btn-success text-white"><a class="btn btn-success text-white">create</a></button>
    <button id="Back" type="button" class="mt-4 btn btn-success"> <a href="{{route('posts.index')}}" class="btn btn-success text-white">Back</a></button>
</form>

@endsection