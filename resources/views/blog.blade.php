<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Blogs Management</title>
</head>
<body>
  <h1>Blogs Management</h1>
  <p>Welcome to the Blogs Management page. Here you can manage, create, and view blogs.</p>

  <h2>Search Blogs</h2>
  <form>
    <input type="text" placeholder="Search by title...">
    <button type="submit">Search</button>
  </form>

  <h2>Recent Blogs</h2>
  <ul>
    <li>
      <h3>First Blog Post</h3>
      <p>This is a short description of the first blog post.</p>
    </li>
    <li>
      <h3>Second Blog Post</h3>
      <p>This is a short description of the second blog post.</p>
    </li>
    <li>
      <h3>Third Blog Post</h3>
      <p>This is a short description of the third blog post.</p>
    </li>
  </ul>
 
  <h2>Create a New Blog</h2>
  <form>
    <label>Title: <input type="text" name="title"></label><br><br>
    <label>Content:</label><br>
    <textarea name="content" rows="5" cols="50"></textarea><br><br>
    <button type="submit">Add Blog</button>
  </form>
</body>
</html>
