<!DOCTYPE html>
<html lang="en">
<head>
  <h1>Create Project</h1>
</head>
<body>
  <form action="/projects" method="POST">
    @csrf
    <label for="title">Title</label>
    <input type="text" name="title" placeholder="Title">
    <label for="description">Description</label>
    <textarea type="text" name="description" placeholder="Description">
    </textarea>

    <button type="submit">Create Project</button>
  </form>
</body>
</html>