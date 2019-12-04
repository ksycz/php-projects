<?php
// Created based on https://medium.com/@noufel.gouirhate/create-your-own-mvc-framework-in-php-af7bd1f0ca19
// requires all the files that we will need for the instantiation of the dispatcher.
  define('WEBROOT', str_replace("Webroot/index.php", "", $_SERVER["SCRIPT_NAME"]));
  define('ROOT', str_replace("Webroot/index.php", "", $_SERVER["SCRIPT_FILENAME"]));
  require(ROOT . 'Config/core.php');
  require(ROOT . 'router.php');
  require(ROOT . 'request.php');
  require(ROOT . 'dispatcher.php');
  $dispatch = new Dispatcher();
  $dispatch->dispatch();
?>