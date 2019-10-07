<?php 
  include("config.php");
  include("classes/SiteResultsProvider.php");

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
          $pageLimit = 20;
          $resultsProvider = new SiteResultsProvider($connection);

          $numberOfResults = $resultsProvider->getNumberOfResults($term);
          echo "<p class='results-number'>$numberOfResults results found</p>";

          echo $resultsProvider->getResultsHtml($page, $pageLimit, $term);
        ?>

      </div>

      <div class="pagination-container">

        <?php
          $pagesToShow = 10;
          $currentPage = 1;
          $pagesLeft = 10;

          while($pagesLeft != 0) {

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
  </body>
</html>