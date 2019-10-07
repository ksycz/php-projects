<?php

  class SiteResultsProvider {

    private $connection;

    public function __construct($connection) {
      $this->connection = $connection;
    }

    public function getNumberOfResults($term) {
      $query = $this->connection->prepare("SELECT COUNT(*) as total FROM websites WHERE title LIKE :term OR url LIKE :term OR description LIKE :term OR keywords LIKE :term");

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
      $query = $this->connection->prepare("SELECT * FROM websites WHERE title LIKE :term OR url LIKE :term OR description LIKE :term OR keywords LIKE :term ORDER BY clicks DESC LIMIT :fromLimit, :pageSize");

      // we need it because we want to find not only the exact term, it can be visible in some text
      $searchTerm = "%" . $term . "%";
      $query->bindParam(":term", $searchTerm);
      $query->bindParam(":fromLimit", $fromLimit, PDO::PARAM_INT);
      $query->bindParam(":pageSize", $pageSize, PDO::PARAM_INT);
      $query->execute();

      $resultsHtml = "<div class='website-results'>";

      while($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $id = $row["id"];
        $url = $row["url"];
        $title = $row["title"];
        $description = $row["description"];

        $title = $this->trimField($title, 55);
			  $description = $this->trimField($description, 230);


        $resultsHtml .= "<div class='results-container'>
                          <h3 class='title'>
                            <a class='result' href='$url'>$title</a>
                          </h3>
                          <span class='url'>$url</span>
                          <span class='description'>$description</span>
                        </div>";

      }
      return $resultsHtml;
    }

    private function trimField($string, $characterLimit) {

      $dots = strlen($string) > $characterLimit ? "..." : "";
      return substr($string, 0, $characterLimit) . $dots;
    }
  };
?>