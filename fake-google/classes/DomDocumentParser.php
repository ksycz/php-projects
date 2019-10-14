<?php 
class DomDocumentParser {
  private $doc; // we want to keep this value

  // create constructor, we set it to public to call it outside of the class
  public function __construct($url) {
    // echo "URL: $url";

    $options = array(
              // we want to retrieve data from webpage so we use GET method, User-Agent is how website knows who visited the website - name of the app/version
                'http'=>array('method'=>"GET", 'header'=>"User-Agent: fakeGoogleBot/0.1\n")
              ); // we need to create options for creating a webpage
    $context = stream_context_create($options);
    // create an instance od DomDocument (build-in) class, allows to perform actions on DOM
    // this->doc refers to private $doc above;
    $this->doc = new DomDocument();
    // we adding @ to hide warnings, normally we should not use it; $doc will contain the whole HTML of the requested website
    @$this->doc->loadHTML(file_get_contents($url, false, $context));

  }

  // get all links from the website
  public function getLinks() {
    return $this->doc->getElementsByTagName('a');
  }

  // get titles
  public function getTitleTags() {
    return $this->doc->getElementsByTagName('title');
  }

   // get titles
   public function getMetaTags() {
    return $this->doc->getElementsByTagName('meta');
  }

   // get images
   public function getImages() {
    return $this->doc->getElementsByTagName('img');
  }

  // constructor will be executed as soon as we create the object to the class (in the crawl.php file)
}
?>