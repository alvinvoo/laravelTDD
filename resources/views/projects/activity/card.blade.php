<div class="card mt-3">
    <ul class="text-xs">
      @foreach ($project->activity as $activity)
        <li class="{{ $loop->last ? '' : 'mb-1' }}">
          @include("projects.activity.{$activity->description}")
          <span class="text-grey">
            {{ $activity->created_at->since(null, 1) }}
          </span>
        </li>
      @endforeach
    </ul>
  </div>