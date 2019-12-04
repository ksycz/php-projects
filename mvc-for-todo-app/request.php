<?php
// get URL requested by user
  class Request
  {
    public $url;
    public function __construct()
    {
      $this->url = $_SERVER["REQUEST_URI"];
    }
  }
?>