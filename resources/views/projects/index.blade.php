<!DOCTYPE html>
<html lang="en">
<head>
  <h1>Birdboard Projects</h1>
</head>
<body>
  <ul>
    @forelse ($projects as $project)
      <li><a href={{ $project->path() }}>{{ $project->title }}</a></li>
    @empty
      <p>There's no projet yet.</p>  
    @endforelse
  </ul>
</body>
</html>