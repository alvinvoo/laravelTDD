@if (count($activity->changes['after']) == 1)
  You've updated the {{ key($activity->changes['after']) }} of the project
@else
  You've updated the project.
@endif