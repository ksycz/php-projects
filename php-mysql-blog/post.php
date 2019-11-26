<?php
require('config/config.php');
require('config/db.php');

if(isset($_POST['delete'])) {
  // get form data
  $delete_id = mysqli_real_escape_string($connection, $_POST['delete_id']);

  $query = "DELETE FROM posts WHERE id={$delete_id}";

  if(mysqli_query($connection, $query)) {
    // if successfull redirect
    header('Location'.ROOT_URL.'');
  } else {
    echo 'Error: '.mysqli_error($connection);
  }
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
    <a href="<?php echo ROOT_URL; ?>" class="btn btn-info">Back</a>
    <h1><?php echo $post['title']; ?></h1>
    <small>Create on: <?php echo $post['created_at']; ?> by <?php echo $post['author']; ?></small>
    <p><?php echo $post['body']; ?></p>
    <hr>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="pull-right">
      <input type="hidden" name="delete_id" value="<?php echo $post['id']; ?>">
      <input type="submit" name="delete" value="Delete" class="btn btn-danger">
    </form>
    <a href="<?php echo ROOT_URL; ?>edit-post.php?id=<?php echo $post['id']; ?>" class="btn btn-primary">Edit</a>
  </div>
<?php include('inc/footer.php'); ?>