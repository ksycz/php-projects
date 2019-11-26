<?php
require('config/config.php');
require('config/db.php');

// check if it is submitted

if(isset($_POST['submit'])) {
  // get form data
  $update_id = mysqli_real_escape_string($connection, $_POST["update_id"]);
  $title = mysqli_real_escape_string($connection, $_POST["title"]);
  $body= mysqli_real_escape_string($connection, $_POST["body"]);
  $author = mysqli_real_escape_string($connection, $_POST["author"]);

  $query = "UPDATE posts SET 
              title='$title',
              author='$author',
              body='$body'
            WHERE id='$update_id'";

  if(mysqli_query($connection, $query)) {
    // if successfull redirect
    header('Location'.ROOT_URL.'');
  } else {
    echo 'Error: '.mysqli_error($connection);
  };
}

// get id, we want escape dangerous characters
$id = mysqli_real_escape_string($connection, $_GET['id']);

// create query
$query = 'SELECT * FROM posts WHERE id= '. $id;

// get results
$result = mysqli_query($connection, $query);

// fetch data, we want only one post
$post = mysqli_fetch_assoc($result);

// free the result
mysqli_free_result($result);

// close connection
mysqli_close($connection);
?>

<?php include('inc/header.php'); ?>
  <div class="container">
    <h1>Add post</h1>
    <!-- we want to submit it to this page -->
    <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
      <div class="form-group">
        <label>Title</label>
        <input type="text" name="title" class="form-control" value="<?php echo $post['title']; ?>">
      </div>
      <div class="form-group">
        <label>Author</label>
        <input type="text" name="author" class="form-control" value="<?php echo $post['author']; ?>">
      </div>
      <div class="form-group">
        <label>Body</label>
        <textarea name="body" class="form-control" value="<?php echo $post['body']; ?>"></textarea>
      </div>
      <input type="hidden" name="update_id" value="<?php echo $post['id']; ?>">
      <input type="submit" name="submit" value="Submit" class="btn btn-success">
    </form>
  </div>
<?php include('inc/footer.php'); ?>