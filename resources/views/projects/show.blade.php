@extends('layouts.app')

@section('content')
  <header class="flex items-center mb-3 py-4">
    <div class="flex justify-between items-end w-full">
      <h2 class="text-grey text-sm">
        <a href="/projects">My Projects</a> / {{ $project->title }}
      </h2>
      <div class="flex items-center">
        @foreach ($project->members as $member)
        <img 
        src="{{ gravatar_url($member->email) }}" 
        alt="{{ $member->name }}'s avatar'"
        class="rounded-full w-8 mr-2"
        title="{{ $member->name }}"
        >        
        @endforeach

        <img 
        src="{{ gravatar_url($project->owner->email) }}" 
        alt="{{ $project->owner->name }}'s avatar'"
        class="rounded-full w-8 mr-2"
        title="{{ $project->owner->name }}"
        >

        <a href="{{ $project->path() }}/edit" class="button ml-4">Edit Project</a>
      </div>
    </div>
  </header>

  <main>
    <div class="lg:flex -mx-3">
      <div class="lg:w-3/4 px-3 mb-6">
        <div class="mb-8">
          <h2 class="text-lg text-grey mb-3">Tasks</h2>
          {{-- tasks --}}
          @foreach ($project->tasks as $task)
            <div class="card mb-3">
              <form action="{{ $task->path() }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="flex">
                  <input type="text" class="w-full {{ $task->completed ? 'text-grey' : ''}}" name="body" value="{{ $task->body }}">
                  <input type="checkbox" name="completed" onchange="this.form.submit()" {{ $task->completed ? 'checked' : ''}}>
                </div>
              </form>
            </div> 
          @endforeach

          <div class="card mb-3">
            <form action="{{ $project->path() . '/tasks'}}" method="POST">
              @csrf
              <input type="text" placeholder="Add new task" class="w-full" name="body">
            </form>
          </div>
        </div>
        
        <div>
          <h2 class="text-lg text-grey mb-3">General Notes</h2>
          {{-- general notes --}}
          <form action="{{ $project->path() }}" method="POST">
            @csrf
            @method('PATCH')
            <textarea 
              class="card w-full" style="min-height: 200px;"
              placeholder="Anything you want to make note of?"
              name="notes"
            >{{ $project->notes }}</textarea>
            <button type="submit" class="button">Save</button>
          </form>
        </div>
        @include ('errors')
      </div>
      <div class="lg:w-1/4 px-3">
        @include('projects.card')

        @include('projects.activity.card')

        @can('manage', $project)
          @include('projects.invite')
        @endcan
      </div>
    </div>
  </main>

  
@endsection
