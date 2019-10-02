<?php 
// if the terms exists, get the term value from the URL
if(isset($_GET["term"])) {
  $term = $_GET["term"];
} else {
  // stop executing remaining code, just show the message from the brackets
  exit("Please type a search term");
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fake Google</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css"/>
    <script src="https://kit.fontawesome.com/23032ab857.js" crossorigin="anonymous"></script>
   </head>
  <body>
    <main class="wrapper">
      <header>
        <div class="header-content">
          <div class="logo-container">
            <a href="index.php">
              <img src="assets/img/google-doodle.png" alt="Fake Google Doodle logo">
            </a>
          </div>

          <div class="search-container">
            <form action="search.php" method="GET">
              <input type="text" class="search-box" name="term" placeholder="Type the search term">
              <button>Search</button>
            </form>
          </div>
        </div>

        <div class="tabs-container">
          <ul>
            <li>
              <a href='<?php echo "search.php?term=$term&type=sites"; ?>'>Sites</a>
            </li>
            <li>
              <a href='<?php echo "search.php?term=$term&type=images"; ?>'>Images</a>
            </li>
          </ul>
        </div>
      </header>
    </main>
  </body>
</html>