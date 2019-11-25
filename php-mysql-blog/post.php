<?php
require('config/config.php');
require('config/db.php');

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
    <small>Create on: <?php echo $post['created_at']; ?> by <?php echo $post['author'] ?></small>
    <p><?php echo $post['body']; ?></p>
  </div>
<?php include('inc/footer.php'); ?>