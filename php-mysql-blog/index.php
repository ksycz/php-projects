<?php
require('config/config.php');
require('config/db.php');

// create query
$query = 'SELECT * FROM posts';

// get results
$result = mysqli_query($connection, $query);

// fetch data, we want associative array format ['name => 'Kasia]
$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

// free the result
mysqli_free_result($result);

// close connection
mysqli_close($connection);

?>

<?php include('inc/header.php'); ?>
  <div class="container">
    <h1>Posts</h1>
    <!-- loop through all posts -->
    <?php foreach($posts as $post) : ?>
      <div class="well">
        <h3><?php echo $post['title']; ?></h3>
        <small>Create on: <?php echo $post['created_at']; ?> by <?php echo $post['author'] ?></small>
        <p><?php echo $post['body']; ?></p>
        <!-- read more link -->
        <a href="<?php echo ROOT_URL;?>post.php?id=<?php echo $post['id']; ?>" class="btn btn-primary">Read more</a>
      </div>
    <?php endforeach; ?>
  </div>
<?php include('inc/footer.php'); ?>