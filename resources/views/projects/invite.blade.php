<div class="card flex flex-col mt-3">
    <h3 class="text-xl py-4 mb-3 -ml-5 border-l-4 border-bb-blue-light pl-4">
      Invite a User
    </h3>
    <form method="POST" action="{{ $project->path() . '/invitations'}}">
      @csrf
      <input type="email" name="email" class="border border-gray rounded w-full py-2 px-3 mb-4" placeholder="Email Address">
      <button type="submit" class="button text-xs">Invite</button>
    </form>

    @include ('errors', ['bag'=>'invitations'])
</div>