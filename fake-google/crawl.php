<?php 
include("config.php");
include("classes/DomDocumentParser.php");

$alreadyCrawled = array();
$crawling = array();
$alreadyFoundImages = array();

// check for duplicates
function linkExists($url) {
  global $connection;

  $query = $connection->prepare("SELECT * FROM websites WHERE url = :url"); 
  
  $query->bindParam(":url", $url);
  $query->execute();

  return $query->rowCount() != 0;
}

function insertLinkIntoDb($url, $title, $description, $keywords) {
  global $connection;

  $query = $connection->prepare("INSERT INTO websites(url, title, description, keywords)
                                VALUES(:url, :title, :description, :keywords)"); 
  
  $query->bindParam(":url", $url);
  $query->bindParam(":title", $title);
  $query->bindParam(":description", $description);
  $query->bindParam(":keywords", $keywords);
  
  // returns true if it works and false when the query does not work
  return $query->execute();
}

function insertImageIntoDb($url, $src, $alt, $title) {
  global $connection;

  $query = $connection->prepare("INSERT INTO images(websiteUrl, imageUrl, alt, title)
                                VALUES(:websiteUrl, :imageUrl, :alt, :title)"); 
  
  $query->bindParam(":websiteUrl", $url);
  $query->bindParam(":imageUrl", $src);
  $query->bindParam(":alt", $alt);
  $query->bindParam(":title", $title);
  
  $query->execute();
}

// convert relative links to absolute links
function createLink($src, $url) {
  // parse_url is JS function
  $scheme = parse_url($url)["scheme"]; // http
  $host = parse_url($url)["host"]; // www...
  // if the links starts with // replace // with http or https (this is an url scheme)
  if(substr($src, 0, 2) == "//") {
		$src =  $scheme . ":" . $src;
	}
	else if(substr($src, 0, 1) == "/") {
		$src = $scheme . "://" . $host . $src;
	}
  else if(substr($src, 0, 2) == "./") {
		$src = $scheme . "://" . $host . $src . dirname(parse_url($url)["path"]) . substr($src, 1); // the last part says that we want to ignore "."
  }
  else if(substr($src, 0, 3) == "../") {
		$src = $scheme . "://" . $host .  "/" . $src;
  }
  else if(substr($src, 0, 5) != "https" && substr($src, 0, 4) != "http") {
		$src = $scheme . "://" . $host .  "/" . $src;
	}
  return $src;
};

function getDetails($url) {

  global $alreadyFoundImages;
  // creating the object with the class we created in another file
  $parser = new DomDocumentParser($url);

  $titleList = $parser->getTitleTags();

  // if the titleList array has 0 length or the first item is NULL
  if(sizeof($titleList) == 0 || $titleList->item(0) == NULL) {
    return;
  }

  // just in case, ensure that only the first title will be taken from the website, there should be only one but who knows :)
  $title = $titleList->item(0)->nodeValue;
  // get rid of the new lines - replace them with the empty string
  $title = str_replace("\n", "", $title);
  // if website does not have a title, we are going to ignore the whole link
  if($title == "") {
    return;
  }

  // get meta info
  $description = "";
  $keywords = "";

  $metasList = $parser->getMetaTags(); 

  foreach ($metasList as $meta) {
    if ($meta->getAttribute("name") == "description") {
      $description = $meta->getAttribute("content");
    }

    if ($meta->getAttribute("name") == "keywords") {
      $keywords = $meta->getAttribute("content");
    }
  }
    $description = str_replace("\n", "", $description);
    $keywords = str_replace("\n", "", $keywords);

   if(linkExists($url)) {
     echo "$url already exists<br>";
   }
   else if(insertLinkIntoDb($url, $title, $description, $keywords)) {
      echo "Yay!<br>";
   }
   else {
     echo "Failed to insert $url into the database<br>";
   }

  //  getting images

  $imagesList = $parser->getImages();

  foreach ($imagesList  as $image) {
    $src = $image->getAttribute("src");
    $alt = $image->getAttribute("alt");
    $title = $image->getAttribute("title");

    // we want to continue even if the alt and title attributes are not added to the image
    if(!$title && !$alt) {
      continue;
    }

    $src = createLink($src, $url);

    if(!in_array($src, $alreadyFoundImages)) {
      $alreadyFoundImages[] = $src;

      // insert the image
      insertImageIntoDb($url, $src, $alt, $title);
    }
  }
};

function followLinks($url) {
  global $alreadyCrawled;
  global $crawling;

  // creating the object with the class we created in another file
  $parser = new DomDocumentParser($url);

  $linkList = $parser->getLinks();

	foreach($linkList as $link) {
		$href = $link->getAttribute("href");

    // get rid of links we don't want to use, for example links with href="#"
		if(strpos($href, "#") !== false) {
			continue;
    }
    // we don't want links that directs to JS
		else if(substr($href, 0, 11) == "javascript:") {
			continue;
		}

    $href = createLink($href, $url);

    // recursive crawling, we need to get all links from the subpages
    // if the website is not crawled yet, put it as the next item in the array
    if(!in_array($href, $alreadyCrawled)) {
      $alreadyCrawled[] = $href;
      $crawling[] = $href;

      //  insert $href;
     getDetails($href);
    }
  }

  //  get rid of what is on top of the array
  array_shift($crawling);

  foreach($crawling as $site) {
    followLinks($site);
  }
}

$startUrl = "http://www.bbc.com";
followLinks($startUrl);

?>