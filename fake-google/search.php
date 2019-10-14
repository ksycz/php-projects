<?php 
  include("config.php");
  include("classes/SiteResultsProvider.php");
  include("classes/ImageResultsProvider.php");

  // if the terms exists, get the term value from the URL
  if(isset($_GET["term"])) {
    $term = $_GET["term"];
  } else {
    // stop executing remaining code, just show the message from the brackets
    exit("Please type a search term");
  }

  // if the terms exists, get the type value from the URL, that's the only variable that differs in images URL and sites URL
  $type = isset($_GET["type"]) ? $_GET["type"] : "sites";
  $page = isset($_GET["page"]) ? $_GET["page"] : 1;
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
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
   </head>
  <body>
    <div class="wrapper">
      <header>
        <div class="header-content">
          <div class="logo-container">
            <a href="index.php">
              <img src="assets/img/google-doodle.png" alt="Fake Google Doodle logo">
            </a>
          </div>

          <div class="search-container">
            <form action="search.php" method="GET">
              <!-- we need to stay in the correct tab when searching -->
              <input type="hidden" name="type" value="<?php echo $type;?>"> 
              <input type="text" class="search-box" name="term" placeholder="Type the search term" value="<?php echo $term; ?>">
              <button>Search</button>
            </form>
          </div>
        </div>

        <div class="tabs-container">
          <ul>
            <!-- if the type is sites, add class "active, if the type is not "sites" add an empty class -->
            <li class="<?php echo $type == "sites" ? "active" : "" ?>"> 
              <a href='<?php echo "search.php?term=$term&type=sites"; ?>'>Sites</a>
            </li>
            <li class="<?php echo $type == "images" ? "active" : "" ?>">
              <a href='<?php echo "search.php?term=$term&type=images"; ?>'>Images</a>
            </li>
          </ul>
        </div>
      </header>
      <div class="main-results">

        <?php

          if($type == "sites") {
            $resultsProvider = new SiteResultsProvider($connection);
            $pageSize = 20;
          }
          else {
            $resultsProvider = new ImageResultsProvider($connection);
            $pageSize = 30;
          }

          $numberOfResults = $resultsProvider->getNumberOfResults($term);
          echo "<p class='results-number'>$numberOfResults results found</p>";

          echo $resultsProvider->getResultsHtml($page, $pageSize, $term);
        ?>

      </div>

      <div class="pagination-container">

        <?php
          $pagesToShow = 10;
          // a number of results on one site, integer
          $numberOfPages = ceil($numberOfResults / $pageSize);
          $currentPage = 1;
          // it will take the smaller number
          $pagesLeft = min($pagesToShow, $numberOfPages);
          // we want to show a few numbers on the left and on the right from the current number
          $currentPage = floor($page - ($pagesToShow / 2));

          if($currentPage < 1) {
            $currentPage = 1;
          }

          if($currentPage + $pagesLeft > $numberOfPages + 1) {
            $currentPage = $numberOfPages - $pagesLeft;
          }

          while($pagesLeft != 0 && $currentPage <= $numberOfPages) {

            if($currentPage == $page) {
              // currently open page number should not be clickable
              echo "<div class='page-number-container'>
                      <span class='page-number'>$currentPage</span>
                    </div>";
            }
            else {
              echo "<div class='page-number-container'>
                      <a href='search.php?term=$term&type=$type&page=$currentPage'>
                        <span class='page-number'>$currentPage</span>
                      </a>
                    </div>";
            }
            

            $currentPage++;
            $pagesLeft--;
          }
        ?>

      </div>

    </div>
    <script type="text/javascript" src="assets/js/script.js"></script>
  </body>
</html>