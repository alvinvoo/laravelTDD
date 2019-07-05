@extends('layouts.app')

@section('content')
  <div class="lg:w-1/2 lg:mx-auto bg-card p-6 md:py-12 md:px-16 rounded shadow bg-white">
    <h1 class="text-2xl mb-10 text-center">
      Edit Your Project
    </h1>
    <form action="{{ $project->path() }}" method="POST">
      @method('PATCH')
      @include ('projects.form', [
                  // 'project' => $project,
                  'buttonText' => 'Save Project'
              ])
    </form>
  </div>
@endsection 