@extends('layouts.app')

@section('content')
  <h1 class="heading">Create a Project</h1>
  <form action="/projects" method="POST">
    @csrf

    <div class="field">
      <label class="label" for="title">Title</label>
      <div class="control">
        <input class="input" type="text" name="title" placeholder="Title">
      </div>
    </div>

    <div class="field">
      <label class="label" for="description">Description</label>
      <div class="control">
        <textarea class="textarea" type="text" name="description" placeholder="Description">
        </textarea>
      </div>
    </div>

    <div class="field">
      <div class="control">
        <button type="submit" class="btn btn-blue">Create Project</button>
        <a href="/projects">Cancel</a>
      </div>
    </div>
  </form>
@endsection