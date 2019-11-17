<?php

  class ImageResultsProvider {

    private $connection;

    public function __construct($connection) {
      $this->connection = $connection;
    }

    public function getNumberOfResults($term) {
      $query = $this->connection->prepare("SELECT COUNT(*) as total FROM images WHERE (title LIKE :term OR alt LIKE :term) AND broken=0");

      // we need it because we want to find not only the exact term, it can be visible in some text
      $searchTerm = "%" . $term . "%";
      $query->bindParam(":term", $searchTerm);

      $query->execute();
      
      // store results in the associative array
      $row = $query->fetch(PDO::FETCH_ASSOC);

      return $row["total"];
    }



    // pageSize is the number of results to show
    public function getResultsHTML($page, $pageSize, $term) {

      $fromLimit = ($page - 1) * $pageSize;

      // we need order to show the most popular results first
      $query = $this->connection->prepare("SELECT * FROM images WHERE (title LIKE :term OR alt LIKE :term) AND broken=0 ORDER BY clicks DESC LIMIT :fromLimit, :pageSize");

      // we need it because we want to find not only the exact term, it can be visible in some text
      $searchTerm = "%" . $term . "%";
      $query->bindParam(":term", $searchTerm);
      $query->bindParam(":fromLimit", $fromLimit, PDO::PARAM_INT);
      $query->bindParam(":pageSize", $pageSize, PDO::PARAM_INT);
      $query->execute();

      $resultsHtml = "<div class='image-results'>";

      while($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $id = $row["id"];
        $websiteUrl = $row["websiteUrl"];
        $imageUrl = $row["imageUrl"];
        $alt = $row["alt"];
        $title = $row["title"];
        

        if($title) {
          $displayText = $title;
        }
        else if($alt) {
          $displayText = $alt;
        }
        else {
          $displayText = $imageUrl;
        }

        $resultsHtml .= "<div class='grid-item'>
                          <a href='$imageUrl'>
                            <img src='$imageUrl'>
                            <span class='image-details'>$displayText</span>
                          </a>
                        </div>";

      }

      $resultsHtml .= "</div>";
      return $resultsHtml;
    }
  };
?>