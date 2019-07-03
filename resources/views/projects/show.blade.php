@extends('layouts.app')

@section('content')
  <h1>Project</h1>
  <p>{{ $project->title }}</p>
  <p>{{ $project->description }}</p>
  <a href="/projects">Go Back</a>
@endsection
