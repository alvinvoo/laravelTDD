<div class="card flex flex-col" style="height: 200px">
  <h3 class="text-xl py-4 mb-3 -ml-5 border-l-4 border-bb-blue-light pl-4">
    <a href="{{ $project->path() }}">{{ $project->title }}</a>
  </h3>
  <div class="text-grey mb-4 flex-1">{{ Str::limit($project->description, 100) }}</div> 
  <footer class="text-right">
    <form method="POST" action="{{ $project->path()}}">
      @csrf
      @method('DELETE')
      <button type="submit" class="text-sm text-red-800">Delete</button>
    </form>
  </footer>
</div>