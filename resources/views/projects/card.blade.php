<div class="card" style="height: 200px">
  <h3 class="text-xl py-4 mb-3 -ml-5 border-l-4 border-bb-blue-light pl-4">
    <a href="{{ $project->path() }}">{{ $project->title }}</a>
  </h3>
  <div class="text-grey">{{ Str::limit($project->description, 100) }}</div> 
  <div class="mt-4 text-right">
    <form method="POST" action="{{ $project->path()}}">
      @csrf
      @method('DELETE')
      <button type="submit" class="text-sm text-red-800">Delete</button>
    </form>
  </div>
</div>