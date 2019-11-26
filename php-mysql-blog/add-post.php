<?php
require('config/config.php');
require('config/db.php');

// check if it is submitted

if(isset($_POST['submit'])) {
  // get form data
  $title = mysqli_real_escape_string($connection, $_POST["title"]);
  $body= mysqli_real_escape_string($connection, $_POST["body"]);
  $author = mysqli_real_escape_string($connection, $_POST["author"]);

  $query = "INSERT INTO posts(title, body, author) VALUES('$title', '$body', '$author')";

  if(mysqli_query($connection, $query)) {
    // if successfull redirect
    header('Location'.ROOT_URL.'');
  } else {
    echo 'Error: '.mysqli_error($connection);
  };
}
?>

<?php include('inc/header.php'); ?>
  <div class="container">
    <h1>Add post</h1>
    <!-- we want to submit it to this page -->
    <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
      <div class="form-group">
        <label>Title</label>
        <input type="text" name="title" class="form-control">
      </div>
      <div class="form-group">
        <label>Author</label>
        <input type="text" name="author" class="form-control">
      </div>
      <div class="form-group">
        <label>Body</label>
        <textarea name="body" class="form-control"></textarea>
      </div>
      <input type="submit" name="submit" value="Submit" class="btn btn-success">
    </form>
  </div>
<?php include('inc/footer.php'); ?>